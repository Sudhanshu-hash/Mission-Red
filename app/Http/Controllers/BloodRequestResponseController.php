<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\BloodRequestResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BloodRequestResponseController extends Controller
{
    /**
     * Store a response to a blood request.
     */
    public function store(
        Request $request,
        BloodRequest $bloodRequest
    ): RedirectResponse {

        /*
         * A user cannot respond to their own request.
         */
        if ($bloodRequest->requester_id === $request->user()->id) {
            return back()->with(
                'error',
                'You cannot respond to your own blood request.'
            );
        }

        /*
         * Only active requests can receive responses.
         */
        if ($bloodRequest->status !== 'active') {
            return back()->with(
                'error',
                'This blood request is no longer active.'
            );
        }

        /*
         * Prevent duplicate responses.
         */
        $alreadyResponded = BloodRequestResponse::where(
            'blood_request_id',
            $bloodRequest->id
        )
            ->where('user_id', $request->user()->id)
            ->exists();

        if ($alreadyResponded) {
            return back()->with(
                'error',
                'You have already responded to this blood request.'
            );
        }

        /*
         * Validate the response.
         */
        $validated = $request->validate([
            'response_type' => [
                'required',
                'in:donate,arrange',
            ],

            'quantity' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'message' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        /*
         * ---------------------------------------------------------
         * DONATION
         * ---------------------------------------------------------
         */

        if ($validated['response_type'] === 'donate') {

            if (
                !isset($validated['quantity']) ||
                $validated['quantity'] < 1
            ) {
                return back()
                    ->withErrors([
                        'quantity' =>
                            'Please enter the number of blood units you can donate.',
                    ])
                    ->withInput();
            }

            /*
             * Calculate the current remaining quantity.
             */
            $remainingQuantity = max(
                0,
                $bloodRequest->required_quantity
                    - $bloodRequest->fulfilled_quantity
            );

            if ($remainingQuantity <= 0) {
                return back()->with(
                    'error',
                    'This blood request has already received enough blood.'
                );
            }

            /*
             * A donor cannot offer more units than currently needed.
             */
            if ($validated['quantity'] > $remainingQuantity) {
                return back()
                    ->withErrors([
                        'quantity' =>
                            "Only {$remainingQuantity} " .
                            str('unit')->plural($remainingQuantity) .
                            " currently remain for this request.",
                    ])
                    ->withInput();
            }
        }

        /*
         * ---------------------------------------------------------
         * HELP ARRANGE
         * ---------------------------------------------------------
         *
         * Quantity is optional because the user may be connecting
         * the requester with another donor.
         */
        if ($validated['response_type'] === 'arrange') {
            $validated['quantity'] = null;
        }

        /*
         * Create the response.
         *
         * fulfilled_quantity is NOT updated here.
         * It will be updated later when the requester accepts/
         * confirms an actual donation.
         */
        BloodRequestResponse::create([
            'blood_request_id' => $bloodRequest->id,
            'user_id' => $request->user()->id,
            'quantity' => $validated['quantity'] ?? null,
            'response_type' => $validated['response_type'],
            'status' => 'pending',
            'message' => $validated['message'] ?? null,
            'responded_at' => now(),
        ]);

        return back()->with(
            'success',
            $validated['response_type'] === 'donate'
                ? 'Your donation response has been submitted.'
                : 'Your offer to help arrange blood has been submitted.'
        );
    }
}
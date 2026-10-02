<?php

namespace App\Http\Controllers;

use App\Models\BloodGroup;
use App\Models\BloodRequest;
use App\Models\BloodRequestResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BloodRequestController extends Controller
{
    /**
     * Show the blood request form.
     */
    public function create(): View
    {
        $bloodGroups = BloodGroup::orderBy('name')->get();

        return view(
            'blood-requests.create',
            compact('bloodGroups')
        );
    }

    /**
     * Store a new blood request.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'blood_group_id' => [
                'required',
                'exists:blood_groups,id',
            ],

            'required_quantity' => [
                'required',
                'integer',
                'min:1',
                'max:100',
            ],

            'required_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'urgency' => [
                'required',
                'in:normal,urgent,critical',
            ],

            'region' => [
                'required',
                'string',
                'max:100',
            ],

            'locality' => [
                'required',
                'string',
                'max:150',
            ],
        ]);

        $bloodRequest = BloodRequest::create([
            'requester_id' => $request->user()->id,
            'blood_group_id' => $validated['blood_group_id'],
            'required_quantity' => $validated['required_quantity'],
            'fulfilled_quantity' => 0,
            'required_date' => $validated['required_date'],
            'urgency' => $validated['urgency'],
            'region' => $validated['region'],
            'locality' => $validated['locality'],
            'status' => 'active',
        ]);

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Your blood request has been created successfully.'
            );
    }

    /**
     * Display the authenticated user's blood requests.
     */
    public function index(Request $request): View
    {
        $bloodRequests = BloodRequest::query()
            ->where('requester_id', $request->user()->id)
            ->with('bloodGroup')
            ->latest()
            ->paginate(10);

        return view(
            'blood-requests.index',
            compact('bloodRequests')
        );
    }

    /**
     * Discover active blood requests from the community.
     *
     * The authenticated user can see:
     * 1. Their own active requests separately.
     * 2. All other active community requests.
     *
     * Blood group does not restrict visibility.
     */
    public function discover(Request $request): View
    {
        /*
         * ---------------------------------------------------------
         * YOUR ACTIVE REQUESTS
         * ---------------------------------------------------------
         */
        $myRequests = BloodRequest::query()
            ->where('requester_id', auth()->id())
            ->where('status', 'active')
            ->whereDate('required_date', '>=', today())
            ->with([
                'bloodGroup',
                'responses',
            ])
            ->latest()
            ->get();


        /*
         * ---------------------------------------------------------
         * COMMUNITY REQUESTS
         * ---------------------------------------------------------
         */
        $query = BloodRequest::query()
            ->where('requester_id', '!=', auth()->id())
            ->where('status', 'active')
            ->whereDate('required_date', '>=', today())
            ->with([
                'bloodGroup',

                /*
                 * Load only the authenticated user's response.
                 * This allows the UI to know whether this user
                 * has already responded to the request.
                 */
                'responses' => function ($query) {
                    $query->where(
                        'user_id',
                        auth()->id()
                    );
                },
            ]);


        /*
         * ---------------------------------------------------------
         * FILTERS
         * ---------------------------------------------------------
         */

        // Blood group
        if ($request->filled('blood_group_id')) {
            $query->where(
                'blood_group_id',
                $request->input('blood_group_id')
            );
        }

        // Urgency
        if ($request->filled('urgency')) {
            $query->where(
                'urgency',
                $request->input('urgency')
            );
        }

        // Region
        if ($request->filled('region')) {
            $query->where(
                'region',
                'like',
                '%' . $request->input('region') . '%'
            );
        }

        // Locality
        if ($request->filled('locality')) {
            $query->where(
                'locality',
                'like',
                '%' . $request->input('locality') . '%'
            );
        }

        // Minimum remaining quantity
        if ($request->filled('min_quantity')) {
            $minQuantity = max(
                1,
                (int) $request->input('min_quantity')
            );

            $query->whereRaw(
                '(required_quantity - fulfilled_quantity) >= ?',
                [$minQuantity]
            );
        }


        /*
         * ---------------------------------------------------------
         * SORTING
         * ---------------------------------------------------------
         *
         * Critical → Urgent → Normal
         */
        $query->orderByRaw("
        CASE urgency
            WHEN 'critical' THEN 1
            WHEN 'urgent' THEN 2
            WHEN 'normal' THEN 3
            ELSE 4
        END
    ");

        $query->latest();


        /*
         * ---------------------------------------------------------
         * PAGINATION
         * ---------------------------------------------------------
         */
        $communityRequests = $query
            ->paginate(12)
            ->withQueryString();


        /*
         * ---------------------------------------------------------
         * BLOOD GROUPS FOR FILTER
         * ---------------------------------------------------------
         */
        $bloodGroups = BloodGroup::orderBy('name')->get();


        return view(
            'blood-requests.discover',
            compact(
                'myRequests',
                'communityRequests',
                'bloodGroups'
            )
        );
    }

    /**
     * Display a single blood request.
     *
     * All authenticated users can view a blood request.
     * Management actions are restricted to the requester.
     */
    public function show(BloodRequest $bloodRequest): View
    {
        $bloodRequest->load([
            'bloodGroup',
            'requester',
        ]);

        return view(
            'blood-requests.show',
            compact('bloodRequest')
        );
    }

    /**
     * Show the edit form for a blood request.
     */
    public function edit(BloodRequest $bloodRequest): View
    {
        abort_unless(
            $bloodRequest->requester_id === auth()->id(),
            403
        );

        $bloodGroups = BloodGroup::orderBy('name')->get();

        return view(
            'blood-requests.edit',
            compact(
                'bloodRequest',
                'bloodGroups'
            )
        );
    }

    /**
     * Update a blood request.
     */
    public function update(
        Request $request,
        BloodRequest $bloodRequest
    ): RedirectResponse {

        abort_unless(
            $bloodRequest->requester_id === auth()->id(),
            403
        );

        /*
         * Only active requests can be edited.
         */
        if ($bloodRequest->status !== 'active') {
            return redirect()
                ->route(
                    'blood-requests.show',
                    $bloodRequest
                )
                ->with(
                    'error',
                    'Only active blood requests can be edited.'
                );
        }

        $validated = $request->validate([
            'blood_group_id' => [
                'required',
                'exists:blood_groups,id',
            ],

            'required_quantity' => [
                'required',
                'integer',
                'min:1',
                'max:100',
            ],

            'required_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'urgency' => [
                'required',
                'in:normal,urgent,critical',
            ],

            'region' => [
                'required',
                'string',
                'max:100',
            ],

            'locality' => [
                'required',
                'string',
                'max:150',
            ],
        ]);

        /*
         * Never allow the required quantity to be reduced
         * below the amount already fulfilled.
         */
        if (
            $validated['required_quantity']
            < $bloodRequest->fulfilled_quantity
        ) {
            return back()
                ->withErrors([
                    'required_quantity' =>
                        'Required quantity cannot be less than the quantity already fulfilled.',
                ])
                ->withInput();
        }

        $bloodRequest->update([
            'blood_group_id' => $validated['blood_group_id'],
            'required_quantity' => $validated['required_quantity'],
            'required_date' => $validated['required_date'],
            'urgency' => $validated['urgency'],
            'region' => $validated['region'],
            'locality' => $validated['locality'],
        ]);

        return redirect()
            ->route(
                'blood-requests.show',
                $bloodRequest
            )
            ->with(
                'success',
                'Blood request updated successfully.'
            );
    }

    /**
     * Cancel a blood request.
     */
    public function destroy(
        BloodRequest $bloodRequest
    ): RedirectResponse {

        abort_unless(
            $bloodRequest->requester_id === auth()->id(),
            403
        );

        if ($bloodRequest->status !== 'active') {
            return redirect()
                ->route(
                    'blood-requests.show',
                    $bloodRequest
                )
                ->with(
                    'error',
                    'This blood request is no longer active.'
                );
        }

        $bloodRequest->update([
            'status' => 'cancelled',
            'closed_at' => now(),
        ]);

        return redirect()
            ->route('blood-requests.index')
            ->with(
                'success',
                'Blood request cancelled successfully.'
            );
    }

    /**
     * Submit a response to a blood request.
     *
     * A user can either:
     *
     * 1. Personally donate blood.
     * 2. Help arrange blood through another person.
     */
    public function respond(
        Request $request,
        BloodRequest $bloodRequest
    ): RedirectResponse {

        /*
         * A requester cannot respond to their own request.
         */
        if (
            $bloodRequest->requester_id
            === $request->user()->id
        ) {
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
         * Calculate remaining required quantity.
         */
        $remainingQuantity = max(
            0,
            $bloodRequest->required_quantity
            - $bloodRequest->fulfilled_quantity
        );

        if ($remainingQuantity <= 0) {
            return back()->with(
                'error',
                'This blood request has already been fulfilled.'
            );
        }

        /*
         * Validate response.
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
                'max:' . $remainingQuantity,
            ],

            'message' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        /*
         * Personal donation requires quantity.
         */
        if (
            $validated['response_type'] === 'donate'
            && empty($validated['quantity'])
        ) {
            return back()
                ->withErrors([
                    'quantity' =>
                        'Please specify how many units you can donate.',
                ])
                ->withInput();
        }

        /*
         * Prevent duplicate responses.
         */
        $existingResponse = BloodRequestResponse::query()
            ->where(
                'blood_request_id',
                $bloodRequest->id
            )
            ->where(
                'user_id',
                $request->user()->id
            )
            ->exists();

        if ($existingResponse) {
            return back()->with(
                'error',
                'You have already responded to this blood request.'
            );
        }

        /*
         * Create the response.
         */
        BloodRequestResponse::create([
            'blood_request_id' => $bloodRequest->id,
            'user_id' => $request->user()->id,
            'response_type' => $validated['response_type'],
            'quantity' => $validated['quantity'] ?? null,
            'status' => 'pending',
            'message' => $validated['message'] ?? null,
            'responded_at' => now(),
        ]);

        /*
         * Response-specific confirmation.
         */
        $message = $validated['response_type'] === 'donate'
            ? 'Your donation response has been sent to the requester.'
            : 'Your help-to-arrange response has been sent to the requester.';

        return back()->with(
            'success',
            $message
        );
    }

    /**
     * Display responses received for a blood request.
     *
     * Only the requester can view these responses.
     */
    public function responses(
        BloodRequest $bloodRequest
    ): View {

        abort_unless(
            $bloodRequest->requester_id === auth()->id(),
            403
        );

        $bloodRequest->load([
            'bloodGroup',
            'responses.user',
        ]);

        return view(
            'blood-requests.responses',
            compact('bloodRequest')
        );
    }

    /**
     * Accept or reject a response.
     */
    public function updateResponse(
        Request $request,
        BloodRequest $bloodRequest,
        BloodRequestResponse $response
    ): RedirectResponse {
        abort_unless(
            $bloodRequest->requester_id === auth()->id(),
            403
        );

        abort_unless(
            $response->blood_request_id === $bloodRequest->id,
            404
        );

        if ($response->status !== 'pending') {
            return back()->with(
                'error',
                'This response has already been reviewed.'
            );
        }

        $validated = $request->validate([
            'status' => ['required', 'in:accepted,rejected'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Reject response
        |--------------------------------------------------------------------------
        */
        if ($validated['status'] === 'rejected') {

            $response->update([
                'status' => 'rejected',
                'reviewed_at' => now(),
            ]);

            return back()->with(
                'success',
                'Response rejected successfully.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Accept response
        |--------------------------------------------------------------------------
        */
        DB::transaction(function () use ($bloodRequest, $response) {

            /*
            |--------------------------------------------------------------------------
            | Lock the blood request row
            |--------------------------------------------------------------------------
            | This prevents two simultaneous acceptances from calculating the
            | remaining quantity from the same old value.
            */
            $bloodRequest = BloodRequest::query()
                ->lockForUpdate()
                ->findOrFail($bloodRequest->id);

            /*
            |--------------------------------------------------------------------------
            | Re-check response status inside the transaction
            |--------------------------------------------------------------------------
            */
            $response->refresh();

            if ($response->status !== 'pending') {
                throw new \RuntimeException(
                    'This response has already been reviewed.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Help-to-arrange without quantity
            |--------------------------------------------------------------------------
            | It can be accepted, but it does not fulfill blood units.
            */
            if (
                $response->response_type === 'arrange'
                && !$response->quantity
            ) {
                $response->update([
                    'status' => 'accepted',
                    'reviewed_at' => now(),
                ]);

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Calculate remaining quantity
            |--------------------------------------------------------------------------
            */
            $remainingQuantity = max(
                0,
                $bloodRequest->required_quantity
                - $bloodRequest->fulfilled_quantity
            );

            /*
            |--------------------------------------------------------------------------
            | Make sure this response does not exceed the remaining requirement
            |--------------------------------------------------------------------------
            */
            if ($response->quantity > $remainingQuantity) {
                throw new \RuntimeException(
                    'This response exceeds the remaining required quantity.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Accept response
            |--------------------------------------------------------------------------
            */
            $response->update([
                'status' => 'accepted',
                'reviewed_at' => now(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | Add fulfilled quantity
            |--------------------------------------------------------------------------
            */
            $bloodRequest->fulfilled_quantity += $response->quantity;

            /*
            |--------------------------------------------------------------------------
            | Close request when fully fulfilled
            |--------------------------------------------------------------------------
            */
            if (
                $bloodRequest->fulfilled_quantity
                >= $bloodRequest->required_quantity
            ) {
                $bloodRequest->fulfilled_quantity =
                    $bloodRequest->required_quantity;

                $bloodRequest->status = 'fulfilled';
                $bloodRequest->closed_at = now();
            }

            $bloodRequest->save();
        });

        return back()->with(
            'success',
            'Response accepted successfully.'
        );
    }
}
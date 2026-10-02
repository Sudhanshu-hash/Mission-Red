<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use Illuminate\Http\Request;
use App\Models\BloodRequestResponse;
class DashboardController extends Controller
{
    /**
     * Display the user's dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $profile = $user->profile;

        /*
         * ---------------------------------------------------------
         * ACTIVE REQUEST
         * ---------------------------------------------------------
         *
         * Show the user's latest active blood request.
         */
        $activeRequest = BloodRequest::query()
            ->where('requester_id', $user->id)
            ->where('status', 'active')
            ->with('bloodGroup')
            ->latest()
            ->first();

        /*
         * ---------------------------------------------------------
         * ACTIVITY COUNTS
         * ---------------------------------------------------------
         */

        // Number of currently active requests created by the user.
        $activeRequestCount = BloodRequest::query()
            ->where('requester_id', $user->id)
            ->where('status', 'active')
            ->count();

        /*
         * Number of responses received on the user's requests.
         *
         * This counts all responses, regardless of whether they
         * are pending, accepted, or rejected.
         */
       $donorResponseCount = BloodRequestResponse::query()
    ->whereHas('bloodRequest', function ($query) use ($user) {
        $query->where('requester_id', $user->id);
    })
    ->count();

        /*
         * Number of requests created by the user that have been
         * completely fulfilled.
         */
        $completedRequestCount = BloodRequest::query()
            ->where('requester_id', $user->id)
            ->where('status', 'fulfilled')
            ->count();

        return view('dashboard', [
            'user' => $user,
            'profile' => $profile,
            'activeRequest' => $activeRequest,
            'activeRequestCount' => $activeRequestCount,
            'donorResponseCount' => $donorResponseCount,
            'completedRequestCount' => $completedRequestCount,
        ]);
    }
}
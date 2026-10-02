<?php

namespace App\Http\Controllers;

use App\Models\BloodGroup;
use App\Models\Location;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Show the profile creation form.
     */
    public function create(Request $request)
    {
        abort_if(
            $request->user()->profile !== null,
            403,
            'Your profile already exists.'
        );

        $bloodGroups = BloodGroup::orderBy('id')->get();

        return view('profile.create', compact('bloodGroups'));
    }

    /**
     * Store a new profile.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        abort_if(
            $user->profile !== null,
            403,
            'Your profile already exists.'
        );

        $validated = $request->validate([
            'phone' => ['required', 'string', 'max:20'],

            'blood_group_id' => [
                'required',
                'integer',
                'exists:blood_groups,id',
            ],

            'state' => [
                'required',
                'string',
                'max:100',
            ],

            'city' => [
                'required',
                'string',
                'max:100',
            ],

            'locality' => [
                'required',
                'string',
                'max:150',
            ],

            'pincode' => [
                'nullable',
                'string',
                'max:10',
            ],
        ]);

        DB::transaction(function () use ($user, $validated) {

            $location = Location::create([
                'state' => $validated['state'],
                'city' => $validated['city'],
                'locality' => $validated['locality'],
                'pincode' => $validated['pincode'] ?? null,
                'latitude' => null,
                'longitude' => null,
            ]);

            Profile::create([
                'user_id' => $user->id,
                'phone' => $validated['phone'],
                'blood_group_id' => $validated['blood_group_id'],
                'location_id' => $location->id,
            ]);
        });

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Your profile has been created successfully.'
            );
    }

    /**
     * Show the profile edit form.
     */
    public function edit(Request $request)
    {
        $profile = $request->user()
            ->profile()
            ->with(['bloodGroup', 'location'])
            ->first();

        abort_if(
            $profile === null,
            404,
            'Profile not found.'
        );

        $bloodGroups = BloodGroup::orderBy('id')->get();

        return view('profile.edit', [
            'profile' => $profile,
            'bloodGroups' => $bloodGroups,
        ]);
    }

    /**
     * Update the authenticated user's profile.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $profile = $user->profile()
            ->with('location')
            ->first();

        abort_if(
            $profile === null,
            404,
            'Profile not found.'
        );

        $validated = $request->validate([
            'phone' => ['required', 'string', 'max:20'],

            'blood_group_id' => [
                'required',
                'integer',
                'exists:blood_groups,id',
            ],

            'state' => [
                'required',
                'string',
                'max:100',
            ],

            'city' => [
                'required',
                'string',
                'max:100',
            ],

            'locality' => [
                'required',
                'string',
                'max:150',
            ],

            'pincode' => [
                'nullable',
                'string',
                'max:10',
            ],
        ]);

        DB::transaction(function () use ($profile, $validated) {

            $profile->update([
                'phone' => $validated['phone'],
                'blood_group_id' => $validated['blood_group_id'],
            ]);

            $profile->location->update([
                'state' => $validated['state'],
                'city' => $validated['city'],
                'locality' => $validated['locality'],
                'pincode' => $validated['pincode'] ?? null,
            ]);
        });

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Your profile has been updated successfully.'
            );
    }
}
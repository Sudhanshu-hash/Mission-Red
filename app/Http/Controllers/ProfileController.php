<?php
namespace App\Http\Controllers;
use App\Models\BloodGroup;
use App\Models\Location;
use App\Models\Profile;
use App\Services\Location\GeocodingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use RuntimeException;
class ProfileController extends Controller
{
    /**
     * Show the profile creation form.
     */
    public function create(Request $request)
    {
        if ($request->user()->profile !== null) {
            return redirect()
                ->route('profile.show');
        }
        $bloodGroups = BloodGroup::orderBy('id')->get();
        return view('profile.create', compact('bloodGroups'));
    }
    /**
     * Store a new profile.
     */
    public function store(
        Request $request,
        GeocodingService $geocodingService
    ) {
        $user = $request->user();
        abort_if(
            $user->profile !== null,
            403,
            'Your profile already exists.'
        );
        $validated = $request->validate([
            'profile_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
            'phone' => [
                'required',
                'string',
                'max:12'
            ],

            'blood_group_id' => [
                'required',
                'integer',
                'exists:blood_groups,id',
            ],
            'state' => [
                'required',
                'string',
                'max:20',
            ],
            'city' => [
                'required',
                'string',
                'max:20',
            ],
            'locality' => [
                'required',
                'string',
                'max:150',
            ],
            'pincode' => [
                'nullable',
                'string',
                'max:6',
            ],
        ]);
        try {
            $coordinates = $geocodingService->geocode(
                $validated['state'],
                $validated['city'],
                $validated['locality'],
                $validated['pincode'] ?? null
            );
        } catch (RuntimeException $e) {
            return back()
                ->withInput()
                ->withErrors([
                    'locality' => $e->getMessage(),
                ]);
        }
        $newImagePath = null;
        if ($request->hasFile('profile_image')) {
            $newImagePath = $request->file('profile_image')
                ->store('profiles', 'public');
        }
        DB::transaction(function () use ($profile, $validated, $coordinates, $newImagePath) {
            $location = Location::create([
                'state' => $validated['state'],
                'city' => $validated['city'],
                'locality' => $validated['locality'],
                'pincode' => $validated['pincode'] ?? null,
                'latitude' => $coordinates['latitude'],
                'longitude' => $coordinates['longitude'],
            ]);
            DB::statement(
                '
            UPDATE locations
            SET coordinates = ST_SetSRID(
                ST_MakePoint(?, ?),
                4326
            )::geography
            WHERE id = ?
            ',
                [
                    $coordinates['longitude'],
                    $coordinates['latitude'],
                    $location->id,
                ]
            );
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
     * Show the authenticated user's profile.
     */
    public function show(Request $request)
    {
        $user = $request->user();
        $profile = $user
            ->profile()
            ->with(['bloodGroup', 'location'])
            ->first();
        if ($profile === null) {
            return redirect()
                ->route('profile.create')
                ->with(
                    'info',
                    'Please complete your profile to continue.'
                );
        }
        $completion = 0;
        if (
            filled($user->name) &&
            filled($user->email)
        ) {
            $completion += 25;
        }
        if ($profile->blood_group_id !== null) {
            $completion += 25;
        }
        if (
            $profile->location !== null &&
            filled($profile->location->state) &&
            filled($profile->location->city) &&
            filled($profile->location->locality) &&
            filled($profile->location->latitude) &&
            filled($profile->location->longitude)
        ) {
            $completion += 40;
        }
        if (filled($profile->phone)) {
            $completion += 10;
        }
        return view('profile.show', [
            'user' => $user,
            'profile' => $profile,
            'completion' => $completion,
        ]);
    }
    /**
     * Show the profile edit form.
     */
    /**
     * Update profile contact privacy settings.
     */
    public function updatePrivacy(Request $request)
    {
        $profile = $request->user()
            ->profile()
            ->first();
        abort_if(
            $profile === null,
            404,
            'Profile not found.'
        );
        $validated = $request->validate([
            'email_private' => [
                'required',
                'boolean',
            ],
            'phone_private' => [
                'required',
                'boolean',
            ],
        ]);
        $profile->update([
            'email_private' => $validated['email_private'],
            'phone_private' => $validated['phone_private'],
        ]);
        return redirect()
            ->route('profile.show')
            ->with(
                'success',
                'Your contact privacy settings have been updated.'
            );
    }
    public function edit(Request $request)
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

        $oldEmail = $user->email;
        $oldPhone = $profile->phone;

        $bloodGroups = BloodGroup::orderBy('id')->get();

        return view('profile.edit', [
            'user' => $user,
            'profile' => $profile,
            'bloodGroups' => $bloodGroups,
        ]);
    }
    /**
     * Update the authenticated user's profile.
     */
    public function update(
        Request $request,
        GeocodingService $geocodingService
    ) {
        $user = $request->user();
        $profile = $user->profile()
            ->with('location')
            ->first();
        abort_if(
            $profile === null,
            404,
            'Profile not found.'
        );
        $oldEmail = $user->email;
        $oldPhone = $profile->phone;
        $validated = $request->validate([
            'profile_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $user->id,
            ],
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
        /*
         * ---------------------------------------------------------
         * GEOCODE LOCATION
         * ---------------------------------------------------------
         */
        try {
            $coordinates = $geocodingService->geocode(
                $validated['state'],
                $validated['city'],
                $validated['locality'],
                $validated['pincode'] ?? null
            );
        } catch (RuntimeException $e) {
            return back()
                ->withInput()
                ->withErrors([
                    'locality' => $e->getMessage(),
                ]);
        }
        /*
         * ---------------------------------------------------------
         * PROFILE IMAGE
         * ---------------------------------------------------------
         */
        $oldImagePath = $profile->profile_image_path;
        $newImagePath = null;
        if ($request->hasFile('profile_image')) {
            $newImagePath = $request->file('profile_image')
                ->store('profiles', 'public');
        }
        /*
         * ---------------------------------------------------------
         * UPDATE PROFILE + LOCATION
         * ---------------------------------------------------------
         */
        DB::transaction(function () use ($user, $profile, $validated, $coordinates, $newImagePath, $oldEmail, $oldPhone) {

            /*
            |--------------------------------------------------------------------------
            | Update USER
            |--------------------------------------------------------------------------
            */

            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];

            /*
            |--------------------------------------------------------------------------
            | Email verification
            |--------------------------------------------------------------------------
            |
            | If the email changes, the new email must be verified again.
            |
            */

            if ($oldEmail !== $validated['email']) {
                $userData['email_verified_at'] = null;
            }

            $user->update($userData);


            /*
            |--------------------------------------------------------------------------
            | Update PROFILE
            |--------------------------------------------------------------------------
            */

            $profileData = [
                'phone' => $validated['phone'],
                'blood_group_id' => $validated['blood_group_id'],
            ];

            /*
            |--------------------------------------------------------------------------
            | Phone verification
            |--------------------------------------------------------------------------
            |
            | If the phone number changes, the new number must be verified again.
            |
            */

            if ($oldPhone !== $validated['phone']) {
                $profileData['phone_verified_at'] = null;
            }

            /*
            |--------------------------------------------------------------------------
            | Profile Image
            |--------------------------------------------------------------------------
            */

            if ($newImagePath !== null) {
                $profileData['profile_image_path'] = $newImagePath;
            }

            $profile->update($profileData);


            /*
            |--------------------------------------------------------------------------
            | Update LOCATION
            |--------------------------------------------------------------------------
            */

            $profile->location->update([
                'state' => $validated['state'],
                'city' => $validated['city'],
                'locality' => $validated['locality'],
                'pincode' => $validated['pincode'] ?? null,
                'latitude' => $coordinates['latitude'],
                'longitude' => $coordinates['longitude'],
            ]);


            /*
            |--------------------------------------------------------------------------
            | Update PostGIS coordinates
            |--------------------------------------------------------------------------
            */

            DB::statement('
        UPDATE locations
        SET coordinates = ST_SetSRID(
            ST_MakePoint(?, ?),
            4326
        )::geography
        WHERE id = ?
    ', [
                $coordinates['longitude'],
                $coordinates['latitude'],
                $profile->location->id,
            ]);
        });
        /*
         * ---------------------------------------------------------
         * REMOVE OLD IMAGE
         * ---------------------------------------------------------
         */
        if (
            $newImagePath !== null &&
            filled($oldImagePath)
        ) {
            Storage::disk('public')->delete($oldImagePath);
        }
        return redirect()
            ->route('profile.show')
            ->with(
                'success',
                'Your profile has been updated successfully.'
            );
    }
}
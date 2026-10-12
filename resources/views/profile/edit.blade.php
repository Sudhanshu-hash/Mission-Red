@extends('layouts.base')
@section('title', 'Edit Profile')
@section('content')
    <div class="min-h-[calc(100vh-4rem)] bg-white py-8 sm:py-12">
        <div class="mx-auto max-w-4xl px-5 sm:px-8">
            {{-- =========================================================
            HEADER
            ========================================================== --}}
            
            <header class="mb-2 flex items-center justify-between">

            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-red-600">
                    Mission Red
                </p>

                <h1 class="mt-1 text-2xl font-semibold tracking-tight text-slate-900">
                    Edit Profile
                </h1>
                 <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                        Keep your profile, blood group and general location information
                        up to date.
                    </p>
            </div>


        </header>
            {{-- =========================================================
            VALIDATION ERRORS
            ========================================================== --}}
            @if ($errors->any())
                <div class="mb-6 border-l-4 border-red-500 bg-red-50 px-4 py-3">
                    <p class="text-sm font-semibold text-red-800">
                        Please correct the following errors:
                    </p>
                    <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {{-- =========================================================
            SUCCESS MESSAGE
            ========================================================== --}}
            @if (session('success'))
                <div class="mb-6 border-l-4 border-green-500 bg-green-50 px-4 py-3">
                    <p class="text-sm font-medium text-green-800">
                        {{ session('success') }}
                    </p>
                </div>
            @endif
            {{-- =========================================================
            EDIT PROFILE FORM
            ========================================================== --}}
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')
                {{-- =====================================================
                PROFILE PHOTO
                ====================================================== --}}
                <section class="border-y border-slate-200 py-3">
                    <div>
                        <!-- <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">
                            Profile
                        </p> -->
                        <h2 class="mt-1 text-lg font-semibold text-slate-900">
                            Profile Photo
                        </h2>
                        <p class="mt-1 text-sm leading-6 text-slate-500">
                            Add a profile photo so members of the Mission Red
                            community can recognize you.
                        </p>
                    </div>
                    <div class="mt-3 flex flex-col gap-5 sm:flex-row sm:items-center">
                        {{-- Current Image --}}
                        <div
                            class="flex h-24 w-24 shrink-0 items-center justify-center overflow-hidden rounded-full bg-slate-100 ring-1 ring-slate-200">
                            @if ($profile->profile_image_path)
                                <img src="{{ asset('storage/' . $profile->profile_image_path) }}"
                                    alt="{{ $profile->user->name }}" class="h-full w-full object-cover">
                            @else
                                <span class="text-3xl font-semibold text-slate-400">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                            @endif
                        </div>
                        {{-- Upload --}}
                        <div class="min-w-0">
                            <label for="profile_image" class="block text-sm font-medium text-slate-700">
                                Choose a new photo
                            </label>
                            <input type="file" id="profile_image" name="profile_image" accept=".jpg,.jpeg,.png,.webp" class="mt-2 block w-full text-sm text-slate-600
                                    file:mr-4 file:rounded-lg file:border-0
                                    file:bg-red-50 file:px-4 file:py-2
                                    file:text-sm file:font-medium file:text-red-700
                                    hover:file:bg-red-100">
                            <!-- <p class="mt-2 text-xs text-slate-500">
                                JPG, JPEG, PNG or WebP. Maximum size: 2 MB.
                            </p> -->
                            @error('profile_image')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </section>
                {{-- =====================================================
                CONTACT INFORMATION
                ====================================================== --}}
                {{-- Contact Information --}}
<section class="border-b border-slate-200 pb-3">

    <div>

        <h2 class="text-lg font-semibold text-slate-900">
            Contact Information
        </h2>

    </div>

<div class="mt-2 max-w-xl">

        <label
            for="name"
            class="block text-sm font-medium text-slate-700"
        >
            Name
        </label>

        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name', $user->name) }}"
            required
            maxlength="255"
            autocomplete="name"
            class="mt-2 block w-full rounded-lg border border-slate-300
                px-3 py-2.5 text-sm shadow-sm outline-none
                transition focus:border-red-500
                focus:ring-2 focus:ring-red-100"
        >

        @error('name')

            <p class="mt-2 text-sm text-red-600">
                {{ $message }}
            </p>

        @enderror

    </div>
    {{-- Phone --}}
    <div class="mt-2 max-w-xl">

        <label
            for="phone"
            class="block text-sm font-medium text-slate-700"
        >
            Phone Number
        </label>

        <input
            type="text"
            id="phone"
            name="phone"
            value="{{ old('phone', $profile->phone) }}"
            required
            maxlength="20"
            autocomplete="tel"
            class="mt-2 block w-full rounded-lg border border-slate-300
                px-3 py-2.5 text-sm shadow-sm outline-none
                transition focus:border-red-500
                focus:ring-2 focus:ring-red-100"
        >

        @error('phone')

            <p class="mt-2 text-sm text-red-600">
                {{ $message }}
            </p>

        @enderror

    </div>


    {{-- Email --}}
    <div class="mt-2 max-w-xl">

        <label
            for="email"
            class="block text-sm font-medium text-slate-700"
        >
            Email
        </label>

        <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email', $user->email) }}"
            required
            maxlength="255"
            autocomplete="email"
            class="mt-2 block w-full rounded-lg border border-slate-300
                px-3 py-2.5 text-sm shadow-sm outline-none
                transition focus:border-red-500
                focus:ring-2 focus:ring-red-100"
        >

        @error('email')

            <p class="mt-2 text-sm text-red-600">
                {{ $message }}
            </p>

        @enderror

    </div>

</section>
                {{-- =====================================================
                BLOOD GROUP
                ====================================================== --}}
                <section class="border-b border-slate-200 pb-3">
                    <div>
                        
                        <h2 class="text-lg font-semibold text-slate-900">
                            Blood Group
                        </h2>
                        
                    </div>
                    <div class="mt-1 max-w-xl">
                        <!-- <label for="blood_group_id" class="block text-sm font-medium text-slate-700">
                            Blood Group
                        </label> -->
                        <select id="blood_group_id" name="blood_group_id" required class="mt-2 block w-full rounded-lg border border-slate-300
                                bg-white px-3 py-2.5 text-sm shadow-sm outline-none
                                transition focus:border-red-500
                                focus:ring-2 focus:ring-red-100">
                            <option value="">
                                Select blood group
                            </option>
                            @foreach ($bloodGroups as $bloodGroup)
                                <option value="{{ $bloodGroup->id }}" @selected(
                                    old(
                                        'blood_group_id',
                                        $profile->blood_group_id
                                    ) == $bloodGroup->id
                                )>
                                    {{ $bloodGroup->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('blood_group_id')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </section>
                {{-- =====================================================
                GENERAL LOCATION
                ====================================================== --}}
                <section class="border-b border-slate-200 pb-7">
                    <div>
                        <!-- <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">
                            Location
                        </p> -->
                        <h2 class=" text-lg font-semibold text-slate-900">
                            General Location
                        </h2>
                        <p class="mt-1 max-w-2xl text-sm leading-6 text-slate-500">
                            Your general area helps you discover relevant blood
                            requests while keeping your exact address private.
                        </p>
                    </div>
                    <div class="mt-3 grid gap-5 md:grid-cols-2">
                        {{-- State --}}
                        <div>
                            <label for="state" class="block text-sm font-medium text-slate-700">
                                State
                            </label>
                            <input type="text" id="state" name="state"
                                value="{{ old('state', $profile->location?->state) }}" required maxlength="100"
                                autocomplete="address-level1" class="mt-2 block w-full rounded-lg border border-slate-300
                                    px-3 py-2.5 text-sm shadow-sm outline-none
                                    transition focus:border-red-500
                                    focus:ring-2 focus:ring-red-100">
                            @error('state')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        {{-- City --}}
                        <div>
                            <label for="city" class="block text-sm font-medium text-slate-700">
                                City
                            </label>
                            <input type="text" id="city" name="city" value="{{ old('city', $profile->location?->city) }}"
                                required maxlength="100" autocomplete="address-level2" class="mt-2 block w-full rounded-lg border border-slate-300
                                    px-3 py-2.5 text-sm shadow-sm outline-none
                                    transition focus:border-red-500
                                    focus:ring-2 focus:ring-red-100">
                            @error('city')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        {{-- Locality --}}
                        <div>
                            <label for="locality" class="block text-sm font-medium text-slate-700">
                                Locality / Area
                            </label>
                            <input type="text" id="locality" name="locality"
                                value="{{ old('locality', $profile->location?->locality) }}" required maxlength="150"
                                autocomplete="address-line2" class="mt-2 block w-full rounded-lg border border-slate-300
                                    px-3 py-2.5 text-sm shadow-sm outline-none
                                    transition focus:border-red-500
                                    focus:ring-2 focus:ring-red-100">
                            @error('locality')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        {{-- Pincode --}}
                        <div>
                            <label for="pincode" class="block text-sm font-medium text-slate-700">
                                Pincode
                                <span class="font-normal text-slate-400">
                                    (Optional)
                                </span>
                            </label>
                            <input type="text" id="pincode" name="pincode"
                                value="{{ old('pincode', $profile->location?->pincode) }}" maxlength="10"
                                autocomplete="postal-code" class="mt-2 block w-full rounded-lg border border-slate-300
                                    px-3 py-2.5 text-sm shadow-sm outline-none
                                    transition focus:border-red-500
                                    focus:ring-2 focus:ring-red-100">
                            @error('pincode')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    {{-- Privacy Notice --}}
                    <div class="mt-6 border-l-4 border-green-500 bg-green-50 px-4 py-3">
                        <p class="text-sm font-medium text-green-800">
                            Location privacy
                        </p>
                        <p class="mt-1 text-sm leading-6 text-green-700">
                            Mission Red uses your general location for distance-based
                            blood request discovery. Your exact address is not
                            displayed to other users.
                        </p>
                    </div>
                </section>
                {{-- =====================================================
                ACTIONS
                ====================================================== --}}
                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <a href="{{ route('profile.show') }}" class="inline-flex items-center justify-center rounded-lg
                            border border-slate-300 bg-white px-5 py-2.5
                            text-sm font-medium text-slate-700 transition
                            hover:bg-slate-50">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-lg
                            bg-red-600 px-6 py-2.5 text-sm font-semibold
                            text-white transition hover:bg-red-700
                            focus:outline-none focus:ring-2
                            focus:ring-red-500 focus:ring-offset-2">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
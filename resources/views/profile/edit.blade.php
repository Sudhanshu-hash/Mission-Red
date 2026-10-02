@extends('layouts.base')

@section('title', 'Edit Profile')

@section('content')

<div class="max-w-3xl mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="mb-8">
        <a
            href="{{ route('dashboard') }}"
            class="inline-flex items-center text-sm font-medium text-slate-600 hover:text-slate-900"
        >
            ← Back to Dashboard
        </a>

        <h1 class="mt-5 text-2xl font-semibold text-slate-900">
            Edit Your Profile
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Keep your blood group and general location information up to date.
        </p>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
            <p class="font-medium text-red-800">
                Please correct the following errors:
            </p>

            <ul class="mt-2 list-disc pl-5 text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Success Message --}}
    @if (session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('profile.update') }}"
        class="space-y-6"
    >
        @csrf
        @method('PUT')

        {{-- Contact Information --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

            <h2 class="text-lg font-semibold text-slate-900">
                Contact Information
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Your phone number is kept private by default.
            </p>

            <div class="mt-5">
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
                    class="mt-2 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm shadow-sm outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100"
                >
            </div>

        </div>

        {{-- Blood Group --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

            <h2 class="text-lg font-semibold text-slate-900">
                Blood Group
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                This information helps match you with relevant blood requests.
            </p>

            <div class="mt-5">
                <label
                    for="blood_group_id"
                    class="block text-sm font-medium text-slate-700"
                >
                    Blood Group
                </label>

                <select
                    id="blood_group_id"
                    name="blood_group_id"
                    required
                    class="mt-2 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm shadow-sm outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100"
                >
                    <option value="">Select blood group</option>

                    @foreach ($bloodGroups as $bloodGroup)
                        <option
                            value="{{ $bloodGroup->id }}"
                            @selected(
                                old(
                                    'blood_group_id',
                                    $profile->blood_group_id
                                ) == $bloodGroup->id
                            )
                        >
                            {{ $bloodGroup->name }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        {{-- Location --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

            <h2 class="text-lg font-semibold text-slate-900">
                General Location
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Your general area helps you discover relevant blood requests
                while keeping your exact address private.
            </p>

            <div class="mt-5 grid gap-5 md:grid-cols-2">

                {{-- State --}}
                <div>
                    <label
                        for="state"
                        class="block text-sm font-medium text-slate-700"
                    >
                        State
                    </label>

                    <input
                        type="text"
                        id="state"
                        name="state"
                        value="{{ old('state', $profile->location?->state) }}"
                        required
                        maxlength="100"
                        class="mt-2 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm shadow-sm outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100"
                    >
                </div>

                {{-- City --}}
                <div>
                    <label
                        for="city"
                        class="block text-sm font-medium text-slate-700"
                    >
                        City
                    </label>

                    <input
                        type="text"
                        id="city"
                        name="city"
                        value="{{ old('city', $profile->location?->city) }}"
                        required
                        maxlength="100"
                        class="mt-2 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm shadow-sm outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100"
                    >
                </div>

                {{-- Locality --}}
                <div>
                    <label
                        for="locality"
                        class="block text-sm font-medium text-slate-700"
                    >
                        Locality / Area
                    </label>

                    <input
                        type="text"
                        id="locality"
                        name="locality"
                        value="{{ old('locality', $profile->location?->locality) }}"
                        required
                        maxlength="150"
                        class="mt-2 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm shadow-sm outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100"
                    >
                </div>

                {{-- Pincode --}}
                <div>
                    <label
                        for="pincode"
                        class="block text-sm font-medium text-slate-700"
                    >
                        Pincode
                        <span class="font-normal text-slate-400">
                            (Optional)
                        </span>
                    </label>

                    <input
                        type="text"
                        id="pincode"
                        name="pincode"
                        value="{{ old('pincode', $profile->location?->pincode) }}"
                        maxlength="10"
                        class="mt-2 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm shadow-sm outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100"
                    >
                </div>

            </div>

            {{-- Privacy Notice --}}
            <div class="mt-5 rounded-lg border border-slate-200 bg-slate-50 p-4">
                <p class="text-sm font-medium text-slate-800">
                    Privacy
                </p>

                <p class="mt-1 text-sm leading-6 text-slate-600">
                    Mission Red stores your general location for community
                    matching. Do not enter your exact home address.
                </p>
            </div>

        </div>

        {{-- Actions --}}
        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

            <a
                href="{{ route('dashboard') }}"
                class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-lg bg-red-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-200"
            >
                Save Changes
            </button>

        </div>

    </form>

</div>

@endsection
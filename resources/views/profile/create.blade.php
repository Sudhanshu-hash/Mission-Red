@extends('layouts.base')

@section('title', 'Complete Your Profile | Mission Red')

@section('content')
    <section class="min-h-screen bg-slate-50 py-12">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            {{-- Page Header --}}
            <div class="mb-8">
                <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-red-600">
                    Profile Setup
                </p>

                <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                    Complete your profile
                </h1>

                <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-600 sm:text-base">
                    Your profile helps Mission Red connect you with relevant blood
                    requests while keeping your personal information private.
                </p>
            </div>

            {{-- Validation Summary --}}
            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">
                    <p class="font-semibold text-red-800">
                        Please correct the following:
                    </p>

                    <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                action="{{ route('profile.store') }}"
                method="POST"
                class="space-y-6"
            >
                @csrf

                {{-- Personal & Blood Information --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-slate-900">
                            Personal & Blood Information
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            These details help us identify and connect suitable donors.
                        </p>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">

                        {{-- Phone --}}
                        <div>
                            <label
                                for="phone"
                                class="mb-2 block text-sm font-medium text-slate-700"
                            >
                                Phone number
                            </label>

                            <input
                                type="tel"
                                id="phone"
                                name="phone"
                                value="{{ old('phone') }}"
                                maxlength="20"
                                autocomplete="tel"
                                placeholder="Enter your phone number"
                                class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-red-500 focus:ring-2 focus:ring-red-100"
                                required
                            >

                            @error('phone')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                            <p class="mt-2 text-xs text-slate-500">
                                Your phone number remains private by default.
                            </p>
                        </div>

                        {{-- Blood Group --}}
                        <div>
                            <label
                                for="blood_group_id"
                                class="mb-2 block text-sm font-medium text-slate-700"
                            >
                                Blood group
                            </label>

                            <select
                                id="blood_group_id"
                                name="blood_group_id"
                                class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100"
                                required
                            >
                                <option value="">Select your blood group</option>

                                @foreach ($bloodGroups as $bloodGroup)
                                    <option
                                        value="{{ $bloodGroup->id }}"
                                        @selected(old('blood_group_id') == $bloodGroup->id)
                                    >
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

                    </div>
                </div>

                {{-- Approximate Location --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-slate-900">
                            Approximate Location
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
    Your general area helps you discover relevant blood requests
    while keeping your exact address private.
</p>

                        {{-- Privacy Notice --}}
                        <div class="mt-4 rounded-xl border border-red-100 bg-red-50 p-4">
                            <p class="text-sm leading-6 text-slate-700">
                                <span class="font-semibold text-slate-900">
                                    Privacy first:
                                </span>
                                Mission Red does not ask for or display your exact home
                                address. Your location is represented using your general
                                area.
                            </p>
                        </div>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">

                        {{-- State --}}
                        <div>
                            <label
                                for="state"
                                class="mb-2 block text-sm font-medium text-slate-700"
                            >
                                State
                            </label>

                            <input
                                type="text"
                                id="state"
                                name="state"
                                value="{{ old('state') }}"
                                maxlength="100"
                                autocomplete="address-level1"
                                placeholder="Enter your state"
                                class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-red-500 focus:ring-2 focus:ring-red-100"
                                required
                            >

                            @error('state')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- City --}}
                        <div>
                            <label
                                for="city"
                                class="mb-2 block text-sm font-medium text-slate-700"
                            >
                                City
                            </label>

                            <input
                                type="text"
                                id="city"
                                name="city"
                                value="{{ old('city') }}"
                                maxlength="100"
                                autocomplete="address-level2"
                                placeholder="Enter your city"
                                class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-red-500 focus:ring-2 focus:ring-red-100"
                                required
                            >

                            @error('city')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Locality --}}
                        <div>
                            <label
                                for="locality"
                                class="mb-2 block text-sm font-medium text-slate-700"
                            >
                                Locality / Area
                            </label>

                            <input
                                type="text"
                                id="locality"
                                name="locality"
                                value="{{ old('locality') }}"
                                maxlength="150"
                                placeholder="e.g. Vaishali Nagar"
                                class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-red-500 focus:ring-2 focus:ring-red-100"
                                required
                            >

                            @error('locality')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Pincode --}}
                        <div>
                            <label
                                for="pincode"
                                class="mb-2 block text-sm font-medium text-slate-700"
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
                                value="{{ old('pincode') }}"
                                maxlength="10"
                                inputmode="numeric"
                                autocomplete="postal-code"
                                placeholder="Enter your pincode"
                                class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-red-500 focus:ring-2 focus:ring-red-100"
                            >

                            @error('pincode')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                    <a
                        href="{{ route('dashboard') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-red-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                    >
                        Complete Profile
                    </button>

                </div>

            </form>

        </div>
    </section>
@endsection
@extends('layouts.base')
@section('title', 'Profile | Mission Red')
@section('content')
@php
    $emailVerified = $user->email_verified_at !== null;
    $phoneVerified = $profile->phone_verified_at !== null;
    $isVerified = $emailVerified && $phoneVerified;
    $isOnline = $profile->last_seen_at !== null
        && $profile->last_seen_at->gt(now()->subMinutes(5));
    $profileImage = $profile->profile_image_path
        ? asset('storage/' . $profile->profile_image_path)
        : null;
@endphp
<section class="min-h-[calc(100vh-4rem)] bg-white py-4 sm:py-14">
    <div class="mx-auto max-w-4xl px-5 sm:px-8">
        {{-- =========================================================
            PAGE HEADER
        ========================================================== --}}
        <header class="mb-2 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-red-600">
                    Mission Red
                </p>
                <h1 class="mt-1 text-2xl font-semibold tracking-tight text-slate-900">
                    Profile
                </h1>
            </div>
        </header>
        {{-- =========================================================
            SUCCESS MESSAGE
        ========================================================== --}}
        @if (session('success'))
            <div class="mb-2 border-l-4 border-green-500 bg-green-50 px-4 py-3">
                <p class="text-sm font-medium text-green-800">
                    {{ session('success') }}
                </p>
            </div>
        @endif
        {{-- =========================================================
            PROFILE IDENTITY
        ========================================================== --}}
<section class="border-b border-slate-200 py-8">
    <div class="grid grid-cols-[auto_minmax(0,1fr)_88px] items-center gap-5 sm:gap-6">
        {{-- Profile Image --}}
        <div class="relative shrink-0">
            @if ($profileImage)
                <img
                    src="{{ $profileImage }}"
                    alt="{{ $user->name }}"
                    class="h-24 w-24 rounded-full object-cover ring-1 ring-slate-200 sm:h-28 sm:w-28"
                >
            @else
                <div
                    class="flex h-24 w-24 items-center justify-center rounded-full bg-slate-100 ring-1 ring-slate-200 sm:h-28 sm:w-28"
                >
                    <span class="text-3xl font-semibold text-slate-400">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </span>
                </div>
            @endif
            {{-- Online / Offline Status --}}
            <span
                class="absolute bottom-1 left-1 h-4 w-4 rounded-full border-2 border-white
                {{ $isOnline ? 'bg-green-500' : 'bg-slate-400' }}"
                title="{{ $isOnline ? 'Online' : 'Offline' }}"
            ></span>
        </div>
        {{-- Identity Information --}}
        <div class="min-w-0">
            <div class="flex flex-wrap items-center gap-2">
                <h2 class="text-xl font-semibold tracking-tight text-slate-900 sm:text-2xl">
                    {{ $user->name }}
                </h2>
                {{-- Verification Badge --}}
                @if ($isVerified)
                    <span
                        class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-blue-600 text-white"
                        title="Email and phone verified"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            class="h-3.5 w-3.5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m5 12 4 4L19 6"
                            />
                        </svg>
                    </span>
                @else
                    <span
                        class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-slate-300 text-white"
                        title="Verification pending"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            class="h-3.5 w-3.5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m5 12 4 4L19 6"
                            />
                        </svg>
                    </span>
                @endif
            </div>
            <p class="mt-2 text-2xl text-extrabold text-red-500">
                {{ $profile->bloodGroup?->name ?? 'Blood group not provided' }}
            </p>
            <!-- <div class="mt-3 flex items-center gap-2 text-xs text-slate-500">
                <span
                    class="h-2 w-2 rounded-full
                    {{ $isOnline ? 'bg-green-500' : 'bg-slate-400' }}"
                ></span>
                {{ $isOnline ? 'Online' : 'Offline' }}
            </div> -->
        </div>
        {{-- Profile Completion --}}
        <div class="flex flex-col items-center justify-center text-center">
            {{-- Hollow Completion Ring --}}
            <div
                class="flex h-16 w-16 items-center justify-center rounded-full border-2 border-red-600 bg-white"
                aria-label="Profile completion {{ $completion }} percent"
            >
                <span class="text-sm font-semibold text-slate-900">
                    {{ $completion }}%
                </span>
            </div>
            {{-- Completion Action --}}
            <a
                href="{{ route('profile.edit') }}"
                class="mt-2 text-[11px] font-semibold leading-4 text-red-600 transition hover:text-red-700"
            >
                {{ $completion < 100 ? 'Complete Your Profile' : 'Edit Profile' }}
            </a>
        </div>
    </div>
</section>
        {{-- =========================================================
            CONTACT INFORMATION
        ========================================================== --}}
        <section class="border-b border-slate-200 py-3">
            <div class="mb-2">
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">
                    Contact
                </p>
                <h2 class="mt-1 text-lg font-semibold text-slate-900">
                    Contact information
                </h2>
            </div>
            {{-- Email --}}
            <div class="flex flex-col gap-4  border-slate-100 py-2 sm:flex-row sm:items-center sm:justify-between">
                <div class="min-w-0">
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Email
                    </p>
                    <p class="mt-1 break-all text-sm font-medium text-slate-800">
                        {{ $user->email }}
                    </p>
                    @if ($emailVerified)
                        <p class="mt-1 text-xs text-green-600">
                            Verified
                        </p>
                    @else
                        <p class="mt-1 text-xs text-slate-400">
                            Not verified
                        </p>
                    @endif
                </div>
                {{-- Email Privacy --}}
<form
    method="POST"
    action="{{ route('profile.privacy.update') }}"
    class="shrink-0"
>
    @csrf
    @method('PATCH')
    <input
        type="hidden"
        name="email_private"
        value="{{ $profile->email_private ? 0 : 1 }}"
    >
    <input
        type="hidden"
        name="phone_private"
        value="{{ $profile->phone_private ? 1 : 0 }}"
    >
    <button
        type="submit"
        class="flex items-center gap-3 text-sm text-slate-600"
        title="{{ $profile->email_private
            ? 'Email is private. Click to make it public.'
            : 'Email is public. Click to make it private.' }}"
    >
        <span>
            {{ $profile->email_private ? 'Private' : 'Public' }}
        </span>
        {{-- Privacy Toggle --}}
        <span
            class="relative inline-flex h-6 w-11 shrink-0 overflow-hidden rounded-full transition-colors
                {{ $profile->email_private
                    ? 'bg-slate-700'
                    : 'bg-slate-300' }}"
        >
            <span
                class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow-sm transition-transform
                    {{ $profile->email_private
                        ? 'translate-x-5'
                        : 'translate-x-0' }}"
            ></span>
        </span>
    </button>
</form>
            </div>
            {{-- Phone --}}
            <div class="flex flex-col gap-4  border-slate-100 py-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Phone
                    </p>
                    <p class="mt-1 text-sm font-medium text-slate-800">
                        {{ $profile->phone }}
                    </p>
                    @if ($phoneVerified)
                        <p class="mt-1 text-xs text-green-600">
                            Verified
                        </p>
                    @else
                        <p class="mt-1 text-xs text-slate-400">
                            Not verified
                        </p>
                    @endif
                </div>
                {{-- Phone Privacy --}}
<form
    method="POST"
    action="{{ route('profile.privacy.update') }}"
    class="shrink-0"
>
    @csrf
    @method('PATCH')
    <input
        type="hidden"
        name="email_private"
        value="{{ $profile->email_private ? 1 : 0 }}"
    >
    <input
        type="hidden"
        name="phone_private"
        value="{{ $profile->phone_private ? 0 : 1 }}"
    >
    <button
        type="submit"
        class="flex items-center gap-3 text-sm text-slate-600"
        title="{{ $profile->phone_private
            ? 'Phone is private. Click to make it public.'
            : 'Phone is public. Click to make it private.' }}"
    >
        <span>
            {{ $profile->phone_private ? 'Private' : 'Public' }}
        </span>
        {{-- Privacy Toggle --}}
        <span
            class="relative inline-flex h-6 w-11 shrink-0 overflow-hidden rounded-full transition-colors
                {{ $profile->phone_private
                    ? 'bg-slate-700'
                    : 'bg-slate-300' }}"
        >
            <span
                class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow-sm transition-transform
                    {{ $profile->phone_private
                        ? 'translate-x-5'
                        : 'translate-x-0' }}"
            ></span>
        </span>
    </button>
</form>
            </div>
        </section>
        {{-- =========================================================
            LOCATION
        ========================================================== --}}
        <section class="border-b border-slate-200 py-3">
            <div class="mb-2">
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">
                    Location
                </p>
                <h2 class="mt-1 text-lg font-semibold text-slate-900">
                    General location
                </h2>
            </div>
            @if ($profile->location)
                <dl class="  border-slate-100">
                    <div class="grid grid-cols-1 gap-1 py-2 sm:grid-cols-3 sm:gap-6">
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">
                            State
                        </dt>
                        <dd class="text-sm font-medium text-slate-800 sm:col-span-2">
                            {{ $profile->location->state }}
                        </dd>
                    </div>
                    <div class="grid grid-cols-1 gap-1 py-2 sm:grid-cols-3 sm:gap-6">
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">
                            City
                        </dt>
                        <dd class="text-sm font-medium text-slate-800 sm:col-span-2">
                            {{ $profile->location->city }}
                        </dd>
                    </div>
                    <div class="grid grid-cols-1 gap-1 py-2 sm:grid-cols-3 sm:gap-6">
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">
                            Locality
                        </dt>
                        <dd class="text-sm font-medium text-slate-800 sm:col-span-2">
                            {{ $profile->location->locality }}
                        </dd>
                    </div>
                    <div class="grid grid-cols-1 gap-1 py-2 sm:grid-cols-3 sm:gap-6">
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">
                            Pincode
                        </dt>
                        <dd class="text-sm font-medium text-slate-800 sm:col-span-2">
                            {{ $profile->location->pincode ?: 'Not provided' }}
                        </dd>
                    </div>
                </dl>
                <div class="mt-6 flex items-start gap-3 text-sm text-slate-500">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.7"
                        stroke="currentColor"
                        class="mt-0.5 h-5 w-5 shrink-0 text-green-600"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 21s7-4.35 7-10a7 7 0 1 0-14 0c0 5.65 7 10 7 10Z"
                        />
                    </svg>
                    <p>
                        Your general location can be used for distance-based blood
                        request discovery. Your exact address is not displayed to
                        other users.
                    </p>
                </div>
            @else
                <div class="border-t border-slate-100 pt-5">
                    <p class="text-sm text-slate-600">
                        Add your location to use distance-based blood request discovery.
                    </p>
                    <a
                        href="{{ route('profile.edit') }}"
                        class="mt-3 inline-block text-sm font-semibold text-red-600 hover:text-red-700"
                    >
                        Add location
                    </a>
                </div>
            @endif
        </section>
        {{-- =========================================================
            PROFILE COMPLETION
        ========================================================== --}}
    </div>
</section>
@endsection
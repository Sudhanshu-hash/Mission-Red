@extends('layouts.base')

@section('title', 'Dashboard | Mission Red')

@section('content')

    <section class="min-h-[calc(100vh-4rem)] bg-slate-50 py-8 sm:py-10 lg:py-12">
 {{-- Background Video --}}
    <!-- <video
        autoplay
        muted
        loop
        playsinline
        class="fixed inset-0 z-[-2] h-full w-full object-cover"
    >
        <source src="{{ asset('assets/index.mp4') }}" type="video/mp4">
        
    </video> -->
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- =========================================================
            DASHBOARD HEADER
            ========================================================== --}}
            <div class="mb-8 flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">

                <div>
                    <!-- <p class="mb-2 text-sm font-medium text-red-600">
                        Dashboard
                    </p> -->

                    <h1 class="text-3xl font-bold tracking-tight text-red-700 sm:text-4xl">
                        Good morning, {{ $user->name }}
                    </h1>

                    <p class="mt-2 max-w-xl text-sm leading-6 text-slate-500 sm:text-base">
                        Ready to help your community.
                    </p>
                </div>
         

            </div>


        {{-- =========================================================
PROFILE COMPLETION
========================================================== --}}

@if ($profileCompletion < 100)

    <div class="mb-6 overflow-hidden rounded-2xl border border-red-100 bg-white shadow-sm">

        <div class="p-5 sm:p-6">

            <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">

                {{-- Icon + Content --}}
                <div class="flex items-start gap-4">

                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-600">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="h-5 w-5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0
                                3.75 3.75 0 0 1 7.5 0ZM4.501 20.118
                                a7.5 7.5 0 0 1 14.998 0
                                A17.933 17.933 0 0 1 12 21.75
                                a17.933 17.933 0 0 1-7.499-1.632Z"
                            />
                        </svg>

                    </div>

                    <div class="min-w-0">

                        <div class="flex flex-wrap items-center gap-2">

                            <h2 class="text-sm font-semibold text-slate-900">
                                Complete your profile
                            </h2>

                            <span
                                class="rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-600"
                            >
                                {{ $profileCompletion }}%
                            </span>

                        </div>

                        <p class="mt-1 max-w-xl text-sm leading-5 text-slate-500">

                            @if ($profileCompletion < 60)
                                Add your blood group and location to get the most out of Mission Red.
                            @elseif ($profileCompletion < 100)
                                Your profile is {{ $profileCompletion }}% complete.
                                Complete the remaining details to enable distance-based discovery.
                            @endif

                        </p>

                    </div>

                </div>

                {{-- Edit Profile --}}
                <a
                    href="{{ route('profile.edit') }}"
                    class="inline-flex shrink-0 items-center justify-center rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                >
                    Complete Profile

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="ml-2 h-4 w-4"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"
                        />
                    </svg>

                </a>

            </div>

            {{-- Progress Bar --}}
            <div class="mt-5">

                <div class="mb-2 flex items-center justify-between">

                    <span class="text-xs font-medium text-slate-500">
                        Profile completion
                    </span>

                    <span class="text-xs font-semibold text-slate-700">
                        {{ $profileCompletion }}%
                    </span>

                </div>

                <div
                    class="h-2 overflow-hidden rounded-full bg-slate-100"
                    role="progressbar"
                    aria-valuenow="{{ $profileCompletion }}"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    aria-label="Profile completion"
                >
                    <div
                        class="h-full rounded-full bg-red-600 transition-all duration-500"
                        style="width: {{ $profileCompletion }}%"
                    ></div>
                </div>

            </div>

        </div>

    </div>

@elseif ($profileCompletion === 100)

    {{-- Fully completed profile --}}
    <div class="mb-6 rounded-2xl border border-green-100 bg-green-50/50 px-5 py-4 sm:px-6">

        <div class="flex items-center gap-3">

            <div
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-green-100 text-green-600"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="2"
                    stroke="currentColor"
                    class="h-5 w-5"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m5 12 4 4L19 7"
                    />
                </svg>
            </div>

            <div>

                <p class="text-sm font-semibold text-slate-900">
                    Your profile is complete
                </p>

                <p class="mt-0.5 text-sm text-slate-500">
                    Your location is ready for distance-based discovery.
                </p>

            </div>

        </div>

    </div>

@endif


            {{-- =========================================================
            PRIMARY ACTIONS
            ========================================================== --}}
            <div class="mb-8 grid gap-5 md:grid-cols-2">


                {{-- =====================================================
                REQUEST BLOOD
                ====================================================== --}}
                <div class="group relative overflow-hidden rounded-2xl bg-slate-950 p-6 shadow-sm sm:p-8">

                    <div class="relative z-10">

                        <div class="mb-8 flex items-start justify-between">

                            <span class="text-xs font-semibold uppercase tracking-[0.14em] text-red-400">
                                Need Blood
                            </span>

                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 text-white">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7"
                                    stroke="currentColor" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 3.75s6 6.042 6 10.125a6 6 0 1 1-12 0C6 9.792 12 3.75 12 3.75Z" />
                                </svg>

                            </div>

                        </div>

                        <h2 class="text-2xl font-semibold tracking-tight text-white">
                            Request blood
                        </h2>

                        <p class="mt-3 max-w-md text-sm leading-6 text-slate-300">
                            Create a blood request and let suitable donors
                            in your area find you.
                        </p>

                        <div class="mt-7">

                            {{-- Functional now --}}
                            <a href="{{ route('blood-requests.create') }}"
                                class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-slate-950">
                                Create Request

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>

                            </a>

                        </div>

                    </div>


                    {{-- Decorative elements --}}
                    <div class="absolute -bottom-16 -right-16 h-48 w-48 rounded-full border border-white/5"></div>

                    <div class="absolute -bottom-10 -right-10 h-32 w-32 rounded-full border border-red-500/10"></div>

                </div>


                {{-- =====================================================
                DONATE BLOOD
                ====================================================== --}}
                <div
                    class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

                    <div class="relative z-10">

                        <div class="mb-8 flex items-start justify-between">

                            <span class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">
                                Help Someone
                            </span>

                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 text-red-600">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7"
                                    stroke="currentColor" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 3.75s6 6.042 6 10.125a6 6 0 1 1-12 0C6 9.792 12 3.75 12 3.75Z" />
                                </svg>

                            </div>

                        </div>

                        <h2 class="text-2xl font-semibold tracking-tight text-slate-950">
                            Donate blood
                        </h2>

                        <p class="mt-3 max-w-md text-sm leading-6 text-slate-500">
                            Discover nearby blood requests that may match
                            your blood group.
                        </p>

                        <div class="mt-7">

                            <a href="{{ route('blood-requests.discover') }}"
                                class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                Find Requests

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>
                            </a>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =========================================================
            ACTIVE REQUEST
            ========================================================== --}}
            <div class="mb-8 rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-100 px-6 py-5 sm:px-7">

                    <div class="flex items-center justify-between gap-4">

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">
                                Requests
                            </p>

                            <h2 class="mt-1.5 text-lg font-semibold text-slate-950">
                                Your active request
                            </h2>

                        </div>


                        {{-- My Requests --}}
                        <a href="{{ route('blood-requests.index') }}"
                            class="shrink-0 text-sm font-semibold text-red-600 transition hover:text-red-700">
                            My Requests
                        </a>

                    </div>

                </div>


                @if ($activeRequest)

                    <div class="p-6 sm:p-7">

                        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                            {{-- Request summary --}}
                            <div>

                                <div class="flex items-center gap-3">

                                    <span class="text-3xl font-bold text-red-600">
                                        {{ $activeRequest->bloodGroup->name }}
                                    </span>

                                    <span
                                        class="rounded-full border border-green-200 bg-green-50 px-3 py-1.5 text-xs font-semibold text-green-700">
                                        Active
                                    </span>

                                </div>

                                <p class="mt-2 text-sm text-slate-500">
                                    Blood request created
                                    {{ $activeRequest->created_at->format('d M Y') }}
                                </p>

                            </div>


                            {{-- Request details --}}
                            <div class="grid grid-cols-3 gap-6">

                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-400">
                                        Required
                                    </p>

                                    <p class="mt-1 text-lg font-semibold text-slate-950">
                                        {{ $activeRequest->required_quantity }}
                                    </p>

                                    <p class="text-xs text-slate-400">
                                        units
                                    </p>
                                </div>


                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-400">
                                        Fulfilled
                                    </p>

                                    <p class="mt-1 text-lg font-semibold text-green-600">
                                        {{ $activeRequest->fulfilled_quantity }}
                                    </p>

                                    <p class="text-xs text-slate-400">
                                        units
                                    </p>
                                </div>


                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-400">
                                        Remaining
                                    </p>

                                    <p class="mt-1 text-lg font-semibold text-red-600">
                                        {{ $activeRequest->remaining_quantity }}
                                    </p>

                                    <p class="text-xs text-slate-400">
                                        units
                                    </p>
                                </div>

                            </div>

                        </div>


                        {{-- Location + date --}}
                        <div
                            class="mt-6 flex flex-col gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:items-center sm:justify-between">

                            <div class="text-sm text-slate-500">

                                <span class="font-medium text-slate-700">
                                    {{ $activeRequest->locality }}
                                </span>

                                <span class="mx-1">
                                    ,
                                </span>

                                {{ $activeRequest->region }}

                            </div>

                            <div class="text-sm text-slate-500">

                                Required by
                                <span class="font-semibold text-slate-800">
                                    {{ $activeRequest->required_date->format('d M Y') }}
                                </span>

                            </div>

                        </div>


                        {{-- Action --}}
                        <div class="mt-5">
                            <a href="{{ route('blood-requests.index') }}"
                                class="inline-flex items-center gap-2 rounded-xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                                View My Requests

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                                    stroke="currentColor" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>
                            </a>
                            <!-- <a
                        href="{{ route('blood-requests.index') }}"
                        class="inline-flex items-center gap-2 rounded-xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
                    >
                        View Request

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="h-4 w-4"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"
                            />
                        </svg>

                    </a> -->

                        </div>

                    </div>

                @else

                    {{-- Empty state --}}
                    <div class="px-6 py-12 text-center sm:px-7">

                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6"
                                stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m0 3h.008v.008H12V15.75ZM10.5 3.75h3L21 19.5H3L10.5 3.75Z" />
                            </svg>

                        </div>

                        <h3 class="mt-4 text-sm font-semibold text-slate-800">
                            No active blood request
                        </h3>

                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                            When you create a blood request, its status,
                            donor responses and approximate location will appear here.
                        </p>

                    </div>

                @endif

            </div>


            {{-- =========================================================
            ACTIVITY + CONNECTIONS
            ========================================================== --}}
            <div class="grid gap-5 md:grid-cols-2">


                {{-- =====================================================
                ACTIVITY
                ====================================================== --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-7">

                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">
                        Overview
                    </p>

                    <h2 class="mt-1.5 text-lg font-semibold text-slate-950">
                        Your activity
                    </h2>

                    <div class="mt-6 divide-y divide-slate-100">

                        <div class="flex items-center justify-between py-4 first:pt-0">

                            <span class="text-sm text-slate-500">
                                Active requests
                            </span>

                            <span class="text-lg font-semibold text-slate-950">
                                {{ $activeRequestCount }}
                            </span>

                        </div>


                        <div class="flex items-center justify-between py-4">

                            <span class="text-sm text-slate-500">
                                Donor responses
                            </span>

                            <span class="text-lg font-semibold text-slate-950">
                                {{ $donorResponseCount }}
                            </span>

                        </div>


                        <div class="flex items-center justify-between py-4 last:pb-0">

                            <span class="text-sm text-slate-500">
                                Completed requests
                            </span>

                            <span class="text-lg font-semibold text-slate-950">
                                {{ $completedRequestCount }}
                            </span>

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                CONNECTIONS
                ====================================================== --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-7">

                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">
                        Communication
                    </p>

                    <h2 class="mt-1.5 text-lg font-semibold text-slate-950">
                        Your connections
                    </h2>

                    <div class="mt-6 rounded-xl border border-dashed border-slate-200 bg-slate-50 px-5 py-8 text-center">

                        <p class="text-sm leading-6 text-slate-500">
                            Accepted donor and requester connections
                            will appear here.
                        </p>

                        <button type="button" disabled class="mt-4 cursor-not-allowed text-sm font-semibold text-slate-400">
                            View Connections
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection
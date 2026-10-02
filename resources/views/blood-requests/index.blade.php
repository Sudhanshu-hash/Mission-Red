@extends('layouts.base')

@section('title', 'My Blood Requests | Mission Red')

@section('content')

<section class="min-h-[calc(100vh-4rem)] bg-slate-50 py-8 sm:py-10">

    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
 <a
                href="{{ route('dashboard') }}"
                class="mb-5 inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-slate-900"
            >
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
                        d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"
                    />
                </svg>

                Back to Dashboard
            </a>
        {{-- Header --}}
        <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

            <div>
                <p class="text-sm font-semibold text-red-600">
                    Blood Requests
                </p>

                <h1 class="mt-1.5 text-3xl font-bold tracking-tight text-slate-950">
                    My requests
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                    View and manage the blood requests you have created.
                </p>
            </div>

            <a
                href="{{ route('blood-requests.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="2"
                    stroke="currentColor"
                    class="h-4 w-4"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 4.5v15m7.5-7.5h-15"
                    />
                </svg>

                Request Blood
            </a>

        </div>


        {{-- Success message --}}
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                {{ session('success') }}
            </div>
        @endif


        {{-- Empty state --}}
        @if ($bloodRequests->isEmpty())

            <div class="rounded-2xl border border-slate-200 bg-white px-6 py-14 text-center shadow-sm">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-red-50 text-red-600">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-7 w-7"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 3.75c-3.75 4.125-6 7.05-6 10.125a6 6 0 0 0 12 0c0-3.075-2.25-6-6-10.125Z"
                        />
                    </svg>

                </div>

                <h2 class="mt-5 text-lg font-semibold text-slate-950">
                    No blood requests yet
                </h2>

                <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                    If you or someone you are helping needs blood,
                    create a request and let suitable donors discover it.
                </p>

                <a
                    href="{{ route('blood-requests.create') }}"
                    class="mt-6 inline-flex items-center justify-center rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-700"
                >
                    Create your first request
                </a>

            </div>

        @else

            {{-- Request list --}}
            <div class="space-y-4">

                @foreach ($bloodRequests as $bloodRequest)

                    <article class="rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:border-slate-300">

                        <div class="p-5 sm:p-6">

                            <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

                                {{-- Main information --}}
                                <div class="flex min-w-0 items-start gap-4">

                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-red-50 text-sm font-bold text-red-600">
                                        {{ $bloodRequest->bloodGroup->name }}
                                    </div>

                                    <div class="min-w-0">

                                        <div class="flex flex-wrap items-center gap-2">

                                            <h2 class="text-base font-semibold text-slate-950">
                                                {{ $bloodRequest->bloodGroup->name }} blood request
                                            </h2>

                                            <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold capitalize text-slate-600">
                                                {{ $bloodRequest->status }}
                                            </span>

                                        </div>

                                        <p class="mt-1 text-sm text-slate-500">
                                            {{ $bloodRequest->region }}
                                            <span class="mx-1">·</span>
                                            {{ $bloodRequest->locality }}
                                        </p>

                                    </div>

                                </div>


                                {{-- Action --}}
                                <a
                                    href="{{ route('blood-requests.show', $bloodRequest) }}"
                                    class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
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
                                            d="m9 18 6-6-6-6"
                                        />
                                    </svg>
                                </a>

                            </div>


                            {{-- Request metadata --}}
                            <div class="mt-5 grid grid-cols-2 gap-4 border-t border-slate-100 pt-5 sm:grid-cols-4">

                                <div>
                                    <p class="text-xs font-medium text-slate-400">
                                        Required
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-slate-800">
                                        {{ $bloodRequest->required_quantity }}
                                        {{ $bloodRequest->required_quantity === 1 ? 'unit' : 'units' }}
                                    </p>
                                </div>


                                <div>
                                    <p class="text-xs font-medium text-slate-400">
                                        Remaining
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-slate-800">
                                        {{ $bloodRequest->remaining_quantity }}
                                        {{ $bloodRequest->remaining_quantity === 1 ? 'unit' : 'units' }}
                                    </p>
                                </div>


                                <div>
                                    <p class="text-xs font-medium text-slate-400">
                                        Required date
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-slate-800">
                                        {{ $bloodRequest->required_date->format('d M Y') }}
                                    </p>
                                </div>


                                <div>
                                    <p class="text-xs font-medium text-slate-400">
                                        Urgency
                                    </p>

                                    <p class="mt-1 text-sm font-semibold capitalize text-slate-800">
                                        {{ $bloodRequest->urgency }}
                                    </p>
                                </div>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>


            {{-- Pagination --}}
            @if ($bloodRequests->hasPages())

                <div class="mt-6">
                    {{ $bloodRequests->links() }}
                </div>

            @endif

        @endif

    </div>

</section>

@endsection
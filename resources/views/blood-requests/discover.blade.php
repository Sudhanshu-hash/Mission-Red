@extends('layouts.base')

@section('title', 'Find Blood Requests | Mission Red')

@section('content')

    <section class="min-h-[calc(100vh-4rem)] bg-slate-50 py-8 sm:py-10 lg:py-12">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- =========================================================
            HEADER
            ========================================================== --}}

            <div class="mb-8">
                <a href="{{ route('dashboard') }}"
                    class="mb-5 inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>

                    Back to Dashboard
                </a>
                <p class="text-sm font-medium text-red-600">
                    Community
                </p>

                <div class="mt-2 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                    <div>

                        <h1 class="text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">
                            Find blood requests
                        </h1>

                        <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500 sm:text-base">
                            Browse active blood requests from the Mission Red community.
                            You can donate directly or help arrange blood through someone you know.
                        </p>

                    </div>

                    <!-- <a
                        href="{{ route('blood-requests.create') }}"
                        class="inline-flex items-center justify-center rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-700"
                    >
                        Request Blood
                    </a> -->

                </div>

            </div>


            {{-- =========================================================
            COMMUNITY REQUESTS
            ========================================================== --}}

            <section>

                <div class="mb-5">

                    <!-- <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-400">
                        Community
                    </p> -->

                    <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-950">
                        Community Requests
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Help people who need blood. Every active request is visible to the community.
                    </p>

                </div>


                {{-- =========================================================
                FILTERS
                ========================================================== --}}

                <form method="GET" action="{{ route('blood-requests.discover') }}"
                    class="mb-8 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

                    <div class="mb-5">

                        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-400">
                            Filter Requests
                        </p>

                        <h3 class="mt-1 text-lg font-semibold text-slate-950">
                            Find requests that matter to you
                        </h3>

                    </div>


                  <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                        {{-- Blood Group --}}

                        <div>

                            <label for="blood_group_id" class="mb-2 block text-sm font-medium text-slate-700">
                                Blood Group
                            </label>

                            <select id="blood_group_id" name="blood_group_id"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100">

                                <option value="">
                                    All Blood Groups
                                </option>

                                @foreach ($bloodGroups as $bloodGroup)

                                    <option value="{{ $bloodGroup->id }}" @selected(request('blood_group_id') == $bloodGroup->id)>
                                        {{ $bloodGroup->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- Urgency --}}

                        <div>

                            <label for="urgency" class="mb-2 block text-sm font-medium text-slate-700">
                                Urgency
                            </label>

                            <select id="urgency" name="urgency"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100">

                                <option value="">
                                    All Urgency Levels
                                </option>

                                <option value="critical" @selected(request('urgency') === 'critical')>
                                    Critical
                                </option>

                                <option value="urgent" @selected(request('urgency') === 'urgent')>
                                    Urgent
                                </option>

                                <option value="normal" @selected(request('urgency') === 'normal')>
                                    Normal
                                </option>

                            </select>

                        </div>


                        {{-- Region --}}

                        <div>

                            <label for="region" class="mb-2 block text-sm font-medium text-slate-700">
                                Region
                            </label>

                            <input type="text" id="region" name="region" value="{{ request('region') }}"
                                placeholder="e.g. Rajasthan"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-red-500 focus:ring-2 focus:ring-red-100">

                        </div>


                        {{-- Locality --}}

                        <div>

                            <label for="locality" class="mb-2 block text-sm font-medium text-slate-700">
                                Locality
                            </label>

                            <input type="text" id="locality" name="locality" value="{{ request('locality') }}"
                                placeholder="e.g. Vaishali Nagar"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-red-500 focus:ring-2 focus:ring-red-100">

                        </div>
{{-- Radius --}}
<div>

    <label
        for="radius"
        class="mb-2 block text-sm font-medium text-slate-700"
    >
        Distance
    </label>

    <select
        id="radius"
        name="radius"
        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100"
    >

        <option value="2" @selected(request('radius', '10') === '2')>
            Within 2 km
        </option>

        <option value="5" @selected(request('radius', '10') === '5')>
            Within 5 km
        </option>

        <option value="10" @selected(request('radius', '10') === '10')>
            Within 10 km
        </option>

        <option value="25" @selected(request('radius', '10') === '25')>
            Within 25 km
        </option>

        <option value="50" @selected(request('radius', '10') === '50')>
            Within 50 km
        </option>

        <option value="100" @selected(request('radius', '10') === '100')>
            Within 100 km
        </option>

        <option value="all" @selected(request('radius', '10') === 'all')>
            All distances
        </option>

    </select>

</div>
                    </div>


                    <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:justify-end">

                        <a href="{{ route('blood-requests.discover') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            Clear Filters
                        </a>

                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                            Apply Filters
                        </button>

                    </div>

                </form>


                {{-- =========================================================
                RESULTS HEADER
                ========================================================== --}}

                <div>

    <p class="text-sm text-slate-500">

        Showing

        <span class="font-semibold text-slate-800">
            {{ $communityRequests->total() }}
        </span>

        community requests

    </p>

    @if (request('radius', '10') !== 'all')
        <p class="mt-1 text-xs text-slate-400">
            Within {{ request('radius', '10') }} km of your location
        </p>
    @else
        <p class="mt-1 text-xs text-slate-400">
            Showing requests at all distances
        </p>
    @endif

</div>


                {{-- =========================================================
                COMMUNITY REQUESTS
                ========================================================== --}}

                @if ($communityRequests->count())

                    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">

                        @foreach ($communityRequests as $bloodRequest)

                            @php

                                $remainingQuantity = $bloodRequest->remaining_quantity;

                                $urgencyClasses = match ($bloodRequest->urgency) {

                                    'critical' =>
                                        'bg-red-50 text-red-700 border-red-200',

                                    'urgent' =>
                                        'bg-amber-50 text-amber-700 border-amber-200',

                                    default =>
                                        'bg-slate-100 text-slate-600 border-slate-200',

                                };

                                $alreadyResponded = $bloodRequest->responses
                                    ->contains('user_id', auth()->id());

                            @endphp


                            <article
                                class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">

                                {{-- =================================================
                                REQUEST HEADER
                                ================================================== --}}

                                <div class="border-b border-slate-100 p-5">

                                    <div class="flex items-start justify-between gap-4">

                                        <div>

                                            <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-400">
                                                Blood Required
                                            </p>

                                            <h3 class="mt-2 text-3xl font-bold text-red-600">
                                                {{ $bloodRequest->bloodGroup->name }}
                                            </h3>

                                        </div>


                                        <span class="rounded-full border px-3 py-1.5 text-xs font-semibold {{ $urgencyClasses }}">
                                            {{ ucfirst($bloodRequest->urgency) }}
                                        </span>

                                    </div>

                                </div>


                                {{-- =================================================
                                REQUEST INFORMATION
                                ================================================== --}}

                                <div class="p-5">

                                    <div class="space-y-4">

                                        {{-- Quantity --}}

                                        <div class="flex items-center justify-between">

                                            <span class="text-sm text-slate-500">
                                                Remaining
                                            </span>

                                            <span class="text-sm font-semibold text-slate-900">

                                                {{ $remainingQuantity }}

                                                {{ Str::plural('unit', $remainingQuantity) }}

                                            </span>

                                        </div>


                                        {{-- Date --}}

                                        <div class="flex items-center justify-between">

                                            <span class="text-sm text-slate-500">
                                                Required date
                                            </span>

                                            <span class="text-sm font-semibold text-slate-900">
                                                {{ $bloodRequest->required_date->format('d M Y') }}
                                            </span>

                                        </div>


{{-- Location --}}
<div>

    <p class="text-sm text-slate-500">
        Location
    </p>

    <p class="mt-1 text-sm font-semibold text-slate-900">
        {{ $bloodRequest->location?->locality ?? $bloodRequest->locality }},
        {{ $bloodRequest->location?->city ?? $bloodRequest->region }}
    </p>

    @if (isset($bloodRequest->distance_km))
        <p class="mt-1 text-xs font-medium text-slate-500">
            {{ number_format((float) $bloodRequest->distance_km, 2) }}
            km away
        </p>
    @endif

</div>

                                    </div>


                                    {{-- =================================================
                                    VIEW REQUEST
                                    ================================================== --}}

                                    <div class="mt-6 border-t border-slate-100 pt-5">

                                        <a href="{{ route('blood-requests.show', $bloodRequest) }}"
                                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">

                                            View Request

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.8" stroke="currentColor" class="h-4 w-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                            </svg>

                                        </a>

                                    </div>


                                    {{-- =================================================
                                    RESPONSE FORM
                                    ================================================== --}}

                                    @if ($alreadyResponded)

                                        <div class="mt-5 border-t border-slate-100 pt-5">

                                            <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-4">

                                                <p class="text-sm font-semibold text-green-800">
                                                    Response submitted
                                                </p>

                                                <p class="mt-1 text-xs leading-5 text-green-700">
                                                    You have already responded to this request.
                                                </p>

                                            </div>

                                        </div>

                                    @else

                                        <div class="mt-5 border-t border-slate-100 pt-5">

                                            <form method="POST" action="{{ route('blood-request-responses.store', $bloodRequest) }}">

                                                @csrf


                                                {{-- Response Type --}}

                                                <div>

                                                    <label class="mb-3 block text-sm font-medium text-slate-700">
                                                        How would you like to help?
                                                    </label>

                                                    <div class="grid gap-3 sm:grid-cols-2">

                                                        {{-- Donate --}}

                                                        <label class="cursor-pointer">

                                                            <input type="radio" name="response_type" value="donate" class="peer sr-only"
                                                                required>

                                                            <div
                                                                class="rounded-xl border border-slate-200 bg-white p-4 transition hover:border-slate-300 peer-checked:border-red-500 peer-checked:bg-red-50">

                                                                <p class="text-sm font-semibold text-slate-900">
                                                                    I Can Donate
                                                                </p>

                                                                <p class="mt-1 text-xs leading-5 text-slate-500">
                                                                    I can personally donate blood.
                                                                </p>

                                                            </div>

                                                        </label>


                                                        {{-- Arrange --}}

                                                        <label class="cursor-pointer">

                                                            <input type="radio" name="response_type" value="arrange"
                                                                class="peer sr-only">

                                                            <div
                                                                class="rounded-xl border border-slate-200 bg-white p-4 transition hover:border-slate-300 peer-checked:border-red-500 peer-checked:bg-red-50">

                                                                <p class="text-sm font-semibold text-slate-900">
                                                                    I Can Help Arrange
                                                                </p>

                                                                <p class="mt-1 text-xs leading-5 text-slate-500">
                                                                    I can connect the requester with someone who can help.
                                                                </p>

                                                            </div>

                                                        </label>

                                                    </div>

                                                </div>


                                                {{-- Quantity --}}

                                                <div class="mt-4">

                                                    <label for="quantity-{{ $bloodRequest->id }}"
                                                        class="mb-2 block text-sm font-medium text-slate-700">

                                                        Quantity

                                                        <span id="quantity-required-label-{{ $bloodRequest->id }}"
                                                            class="font-normal text-slate-400">
                                                            (required for donation)
                                                        </span>

                                                    </label>

                                                    <input type="number" id="quantity-{{ $bloodRequest->id }}" name="quantity" min="1"
                                                        max="{{ $remainingQuantity }}" value="1" required
                                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100">

                                                    <p id="quantity-help-{{ $bloodRequest->id }}" class="mt-1.5 text-xs text-slate-400">
                                                        You can offer up to
                                                        {{ $remainingQuantity }}
                                                        {{ Str::plural('unit', $remainingQuantity) }}.
                                                    </p>

                                                </div>


                                                {{-- Message --}}

                                                <div class="mt-4">

                                                    <label for="message-{{ $bloodRequest->id }}"
                                                        class="mb-2 block text-sm font-medium text-slate-700">

                                                        Message

                                                        <span class="font-normal text-slate-400">
                                                            (optional for donation, recommended for arranging)
                                                        </span>

                                                    </label>

                                                    <textarea id="message-{{ $bloodRequest->id }}" name="message" rows="3"
                                                        placeholder="Add a short message..."
                                                        class="w-full resize-none rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-red-500 focus:ring-2 focus:ring-red-100"></textarea>

                                                </div>


                                                {{-- Submit --}}

                                                <button type="submit"
                                                    class="mt-4 inline-flex w-full items-center justify-center rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-700">
                                                    Submit Response
                                                </button>

                                            </form>

                                        </div>

                                    @endif

                                </div>

                            </article>

                        @endforeach

                    </div>


                    {{-- =========================================================
                    PAGINATION
                    ========================================================== --}}

                    @if ($communityRequests->hasPages())

                        <div class="mt-8">
                            {{ $communityRequests->links() }}
                        </div>

                    @endif

                @else

                    <div class="rounded-2xl border border-slate-200 bg-white px-6 py-16 text-center shadow-sm">

                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6"
                                stroke="currentColor" class="h-7 w-7">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m0 3h.008v.008H12V15.75ZM10.5 3.75h3L21 19.5H3L10.5 3.75Z" />
                            </svg>

                        </div>

                        <h2 class="mt-5 text-lg font-semibold text-slate-900">
                            No community blood requests found
                        </h2>

                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                            There are currently no active community requests matching
                            your filters. Try removing some filters or check again later.
                        </p>

                        <a href="{{ route('blood-requests.discover') }}"
                            class="mt-6 inline-flex items-center justify-center rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            View All Requests
                        </a>

                    </div>

                @endif

            </section>

        </div>

    </section>

@endsection


@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            document
                .querySelectorAll('form[action*="blood-request-responses"]')
                .forEach(function (form) {

                    const donateRadio = form.querySelector(
                        'input[name="response_type"][value="donate"]'
                    );

                    const arrangeRadio = form.querySelector(
                        'input[name="response_type"][value="arrange"]'
                    );

                    const quantityInput = form.querySelector(
                        'input[name="quantity"]'
                    );

                    const quantityRequiredLabel = form.querySelector(
                        '[id^="quantity-required-label-"]'
                    );

                    const quantityHelp = form.querySelector(
                        '[id^="quantity-help-"]'
                    );


                    if (
                        !donateRadio ||
                        !arrangeRadio ||
                        !quantityInput
                    ) {
                        return;
                    }


                    function updateQuantityField() {

                        if (donateRadio.checked) {

                            quantityInput.required = true;
                            quantityInput.disabled = false;

                            quantityRequiredLabel.textContent =
                                '(required for donation)';

                            quantityHelp.textContent =
                                'You can offer up to ' +
                                quantityInput.max +
                                ' unit(s).';

                        } else if (arrangeRadio.checked) {

                            quantityInput.required = false;
                            quantityInput.disabled = false;

                            quantityRequiredLabel.textContent =
                                '(optional for arranging)';

                            quantityHelp.textContent =
                                'You can leave this blank when helping arrange blood.';

                        }

                    }


                    donateRadio.addEventListener(
                        'change',
                        updateQuantityField
                    );

                    arrangeRadio.addEventListener(
                        'change',
                        updateQuantityField
                    );


                    updateQuantityField();

                });

        });
    </script>

@endpush
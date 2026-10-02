@extends('layouts.base')

@section('title', 'Blood Request | Mission Red')

@section('content')

<section class="min-h-[calc(100vh-4rem)] bg-slate-50 py-8 sm:py-10 lg:py-12">

    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

        @php
            $isOwner = $bloodRequest->requester_id === auth()->id();

            $statusClasses = match ($bloodRequest->status) {
                'active' => 'bg-green-50 text-green-700 border-green-200',
                'fulfilled' => 'bg-blue-50 text-blue-700 border-blue-200',
                'cancelled' => 'bg-slate-100 text-slate-600 border-slate-200',
                'expired' => 'bg-amber-50 text-amber-700 border-amber-200',
                default => 'bg-slate-100 text-slate-600 border-slate-200',
            };

            $alreadyResponded = !$isOwner
                ? $bloodRequest->responses->contains('user_id', auth()->id())
                : false;
        @endphp


        {{-- =========================================================
            BACK NAVIGATION
        ========================================================== --}}
        <div class="mb-6">

            <a
                href="{{ $isOwner
                    ? route('blood-requests.index')
                    : route('blood-requests.discover') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-slate-900"
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

                {{ $isOwner ? 'My Requests' : 'Find Blood Requests' }}

            </a>

        </div>


        {{-- =========================================================
            HEADER
        ========================================================== --}}
        <div class="mb-8">

            <p class="text-sm font-medium text-red-600">
                Blood Request
            </p>

            <div class="mt-2 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <h1 class="text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">
                        {{ $bloodRequest->bloodGroup->name }} Blood Required
                    </h1>

                    <p class="mt-2 text-sm text-slate-500">
                        Created {{ $bloodRequest->created_at->format('d M Y') }}
                    </p>

                </div>


                <span
                    class="inline-flex w-fit rounded-full border px-3 py-1.5 text-xs font-semibold {{ $statusClasses }}"
                >
                    {{ ucfirst($bloodRequest->status) }}
                </span>

            </div>

        </div>


        {{-- =========================================================
            MAIN REQUEST CARD
        ========================================================== --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">


            {{-- =====================================================
                BLOOD SUMMARY
            ====================================================== --}}
            <div class="border-b border-slate-100 p-6 sm:p-8">

                <div class="grid gap-6 sm:grid-cols-3">


                    {{-- Blood Group --}}
                    <div>

                        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-400">
                            Blood Group
                        </p>

                        <p class="mt-2 text-2xl font-bold text-red-600">
                            {{ $bloodRequest->bloodGroup->name }}
                        </p>

                    </div>


                    {{-- Required --}}
                    <div>

                        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-400">
                            Required
                        </p>

                        <p class="mt-2 text-2xl font-bold text-slate-950">
                            {{ $bloodRequest->required_quantity }}

                            <span class="text-base font-medium text-slate-500">
                                units
                            </span>
                        </p>

                    </div>


                    {{-- Remaining --}}
                    <div>

                        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-400">
                            Remaining
                        </p>

                        <p class="mt-2 text-2xl font-bold text-slate-950">
                            {{ $bloodRequest->remaining_quantity }}

                            <span class="text-base font-medium text-slate-500">
                                units
                            </span>
                        </p>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                REQUEST INFORMATION
            ====================================================== --}}
            <div class="p-6 sm:p-8">

                <h2 class="text-lg font-semibold text-slate-950">
                    Request information
                </h2>

                <div class="mt-6 grid gap-x-8 gap-y-6 sm:grid-cols-2">


                    {{-- Required date --}}
                    <div>

                        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-400">
                            Required date
                        </p>

                        <p class="mt-2 text-sm font-medium text-slate-800">
                            {{ $bloodRequest->required_date->format('d M Y') }}
                        </p>

                    </div>


                    {{-- Urgency --}}
                    <div>

                        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-400">
                            Urgency
                        </p>

                        <p class="mt-2 text-sm font-medium capitalize text-slate-800">
                            {{ $bloodRequest->urgency }}
                        </p>

                    </div>


                    {{-- Region --}}
                    <div>

                        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-400">
                            Region
                        </p>

                        <p class="mt-2 text-sm font-medium text-slate-800">
                            {{ $bloodRequest->region }}
                        </p>

                    </div>


                    {{-- Locality --}}
                    <div>

                        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-400">
                            Locality
                        </p>

                        <p class="mt-2 text-sm font-medium text-slate-800">
                            {{ $bloodRequest->locality }}
                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
            COMMUNITY RESPONSE SECTION
        ========================================================== --}}
        @if (
            !$isOwner &&
            $bloodRequest->status === 'active' &&
            $bloodRequest->remaining_quantity > 0
        )

            <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

                <div class="mb-5">

                    <h2 class="text-lg font-semibold text-slate-900">
                        Help with this request
                    </h2>

                    <p class="mt-1 text-sm text-slate-600">
                        You can donate blood directly or help connect the requester
                        with someone who can donate.
                    </p>

                </div>


                {{-- Already Responded --}}
                @if ($alreadyResponded)

                    <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">

                        You have already responded to this request.

                    </div>


                @else

                    {{-- Response Form --}}
                    <form
                        method="POST"
                        action="{{ route('blood-request-responses.store', $bloodRequest) }}"
                        class="space-y-5"
                    >

                        @csrf


                        {{-- Response Type --}}
                        <div>

                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                How can you help?
                            </label>

                            <div class="grid gap-3 sm:grid-cols-2">


                                {{-- Donate --}}
                                <label class="cursor-pointer">

                                    <input
                                        type="radio"
                                        name="response_type"
                                        value="donate"
                                        class="peer sr-only"
                                        {{ old('response_type', 'donate') === 'donate' ? 'checked' : '' }}
                                    >

                                    <div class="rounded-xl border border-slate-300 p-4 transition peer-checked:border-red-500 peer-checked:bg-red-50">

                                        <div class="font-semibold text-slate-900">
                                            I Can Donate
                                        </div>

                                        <div class="mt-1 text-xs text-slate-500">
                                            I can personally donate blood.
                                        </div>

                                    </div>

                                </label>


                                {{-- Arrange --}}
                                <label class="cursor-pointer">

                                    <input
                                        type="radio"
                                        name="response_type"
                                        value="arrange"
                                        class="peer sr-only"
                                        {{ old('response_type') === 'arrange' ? 'checked' : '' }}
                                    >

                                    <div class="rounded-xl border border-slate-300 p-4 transition peer-checked:border-red-500 peer-checked:bg-red-50">

                                        <div class="font-semibold text-slate-900">
                                            I Can Help Arrange
                                        </div>

                                        <div class="mt-1 text-xs text-slate-500">
                                            I can help connect the requester with a donor.
                                        </div>

                                    </div>

                                </label>

                            </div>

                        </div>


                        {{-- Quantity --}}
                        <div id="response-quantity-field">

                            <label
                                for="quantity"
                                class="mb-2 block text-sm font-medium text-slate-700"
                            >
                                Quantity I can donate
                            </label>

                            <input
                                type="number"
                                id="quantity"
                                name="quantity"
                                min="1"
                                max="{{ $bloodRequest->remaining_quantity }}"
                                value="{{ old('quantity') }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100"
                                placeholder="Enter quantity"
                            >

                            <p class="mt-1 text-xs text-slate-500">
                                Remaining requirement:
                                {{ $bloodRequest->remaining_quantity }} unit(s)
                            </p>

                            @error('quantity')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Message --}}
                        <div>

                            <label
                                for="message"
                                class="mb-2 block text-sm font-medium text-slate-700"
                            >
                                Message
                                <span class="font-normal text-slate-400">
                                    (optional)
                                </span>
                            </label>

                            <textarea
                                id="message"
                                name="message"
                                rows="4"
                                maxlength="1000"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100"
                                placeholder="Add any useful information for the requester..."
                            >{{ old('message') }}</textarea>

                            @error('message')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Response Type Error --}}
                        @error('response_type')

                            <p class="text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror


                        {{-- Submit --}}
                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-700 sm:w-auto"
                        >
                            Send Response
                        </button>

                    </form>

                @endif

            </div>


            {{-- Response Form JavaScript --}}
            <script>
                document.addEventListener('DOMContentLoaded', function () {

                    const responseTypes = document.querySelectorAll(
                        'input[name="response_type"]'
                    );

                    const quantityField = document.getElementById(
                        'response-quantity-field'
                    );

                    const quantityInput = document.getElementById('quantity');

                    if (!quantityField || !quantityInput) {
                        return;
                    }

                    function toggleQuantityField() {

                        const selected = document.querySelector(
                            'input[name="response_type"]:checked'
                        );

                        if (!selected) {
                            return;
                        }

                        const label = quantityField.querySelector('label');
                        const description = quantityField.querySelector('p');

                        if (selected.value === 'donate') {

                            label.textContent = 'Quantity I can donate';

                            quantityInput.required = true;

                            description.textContent =
                                'Remaining requirement: {{ $bloodRequest->remaining_quantity }} unit(s)';

                        } else {

                            label.textContent = 'Quantity I can help arrange';

                            quantityInput.required = false;

                            description.textContent =
                                'Optional. Leave blank if you are only helping connect the requester with another donor.';

                        }
                    }

                    responseTypes.forEach(function (radio) {

                        radio.addEventListener(
                            'change',
                            toggleQuantityField
                        );

                    });

                    toggleQuantityField();

                });
            </script>

        @endif


        {{-- =========================================================
            REQUEST RESPONSES
            OWNER ONLY
        ========================================================== --}}
        @if ($isOwner)

            <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">

                <div class="p-6 sm:p-8">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-400">
                                Donor responses
                            </p>

                            <h2 class="mt-1 text-lg font-semibold text-slate-950">
                                People who want to help
                            </h2>

                        </div>


                        <div class="flex items-center gap-3">

                            {{-- Response Count --}}
                            <div class="flex h-10 min-w-10 items-center justify-center rounded-xl bg-white px-3 text-sm font-semibold text-slate-700 shadow-sm">
                                {{ $bloodRequest->responses->count() }}
                            </div>


                            {{-- View Responses --}}
                            @if ($bloodRequest->responses->isNotEmpty())

                                <a
                                    href="{{ route('blood-request-responses.index', $bloodRequest) }}"
                                    class="inline-flex items-center gap-2 rounded-xl bg-slate-950 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800"
                                >

                                    View Responses

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

                                </a>

                            @endif

                        </div>

                    </div>


                    {{-- Response Information --}}
                    <div class="mt-6 rounded-xl border border-dashed border-slate-200 bg-white px-5 py-8 text-center">

                        @if ($bloodRequest->responses->isNotEmpty())

                            <p class="text-sm leading-6 text-slate-500">
                                People from the Mission Red community have responded
                                to this request. Review their responses to decide
                                how to proceed.
                            </p>

                        @else

                            <p class="text-sm leading-6 text-slate-500">
                                Responses from people who want to donate blood
                                or help arrange blood will appear here.
                            </p>

                        @endif

                    </div>

                </div>

            </div>

        @endif


        {{-- =========================================================
            REQUEST MANAGEMENT
            OWNER ONLY
        ========================================================== --}}
        @if ($isOwner && $bloodRequest->status === 'active')

            <div class="mt-6 flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:flex-row sm:justify-end sm:p-8">


                {{-- Edit Request --}}
                <a
                    href="{{ route('blood-requests.edit', $bloodRequest) }}"
                    class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    Edit Request
                </a>


                {{-- Cancel Request --}}
                <form
                    method="POST"
                    action="{{ route('blood-requests.destroy', $bloodRequest) }}"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        onclick="return confirm('Are you sure you want to cancel this blood request?')"
                        class="inline-flex w-full items-center justify-center rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-700 sm:w-auto"
                    >
                        Cancel Request
                    </button>

                </form>

            </div>

        @endif

    </div>

</section>

@endsection
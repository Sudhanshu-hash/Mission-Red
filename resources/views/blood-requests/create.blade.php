@extends('layouts.base')

@section('title', 'Request Blood | Mission Red')

@section('content')

<section class="min-h-[calc(100vh-4rem)] bg-slate-50 py-8 sm:py-10 lg:py-12">

    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8">

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

            <p class="text-sm font-semibold text-red-600">
                Request Blood
            </p>

            <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">
                Tell us what you need
            </h1>

            <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-500 sm:text-base">
                Provide the basic details about the blood requirement.
                Mission Red will use your request to help suitable donors
                discover it.
            </p>

        </div>


        {{-- Privacy notice --}}
        <div class="mb-6 rounded-2xl border border-red-100 bg-red-50 p-5">

            <div class="flex items-start gap-3">

                <div class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-red-600">
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
                            d="M12 9v3.75m0 3h.008v.008H12V15.75ZM10.5 3.75h3L21 19.5H3L10.5 3.75Z"
                        />
                    </svg>
                </div>

                <div>
                    <h2 class="text-sm font-semibold text-slate-900">
                        Your exact address is not required
                    </h2>

                    <p class="mt-1 text-sm leading-6 text-slate-600">
                        We only ask for your region and locality so donors can
                        understand the approximate area. Your exact address
                        and phone number are not displayed publicly.
                    </p>
                </div>

            </div>

        </div>


        {{-- Form --}}
        <form
            method="POST"
            action="{{ route('blood-requests.store') }}"
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
        >

            @csrf

            <div class="p-6 sm:p-8 lg:p-10">

                {{-- =====================================================
                    BLOOD REQUIREMENT
                ====================================================== --}}
                <div>

                    <div class="mb-6">

                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">
                            Blood requirement
                        </p>

                        <h2 class="mt-1.5 text-lg font-semibold text-slate-950">
                            What blood is needed?
                        </h2>

                    </div>


                    <div class="grid gap-6 sm:grid-cols-2">

                        {{-- Blood group --}}
                        <div>

                            <label
                                for="blood_group_id"
                                class="mb-2 block text-sm font-semibold text-slate-800"
                            >
                                Blood group
                                <span class="text-red-600">*</span>
                            </label>

                            <select
                                id="blood_group_id"
                                name="blood_group_id"
                                required
                                class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100"
                            >
                                <option value="">Select blood group</option>

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


                        {{-- Quantity --}}
                        <div>

                            <label
                                for="required_quantity"
                                class="mb-2 block text-sm font-semibold text-slate-800"
                            >
                                Required quantity
                                <span class="text-red-600">*</span>
                            </label>

                            <select
                                id="required_quantity"
                                name="required_quantity"
                                required
                                class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100"
                            >
                                <option value="">Select quantity</option>

                                @for ($quantity = 1; $quantity <= 10; $quantity++)
                                    <option
                                        value="{{ $quantity }}"
                                        @selected(old('required_quantity') == $quantity)
                                    >
                                        {{ $quantity }} {{ $quantity === 1 ? 'unit' : 'units' }}
                                    </option>
                                @endfor
                            </select>

                            @error('required_quantity')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- Divider --}}
                <div class="my-10 border-t border-slate-100"></div>


                {{-- =====================================================
                    WHEN
                ====================================================== --}}
                <div>

                    <div class="mb-6">

                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">
                            Timing
                        </p>

                        <h2 class="mt-1.5 text-lg font-semibold text-slate-950">
                            When is the blood needed?
                        </h2>

                    </div>


                    <div class="grid gap-6 sm:grid-cols-2">

                        {{-- Required date --}}
                        <div>

                            <label
                                for="required_date"
                                class="mb-2 block text-sm font-semibold text-slate-800"
                            >
                                Required date
                                <span class="text-red-600">*</span>
                            </label>

                            <input
                                id="required_date"
                                type="date"
                                name="required_date"
                                value="{{ old('required_date') }}"
                                min="{{ now()->format('Y-m-d') }}"
                                required
                                class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100"
                            >

                            @error('required_date')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Urgency --}}
                        <div>

                            <label
                                for="urgency"
                                class="mb-2 block text-sm font-semibold text-slate-800"
                            >
                                Urgency
                                <span class="text-red-600">*</span>
                            </label>

                            <select
                                id="urgency"
                                name="urgency"
                                required
                                class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100"
                            >
                                <option value="">Select urgency</option>

                                <option value="normal" @selected(old('urgency') === 'normal')>
                                    Normal
                                </option>

                                <option value="urgent" @selected(old('urgency') === 'urgent')>
                                    Urgent
                                </option>

                                <option value="critical" @selected(old('urgency') === 'critical')>
                                    Critical
                                </option>
                            </select>

                            @error('urgency')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- Divider --}}
                <div class="my-10 border-t border-slate-100"></div>


                {{-- =====================================================
                    LOCATION
                ====================================================== --}}
                <div>

                    <div class="mb-6">

                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">
                            Approximate location
                        </p>

                        <h2 class="mt-1.5 text-lg font-semibold text-slate-950">
                            Where is blood needed?
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Enter only your region and locality. Do not enter
                            your home address.
                        </p>

                    </div>


                    <div class="grid gap-6 sm:grid-cols-2">

                        {{-- Region --}}
                        <div>

                            <label
                                for="region"
                                class="mb-2 block text-sm font-semibold text-slate-800"
                            >
                                Region
                                <span class="text-red-600">*</span>
                            </label>

                            <input
                                id="region"
                                type="text"
                                name="region"
                                value="{{ old('region') }}"
                                maxlength="100"
                                placeholder="e.g. Rajasthan"
                                required
                                class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100"
                            >

                            @error('region')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Locality --}}
                        <div>

                            <label
                                for="locality"
                                class="mb-2 block text-sm font-semibold text-slate-800"
                            >
                                Locality
                                <span class="text-red-600">*</span>
                            </label>

                            <input
                                id="locality"
                                type="text"
                                name="locality"
                                value="{{ old('locality') }}"
                                maxlength="100"
                                placeholder="e.g. Civil Lines"
                                required
                                class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100"
                            >

                            @error('locality')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                </div>

            </div>


            {{-- =========================================================
                FORM FOOTER
            ========================================================== --}}
            <div class="flex flex-col gap-4 border-t border-slate-100 bg-slate-50 px-6 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-8 lg:px-10">

                <p class="max-w-md text-xs leading-5 text-slate-500">
                    By submitting this request, you confirm that the
                    information provided is accurate to the best of your
                    knowledge.
                </p>

                <div class="flex flex-col-reverse gap-3 sm:flex-row">

                    <a
                        href="{{ route('dashboard') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-red-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                    >
                        Create Request

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
                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"
                            />
                        </svg>
                    </button>

                </div>

            </div>

        </form>

    </div>

</section>

@endsection
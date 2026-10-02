@extends('layouts.base')

@section('title', 'Edit Blood Request | Mission Red')

@section('content')

<section class="min-h-[calc(100vh-4rem)] bg-slate-50 py-8 sm:py-10 lg:py-12">

    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

        <div class="mb-8">

            <a
                href="{{ route('blood-requests.show', $bloodRequest) }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-900"
            >
                ← Back to Request
            </a>

            <p class="mt-6 text-sm font-medium text-red-600">
                Blood Request
            </p>

            <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-950">
                Edit Request
            </h1>

            <p class="mt-2 text-sm leading-6 text-slate-500">
                Update the details of your active blood request.
            </p>

        </div>


        @if ($errors->any())

            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">

                <p class="text-sm font-semibold text-red-700">
                    Please correct the following:
                </p>

                <ul class="mt-2 list-disc pl-5 text-sm text-red-600">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif


        <form
            method="POST"
            action="{{ route('blood-requests.update', $bloodRequest) }}"
            class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8"
        >

            @csrf
            @method('PUT')


            {{-- Blood group --}}
            <div>
                <label
                    for="blood_group_id"
                    class="text-sm font-semibold text-slate-800"
                >
                    Blood Group
                </label>

                <select
                    id="blood_group_id"
                    name="blood_group_id"
                    required
                    class="mt-2 block w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-red-500 focus:ring-red-500"
                >

                    @foreach ($bloodGroups as $bloodGroup)

                        <option
                            value="{{ $bloodGroup->id }}"
                            @selected(
                                old(
                                    'blood_group_id',
                                    $bloodRequest->blood_group_id
                                ) == $bloodGroup->id
                            )
                        >
                            {{ $bloodGroup->name }}
                        </option>

                    @endforeach

                </select>
            </div>


            {{-- Quantity --}}
            <div class="mt-6">

                <label
                    for="required_quantity"
                    class="text-sm font-semibold text-slate-800"
                >
                    Required quantity
                </label>

                <input
                    id="required_quantity"
                    type="number"
                    name="required_quantity"
                    min="1"
                    max="100"
                    required
                    value="{{ old('required_quantity', $bloodRequest->required_quantity) }}"
                    class="mt-2 block w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-red-500 focus:ring-red-500"
                >

                @if ($bloodRequest->fulfilled_quantity > 0)

                    <p class="mt-2 text-xs text-slate-500">
                        {{ $bloodRequest->fulfilled_quantity }}
                        unit(s) have already been fulfilled.
                    </p>

                @endif

            </div>


            {{-- Date --}}
            <div class="mt-6">

                <label
                    for="required_date"
                    class="text-sm font-semibold text-slate-800"
                >
                    Required date
                </label>

                <input
                    id="required_date"
                    type="date"
                    name="required_date"
                    required
                    value="{{ old('required_date', $bloodRequest->required_date->format('Y-m-d')) }}"
                    class="mt-2 block w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-red-500 focus:ring-red-500"
                >

            </div>


            {{-- Urgency --}}
            <div class="mt-6">

                <label
                    for="urgency"
                    class="text-sm font-semibold text-slate-800"
                >
                    Urgency
                </label>

                <select
                    id="urgency"
                    name="urgency"
                    required
                    class="mt-2 block w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-red-500 focus:ring-red-500"
                >

                    <option value="normal" @selected(old('urgency', $bloodRequest->urgency) === 'normal')>
                        Normal
                    </option>

                    <option value="urgent" @selected(old('urgency', $bloodRequest->urgency) === 'urgent')>
                        Urgent
                    </option>

                    <option value="critical" @selected(old('urgency', $bloodRequest->urgency) === 'critical')>
                        Critical
                    </option>

                </select>

            </div>


            {{-- Region --}}
            <div class="mt-6">

                <label
                    for="region"
                    class="text-sm font-semibold text-slate-800"
                >
                    Region
                </label>

                <input
                    id="region"
                    type="text"
                    name="region"
                    required
                    maxlength="100"
                    value="{{ old('region', $bloodRequest->region) }}"
                    class="mt-2 block w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-red-500 focus:ring-red-500"
                >

            </div>


            {{-- Locality --}}
            <div class="mt-6">

                <label
                    for="locality"
                    class="text-sm font-semibold text-slate-800"
                >
                    Locality
                </label>

                <input
                    id="locality"
                    type="text"
                    name="locality"
                    required
                    maxlength="150"
                    value="{{ old('locality', $bloodRequest->locality) }}"
                    class="mt-2 block w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-red-500 focus:ring-red-500"
                >

            </div>


            {{-- Actions --}}
            <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-end">

                <a
                    href="{{ route('blood-requests.show', $bloodRequest) }}"
                    class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white hover:bg-red-700"
                >
                    Save Changes
                </button>

            </div>

        </form>


        {{-- Cancel request --}}
        <div class="mt-6 rounded-2xl border border-red-100 bg-white p-6">

            <h2 class="text-sm font-semibold text-slate-900">
                Cancel this request
            </h2>

            <p class="mt-2 text-sm leading-6 text-slate-500">
                Cancel the request if you no longer need blood.
                The request will remain in your history but will no longer accept donor responses.
            </p>

            <form
                method="POST"
                action="{{ route('blood-requests.destroy', $bloodRequest) }}"
                class="mt-4"
            >

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    onclick="return confirm('Are you sure you want to cancel this blood request?')"
                    class="inline-flex items-center justify-center rounded-xl border border-red-200 px-5 py-3 text-sm font-semibold text-red-600 hover:bg-red-50"
                >
                    Cancel Blood Request
                </button>

            </form>

        </div>

    </div>

</section>

@endsection
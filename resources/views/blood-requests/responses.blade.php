@extends('layouts.base')
@section('title', 'Donor Responses | Mission Red')
@section('content')
<section class="min-h-[calc(100vh-4rem)] bg-slate-50 py-8 sm:py-10 lg:py-12">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        {{-- BACK --}}
        <div class="mb-6">
            <a
                href="{{ route('blood-requests.show', $bloodRequest) }}"
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
                Back to Request
            </a>
        </div>
        {{-- HEADER --}}
        <div class="mb-8">
            <p class="text-sm font-medium text-red-600">
                Donor Responses
            </p>
            <div class="mt-2 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">
                        People who want to help
                    </h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500 sm:text-base">
                        Review the people who have responded to your
                        {{ $bloodRequest->bloodGroup->name }} blood request.
                    </p>
                </div>
                {{-- REQUEST SUMMARY --}}
                <div class="rounded-xl border border-slate-200 bg-white px-5 py-4 shadow-sm">
                    <div class="flex items-center gap-5">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-400">
                                Blood Group
                            </p>
                            <p class="mt-1 text-xl font-bold text-red-600">
                                {{ $bloodRequest->bloodGroup->name }}
                            </p>
                        </div>
                        <div class="h-8 w-px bg-slate-200"></div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-400">
                                Remaining
                            </p>
                            <p class="mt-1 text-xl font-bold text-slate-950">
                                {{ $bloodRequest->remaining_quantity }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- FLASH MESSAGES --}}
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4">
                <p class="text-sm font-medium text-green-700">
                    {{ session('success') }}
                </p>
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4">
                <p class="text-sm font-medium text-red-700">
                    {{ session('error') }}
                </p>
            </div>
        @endif
        {{-- RESPONSES --}}
        @if ($bloodRequest->responses->isEmpty())
            {{-- EMPTY STATE --}}
            <div class="rounded-2xl border border-slate-200 bg-white px-6 py-14 text-center shadow-sm">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.6"
                        stroke="currentColor"
                        class="h-7 w-7"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0M4.5 20.25a7.5 7.5 0 0 1 15 0M12 12.75v3m0 0 1.5-1.5M12 15.75l-1.5-1.5"
                        />
                    </svg>
                </div>
                <h2 class="mt-5 text-lg font-semibold text-slate-900">
                    No responses yet
                </h2>
                <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                    When people respond to your blood request,
                    their offers to donate or help arrange blood
                    will appear here.
                </p>
            </div>
        @else
            <div class="space-y-5">
                @foreach ($bloodRequest->responses as $response)
                    @php
                        $statusClasses = match ($response->status) {
                            'pending' =>
                                'border-amber-200 bg-amber-50 text-amber-700',
                            'accepted' =>
                                'border-green-200 bg-green-50 text-green-700',
                            'rejected' =>
                                'border-red-200 bg-red-50 text-red-700',
                            default =>
                                'border-slate-200 bg-slate-50 text-slate-600',
                        };
                    @endphp
                    {{-- RESPONSE CARD --}}
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                        {{-- CARD HEADER --}}
                        <div class="flex flex-col gap-4 border-b border-slate-100 p-5 sm:flex-row sm:items-center sm:justify-between sm:p-6">
                            <div class="flex items-center gap-4">
                                {{-- AVATAR --}}
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-slate-950 text-sm font-semibold text-white">
                                    {{ strtoupper(substr($response->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <h2 class="text-base font-semibold text-slate-950">
                                        {{ $response->user->name ?? 'Community Member' }}
                                    </h2>
                                    <p class="mt-1 text-xs text-slate-400">
                                        Responded
                                        {{ $response->responded_at?->format('d M Y, h:i A') ?? $response->created_at->format('d M Y, h:i A') }}
                                    </p>
                                </div>
                            </div>
                            {{-- STATUS --}}
                            <span
                                class="inline-flex w-fit rounded-full border px-3 py-1.5 text-xs font-semibold {{ $statusClasses }}"
                            >
                                {{ ucfirst($response->status) }}
                            </span>
                        </div>
                        {{-- RESPONSE BODY --}}
                        <div class="p-5 sm:p-6">
                            <div class="grid gap-5 sm:grid-cols-2">
                                {{-- RESPONSE TYPE --}}
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-400">
                                        Help Type
                                    </p>
                                    @if ($response->response_type === 'donate')
                                        <div class="mt-2 flex items-center gap-2">
                                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 text-red-600">
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
                                                        d="M12 3.75s6 6.042 6 10.125a6 6 0 1 1-12 0C6 9.792 12 3.75 12 3.75Z"
                                                    />
                                                </svg>
                                            </span>
                                            <span class="text-sm font-semibold text-slate-800">
                                                I Can Donate
                                            </span>
                                        </div>
                                    @else
                                        <div class="mt-2 flex items-center gap-2">
                                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 text-red-600">
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
                                                        d="M18 18.75a3 3 0 0 0-6 0m6 0v.75m-6-.75a3 3 0 0 0-6 0m6 0v.75M9 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm9 0a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                                                    />
                                                </svg>
                                            </span>
                                            <span class="text-sm font-semibold text-slate-800">
                                                I Can Help Arrange
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                {{-- QUANTITY --}}
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-400">
                                        Quantity Offered
                                    </p>
                                    <p class="mt-2 text-sm font-semibold text-slate-800">
                                        @if ($response->quantity)
                                            {{ $response->quantity }}
                                            {{ Str::plural('unit', $response->quantity) }}
                                        @else
                                            Not specified
                                        @endif
                                    </p>
                                </div>
                            </div>
                            {{-- MESSAGE --}}
                            @if ($response->message)
                                <div class="mt-6 rounded-xl bg-slate-50 px-4 py-4">
                                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-400">
                                        Message
                                    </p>
                                    <p class="mt-2 text-sm leading-6 text-slate-600">
                                        {{ $response->message }}
                                    </p>
                                </div>
                            @endif
                            {{-- ACTIONS --}}
                            @if ($response->status === 'pending')
                                <div class="mt-6 flex flex-col gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                                    {{-- REJECT --}}
                                    <form
                                        method="POST"
                                        action="{{ route('blood-request-responses.update', [$bloodRequest, $response]) }}"
                                    >
                                        @csrf
                                        @method('PATCH')
                                        <input
                                            type="hidden"
                                            name="status"
                                            value="rejected"
                                        >
                                        <button
                                            type="submit"
                                            onclick="return confirm('Are you sure you want to reject this response?')"
                                            class="inline-flex w-full items-center justify-center rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 sm:w-auto"
                                        >
                                            Reject
                                        </button>
                                    </form>
                                    {{-- ACCEPT --}}
                                    <form
                                        method="POST"
                                        action="{{ route('blood-request-responses.update', [$bloodRequest, $response]) }}"
                                    >
                                        @csrf
                                        @method('PATCH')
                                        <input
                                            type="hidden"
                                            name="status"
                                            value="accepted"
                                        >
                                        <button
                                            type="submit"
                                            onclick="return confirm('Accept this response?')"
                                            class="inline-flex w-full items-center justify-center rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-700 sm:w-auto"
                                        >
                                            Accept
                                        </button>
                                    </form>
                                </div>
                            @elseif ($response->status === 'accepted')
                                <div class="mt-6 border-t border-slate-100 pt-5">
                                    <p class="text-sm font-medium text-green-700">
                                        This response has been accepted.
                                    </p>
                                </div>
                            @elseif ($response->status === 'rejected')
                                <div class="mt-6 border-t border-slate-100 pt-5">
                                    <p class="text-sm font-medium text-slate-500">
                                        This response was rejected.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
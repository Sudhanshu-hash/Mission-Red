@extends('layouts.auth')
@section('title', 'Reset Password | Mission Red')
@section('content')
    <div class="min-h-screen lg:grid lg:grid-cols-2">
        {{-- Left --}}
        <section class="hidden bg-gray-900 lg:flex lg:flex-col lg:items-center lg:justify-center lg:px-12">
            <div class="max-w-md text-center">
                <h1 class="text-4xl font-bold tracking-tight text-white">
                    Mission Red
                </h1>
                <p class="mt-4 text-lg leading-8 text-gray-300">
                    Connecting people who need blood with people willing to donate.
                </p>
            </div>
        </section>
        {{-- Right --}}
        <section class="flex min-h-screen items-center justify-center bg-white px-6 py-12 sm:px-10 lg:px-16">
            <div class="w-full max-w-md">
                <div class="mb-10 text-center lg:hidden">
                    <h1 class="text-3xl font-bold text-gray-900">
                        Mission Red
                    </h1>
                </div>
                <h2 class="text-3xl font-bold tracking-tight text-gray-900">
                    Reset your password
                </h2>
                <p class="mt-2 text-sm text-gray-500">
                    Choose a new password for your Mission Red account.
                </p>
                @if ($errors->any())
                    <div class="mt-6 rounded-lg border border-red-200 bg-red-50 p-4">
                        @foreach ($errors->all() as $error)
                            <p class="text-sm text-red-700">
                                {{ $error }}
                            </p>
                        @endforeach
                    </div>
                @endif
                <form
                    method="POST"
                    action="{{ route('password.update') }}"
                    class="mt-8 space-y-5"
                >
                    @csrf
                    <input
                        type="hidden"
                        name="token"
                        value="{{ $token }}"
                    >
                    <div>
                        <label
                            for="email"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Email Address
                        </label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email', $email) }}"
                            autocomplete="email"
                            required
                            class="mt-2 block w-full rounded-lg border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-red-500 focus:ring-red-500"
                        >
                    </div>
                    <div>
                        <label
                            for="password"
                            class="block text-sm font-medium text-gray-700"
                        >
                            New Password
                        </label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="new-password"
                            required
                            class="mt-2 block w-full rounded-lg border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-red-500 focus:ring-red-500"
                        >
                    </div>
                    <div>
                        <label
                            for="password_confirmation"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Confirm New Password
                        </label>
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            autocomplete="new-password"
                            required
                            class="mt-2 block w-full rounded-lg border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-red-500 focus:ring-red-500"
                        >
                    </div>
                    <button
                        type="submit"
                        class="w-full rounded-lg bg-red-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700"
                    >
                        Reset Password
                    </button>
                </form>
                <p class="mt-8 text-center text-sm text-gray-500">
                    <a
                        href="{{ route('login') }}"
                        class="font-semibold text-red-600 hover:text-red-700"
                    >
                        Back to Login
                    </a>
                </p>
            </div>
        </section>
    </div>
@endsection
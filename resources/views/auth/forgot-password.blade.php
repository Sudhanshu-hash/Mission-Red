@extends('layouts.auth')
@section('title', 'Forgot Password | Mission Red')
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
                    Forgot your password?
                </h2>
                <p class="mt-2 text-sm text-gray-500">
                    Enter your email address and we'll send you a password reset link.
                </p>
                @if (session('status'))
                    <div class="mt-6 rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-700">
                        {{ session('status') }}
                    </div>
                @endif
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
                    action="{{ route('password.email') }}"
                    class="mt-8 space-y-5"
                >
                    @csrf
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
                            value="{{ old('email') }}"
                            autocomplete="email"
                            required
                            autofocus
                            class="mt-2 block w-full rounded-lg border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-red-500 focus:ring-red-500"
                        >
                    </div>
                    <button
                        type="submit"
                        class="w-full rounded-lg bg-red-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700"
                    >
                        Send Reset Link
                    </button>
                </form>
                <p class="mt-8 text-center text-sm text-gray-500">
                    Remember your password?
                    <a
                        href="{{ route('login') }}"
                        class="font-semibold text-red-600 hover:text-red-700"
                    >
                        Login
                    </a>
                </p>
            </div>
        </section>
    </div>
@endsection
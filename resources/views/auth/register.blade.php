@extends('layouts.auth')

@section('title', 'Create Account | Mission Red')

@section('content')

    <div class="min-h-screen lg:grid lg:grid-cols-2">

        {{-- =========================================================
             LEFT: MISSION RED
             LOCKED — DO NOT CHANGE
        ========================================================== --}}
         <section class="relative hidden min-h-screen overflow-hidden lg:block">
            {{-- Background Video --}}
            <video
                autoplay
                muted
                loop
                playsinline
                class="absolute inset-0 h-full w-full object-cover"
            >
                <source
                    src="{{ asset('assets/login-register.mp4') }}"
                    type="video/mp4"
                >
            </video>
            {{-- Dark overlay --}}
            <div
                class="absolute inset-0
                       bg-gradient-to-b
                       from-black/45
                       via-black/10
                       to-black/70"
            ></div>
            {{-- Left-side subtle red tint --}}
            <div
                class="absolute inset-0
                       bg-gradient-to-r
                       from-red-950/25
                       via-transparent
                       to-transparent"
            ></div>
            {{-- =====================================================
                 BRANDING
            ====================================================== --}}
            <div
                class="absolute left-0 right-0 top-10 z-10
                       flex justify-center"
            >
                <div class="text-center">
                    {{-- Logo / Brand Mark --}}
                    <!-- <div
                        class="mx-auto flex h-16 w-16
                               items-center justify-center
                               rounded-full
                               border border-white/40
                               bg-black/20
                               shadow-xl
                               backdrop-blur-md"
                    >
                        <img
                            src="{{ asset('images/mission-red-logo.png') }}"
                            alt="Mission Red Logo"
                            class="h-16 w-16 rounded-full object-cover">
                    </div> -->
                    <h1
                        class="mt-4 text-5xl font-bold
                               tracking-tight text-white
                               drop-shadow-lg font-serif"
                    >
                        Mission Red
                    </h1>
                </div>
            </div>
            {{-- =====================================================
                 LEFT CONTENT
            ====================================================== --}}
            <div
                class="absolute bottom-12 left-0 right-0 z-10
                       px-12 text-center"
            >
                <div class="mx-auto max-w-lg">
                    {{-- Small label --}}
                    <!-- <div
                        class="mb-4 flex items-center
                               justify-center gap-3"
                    >
                        <span class="h-px w-8 bg-red-300"></span>
                        <span
                            class="text-xs font-semibold
                                   uppercase tracking-[0.25em]
                                   text-red-100"
                        >
                            Blood Donation
                        </span>
                        <span class="h-px w-8 bg-red-300"></span>
                    </div> -->
                    {{-- Main message --}}
                    <!-- <h2
                        class="text-3xl font-bold
                               leading-tight text-white
                               drop-shadow-lg
                               xl:text-4xl"
                    >
                        Every Drop
                        <span class="text-red-200">
                            Builds Hope.
                        </span>
                    </h2> -->
                    {{-- Description --}}
                    <p
                        class="mx-auto mt-4 max-w-md
                               text-sm leading-6
                               text-white/85
                               drop-shadow-md"
                    >
                    
                        Connecting people who need blood
                        with people willing to donate.
                    </p>
                    {{-- Bottom statement --}}
                    <div
                        class="mx-auto mt-7
                               flex max-w-md
                               items-center justify-center
                               gap-3"
                    >
                        <span
                            class="h-2 w-2 rounded-full
                                   bg-red-400 shadow-lg
                                   shadow-red-500/50"
                        ></span>
                        <p
                            class="text-xs font-medium
                                   tracking-wide
                                   text-white/75"
                        >
                            One request. One connection.
                            One opportunity to help.
                        </p>
                    </div>
                </div>
            </div>
        </section>


        {{-- =========================================================
             RIGHT: REGISTRATION
        ========================================================== --}}
        <section
             class="flex min-h-screen items-center
                   justify-center
                   bg-slate-50
                   px-5 py-10
                   sm:px-8"
        >

            {{-- Registration Card --}}
                <div
    class="w-full max-w-lg
           rounded-2xl
           border border-slate-300
           bg-slate-100
           p-6
           shadow-[0_10px_35px_rgba(15,23,42,0.10)]
           sm:p-9
           lg:p-10"
>

                {{-- =================================================
                     MOBILE BRANDING
                ================================================== --}}
                <div class="mb-6 text-center lg:hidden">

                    <div
                        class="mx-auto flex h-12 w-12
                               items-center justify-center
                               rounded-full bg-red-700"
                    >
                        <span class="text-sm font-bold text-white">
                            MR
                        </span>
                    </div>

                    <h1
                        class="mt-3 text-2xl font-bold
                               tracking-tight text-slate-900"
                    >
                        Mission Red
                    </h1>

                    <p class="mt-1 text-xs text-slate-500">
                        Connecting people. Helping people.
                    </p>

                </div>


                {{-- =================================================
                     HEADING
                ================================================== --}}
                <div>

                    <h2
                        class="text-2xl font-bold
                               tracking-tight text-slate-900"
                    >
                        Create your account
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Join Mission Red to request or donate blood.
                    </p>

                </div>


                {{-- =================================================
                     VALIDATION ERRORS
                ================================================== --}}
                @if ($errors->any())

                    <div
                        class="mt-5 rounded-lg
                               border border-red-200
                               bg-red-50 p-3"
                    >

                        <div class="flex items-start gap-2">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="mt-0.5 h-4 w-4 shrink-0 text-red-600"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 9v4m0 4h.01M10.29 3.86l-8.82 15a2 2 0 001.72 3h17.62a2 2 0 001.72-3l-8.82-15a2 2 0 00-3.42 0z"
                                />
                            </svg>

                            <div>

                                <p class="text-xs font-semibold text-red-800">
                                    Please correct the following errors.
                                </p>

                                <ul
                                    class="mt-1 list-inside list-disc
                                           text-xs text-red-700"
                                >

                                    @foreach ($errors->all() as $error)

                                        <li>
                                            {{ $error }}
                                        </li>

                                    @endforeach

                                </ul>

                            </div>

                        </div>

                    </div>

                @endif


                {{-- =================================================
                     REGISTRATION FORM
                ================================================== --}}
                <form
                    method="POST"
                    action="{{ route('register.store') }}"
                    class="mt-6 space-y-4"
                >

                    @csrf


                    {{-- =================================================
                         FULL NAME
                    ================================================== --}}
                    <div>

                        <label
                            for="name"
                            class="block text-xs
                                   font-medium text-slate-700"
                        >
                            Full Name
                        </label>

                        <div class="relative mt-1.5">

                            {{-- User Icon --}}
                            <div
                                class="pointer-events-none
                                       absolute inset-y-0 left-0
                                       flex items-center pl-3
                                       text-slate-400"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15 19a6 6 0 00-12 0M9 11a4 4 0 100-8 4 4 0 000 8zm6-3a4 4 0 110 8m0-8a4 4 0 010 8"
                                    />
                                </svg>

                            </div>

                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name') }}"
                                autocomplete="name"
                                required
                                autofocus
                                placeholder="Full Name"
                                class="block w-full rounded-lg
                                       border border-slate-200
                                       bg-slate-100
                                       py-2.5 pl-10 pr-3
                                       text-xs text-slate-800
                                       placeholder:text-slate-400
                                       shadow-sm transition
                                       focus:border-red-500
                                       focus:bg-white
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-red-500/20"
                            >

                        </div>

                        @error('name')

                            <p class="mt-1 text-xs text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- =================================================
                         EMAIL
                    ================================================== --}}
                    <div>

                        <label
                            for="email"
                            class="block text-xs
                                   font-medium text-slate-700"
                        >
                            Email Address
                        </label>

                        <div class="relative mt-1.5">

                            {{-- Email Icon --}}
                            <div
                                class="pointer-events-none
                                       absolute inset-y-0 left-0
                                       flex items-center pl-3
                                       text-slate-400"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 8l9 6 9-6M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"
                                    />
                                </svg>

                            </div>

                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                autocomplete="email"
                                required
                                placeholder="Email Address"
                                class="block w-full rounded-lg
                                       border border-slate-200
                                       bg-slate-100
                                       py-2.5 pl-10 pr-3
                                       text-xs text-slate-800
                                       placeholder:text-slate-400
                                       shadow-sm transition
                                       focus:border-red-500
                                       focus:bg-white
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-red-500/20"
                            >

                        </div>

                        @error('email')

                            <p class="mt-1 text-xs text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- =================================================
                         PASSWORD
                    ================================================== --}}
                    <div>

                        <label
                            for="password"
                            class="block text-xs
                                   font-medium text-slate-700"
                        >
                            Password
                        </label>

                        <div class="relative mt-1.5">

                            {{-- Lock Icon --}}
                            <div
                                class="pointer-events-none
                                       absolute inset-y-0 left-0
                                       flex items-center pl-3
                                       text-slate-400"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M16.5 10V7a4.5 4.5 0 00-9 0v3m-1 0h11a1 1 0 011 1v8a1 1 0 01-1 1h-11a1 1 0 01-1-1v-8a1 1 0 011-1z"
                                    />

                                </svg>

                            </div>

                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="new-password"
                                required
                                placeholder="Create a password"
                                class="block w-full rounded-lg
                                       border border-slate-200
                                       bg-slate-100
                                       py-2.5 pl-10 pr-10
                                       text-xs text-slate-800
                                       placeholder:text-slate-400
                                       shadow-sm transition
                                       focus:border-red-500
                                       focus:bg-white
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-red-500/20"
                            >

                            {{-- Password visibility --}}
                            <button
                                type="button"
                                onclick="togglePassword('password', 'passwordIcon')"
                                class="absolute inset-y-0 right-0
                                       flex items-center pr-3
                                       text-slate-400
                                       transition hover:text-slate-600"
                                aria-label="Show password"
                            >

                                <svg
                                    id="passwordIcon"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.25 12s3.75-6 9.75-6 9.75 6 9.75 6-3.75 6-9.75 6-9.75-6-9.75-6z"
                                    />
                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="2.5"
                                    />
                                </svg>

                            </button>

                        </div>

                        @error('password')

                            <p class="mt-1 text-xs text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- =================================================
                         CONFIRM PASSWORD
                    ================================================== --}}
                    <div>

                        <label
                            for="password_confirmation"
                            class="block text-xs
                                   font-medium text-slate-700"
                        >
                            Confirm Password
                        </label>

                        <div class="relative mt-1.5">

                            {{-- Lock Icon --}}
                            <div
                                class="pointer-events-none
                                       absolute inset-y-0 left-0
                                       flex items-center pl-3
                                       text-slate-400"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M16.5 10V7a4.5 4.5 0 00-9 0v3m-1 0h11a1 1 0 011 1v8a1 1 0 01-1 1h-11a1 1 0 01-1-1v-8a1 1 0 011-1z"
                                    />

                                </svg>

                            </div>

                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                autocomplete="new-password"
                                required
                                placeholder="Confirm your password"
                                class="block w-full rounded-lg
                                       border border-slate-200
                                       bg-slate-100
                                       py-2.5 pl-10 pr-10
                                       text-xs text-slate-800
                                       placeholder:text-slate-400
                                       shadow-sm transition
                                       focus:border-red-500
                                       focus:bg-white
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-red-500/20"
                            >

                            {{-- Password visibility --}}
                            <button
                                type="button"
                                onclick="togglePassword(
                                    'password_confirmation',
                                    'confirmPasswordIcon'
                                )"
                                class="absolute inset-y-0 right-0
                                       flex items-center pr-3
                                       text-slate-400
                                       transition hover:text-slate-600"
                                aria-label="Show password"
                            >

                                <svg
                                    id="confirmPasswordIcon"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.25 12s3.75-6 9.75-6 9.75 6 9.75 6-3.75 6-9.75 6-9.75-6-9.75-6z"
                                    />
                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="2.5"
                                    />
                                </svg>

                            </button>

                        </div>

                    </div>


                    {{-- =================================================
                         CREATE ACCOUNT BUTTON
                    ================================================== --}}
                    <button
                        type="submit"
                        class="group flex w-full
                               items-center justify-center
                               rounded-lg
                               bg-red-700
                               px-5 py-2.5
                               text-xs font-semibold text-white
                               shadow-[0_5px_15px_rgba(185,28,28,0.25)]
                               transition-all duration-200
                               hover:-translate-y-0.5
                               hover:bg-red-800
                               hover:shadow-[0_7px_18px_rgba(185,28,28,0.30)]
                               focus:outline-none
                               focus:ring-2
                               focus:ring-red-500
                               focus:ring-offset-2"
                    >

                        Create Account

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="ml-1.5 h-3.5 w-3.5
                                   transition-transform
                                   duration-200
                                   group-hover:translate-x-0.5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5 12h14m-6-6l6 6-6 6"
                            />
                        </svg>

                    </button>

                </form>


                {{-- =================================================
                     LOGIN
                ================================================== --}}
                <p
                    class="mt-5 text-center
                           text-xs text-slate-500"
                >

                    Already have an account?

                    <a
                        href="{{ route('login') }}"
                        class="font-semibold text-red-600
                               transition hover:text-red-700"
                    >
                        Login
                    </a>

                </p>

            </div>

        </section>

    </div>


    {{-- =============================================================
         PASSWORD VISIBILITY
    ============================================================= --}}
    <script>

        function togglePassword(inputId, iconId) {

            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {

                input.type = 'text';

                icon.innerHTML = `
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 3l18 18M10.58 10.58a2 2 0 002.83 2.83
                           M9.88 4.24A9.77 9.77 0 0112 4
                           c6 0 9.75 6 9.75 6a18.5 18.5 0 01-3.18 3.75
                           M6.61 6.61C3.85 8.25 2.25 12 2.25 12
                           s3.75 6 9.75 6a9.8 9.8 0 004.11-.9"
                    />
                `;

            } else {

                input.type = 'password';

                icon.innerHTML = `
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M2.25 12s3.75-6 9.75-6 9.75 6 9.75 6
                           -3.75 6-9.75 6-9.75-6-9.75-6z"
                    />
                    <circle
                        cx="12"
                        cy="12"
                        r="2.5"
                    />
                `;

            }

        }

    </script>

@endsection
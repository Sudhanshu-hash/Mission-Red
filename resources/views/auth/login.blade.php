@extends('layouts.auth')
@section('title', 'Login | Mission Red')
@section('content')
    <div class="min-h-screen lg:grid lg:grid-cols-2">
        {{-- =========================================================
             LEFT: MISSION RED VIDEO
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
             RIGHT: LOGIN
        ========================================================== --}}
        <section
            class="flex min-h-screen items-center
                   justify-center
                   bg-slate-50
                   px-5 py-10
                   sm:px-8"
        >
            {{-- Login Card --}}
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
                <div class="mb-7 text-center lg:hidden">
                    <div
                        class="mx-auto flex h-12 w-12
                               items-center justify-center
                               rounded-full
                               bg-red-700"
                    >
                        <span
                            class="text-sm font-bold text-white"
                        >
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
                        Welcome back
                    </h2>
                    <p class="mt-1 text-xs text-slate-500">
                        Login to continue to Mission Red.
                    </p>
                </div>
                {{-- =================================================
                     VALIDATION / AUTHENTICATION ERRORS
                ================================================== --}}
                @if ($errors->any())
                    <div
                        class="mt-5 rounded-lg
                               border border-red-200
                               bg-red-50 p-3"
                    >
                        <p class="text-xs font-semibold text-red-800">
                            Please check your details.
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
                @endif
                {{-- =================================================
                     LOGIN FORM
                ================================================== --}}
                <form
                    method="POST"
                    action="{{ route('login.store') }}"
                    class="mt-6 space-y-4"
                >
                    @csrf
                    {{-- EMAIL --}}
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
                                autofocus
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
                    </div>
                    {{-- PASSWORD --}}
                    <div>
                        <div
                            class="flex items-center
                                   justify-between"
                        >
                            <label
                                for="password"
                                class="block text-xs
                                       font-medium
                                       text-slate-700"
                            >
                                Password
                            </label>
                            <a
                                href="{{ route('password.request') }}"
                                class="text-xs font-semibold
                                       text-red-600
                                       transition
                                       hover:text-red-700"
                            >
                                Forgot password?
                            </a>
                        </div>
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
                                autocomplete="current-password"
                                required
                                placeholder="Password"
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
                    </div>
                    {{-- REMEMBER ME --}}
                    <div class="flex items-center">
                        <input
                            id="remember"
                            name="remember"
                            type="checkbox"
                            value="1"
                            class="h-3.5 w-3.5 rounded
                                   border-slate-300
                                   text-red-600
                                   focus:ring-red-500"
                        >
                        <label
                            for="remember"
                            class="ml-2 text-xs text-slate-600"
                        >
                            Remember me
                        </label>
                    </div>
                    {{-- LOGIN --}}
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
                        Login
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
                {{-- REGISTER --}}
                <p
                    class="mt-5 text-center
                           text-xs text-slate-500"
                >
                    Don't have an account?
                    <a
                        href="{{ route('register') }}"
                        class="font-semibold text-red-600
                               transition hover:text-red-700"
                    >
                        Create account
                    </a>
                </p>
            </div>
        </section>
    </div>
@endsection
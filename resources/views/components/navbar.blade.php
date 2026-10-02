<nav class="border-b border-slate-200 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="flex h-16 items-center justify-between">

            {{-- Brand --}}
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                <span class="text-xl font-bold tracking-tight text-slate-950">
                    Mission
                </span>

                <span class="text-xl font-bold tracking-tight text-red-600">
                    Red
                </span>
            </a>


            {{-- Desktop Navigation --}}
            <div class="hidden items-center gap-1 md:flex">

                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                    class="rounded-lg px-4 py-2 text-sm font-medium text-slate-900 transition hover:bg-slate-100">
                    Home
                </a>

                {{-- Requests  --}}
                <a href="{{ route('blood-requests.create') }}"
                    class="rounded-lg px-4 py-2 text-sm font-medium text-slate-900 transition hover:bg-slate-100">
                    Requests
                </a>
                

                {{-- Donate --}}
                 <a href="{{ route('blood-requests.discover') }}"
                    class="rounded-lg px-4 py-2 text-sm font-medium text-slate-900 transition hover:bg-slate-100">
                    Donate
                </a>

                {{-- Connections - Coming Soon --}}
                <span class="cursor-default rounded-lg px-4 py-2 text-sm font-medium text-slate-400"
                    title="Coming soon">
                    Connections
                </span>

            </div>


            {{-- Right Side --}}
            <div class="hidden items-center gap-3 md:flex">

                {{-- Notifications --}}
                <button type="button"
                    class="relative flex h-10 w-10 items-center justify-center rounded-full text-slate-600 transition hover:bg-slate-100 hover:text-slate-900"
                    aria-label="Notifications">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7"
                        stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9a6 6 0 0 0-12 0v.75a8.967 8.967 0 0 1-2.31 6.022 23.848 23.848 0 0 0 5.454 1.31m5.713 0a24.255 24.255 0 0 1-5.713 0m5.713 0a3 3 0 1 1-5.713 0" />
                    </svg>

                    {{-- Unread notification indicator --}}
                    {{-- Will become dynamic when notifications are implemented. --}}
                </button>


                {{-- User / Profile --}}
                <a href="{{ route('profile.edit') }}"
                    class="group flex items-center gap-3 border-l border-slate-200 pl-4" aria-label="Edit Profile">
                    <div class="hidden text-right lg:block">
                        <p class="text-sm font-semibold text-slate-900 group-hover:text-red-600">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="max-w-40 truncate text-xs text-slate-500">
                            {{ auth()->user()->email }}
                        </p>
                    </div>

                    {{-- User Avatar --}}
                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-full bg-red-50 text-sm font-semibold text-red-600 transition group-hover:bg-red-100">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </a>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                        class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">
                        Logout
                    </button>
                </form>

            </div>

        </div>


        {{-- Mobile Menu --}}
        <details class="relative md:hidden">

            <summary
                class="flex h-10 w-10 cursor-pointer list-none items-center justify-center rounded-lg text-slate-700 transition hover:bg-slate-100"
                aria-label="Open navigation menu">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                    stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </summary>


            <div class="absolute right-0 top-12 z-50 w-72 rounded-2xl border border-slate-200 bg-white p-3 shadow-xl">

                {{-- Mobile User --}}
                <div class="mb-2 flex items-center gap-3 border-b border-slate-100 px-3 pb-3">

                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-50 text-sm font-semibold text-red-600">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-slate-900">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="truncate text-xs text-slate-500">
                            {{ auth()->user()->email }}
                        </p>
                    </div>

                </div>

                {{-- Profile --}}
                <a href="{{ route('profile.edit') }}"
                    class="block rounded-xl px-3 py-2.5 text-sm font-medium text-slate-900 hover:bg-slate-50">
                    Edit Profile
                </a>

                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                    class="block rounded-xl px-3 py-2.5 text-sm font-medium text-slate-900 hover:bg-slate-50">
                    Home
                </a>


               <a href="{{ route('blood-requests.create') }}"
                    class="block rounded-xl px-3 py-2.5 text-sm font-medium text-slate-900 hover:bg-slate-50">
                    Requests
                </a>

                    
                    

                 <a href="{{ route('blood-requests.discover') }}"
                    class="block rounded-xl px-3 py-2.5 text-sm font-medium text-slate-900 hover:bg-slate-50">
                    Donate
                </a>

                <span class="block cursor-default rounded-xl px-3 py-2.5 text-sm font-medium text-slate-400">
                    Connections
                    <span class="ml-1 text-xs">Coming soon</span>
                </span>


                {{-- Notifications --}}
                <button type="button"
                    class="flex w-full items-center justify-between rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    <span>Notifications</span>

                    <span class="text-xs text-slate-400">
                        0
                    </span>
                </button>


                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}" class="mt-2 border-t border-slate-100 pt-2">
                    @csrf

                    <button type="submit"
                        class="w-full rounded-xl px-3 py-2.5 text-left text-sm font-medium text-slate-600 hover:bg-slate-50">
                        Logout
                    </button>
                </form>

            </div>

        </details>

    </div>

    </div>
</nav>
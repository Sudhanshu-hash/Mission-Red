<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('title', 'Mission Red')</title>
    <link rel="icon" href="{{ asset('favicon_icon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="m-0 overflow-visible ">

    {{-- Background Video --}}
    <video
        autoplay
        muted
        loop
        playsinline
        class="fixed inset-0 z-[-2] h-full w-full object-cover"
    >
        <source src="{{ asset('assets/index.mp4') }}" type="video/mp4">
        
    </video>

    {{-- Dark Overlay --}}
    <div class="fixed inset-0 z-[-1] bg-black/45"></div>

    {{-- Header --}}
    @include('components.header')

    {{-- Navigation --}}
    @include('components.navbar')

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.footer')

    @stack('scripts')

</body>
</html>
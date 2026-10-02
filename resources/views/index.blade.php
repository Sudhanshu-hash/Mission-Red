<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mission Red</title>

    @vite('resources/css/app.css')
</head>

<body class="m-0 overflow-hidden">

    <section class="relative h-screen w-screen overflow-hidden">

        {{-- Background Video --}}
        <video
            autoplay
            muted
            loop
            playsinline
            class="absolute inset-0 h-full w-full object-cover"
        >
            <source src="{{ asset('assets/index.mp4') }}" type="video/mp4">
        </video>


        {{-- Dark Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-r
                    from-black/60
                    via-black/25
                    to-transparent">
        </div>


        {{-- Subtle Bottom Gradient --}}
        <div class="absolute inset-x-0 bottom-0 h-40
                    bg-gradient-to-t from-black/35
                    to-transparent">
        </div>


        {{-- =========================
             BRAND
        ========================== --}}
        <div class="absolute left-1/2 top-[9%]
                    z-20 -translate-x-1/2">

            <div class="text-center">

                <h2 class="font-serif text-4xl font-bold
                           tracking-[0.12em] text-white
                           drop-shadow-lg md:text-5xl">

                    MISSION RED

                </h2>

                {{-- Small line underneath --}}
                <div class="mx-auto mt-3 h-[2px] w-16
                            bg-white/70">
                </div>

            </div>

        </div>


        {{-- =========================
             HERO CONTENT
        ========================== --}}
        <div class="absolute left-[8%] top-1/2
                    z-20 -translate-y-1/2">

            <div class="max-w-2xl">

                {{-- Heading --}}
                <h1 class="text-4xl font-bold leading-[1.08]
                           tracking-tight text-white
                           drop-shadow-lg
                           sm:text-5xl
                           md:text-6xl">

                    Donate Blood.
                    <br>

                    Share Hope.
                    <br>

                    <span class="text-red-200">
                        Save Lives.
                    </span>

                </h1>


                {{-- Description --}}
                <p class="mt-6 max-w-lg
                          text-lg font-medium
                          leading-relaxed
                          text-white/90
                          drop-shadow-md
                          md:text-xl">

                    Your blood can be someone's
                    second chance.

                </p>


                {{-- Small supporting line --}}
                <div class="mt-5 flex items-center gap-3">

                    <span class="h-[2px] w-8 bg-red-300"></span>

                    <p class="text-sm font-medium
                              tracking-wide text-white/75">

                        Every drop can make a difference.

                    </p>

                </div>


                {{-- =========================
                     ACTION BUTTONS
                ========================== --}}
                <div class="mt-8 flex items-center gap-4">

                    {{-- Login --}}
                    <a
                        href="{{ route('login') }}"
                        class="group inline-flex items-center
                               justify-center
                               rounded-xl
                               border border-white/40
                               bg-black/20
                               px-8 py-3.5
                               text-base font-semibold
                               text-white
                               shadow-lg
                               backdrop-blur-md
                               transition-all duration-300
                               hover:-translate-y-1
                               hover:border-white/70
                               hover:bg-white/15
                               hover:shadow-2xl"
                    >
                        Login
                    </a>


                    {{-- Register --}}
                    <a
                        href="{{ route('register') }}"
                        class="group inline-flex items-center
                               justify-center gap-2
                               rounded-xl
                               bg-white
                               px-8 py-3.5
                               text-base font-semibold
                               text-gray-900
                               shadow-xl
                               transition-all duration-300
                               hover:-translate-y-1
                               hover:bg-red-50
                               hover:shadow-2xl"
                    >
                        Register

                        <span class="text-lg transition-transform
                                     duration-300
                                     group-hover:translate-x-1">
                            →
                        </span>

                    </a>

                </div>

            </div>

        </div>


        {{-- =========================
             BOTTOM RIGHT MESSAGE
        ========================== --}}
        <div class="absolute bottom-7 right-8
                    z-20 hidden
                    items-center gap-3
                    text-sm text-white/70
                    md:flex">

            <span class="h-2 w-2 rounded-full bg-red-300"></span>

            <span>
                Give blood. Give hope.
            </span>

        </div>

    </section>

</body>

</html>
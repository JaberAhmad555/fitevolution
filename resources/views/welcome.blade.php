<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fitevolution - Your Ultimate Fitness Journey</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-900 text-gray-300">

    {{-- HEADER --}}
    <header class="absolute top-0 left-0 w-full z-50 p-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-white">Fitevolution</a>
            <div>
                @auth
                    <a href="{{ url('/dashboard') }}" class="inline-block rounded-md px-4 py-2 text-sm font-semibold hover:text-white transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="inline-block rounded-md bg-gray-800/80 px-5 py-2.5 text-sm font-semibold text-white shadow-sm ring-1 ring-white/20 hover:bg-gray-700 transition-colors">
                        Log In
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main>
        {{-- HERO SECTION --}}
        <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-28 overflow-hidden">
             <div class="absolute inset-0 bg-gradient-to-b from-gray-900 via-gray-900 to-gray-800/90"></div>
            <div class="relative max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                {{-- Left Column: Text & CTA --}}
                <div class="text-center lg:text-left">
                    <h1 class="text-4xl lg:text-6xl font-extrabold tracking-tight text-white">
                        Chart Your Path.
                        <span class="block bg-gradient-to-r from-indigo-400 to-purple-500 bg-clip-text text-transparent">Crush Your Goals.</span>
                    </h1>
                    <p class="mt-6 text-lg text-gray-400 max-w-lg mx-auto lg:mx-0">
                        Stop just working out. Start building your legacy. Fitevolution is your all-in-one platform to log workouts, track progress, and stay motivated like never before.
                    </p>
                    <div class="mt-10">
                        <a href="{{ route('register') }}" class="inline-block bg-indigo-600 text-white font-bold py-4 px-8 rounded-lg text-lg shadow-lg shadow-indigo-500/30 transform hover:-translate-y-1 transition-all">
                            Start Your Evolution - Free
                        </a>
                    </div>
                </div>
                {{-- Right Column: Image --}}
                <div class="hidden lg:block">
                    <img src="{{ asset('images/hero-column.jpg') }}" alt="Athlete working out" class="rounded-2xl shadow-2xl transform-gpu rotate-3">
                </div>
            </div>
        </section>

        {{-- FEATURES SECTION --}}
        <section class="bg-gray-800/90 py-20 sm:py-24">
            <div class="max-w-7xl mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold tracking-tight text-white">The Most Advanced Fitness Tracker Ever Built</h2>
                <p class="mt-4 text-lg text-gray-400">Everything you need, and features you've never dreamed of.</p>

                <div class="mt-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                    {{-- Feature 1: Dynamic Logging --}}
                    <div class="p-8 bg-gray-900/70 rounded-2xl">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-indigo-500 text-white"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg></div>
                        <h3 class="mt-6 font-semibold text-white">Dynamic Workout Logging</h3>
                        <p class="mt-2 text-sm text-gray-400">From running distance to weightlifting sets and reps, our forms adapt to your specific workout.</p>
                    </div>

                    {{-- Feature 2: Calorie Tracking --}}
                    <div class="p-8 bg-gray-900/70 rounded-2xl">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-indigo-500 text-white"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m-9-5.747l18 0"></path></svg></div>
                        <h3 class="mt-6 font-semibold text-white">Automatic Calorie Tracking</h3>
                        <p class="mt-2 text-sm text-gray-400">Based on your weight and activity, we automatically calculate the calories you burn for every workout.</p>
                    </div>

                    {{-- Feature 3: Time Capsule Goals --}}
                    <div class="p-8 bg-gray-900/70 rounded-2xl">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-indigo-500 text-white"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
                        <h3 class="mt-6 font-semibold text-white">Fitness Time Capsule</h3>
                        <p class="mt-2 text-sm text-gray-400">Lock away your long-term goals and stay motivated for the big reveal on your unlock date.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- FINAL CTA SECTION --}}
        <section class="py-20">
            <div class="max-w-4xl mx-auto px-6 text-center">
                 <h2 class="text-3xl font-extrabold text-white">Ready to Begin Your Evolution?</h2>
                 <p class="mt-4 text-lg text-gray-400">Create your free account and start tracking your fitness journey like never before.</p>
                 <div class="mt-8">
                     <a href="{{ route('register') }}" class="inline-block bg-indigo-600 text-white font-bold py-4 px-8 rounded-lg text-lg shadow-lg shadow-indigo-500/30 transform hover:-translate-y-1 transition-all">
                        Sign Up Now
                    </a>
                 </div>
            </div>
        </section>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-gray-900 border-t border-white/10">
        <div class="max-w-7xl mx-auto px-6 py-8 text-center text-sm text-gray-500">
            <p>© {{ date('Y') }} Fitevolution. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
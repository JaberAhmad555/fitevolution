<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            {{-- THIS IS THE MAIN CONTENT WRAPPER WE WILL MODIFY --}}
            <main
                class="relative bg-cover bg-center bg-fixed"
                style="background-image: url('{{ asset('images/hero-background.jpg') }}');"
            >
                {{-- This is the dark overlay --}}
                <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>

                {{-- This div now holds the actual page content and sits on top of the overlay --}}
                <div class="relative z-10">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
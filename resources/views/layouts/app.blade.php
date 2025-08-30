<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        {{-- NEW STRUCTURE with a textured background --}}
        <div class="min-h-screen bg-cover bg-center bg-fixed" style="background-image: url('{{ asset('images/dark-texture.jpg') }}')">
            @include('layouts.navigation')

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    
                    <!-- Page Heading -->
                    @if (isset($header))
                        <header class="mb-6">
                            <div class="max-w-7xl mx-auto">
                                {{ $header }}
                            </div>
                        </header>
                    @endif

                    <!-- Main Content -->
                    <main>
                        {{ $slot }}
                    </main>

                </div>
            </div>
        </div>
    </body>
</html>
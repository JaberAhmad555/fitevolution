<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">Workout Summary</h2>
            <div class="flex items-center space-x-2">
                <a href="{{ route('workouts.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-100 uppercase hover:bg-gray-300 dark:hover:bg-gray-600">
                    &larr; Back to List
                </a>
                <a href="{{ route('workouts.edit', $workout) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-100 uppercase hover:bg-gray-300 dark:hover:bg-gray-600">
                    Edit
                </a>
                <form method="POST" action="{{ route('workouts.destroy', $workout) }}" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <x-danger-button type="submit" onclick="return confirm('Are you sure?')">Delete</x-danger-button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Left Column: Stats & Details --}}
                <div class="lg:col-span-1 space-y-6">
                    <!-- Main Info Card -->
                    <div class="bg-gray-800/90 backdrop-blur-sm shadow-2xl sm:rounded-2xl p-6">
                        @if ($workout->photo_path)
                            <img src="{{ asset('storage/' . $workout->photo_path) }}" alt="Workout photo" class="w-full h-64 object-cover rounded-lg mb-4">
                        @endif
                        <h3 class="text-2xl font-bold text-white">{{ ucfirst($workout->type) }}</h3>
                        <p class="mt-1 text-gray-400">{{ $workout->workout_date->format('l, F jS, Y') }}</p>
                    </div>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-800/90 backdrop-blur-sm shadow-2xl sm:rounded-2xl p-4 text-center">
                            <p class="text-sm font-medium text-gray-400">Duration</p>
                            <p class="mt-1 text-3xl font-semibold text-white">{{ $workout->duration_minutes }} <span class="text-xl">min</span></p>
                        </div>
                        <div class="bg-gray-800/90 backdrop-blur-sm shadow-2xl sm:rounded-2xl p-4 text-center">
                            <p class="text-sm font-medium text-gray-400">Calories Burned</p>
                            <p class="mt-1 text-3xl font-semibold text-white"> {{ $workout->calories_burned ?? 'N/A' }}</p>
                        </div>
                        @if(in_array($workout->type, ['running', 'cycling']))
                        <div class="bg-gray-800/90 backdrop-blur-sm shadow-2xl sm:rounded-2xl p-4 text-center col-span-2">
                            <p class="text-sm font-medium text-gray-400">Distance</p>
                            <p class="mt-1 text-3xl font-semibold text-white">{{ $workout->details['distance_km'] ?? 'N/A' }} <span class="text-xl">km</span></p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Right Column: Map --}}
                <div class="lg:col-span-2 bg-gray-800/90 backdrop-blur-sm shadow-2xl sm:rounded-2xl p-6">
                    <h4 class="text-lg font-medium text-white">Workout Route</h4>
                    @if(!empty($workout->route))
                        <div id="map" class="mt-4 h-[500px] w-full rounded-lg z-0"></div>
                    @else
                        <div class="mt-4 h-[500px] flex items-center justify-center bg-gray-900/50 rounded-lg">
                            <p class="text-gray-500">No route data was recorded for this workout.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    @if(!empty($workout->route))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            window.displayRouteMap('map', @json($workout->route));
        });
    </script>
    @endif
</x-app-layout>
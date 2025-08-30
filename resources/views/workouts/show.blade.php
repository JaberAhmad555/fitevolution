<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Workout Summary
            </h2>
            <div class="flex items-center space-x-2">
                <a href="{{ route('workouts.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">
                    &larr; Back to List
                </a>
                <a href="{{ route('workouts.edit', $workout) }}" class="inline-flex items-center px-4 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600">
                    Edit
                </a>
                <form method="POST" action="{{ route('workouts.destroy', $workout) }}" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <x-danger-button type="submit" onclick="return confirm('Are you sure you want to delete this workout?')">
                        Delete
                    </x-danger-button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Left Column: Stats & Details --}}
                <div class="lg:col-span-1 space-y-6">

                    {{-- CORRECTED Main Info Card --}}
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        @if ($workout->photo_path)
                            <img src="{{ asset('storage/' . $workout->photo_path) }}" alt="Workout photo" class="w-full h-64 object-cover rounded-lg mb-4">
                        @endif
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ ucfirst($workout->type) }}</h3>
                        <p class="mt-1 text-gray-500 dark:text-gray-400">{{ $workout->workout_date->format('l, F jS, Y') }}</p>
                    </div>

                    {{-- Stats Grid --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4 text-center">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Duration</p>
                            <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $workout->duration_minutes }} <span class="text-xl">min</span></p>
                        </div>
                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4 text-center">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Calories Burned</p>
                            <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-gray-100">🔥 {{ $workout->calories_burned ?? 'N/A' }}</p>
                        </div>
                        @if(isset($workout->details['distance_km']))
                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4 text-center col-span-2">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Distance</p>
                            <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $workout->details['distance_km'] }} <span class="text-xl">km</span></p>
                        </div>
                        @endif
                    </div>

                    {{-- Weightlifting Exercises --}}
                    @if($workout->type === 'weightlifting' && !empty($workout->details['exercises']))
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                         <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">Exercises Performed</h4>
                         <ul class="mt-4 space-y-3">
                             @foreach($workout->details['exercises'] as $exercise)
                                @if(!empty($exercise['name']))
                                 <li class="text-gray-700 dark:text-gray-300">
                                     <span class="font-bold">{{ $exercise['name'] }}:</span>
                                     {{ $exercise['sets'] ?? 'N/A' }} sets × {{ $exercise['reps'] ?? 'N/A' }} reps @if(!empty($exercise['weight'])) @ {{ $exercise['weight'] }} kg @endif
                                 </li>
                                @endif
                             @endforeach
                         </ul>
                    </div>
                    @endif
                </div>

                {{-- Right Column: Map --}}
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">Workout Route</h4>
                    @if(!empty($workout->route))
                        <div id="map" class="mt-4 h-[500px] w-full rounded-lg"></div> {{-- Increased map height --}}
                    @else
                        <div class="mt-4 h-[500px] flex items-center justify-center bg-gray-100 dark:bg-gray-900/50 rounded-lg">
                            <p class="text-gray-500">No route data was recorded for this workout.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>

        @if(!empty($workout->route))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const map = L.map('map');
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);
                const routeData = @json($workout->route);
                if (routeData && routeData.length > 0) {
                    const polyline = L.polyline(routeData, {color: 'rgb(79 70 229)', weight: 5}).addTo(map);
                    map.fitBounds(polyline.getBounds().pad(0.1));
                }
            });
        </script>
        @endif
    </x-app-layout>
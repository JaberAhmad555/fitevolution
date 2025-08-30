<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Fitness Journey') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-12">

                @forelse ($workoutsByDate as $date => $workouts)
                    {{-- Timeline Entry for a Single Day --}}
                    <div class="relative pl-8">
                        {{-- Vertical Line --}}
                        <div class="absolute left-3 top-3 bottom-0 w-px bg-gray-300 dark:bg-gray-600"></div>
                        {{-- Circle Marker --}}
                        <div class="absolute left-0 top-3 w-6 h-6 bg-indigo-600 rounded-full border-4 border-gray-100 dark:border-gray-900"></div>

                        {{-- Date Header --}}
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">
                            {{ \Carbon\Carbon::parse($date)->format('l, F jS, Y') }}
                        </h3>

                        {{-- Workouts for this day --}}
                        {{-- In resources/views/workouts/journey.blade.php --}}

                            {{-- Workouts for this day --}}
                        <div class="mt-4 space-y-6">
                            @foreach ($workouts as $workout)
                            {{-- Replace the existing card div with this one --}}
                            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                                @if($workout->photo_path)
                                    <img src="{{ asset('storage/' . $workout->photo_path) }}" alt="Workout photo" class="w-full h-48 object-cover">
                                @endif
                                <div class="p-6">
                                    {{-- Workout Title & Type --}}
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ ucfirst($workout->type) }}</h4>
                                            <p class="text-sm text-gray-500">
                                                <a href="{{ route('workouts.show', $workout) }}" class="hover:underline">View Full Details &rarr;</a>
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Key Metrics Display --}}
                                    <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 gap-4 text-center border-t border-gray-200 dark:border-gray-700 pt-4">
                                        {{-- Duration --}}
                                        <div>
                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Duration</p>
                                            <p class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $workout->duration_minutes }} <span class="text-base font-normal">min</span></p>
                                        </div>
                                        {{-- Calories --}}
                                        <div>
                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Calories</p>
                                            <p class="text-xl font-bold text-gray-900 dark:text-gray-100">🔥 {{ $workout->calories_burned ?? 'N/A' }}</p>
                                        </div>
                                        {{-- Distance (Conditional) --}}
                                        @if(isset($workout->details['distance_km']))
                                        <div class="col-span-2 sm:col-span-1">
                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Distance</p>
                                            <p class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $workout->details['distance_km'] }} <span class="text-base font-normal">km</span></p>
                                        </div>
                                        @endif
                                    </div>

                                    {{-- Weightlifting Summary (Conditional) --}}
                                    @if($workout->type === 'weightlifting' && !empty($workout->details['exercises']))
                                    <div class="mt-4 border-t border-gray-200 dark:border-gray-700 pt-4">
                                        <h5 class="text-sm font-medium text-gray-500 dark:text-gray-400">Exercises Performed</h5>
                                        <p class="text-gray-800 dark:text-gray-200 truncate">{{ implode(', ', array_column($workout->details['exercises'], 'name')) }}</p>
                                    </div>
                                    @endif

                                    {{-- NEW: Experience Notes Section (Conditional) --}}
                                    @if($workout->notes)
                                    <div class="mt-4 border-t border-gray-200 dark:border-gray-700 pt-4">
                                        <h5 class="text-sm font-medium text-gray-500 dark:text-gray-400">My Experience</h5>
                                        <p class="mt-2 text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $workout->notes }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Your Journey Awaits</h3>
                        <p class="mt-2 text-gray-500">You haven't logged any workouts yet. <a href="{{ route('dashboard') }}" class="text-indigo-500 hover:underline">Log your first workout</a> to begin your timeline!</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>
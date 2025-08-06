<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Log a New Workout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100" x-data="{ workoutType: '{{ old('type', 'running') }}' }">
                    <form method="POST" action="{{ route('workouts.store') }}">
                        @csrf

                        <!-- Workout Type (Dropdown) -->
                        <div>
                            <x-input-label for="type" :value="__('Workout Type')" />
                            <select id="type" name="type" x-model="workoutType" class="...">
                                <option value="running">Running</option>
                                <option value="cycling">Cycling</option>
                                <option value="weightlifting">Weightlifting</option>
                            </select>
                        </div>

                        <!-- Workout Date -->
                        <div class="mt-4">
                            <x-input-label for="workout_date" :value="__('Date of Workout')" />
                            <x-text-input id="workout_date" class="block mt-1 w-full" type="date" name="workout_date" :value="old('workout_date')" required />
                        </div>

                        <!-- DURATION (NOW A PRIMARY FIELD) -->
                        <div class="mt-4">
                            <x-input-label for="duration_minutes" :value="__('Total Duration (in minutes)')" />
                            <x-text-input id="duration_minutes" class="block mt-1 w-full" type="number" name="duration_minutes" :value="old('duration_minutes')" required />
                            <x-input-error :messages="$errors->get('duration_minutes')" class="mt-2" />
                        </div>


                        <!-- DYNAMIC FIELDS START HERE -->

                        <!-- Fields for Running/Cycling -->
                        <div x-show="workoutType === 'running' || workoutType === 'cycling'" class="mt-4 space-y-4">
                            <div>
                                <x-input-label for="distance_km" :value="__('Distance (in km)')" />
                                <x-text-input id="distance_km" class="block mt-1 w-full" type="text" name="details[distance_km]" />
                            </div>
                            {{-- DURATION WAS REMOVED FROM HERE --}}
                        </div>


                        <!-- Fields for Weightlifting -->
                        <div x-show="workoutType === 'weightlifting'" class="mt-4 space-y-4" x-data="{...}">
                            {{-- The weightlifting block remains the same --}}
                            ...
                        </div>

                        <!-- DYNAMIC FIELDS END HERE -->

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Save Workout') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
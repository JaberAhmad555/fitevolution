<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-white leading-tight">
            Edit Workout
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800/90 backdrop-blur-sm shadow-2xl sm:rounded-2xl p-6 md:p-8">
                {{-- The form tag points to the update route and uses PATCH --}}
                <form method="POST" action="{{ route('workouts.update', $workout) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    {{-- Alpine.js component for dynamic form fields --}}
                    <div x-data="{ workoutType: '{{ old('type', $workout->type) }}' }">

                        <!-- Workout Type -->
                        <div>
                            <x-input-label for="type" :value="__('Workout Type')" class="text-gray-300"/>
                            <select id="type" name="type" x-model="workoutType" class="block mt-1 w-full border-gray-600 bg-gray-900 text-gray-300 rounded-md shadow-sm">
                                <option value="running">Running</option>
                                <option value="cycling">Cycling</option>
                                <option value="weightlifting">Weightlifting</option>
                            </select>
                        </div>

                        <!-- Date & Duration -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <div>
                                <x-input-label for="workout_date" :value="__('Date of Workout')" class="text-gray-300"/>
                                <x-text-input id="workout_date" class="block mt-1 w-full border-gray-600 bg-gray-900 text-gray-300" type="date" name="workout_date" :value="old('workout_date', $workout->workout_date->format('Y-m-d'))" required />
                            </div>
                            <div>
                                <x-input-label for="duration_minutes" :value="__('Total Duration (in minutes)')" class="text-gray-300"/>
                                <x-text-input id="duration_minutes" class="block mt-1 w-full border-gray-600 bg-gray-900 text-gray-300" type="number" name="duration_minutes" :value="old('duration_minutes', $workout->duration_minutes)" required />
                            </div>
                        </div>

                        <!-- Dynamic Fields: Running/Cycling -->
                        <div x-show="workoutType === 'running' || workoutType === 'cycling'" class="space-y-4 mt-6">
                           {{-- The map plotter is not included in the edit form for simplicity --}}
                           <div>
                                <x-input-label for="distance_km" :value="__('Distance (in km)')" class="text-gray-300"/>
                                <x-text-input id="distance_km" class="block mt-1 w-full border-gray-600 bg-gray-900 text-gray-300" type="text" name="details[distance_km]" :value="old('details.distance_km', $workout->details['distance_km'] ?? '')" placeholder="Enter distance manually" />
                           </div>
                        </div>

                        <!-- Dynamic Fields: Weightlifting -->
                        <div x-show="workoutType === 'weightlifting'" class="space-y-4 mt-6" x-data="{ exercises: {{ json_encode(old('details.exercises', $workout->details['exercises'] ?? [['name' => '', 'sets' => '', 'reps' => '', 'weight' => '']])) }} }">
                            {{-- The weightlifting fields as before --}}
                        </div>

                        <!-- Notes & Photo -->
                        <div class="mt-6">
                            <x-input-label for="notes" :value="__('Share Your Experience (Optional)')" class="text-gray-300"/>
                            <textarea id="notes" name="notes" rows="4" class="mt-1 block w-full border-gray-600 bg-gray-900 text-gray-300 rounded-md shadow-sm">{{ old('notes', $workout->notes) }}</textarea>
                        </div>
                        <div class="mt-6">
                            <x-input-label for="photo" :value="__('Change Photo (Optional)')" class="text-gray-300"/>
                            <input id="photo" name="photo" type="file" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:font-semibold file:bg-indigo-900/50 file:text-indigo-300 hover:file:bg-indigo-800/50 mt-1"/>
                            @if($workout->photo_path)
                                <p class="text-xs text-gray-400 mt-2">Current photo:</p>
                                <img src="{{ asset('storage/' . $workout->photo_path) }}" class="mt-1 w-32 h-32 object-cover rounded-md">
                            @endif
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>{{ __('Save Changes') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
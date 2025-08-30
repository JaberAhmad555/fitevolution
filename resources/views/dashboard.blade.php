<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-white leading-tight">
            Dashboard
        </h2>
    </x-slot>

    {{-- Main container for BOTH the suggester and the form --}}
    <div class="bg-gray-800/90 backdrop-blur-sm shadow-2xl sm:rounded-2xl">
        <div class="p-6 md:p-8 space-y-8">

            {{-- Interactive Mood Suggester --}}
            <div x-data="moodSuggester()">
                <div>
                    <label for="mood-selector" class="block font-medium text-lg text-gray-200">How are you feeling today?</label>
                    <select id="mood-selector" x-model="selectedMood" @change="updateSuggestion()" class="mt-2 block w-full md:w-1/2 border-gray-600 bg-gray-900 text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">-- Select your mood --</option>
                        <option value="energetic">⚡ Energetic</option>
                        <option value="stressed">😤 Stressed</option>
                        <option value="tired">😴 Tired</option>
                        <option value="happy">😊 Happy</option>
                        <option value="neutral">😐 Neutral</option>
                    </select>
                    <div x-show="suggestion.reason" x-transition class="mt-4 p-4 bg-indigo-900/50 rounded-lg border border-indigo-500/30">
                        <p class="font-semibold text-indigo-200">Suggestion:</p>
                        <p class="text-indigo-300" x-text="suggestion.reason"></p>
                    </div>
                </div>
            </div>

            <hr class="border-gray-700">

            {{-- "Log New Workout" Form --}}
            <div x-data="{ workoutType: 'running' }">
                <h3 class="text-xl font-bold text-white">Log a New Workout</h3>
                <form method="POST" action="{{ route('workouts.store') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                    @csrf
                    
                    <!-- Workout Type -->
                    <div>
                        <x-input-label for="type" :value="__('Workout Type')" class="text-gray-300"/>
                        <select id="type" name="type" x-model="workoutType" class="block mt-1 w-full border-gray-600 bg-gray-900 text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="running">Running</option>
                            <option value="cycling">Cycling</option>
                            <option value="weightlifting">Weightlifting</option>
                        </select>
                    </div>

                    <!-- Workout Date -->
                    <div>
                        <x-input-label for="workout_date" :value="__('Date of Workout')" class="text-gray-300"/>
                        <x-text-input id="workout_date" class="block mt-1 w-full border-gray-600 bg-gray-900 text-gray-300" type="date" name="workout_date" :value="old('workout_date')" required />
                    </div>

                    <!-- Total Duration -->
                    <div>
                        <x-input-label for="duration_minutes" :value="__('Total Duration (in minutes)')" class="text-gray-300"/>
                        <x-text-input id="duration_minutes" class="block mt-1 w-full border-gray-600 bg-gray-900 text-gray-300" type="number" name="duration_minutes" :value="old('duration_minutes')" required />
                        <x-input-error :messages="$errors->get('duration_minutes')" class="mt-2" />
                    </div>

                    <!-- Dynamic Fields: Running/Cycling with Map -->
                    <!-- Dynamic Fields: Running/Cycling with Map -->
                    <div x-show="workoutType === 'running' || workoutType === 'cycling'"
                        class="space-y-4"
                        x-data="{ isDistanceLocked: false }">

                        {{-- Distance Input with Lock Toggle --}}
                        <div>
                            <label for="distance_km" class="block text-sm font-medium text-gray-300">Distance (in km)</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text"
                                    name="details[distance_km]"
                                    id="distance_km"
                                    x-bind:readonly="isDistanceLocked"
                                    x-bind:class="{ 'bg-gray-700/50 cursor-not-allowed': isDistanceLocked, 'bg-gray-900': !isDistanceLocked }"
                                    class="block w-full border-gray-600 text-gray-300 rounded-l-md focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Type manually or plot on map">

                                <button type="button" @click="isDistanceLocked = !isDistanceLocked"
                                        class="relative -ml-px inline-flex items-center space-x-2 rounded-r-md border border-gray-600 px-4 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700">
                                    {{-- Lock Icon --}}
                                    <svg x-show="!isDistanceLocked" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" /></svg>
                                    {{-- Unlock Icon --}}
                                    <svg x-show="isDistanceLocked" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5a3 3 0 10-6 0V9H6v2a1 1 0 01-2 0V9h1.5V5.5a4.5 4.5 0 119 0V9H15v2a1 1 0 01-2 0V9h-1.5V5.5a3 3 0 00-3-3z" /></svg>
                                    <span x-text="isDistanceLocked ? 'Unlock' : 'Lock'">Lock</span>
                                </button>
                            </div>
                        </div>

                        {{-- Map Plotter Section --}}
                        <div>
                            <h4 class="font-medium text-gray-200">Plot Your Route (Optional)</h4>
                            <p id="map-instructions" class="text-sm text-gray-400">Clicking the map will auto-fill the distance above.</p>
                            <div id="map-plotter" class="mt-2 h-80 w-full rounded-lg z-0"></div>
                            <div class="mt-2">
                                <button type="button" id="reset-route" class="text-sm text-indigo-400 hover:underline">Reset Route</button>
                            </div>
                            <input type="hidden" name="route" id="route-data">
                        </div>
                    </div>
                    <!-- Dynamic Fields: Weightlifting -->
                    <div x-show="workoutType === 'weightlifting'" class="space-y-4" x-data="{ exercises: [{ name: '', sets: '', reps: '', weight: '' }] }">
                        <h4 class="font-bold text-white">Exercises</h4>
                        <template x-for="(exercise, index) in exercises" :key="index">
                            <div class="p-4 border border-gray-700 rounded-lg space-y-3">
                                <div class="flex justify-between items-center"><label class="font-medium text-gray-200" x-text="'Exercise ' + (index + 1)"></label><button type="button" x-show="index > 0" @click="exercises.splice(index, 1)" class="text-red-500 text-sm">Remove</button></div>
                                <div><x-input-label :value="__('Exercise Name')" class="text-gray-300"/><x-text-input type="text" class="block mt-1 w-full border-gray-600 bg-gray-900 text-gray-300" x-bind:name="'details[exercises]['+index+'][name]'" x-model="exercise.name" /></div>
                                <div class="grid grid-cols-3 gap-4">
                                    <div><x-input-label :value="__('Sets')" class="text-gray-300"/><x-text-input type="number" class="block mt-1 w-full border-gray-600 bg-gray-900 text-gray-300" x-bind:name="'details[exercises]['+index+'][sets]'" x-model="exercise.sets" /></div>
                                    <div><x-input-label :value="__('Reps')" class="text-gray-300"/><x-text-input type="number" class="block mt-1 w-full border-gray-600 bg-gray-900 text-gray-300" x-bind:name="'details[exercises]['+index+'][reps]'" x-model="exercise.reps" /></div>
                                    <div><x-input-label :value="__('Weight (kg)')" class="text-gray-300"/><x-text-input type="text" class="block mt-1 w-full border-gray-600 bg-gray-900 text-gray-300" x-bind:name="'details[exercises]['+index+'][weight]'" x-model="exercise.weight" /></div>
                                </div>
                            </div>
                        </template>
                        <button type="button" @click="exercises.push({ name: '', sets: '', reps: '', weight: '' })" class="text-sm text-indigo-400 hover:underline">+ Add Another Exercise</button>
                    </div>
                    
                    <!-- Share Your Experience -->
                    <div>
                        <x-input-label for="notes" :value="__('Share Your Experience (Optional)')" class="text-gray-300"/>
                        <textarea id="notes" name="notes" rows="4" class="mt-1 block w-full border-gray-600 bg-gray-900 text-gray-300 rounded-md shadow-sm" placeholder="How did it feel? Any personal records?">{{ old('notes') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                    </div>
                    
                    <!-- Workout Photo -->
                    <div>
                        <x-input-label for="photo" :value="__('Add a Photo (Optional)')" class="text-gray-300"/>
                        <input id="photo" name="photo" type="file" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:font-semibold file:bg-indigo-900/50 file:text-indigo-300 hover:file:bg-indigo-800/50 mt-1"/>
                        <x-input-error class="mt-2" :messages="$errors->get('photo')" />
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-end">
                        <x-primary-button>
                            {{ __('Save Workout') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPTS for interactive elements --}}
    <script>
        function moodSuggester() {
            return {
                selectedMood: '',
                suggestion: { type: '', reason: '' },
                suggestions: {
                    energetic: { type: 'Running', reason: 'You\'re full of energy! A good run is a perfect way to channel it.' },
                    stressed: { type: 'Weightlifting', reason: 'Feeling stressed? A strength session can be a great outlet.' },
                    tired: { type: 'Cycling', reason: 'Feeling tired? A steady-paced bike ride can help boost your energy levels.' },
                    happy: { type: 'Running', reason: 'You\'re in a great mood! Keep the momentum going with an enjoyable run.' },
                    neutral: { type: 'Weightlifting', reason: 'Not sure what to do? A solid weightlifting session is always a productive choice.' }
                },
                updateSuggestion() {
                    if (this.suggestions[this.selectedMood]) {
                        this.suggestion = this.suggestions[this.selectedMood];
                        const workoutTypeSelect = document.querySelector('#type');
                        const formAlpineData = workoutTypeSelect.closest('[x-data]').__x;
                        if(formAlpineData) {
                            formAlpineData.workoutType = this.suggestion.type.toLowerCase();
                        }
                    } else {
                        this.suggestion = { type: '', reason: '' };
                    }
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const workoutForm = document.querySelector('form[action="{{ route('workouts.store') }}"]');
            if (!workoutForm) return;

            const workoutTypeSelect = workoutForm.querySelector('#type');
            let map;
            
            function initializeMap() {
                if (map) { map.remove(); map = null; }
                
                const mapElement = workoutForm.querySelector('#map-plotter');
                if (!mapElement) return;

                let startPoint = null, endPoint = null;
                let startMarker = null, endMarker = null, routeLine = null;
                const instructions = workoutForm.querySelector('#map-instructions');
                const resetBtn = workoutForm.querySelector('#reset-route');
                const distanceInput = workoutForm.querySelector('#distance_km');
                const routeDataInput = workoutForm.querySelector('#route-data');

                function setupMap(centerCoords) {
                    map = L.map(mapElement).setView(centerCoords, 13);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
                    map.on('click', onMapClick);
                    resetBtn.addEventListener('click', resetRoute);
                }
                function onMapClick(e) { if (!startPoint) { startPoint = e.latlng; startMarker = L.marker(startPoint).addTo(map).bindPopup('Start').openPopup(); instructions.textContent = 'Click the map to set your END point.'; } else if (!endPoint) { endPoint = e.latlng; endMarker = L.marker(endPoint).addTo(map).bindPopup('End').openPopup(); instructions.textContent = 'Route plotted. Click Reset to start over.'; drawRouteAndCalculate(); } }
                // Inside the map script at the bottom of dashboard.blade.php

                function drawRouteAndCalculate() {
                    if (startPoint && endPoint) {
                        const points = [startPoint, endPoint];
                        routeLine = L.polyline(points, {color: 'rgb(79 70 229)', weight: 5}).addTo(map);
                        map.fitBounds(routeLine.getBounds().pad(0.1));

                        const distanceMeters = startPoint.distanceTo(endPoint);
                        const distanceKm = (distanceMeters / 1000).toFixed(2);

                        // THIS IS THE FIX: Check the lock state before updating
                        const formAlpineData = distanceInput.closest('[x-data]').__x;
                        if (!formAlpineData.isDistanceLocked) {
                            distanceInput.value = distanceKm;
                        }

                        routeDataInput.value = JSON.stringify([
                            [startPoint.lat, startPoint.lng],
                            [endPoint.lat, endPoint.lng]
                        ]);
                    }
                }
                function resetRoute() { startPoint = null; endPoint = null; if (startMarker) map.removeLayer(startMarker); if (endMarker) map.removeLayer(endMarker); if (routeLine) map.removeLayer(routeLine); startMarker = null; endMarker = null; routeLine = null; distanceInput.value = ''; routeDataInput.value = ''; instructions.textContent = 'Click the map to set your start point.'; }
                navigator.geolocation.getCurrentPosition(pos => setupMap([pos.coords.latitude, pos.coords.longitude]), () => setupMap([51.505, -0.09]));
            }

            function handleMapVisibility() {
                const selectedType = workoutTypeSelect.value;
                if ((selectedType === 'running' || selectedType === 'cycling')) {
                     setTimeout(() => { if(!map) initializeMap(); }, 100);
                }
            }

            workoutTypeSelect.addEventListener('change', handleMapVisibility);
            handleMapVisibility();
        });
    </script>
</x-app-layout>
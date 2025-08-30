<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                My Workouts
            </h2>

            {{-- THIS IS THE FIX --}}
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                Log New Workout
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- Replace your entire table with this block --}}

                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        {{-- CORRECTED 7-COLUMN HEADER --}}
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Photo</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Duration</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Details</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Calories Burned</th>
                                <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                            </tr>
                        </thead>

                        {{-- CORRECTED 7-COLUMN BODY ROWS --}}
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($workouts as $workout)
                                <tr>
                                    {{-- Column 1: Photo --}}
                                    <td class="px-6 py-4">
                                        @if($workout->photo_path)
                                            <img src="{{ asset('storage/' . $workout->photo_path) }}" alt="Workout photo" class="h-10 w-10 rounded-full object-cover">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l-1.586-1.586a2 2 0 00-2.828 0L6 14m6-6l.01.01"></path></svg>
                                            </div>
                                        @endif
                                    </td>
                                    
                                    {{-- Column 2: Date --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $workout->workout_date->format('M d, Y') }}</td>
                                    
                                    {{-- Column 3: Type --}}
                                    <td class="px-6 py-4 whitespace-nowrap font-medium">
                                        <a href="{{ route('workouts.show', $workout) }}" class="text-indigo-400 hover:underline">
                                            {{ ucfirst($workout->type) }}
                                        </a>
                                    </td>
                                    
                                    {{-- Column 4: Duration --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $workout->duration_minutes }} min</td>

                                    {{-- Column 5: Details --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                        @if(isset($workout->details['distance_km']))
                                            Distance: {{ $workout->details['distance_km'] }} km
                                        @elseif($workout->type === 'weightlifting' && !empty($workout->details['exercises']))
                                            {{ count($workout->details['exercises']) }} exercises
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    
                                    {{-- Column 6: Calories Burned --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-300">🔥 {{ $workout->calories_burned ?? 'N/A' }}</td>

                                    {{-- Column 7: Actions --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('workouts.edit', $workout) }}" class="text-indigo-400 hover:text-indigo-600">Edit</a>
                                        <form method="POST" action="{{ route('workouts.destroy', $workout) }}" class="inline-block ml-4">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                        You haven't logged any workouts yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
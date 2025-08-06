<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('My Workouts') }}
            </h2>
            <a href="{{ route('workouts.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
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
                        {{-- NEW, CLEANER HEADER --}}
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Duration</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Details</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Calories Burned</th>
                                <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                            </tr>
                        </thead>

                        {{-- NEW, CLEANER BODY WITH CORRECT DATA --}}
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($workouts as $workout)
                                <tr>
                                    {{-- Date --}}
                                    <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($workout->workout_date)->format('M d, Y') }}</td>
                                    
                                    {{-- Type --}}
                                    <td class="px-6 py-4 whitespace-nowrap font-medium">{{ ucfirst($workout->type) }}</td>
                                    
                                    {{-- Duration (from the correct top-level property) --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $workout->duration_minutes }} min
                                    </td>

                                    {{-- Details (now shows only what's relevant) --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($workout->type === 'running' || $workout->type === 'cycling')
                                            Distance: {{ $workout->details['distance_km'] ?? 'N/A' }} km
                                        @elseif($workout->type === 'weightlifting')
                                            @if(isset($workout->details['exercises']) && count($workout->details['exercises']) > 0)
                                                {{ count($workout->details['exercises']) }} exercises
                                            @else
                                                N/A
                                            @endif
                                        @endif
                                    </td>
                                    
                                    {{-- Calories Burned (from the correct top-level property) --}}
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold">
                                        🔥 {{ $workout->calories_burned ?? 'N/A' }}
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('workouts.edit', $workout) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900">Edit</a>
                                        <form method="POST" action="{{ route('workouts.destroy', $workout) }}" class="inline-block ml-4">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                        You haven't logged any workouts yet. Start now!
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
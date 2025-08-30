<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Workout Challenges') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                @forelse ($challenges as $challenge)
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $challenge->name }}</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $challenge->description }}</p>
                            <p class="mt-2 text-xs text-gray-500">
                                Runs from {{ $challenge->start_date->format('M d') }} to {{ $challenge->end_date->format('M d, Y') }}
                            </p>
                        </div>

                        <div class="ml-4">
                            {{-- Check if the authenticated user is a participant --}}
                            @if ($challenge->participants->contains(Auth::user()))
                                {{-- User has joined - Show Leave button --}}
                                <form method="POST" action="{{ route('challenges.leave', $challenge) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700">
                                        Leave Challenge
                                    </button>
                                </form>
                            @else
                                {{-- User has not joined - Show Join button --}}
                                <form method="POST" action="{{ route('challenges.join', $challenge) }}">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700">
                                        Join Challenge
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-center">
                        <p class="text-gray-500">No challenges are available at the moment. Please check back later!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
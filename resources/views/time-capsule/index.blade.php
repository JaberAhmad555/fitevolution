<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Fitness Time Capsule') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Section 1: Create a New Time Capsule --}}
            <div class="p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Lock a New Goal</h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Set a future goal for yourself. It will remain locked and hidden until the unlock date you choose.
                </p>
                <form method="POST" action="{{ route('time-capsule.store') }}" class="mt-6 space-y-6">
                    @csrf
                    <div>
                        <x-input-label for="goal_description" :value="__('Your Future Goal')" />
                        <textarea id="goal_description" name="goal_description" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>{{ old('goal_description') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('goal_description')" />
                    </div>
                    <div>
                        <x-input-label for="unlock_date" :value="__('Unlock Date')" />
                        <x-text-input id="unlock_date" type="date" name="unlock_date" class="mt-1 block w-full" :value="old('unlock_date')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('unlock_date')" />
                    </div>
                    <div class="flex items-center">
                        <x-primary-button>
                            {{ __('Lock It In') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            {{-- Section 2: Locked Capsules --}}
            <div class="p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Locked Capsules</h3>
                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($lockedCapsules as $capsule)
                        <div class="flex flex-col items-center justify-center p-6 bg-gray-100 dark:bg-gray-900/50 rounded-lg text-center border-2 border-dashed border-gray-400 dark:border-gray-600">
                            <svg class="w-12 h-12 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a2 2 0 00-2 2v2H7a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V8a2 2 0 00-2-2h-1V4a2 2 0 00-2-2zm-1 4V4a1 1 0 112 0v2H9z" clip-rule="evenodd"></path></svg>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Locked</p>
                            <p class="font-semibold text-gray-700 dark:text-gray-200">Unlocks on {{ $capsule->unlock_date->format('M d, Y') }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400 col-span-full">You have no goals currently locked away.</p>
                    @endforelse
                </div>
            </div>

            {{-- Section 3: Revealed Capsules --}}
            <div class="p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Revealed Goals</h3>
                <div class="mt-4 space-y-4">
                    @forelse ($unlockedCapsules as $capsule)
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Unlocked on {{ $capsule->unlock_date->format('M d, Y') }}</p>
                            <p class="mt-1 text-gray-800 dark:text-gray-200">{{ $capsule->goal_description }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400">None of your past goals have been revealed yet.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-white leading-tight">
            Fitness Travel Ideas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800/90 backdrop-blur-sm shadow-2xl sm:rounded-2xl p-6 md:p-8">
                <h3 class="text-xl text-white">Based on your workout history, we think you'll love these:</h3>
                
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($suggestions as $destination)
                        <div class="bg-gray-900/70 rounded-2xl overflow-hidden shadow-lg">
                            <img src="{{ asset('images/' . $destination->image_path) }}" alt="{{ $destination->name }}" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h4 class="text-lg font-bold text-white">{{ $destination->name }}</h4>
                                <p class="text-sm font-semibold text-indigo-400">{{ $destination->location }}</p>
                                <p class="mt-2 text-sm text-gray-400">{{ $destination->description }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-400 col-span-full">Log some workouts to get personalized travel suggestions!</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
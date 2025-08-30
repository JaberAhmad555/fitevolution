<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-white leading-tight">
            My Awards
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800/90 backdrop-blur-sm shadow-2xl sm:rounded-2xl p-6 md:p-8">
                @if($achievements->isEmpty())
                    <div class="text-center py-12">
                        <h3 class="text-xl font-semibold text-gray-200">Your Trophy Case is Empty</h3>
                        <p class="mt-2 text-gray-400">
                            Keep logging your workouts to earn new awards and badges!
                        </p>
                    </div>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                        @foreach ($achievements as $achievement)
                            <div class="flex flex-col items-center text-center p-4 bg-gray-900/50 rounded-lg">
                                <img src="{{ asset('images/' . $achievement->badge_image) }}" alt="{{ $achievement->name }}" class="h-24 w-24">
                                <h4 class="mt-4 font-semibold text-white">{{ $achievement->name }}</h4>
                                <p class="mt-1 text-xs text-gray-400 flex-grow">{{ $achievement->description }}</p>

                                {{-- Conditional Mint Button / Status --}}
                                <div class="mt-4">
                                    @if ($achievement->nft_transaction_hash)
                                        <a href="https://etherscan.io/tx/{{ $achievement->nft_transaction_hash }}" target="_blank" class="text-sm text-green-400 hover:underline">
                                            ✓ Minted! View on Etherscan
                                        </a>
                                    @else
                                        <form method="POST" action="{{ route('achievements.mint', $achievement) }}">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 bg-indigo-600 text-white text-xs font-semibold rounded-md hover:bg-indigo-700">
                                                Mint as NFT
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        {{-- Add this block to show errors --}}
                        @if($errors->has('wallet_error'))
                            <div class="col-span-full p-4 mb-4 text-sm text-red-400 rounded-lg bg-red-900/50">
                                {{ $errors->first('wallet_error') }}
                            </div>
                        @endif

                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
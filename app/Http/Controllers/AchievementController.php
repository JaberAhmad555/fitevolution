<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Achievement;

class AchievementController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Get all achievements, newest first
        $achievements = $user->achievements()->latest()->get();

        return view('achievements.index', ['achievements' => $achievements]);
    }

    public function mint(Achievement $achievement)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // --- Authorization & Validation ---
        if ($achievement->user_id !== $user->id) { abort(403); }
        if (!$user->wallet_address) {
            return back()->withErrors(['wallet_error' => 'Please add your wallet address to your profile before minting.']);
        }
        if ($achievement->nft_transaction_hash) {
            return back()->withErrors(['wallet_error' => 'This achievement has already been minted as an NFT.']);
        }

        // --- The Minting Simulation ---
        // In a real app, this is where you would:
        // 1. Upload the badge image to IPFS to get a permanent URL.
        // 2. Create a metadata JSON file (with name, description, IPFS image URL) and upload that to IPFS.
        // 3. Call your smart contract's "safeMint" function via an API like Alchemy or Infura,
        //    passing the user's wallet address and the IPFS URL of the metadata.
        // 4. Get the real transaction hash back from that API call.

        // For our simulation, we'll just generate a fake hash.
        $fakeTransactionHash = '0x' . bin2hex(random_bytes(32));

        $achievement->update([
            'nft_transaction_hash' => $fakeTransactionHash,
        ]);

        return redirect()->route('achievements.index')->with('status', 'Your NFT has been minted! The transaction is processing.');
    }
}
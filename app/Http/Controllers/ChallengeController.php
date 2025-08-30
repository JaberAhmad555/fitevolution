<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChallengeController extends Controller
{
    /**
     * Display a listing of the challenges.
     */
    public function index()
    {
        // Eager load the participants to avoid the N+1 query problem
        $challenges = Challenge::with('participants')->latest()->get();

        return view('challenges.index', ['challenges' => $challenges]);
    }

    /**
     * Allow the authenticated user to join a challenge.
     */
    public function join(Challenge $challenge)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // attach() is the method for adding a record to a many-to-many pivot table
        // We use syncWithoutDetaching to prevent errors if the user is already attached.
        $user->challenges()->syncWithoutDetaching($challenge->id);

        return redirect()->route('challenges.index')->with('status', 'Successfully joined the challenge!');
    }

    /**
     * Allow the authenticated user to leave a challenge.
     */
    public function leave(Challenge $challenge)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // detach() is the method for removing a record from a many-to-many pivot table
        $user->challenges()->detach($challenge->id);

        return redirect()->route('challenges.index')->with('status', 'You have left the challenge.');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TimeCapsuleController extends Controller
{
    /**
     * Display the time capsule page, showing locked and unlocked goals.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // THIS IS THE FIX:
        // Gracefully handle the case where the relationship might not be loaded correctly
        // or the user has no capsules.
        $capsules = $user->timeCapsules ?? collect();

        list($lockedCapsules, $unlockedCapsules) = $capsules
            ->sortBy('unlock_date')
            ->partition(function ($capsule) {
                return $capsule->unlock_date->isFuture();
            });

        return view('time-capsule.index', [
            'lockedCapsules' => $lockedCapsules,
            'unlockedCapsules' => $unlockedCapsules,
        ]);
    }

    /**
     * Store a new time capsule goal.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'goal_description' => 'required|string|max:1000',
            'unlock_date' => 'required|date|after:today',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->timeCapsules()->create($validated);

        return redirect()->route('time-capsule.index')->with('status', 'Your goal has been locked in the time capsule!');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Workout;                 // <-- Add this line
use App\Services\CalorieService;        // <-- Add this line
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $workouts = $user->workouts()->latest('workout_date')->get();
        return view('workouts.index', ['workouts' => $workouts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('workouts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CalorieService $calorieService) // The red line will now be gone
    {
        

        $validated = $request->validate([
            'type' => 'required|string|in:running,cycling,weightlifting',
            'workout_date' => 'required|date',
            'duration_minutes' => 'required|integer|min:1', // It's now a required, top-level field
            'details' => 'nullable|array',
        ]);
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Create the workout first
        $workout = $user->workouts()->create($validated);

        // Then, calculate and save calories
        $calories = $calorieService->calculate($workout);
        $workout->update(['calories_burned' => $calories]);

        return redirect()->route('workouts.index')->with('status', 'Workout logged successfully!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Workout $workout) // The red line will now be gone
    {
        if (Auth::id() !== $workout->user_id) {
            abort(403, 'Unauthorized action.');
        }
        return view('workouts.edit', ['workout' => $workout]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Workout $workout, CalorieService $calorieService) // The red line will now be gone
    {
        if (Auth::id() !== $workout->user_id) {
            abort(403, 'Unauthorized action.');
        }

        

        $validated = $request->validate([
            'type' => 'required|string|in:running,cycling,weightlifting',
            'workout_date' => 'required|date',
            'duration_minutes' => 'required|integer|min:1', // It's now a required, top-level field
            'details' => 'nullable|array',
        ]);

        $workout->update($validated);

        // Re-calculate and save calories
        $calories = $calorieService->calculate($workout);
        $workout->update(['calories_burned' => $calories]);

        return redirect()->route('workouts.index')->with('status', 'Workout updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workout $workout) // The red line will now be gone
    {
        if (Auth::id() !== $workout->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $workout->delete();
        return redirect()->route('workouts.index')->with('status', 'Workout deleted successfully!');
    }
}
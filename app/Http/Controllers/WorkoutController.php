<?php

namespace App\Http\Controllers;

use App\Models\Workout;                 // <-- Add this line
use App\Services\CalorieService;        // <-- Add this line
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AchievementService;

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
    // In app/Http/Controllers/WorkoutController.php

    public function store(Request $request, CalorieService $calorieService,AchievementService $achievementService)
    {
        // FIX #1: Added 'jpg', 'png', 'jpeg' to the validation rule
        $validatedData = $request->validate([
            'type' => 'required|string|in:running,cycling,weightlifting',
            'workout_date' => 'required|date',
            'duration_minutes' => 'required|integer|min:1',
            'details' => 'nullable|array',
            'route' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // More mime types
            'notes' => 'nullable|string|max:2000',
            'mood' => 'nullable|string|in:energetic,stressed,tired,happy,neutral',
        
        ]);

        // Handle the photo upload first
        if ($request->hasFile('photo')) {
            $validatedData['photo_path'] = $request->file('photo')->store('workout-photos', 'public');
        }

        // Handle the route data
        if (isset($validatedData['route'])) {
            $validatedData['route'] = json_decode($validatedData['route'], true);
        }
        
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Create the workout with all validated data
        $workout = $user->workouts()->create($validatedData);

        $achievementService->checkAndAwardMilestones($user, $workout);

        // Calculate calories
        $calories = $calorieService->calculate($workout);
        if ($calories) {
            $workout->update(['calories_burned' => $calories]);
        }

        // FIX #2: Redirect to the new workout's summary page
        return redirect()->route('workouts.show', $workout)->with('status', 'Workout logged successfully!');
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
    // In app/Http/Controllers/WorkoutController.php

    public function update(Request $request, CalorieService $calorieService)
    {
        // FIX #1: Added 'jpg', 'png', 'jpeg' to the validation rule
        $validatedData = $request->validate([
            'type' => 'required|string|in:running,cycling,weightlifting',
            'workout_date' => 'required|date',
            'duration_minutes' => 'required|integer|min:1',
            'details' => 'nullable|array',
            'route' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // More mime types
            'notes' => 'nullable|string|max:2000',
            'mood' => 'nullable|string|in:energetic,stressed,tired,happy,neutral',
        ]);

        // Handle the photo upload first
        if ($request->hasFile('photo')) {
            $validatedData['photo_path'] = $request->file('photo')->store('workout-photos', 'public');
        }

        // Handle the route data
        if (isset($validatedData['route'])) {
            $validatedData['route'] = json_decode($validatedData['route'], true);
        }
        
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Create the workout with all validated data
        $workout = $user->workouts()->create($validatedData);

        // Calculate calories
        $calories = $calorieService->calculate($workout);
        if ($calories) {
            $workout->update(['calories_burned' => $calories]);
        }

        // FIX #2: Redirect to the new workout's summary page
        return redirect()->route('workouts.show', $workout)->with('status', 'Workout logged successfully!');
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
    public function show(Workout $workout)
    {
        // Authorization check
        if (Auth::id() !== $workout->user_id) {
            abort(403);
        }

        return view('workouts.show', ['workout' => $workout]);
    }
    // In WorkoutController.php

    public function recalculate(Workout $workout, CalorieService $calorieService)
    {
        // Authorization check
        if (Auth::id() !== $workout->user_id) {
            abort(403);
        }

        // Re-calculate and save the calories
        $calories = $calorieService->calculate($workout);
        $workout->update(['calories_burned' => $calories]);

        // Redirect back to the show page with a success message
        return redirect()->route('workouts.show', $workout)->with('status', 'Calories recalculated successfully!');
    }



    public function journey()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Get all workouts, order by the newest first
        $workouts = $user->workouts()->latest('workout_date')->get();

        // Group the workouts by the date they were performed on
        $workoutsByDate = $workouts->groupBy(function ($workout) {
            return $workout->workout_date->format('Y-m-d');
        });

        return view('workouts.journey', ['workoutsByDate' => $workoutsByDate]);
    }



}
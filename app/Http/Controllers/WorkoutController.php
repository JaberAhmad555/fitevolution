<?php

namespace App\Http\Controllers;

use App\Models\Workout;                 // <-- Add this line
use App\Services\CalorieService;        // <-- Add this line
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AchievementService;
use Illuminate\Support\Facades\Storage; // <-- ADD THIS LINE

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

    // In app/Http/Controllers/WorkoutController.php

    // In app/Http/Controllers/WorkoutController.php

    // In app/Http/Controllers/WorkoutController.php

    // In app/Http/Controllers/WorkoutController.php

    public function store(Request $request, CalorieService $calorieService, AchievementService $achievementService)
    {
    
        $validatedData = $request->validate([
            'type' => 'required|string|in:running,cycling,weightlifting',
            'workout_date' => 'required|date',
            'duration_minutes' => 'required|integer|min:1',
            'details' => 'nullable|array',
            'route' => 'nullable|string', // This comes from the hidden input
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'notes' => 'nullable|string|max:2000',
            'mood' => 'nullable|string|in:energetic,stressed,tired,happy,neutral',
        ]);

        // --- LOGIC REBUILT FOR CLARITY AND ACCURACY ---

        // Initialize details with any submitted exercise data
        $details = $request->input('details', []);
        
        // Handle the route data first, as it is the highest priority
        if ($request->filled('route')) {
            $routeArray = json_decode($validatedData['route'], true);
            
            // Ensure the decoded data is a valid array for a route
            if (is_array($routeArray) && count($routeArray) >= 2) {
                $validatedData['route'] = $routeArray; // Put the clean array back

                // Calculate distance using the Haversine formula for accuracy
                $startPoint = $routeArray[0];
                $endPoint = $routeArray[count($routeArray) - 1];
                $earthRadius = 6371; // km
                $latFrom = deg2rad($startPoint[0]);
                $lonFrom = deg2rad($startPoint[1]);
                $latTo = deg2rad($endPoint[0]);
                $lonTo = deg2rad($endPoint[1]);
                $latDelta = $latTo - $latFrom;
                $lonDelta = $lonTo - $lonFrom;
                $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
                
                // If a route was plotted, its calculated distance OVERWRITES any manual input.
                $details['distance_km'] = round($angle * $earthRadius, 2);
            } else {
                $validatedData['route'] = null; // The submitted route string was invalid
            }
        } else {
            // If no route was submitted, ensure it's null
            $validatedData['route'] = null;
            // And check if a manual distance was entered
            $manualDistance = $request->input('details.distance_km');
            if ($manualDistance) {
                $details['distance_km'] = $manualDistance;
            }
        }

        $validatedData['details'] = $details;

        // Handle file upload
        if ($request->hasFile('photo')) {
            $validatedData['photo_path'] = $request->file('photo')->store('workout-photos', 'public');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $workout = $user->workouts()->create($validatedData);

        // Final calculations and checks
        $calories = $calorieService->calculate($workout);
        if ($calories) { $workout->update(['calories_burned' => $calories]); }
        $achievementService->checkAndAwardMilestones($user, $workout);

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

    public function update(Request $request, Workout $workout, CalorieService $calorieService)
    {
        if (Auth::id() !== $workout->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'type' => 'required|string|in:running,cycling,weightlifting',
            'workout_date' => 'required|date',
            'duration_minutes' => 'required|integer|min:1',
            'details' => 'nullable|array',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'notes' => 'nullable|string|max:2000',
        ]);

        if ($request->hasFile('photo')) {
            // Delete the old photo if it exists
            if ($workout->photo_path) {
                Storage::disk('public')->delete($workout->photo_path);
            }
            $validatedData['photo_path'] = $request->file('photo')->store('workout-photos', 'public');
        }

        $workout->update($validatedData);

        // Re-calculate calories
        $calories = $calorieService->calculate($workout);
        if ($calories) {
            $workout->update(['calories_burned' => $calories]);
        }

        return redirect()->route('workouts.show', $workout)->with('status', 'Workout updated successfully!');
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
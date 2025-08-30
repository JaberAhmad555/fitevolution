<?php
use App\Http\Controllers\TimeCapsuleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChallengeController; // <-- ADD THIS LINE
use App\Services\WorkoutSuggestionService;
use App\Http\Controllers\AchievementController; 
use App\Http\Controllers\ProgressController; 
use App\Http\Controllers\TravelController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Main workout list page
    Route::get('/workouts', [WorkoutController::class, 'index'])->name('workouts.index');

    

    // Action to store a new workout in the database
    Route::post('/workouts', [WorkoutController::class, 'store'])->name('workouts.store');

    // THIS IS THE NEW ROUTE TO ADD
    Route::get('/workouts/{workout}', [WorkoutController::class, 'show'])->name('workouts.show');

    // Page to show the "edit existing workout" form
    Route::get('/workouts/{workout}/edit', [WorkoutController::class, 'edit'])->name('workouts.edit');

    // Action to update an existing workout in the database
    Route::patch('/workouts/{workout}', [WorkoutController::class, 'update'])->name('workouts.update');

    // Action to delete a workout
    Route::delete('/workouts/{workout}', [WorkoutController::class, 'destroy'])->name('workouts.destroy');


    // TIME CAPSULE ROUTES
    Route::get('/time-capsule', [TimeCapsuleController::class, 'index'])->name('time-capsule.index');
    Route::post('/time-capsule', [TimeCapsuleController::class, 'store'])->name('time-capsule.store');
    // In routes/web.php, inside the auth middleware group
    Route::patch('/workouts/{workout}/recalculate', [WorkoutController::class, 'recalculate'])->name('workouts.recalculate');


    Route::get('/challenges', [ChallengeController::class, 'index'])->name('challenges.index');
    Route::post('/challenges/{challenge}/join', [ChallengeController::class, 'join'])->name('challenges.join');
    Route::delete('/challenges/{challenge}/leave', [ChallengeController::class, 'leave'])->name('challenges.leave');

    Route::get('/journey', [WorkoutController::class, 'journey'])->name('workouts.journey');


    Route::get('/awards', [AchievementController::class, 'index'])->name('achievements.index');

    Route::get('/progress', [ProgressController::class, 'index'])->name('progress.index');



    // In routes/web.php, inside the auth group
    Route::post('/achievements/{achievement}/mint', [AchievementController::class, 'mint'])->name('achievements.mint');


    Route::get('/travel', [TravelController::class, 'index'])->name('travel.index');


});

require __DIR__.'/auth.php';

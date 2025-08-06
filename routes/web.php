<?php
use App\Http\Controllers\TimeCapsuleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkoutController;
use Illuminate\Support\Facades\Route;

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
    Route::resource('workouts', WorkoutController::class);
    Route::get('/time-capsule', [TimeCapsuleController::class, 'index'])->name('time-capsule.index');
    Route::post('/time-capsule', [TimeCapsuleController::class, 'store'])->name('time-capsule.store');
});

require __DIR__.'/auth.php';

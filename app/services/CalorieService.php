<?php

namespace App\Services;

use App\Models\Workout;
use App\Models\User;

class CalorieService
{
    // Source: Compendium of Physical Activities
    private const MET_VALUES = [
        'running' => 9.8,   // for a moderate pace
        'cycling' => 7.5,   // for a moderate pace
        'weightlifting' => 5.0, // general weightlifting
        'default' => 3.5,   // light activity
    ];

    /**
     * Calculate calories burned for a given workout.
     * Formula: Calories = Duration (min) * (MET * 3.5 * Weight (kg)) / 200
     *
     * @param Workout $workout
     * @return int|null The calculated calories, or null if calculation is not possible.
     */
    // In app/Services/CalorieService.php

    public function calculate(Workout $workout): ?int
    {
        /** @var User $user */
        $user = $workout->user;

        $weight = $user->weight_kg;

        // THIS IS THE FIX: Get duration from the main property, not 'details'
        $duration = $workout->duration_minutes;

        // Cannot calculate without weight or duration
        if (is_null($weight) || is_null($duration) || $duration == 0) {
            return null; // Return null if we don't have the necessary data
        }

        $metValue = self::MET_VALUES[$workout->type] ?? self::MET_VALUES['default'];

        $calories = ($duration * ($metValue * 3.5 * $weight)) / 200;

        return round($calories);
    }
}
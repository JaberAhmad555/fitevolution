<?php
namespace App\Services;

use App\Models\User;
use App\Models\Destination;
use Illuminate\Support\Facades\DB;

class TravelSuggestionService
{
    /**
     * Get personalized travel suggestions for a user.
     *
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSuggestions(User $user)
    {
        // Find the user's most frequent workout type
        $dominantType = $user->workouts()
            ->select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->orderBy('total', 'desc')
            ->first();

        if ($dominantType) {
            // If they have a dominant type, find destinations matching it
            return Destination::where('fitness_type', $dominantType->type)->get();
        }

        // If the user is new or has no workouts, return a few random destinations
        return Destination::inRandomOrder()->limit(3)->get();
    }
}
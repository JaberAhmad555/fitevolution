<?php
namespace App\Services;

use App\Models\User;
use App\Models\Workout;
use Illuminate\Support\Facades\Config;

class AchievementService
{
    public function checkAndAwardMilestones(User $user, Workout $newWorkout)
    {
        $this->checkTotalWorkouts($user);
        $this->checkDistanceRun($user, $newWorkout);
        // Add calls to other check methods here in the future
    }

    private function checkTotalWorkouts(User $user)
    {
        $milestones = Config::get('milestones.total_workouts');
        $totalWorkouts = $user->workouts()->count();

        foreach ($milestones as $milestone) {
            if ($totalWorkouts >= $milestone['value']) {
                $this->awardMilestone($user, 'total_workouts', $milestone);
            }
        }
    }

    private function checkDistanceRun(User $user, Workout $workout)
    {
        if ($workout->type !== 'running' || !isset($workout->details['distance_km'])) {
            return;
        }

        $milestones = Config::get('milestones.distance_run');
        $runDistance = $workout->details['distance_km'];

        foreach ($milestones as $milestone) {
            if ($runDistance >= $milestone['value']) {
                $this->awardMilestone($user, 'distance_run', $milestone);
            }
        }
    }

    private function awardMilestone(User $user, string $type, array $milestone)
    {
        // Create a unique key to prevent duplicate awards
        $milestoneKey = "user_{$user->id}_{$type}_{$milestone['value']}";

        // Check if this achievement has already been awarded
        $existing = $user->achievements()->where('milestone_key', $milestoneKey)->exists();
        
        if (!$existing) {
            $user->achievements()->create([
                'milestone_key' => $milestoneKey,
                'name' => $milestone['name'],
                'description' => $milestone['description'],
                'badge_image' => $milestone['badge_image'],
            ]);
        }
    }
}
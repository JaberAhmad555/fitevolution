<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Challenge;
use Carbon\Carbon;

class ChallengeSeeder extends Seeder
{
    public function run(): void
    {
        Challenge::create([
            'name' => 'August Running Challenge',
            'description' => 'Run a total of 50 km this month.',
            'start_date' => Carbon::now()->startOfMonth(),
            'end_date' => Carbon::now()->endOfMonth(),
            'goal_type' => 'distance',
            'goal_value' => 50,
        ]);

        Challenge::create([
            'name' => 'Weekly Workout Warrior',
            'description' => 'Log at least 240 minutes of workouts in the next 7 days.',
            'start_date' => Carbon::now()->startOfWeek(),
            'end_date' => Carbon::now()->endOfWeek(),
            'goal_type' => 'duration',
            'goal_value' => 240,
        ]);
    }
}
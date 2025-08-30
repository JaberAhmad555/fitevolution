<?php

return [
    'distance_run' => [
        [
            'name' => 'First 5k',
            'description' => 'Completed a run of at least 5 kilometers.',
            'value' => 5,
            'badge_image' => 'badges/5k_run.png', // Placeholder image path
        ],
        [
            'name' => 'First 10k',
            'description' => 'Completed a run of at least 10 kilometers.',
            'value' => 10,
            'badge_image' => 'badges/10k_run.png',
        ],
    ],
    'total_workouts' => [
        [
            'name' => 'Workout Beginner',
            'description' => 'Logged your first workout.',
            'value' => 1,
            'badge_image' => 'badges/1_workout.png',
        ],
        [
            'name' => 'Consistent Trainer',
            'description' => 'Logged a total of 10 workouts.',
            'value' => 10,
            'badge_image' => 'badges/10_workouts.png',
        ],
    ],
];
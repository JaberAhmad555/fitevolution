<?php

namespace App\Services;

use App\Models\User;

class WorkoutSuggestionService
{
    /**
     * A map of moods to suggested workout types.
     * The values are arrays to allow for multiple suggestions per mood.
     */
    private const MOOD_SUGGESTIONS = [
        'energetic' => [
            'type' => 'Running',
            'reason' => 'You\'re full of energy! A good run is a perfect way to channel it.'
        ],
        'stressed' => [
            'type' => 'Weightlifting',
            'reason' => 'Feeling stressed? A strength session can be a great outlet.'
        ],
        'tired' => [
            'type' => 'Cycling',
            'reason' => 'Feeling tired? A steady-paced bike ride can help boost your energy levels.'
        ],
        'happy' => [
            'type' => 'Running',
            'reason' => 'You\'re in a great mood! Keep the momentum going with an enjoyable run.'
        ],
        'neutral' => [
            'type' => 'Weightlifting',
            'reason' => 'Not sure what to do? A solid weightlifting session is always a productive choice.'
        ],
    ];

    /**
     * Get a workout suggestion for a user based on their self-reported mood.
     *
     * @param string $mood The user's current mood.
     * @return array|null An array containing the suggested workout type and reason, or null.
     */
    public function getSuggestion(string $mood): ?array
    {
        return self::MOOD_SUGGESTIONS[$mood] ?? null;
    }

    /**
     * Get a suggestion for the user's dashboard. For now, this is a placeholder
     * for a random mood. In a future version, this could be based on user input from the dashboard.
     *
     * @return array
     */
    public function getDashboardSuggestion(): array
    {
        $randomMood = array_rand(self::MOOD_SUGGESTIONS);
        return $this->getSuggestion($randomMood);
    }
}
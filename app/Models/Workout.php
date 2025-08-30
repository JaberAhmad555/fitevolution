<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// In app/Models/Workout.php

class Workout extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'user_id', 'type', 'workout_date', 'duration_minutes', 'details', 'calories_burned', 'route', 'photo_path','notes','mood', 
    ];

    protected $casts = [
        'details' => 'array',
        'route' => 'array', // <-- Add this line
        'workout_date' => 'date',
    ];


    /**
     * Get the user that owns the workout.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

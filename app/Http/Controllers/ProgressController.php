<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProgressController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // --- 1. Monthly Workout Duration Chart ---
        $durations = $user->workouts()
            ->where('workout_date', '>=', Carbon::now()->subMonths(6)->startOfMonth())
            ->select(
                DB::raw('YEAR(workout_date) as year'),
                DB::raw('MONTH(workout_date) as month'),
                DB::raw('SUM(duration_minutes) as total_duration')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // --- 2. Monthly Workout Count Chart ---
        $counts = $user->workouts()
            ->where('workout_date', '>=', Carbon::now()->subMonths(6)->startOfMonth())
            ->select(
                DB::raw('YEAR(workout_date) as year'),
                DB::raw('MONTH(workout_date) as month'),
                DB::raw('COUNT(id) as total_workouts')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Format data for Chart.js
        $chartLabels = [];
        $durationData = [];
        $countData = [];

        // Create a base timeline of the last 6 months
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $chartLabels[] = $month->format('M Y');
            $durationData[$month->format('Y-n')] = 0;
            $countData[$month->format('Y-n')] = 0;
        }

        foreach ($durations as $record) {
            $durationData[$record->year . '-' . $record->month] = $record->total_duration;
        }

        foreach ($counts as $record) {
            $countData[$record->year . '-' . $record->month] = $record->total_workouts;
        }

        return view('progress.index', [
            'chartLabels' => $chartLabels,
            'durationData' => array_values($durationData),
            'countData' => array_values($countData),
        ]);
    }
}
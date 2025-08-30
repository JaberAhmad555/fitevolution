<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TravelSuggestionService;
use Illuminate\Support\Facades\Auth;

class TravelController extends Controller
{
    public function index(TravelSuggestionService $travelService)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $suggestions = $travelService->getSuggestions($user);

        return view('travel.index', ['suggestions' => $suggestions]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\M_Games;

class C_Discover extends Controller
{
    public function index()
    {
        $gamesQuery = M_Games::with(['developer', 'images', 'latestPrice', 'tags']);

        if (!(auth()->check() && auth()->user()->is_admin)) {
            $gamesQuery->where('visible', true); // Only apply visibility filter for non-admins
        }

        $games = $gamesQuery->inRandomOrder()->paginate(12);

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Discover']
        ];

        return view('discover.V_Discover', compact('games', 'breadcrumbs'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\M_Games;

class C_Discover extends Controller
{
    public function index()
    {
        // Eager load relationships that are always used in the card
        $games = M_Games::with(['developer', 'images', 'latestPrice', 'tags'])
            ->where('visible', true) // Only show visible games
            ->inRandomOrder()
            ->paginate(12);

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('discover')],
            ['name' => 'Discover']
        ];

        return view('discover.V_Discover', compact('games', 'breadcrumbs'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\M_Games;

class C_Discover extends Controller
{
    // Display a list of games for discovery.
    // Shows all games to admins, visible games to others, paginated and in random order.
    public function index()
    {
        $gamesQuery = M_Games::with(['developer', 'images', 'latestPrice', 'tags']);

        if (!(auth()->check() && auth()->user()->is_admin)) {
            $gamesQuery->where('visible', true);
        }

        $games = $gamesQuery->inRandomOrder()->paginate(\App\Configuration::$pagination);

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Discover']
        ];

        return view('discover.V_Discover', compact('games', 'breadcrumbs'));
    }
}

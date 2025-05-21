<?php

namespace App\Http\Controllers;

use App\Models\M_Games;

class C_Discover extends Controller
{
    public function index()
    {
        $games = M_Games::with(['developer', 'images', 'latestPrice'])
            ->inRandomOrder()
            ->where('visible', true)
            ->paginate(12);

        return view('discover.V_Discover', compact('games'));
    }
}

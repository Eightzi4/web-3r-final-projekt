<?php

namespace App\Http\Controllers;

use App\Models\M_Developers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class C_Developer extends Controller
{
    // Display the specified developer's page.
    // Eager loads related games and prepares breadcrumbs.
    public function show(M_Developers $developer)
    {
        $developer->load(['games.images', 'games.latestPrice', 'games.tags', 'country', 'images']);
        $games = $developer->games()->where('visible', true)
                               ->orderBy('name')
                               ->paginate(\App\Configuration::$pagination);
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Developers', 'url' => '#'],
            ['name' => Str::limit($developer->name, 30)]
        ];
        return view('developers.V_Show', compact('developer', 'games', 'breadcrumbs'));
    }
}

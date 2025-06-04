<?php

namespace App\Http\Controllers;

use App\Models\M_Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class C_Tag extends Controller
{
    // Display the page for a specific tag, showing associated games.
    // Eager loads related game data and prepares breadcrumbs.
    public function show(M_Tags $tag)
    {
        $tag->load(['games.images', 'games.latestPrice', 'games.tags', 'games.developer']);
        $games = $tag->games()->where('visible', true)
                           ->orderBy('name')
                           ->paginate(\App\Configuration::$pagination);
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Tags', 'url' => '#'],
            ['name' => Str::limit($tag->name, 30)]
        ];
        return view('tags.V_Show', compact('tag', 'games', 'breadcrumbs'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\M_Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class C_TagPageController extends Controller
{
    public function show(M_Tags $tag) // Route model binding
    {
        $tag->load(['games.images', 'games.latestPrice', 'games.tags', 'games.developer']); // Eager load games and relations
        $games = $tag->games()->where('visible', true) // Or all if admin
                           ->orderBy('name')
                           ->paginate(12);
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Tags', 'url' => '#'], // Or a future tags index page
            ['name' => Str::limit($tag->name, 30)]
        ];
        return view('tags.V_Show', compact('tag', 'games', 'breadcrumbs'));
    }
}

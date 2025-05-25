<?php

namespace App\Http\Controllers;

use App\Models\M_Developers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class C_DeveloperPageController extends Controller
{
    public function show(M_Developers $developer) // Route model binding
    {
        $developer->load(['games.images', 'games.latestPrice', 'games.tags', 'country', 'images']); // Eager load games and their needed relations
        $games = $developer->games()->where('visible', true) // Or all if admin, similar logic to discover/search
                               ->orderBy('name')
                               ->paginate(12);
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Developers', 'url' => '#'], // Or a future developers index page
            ['name' => Str::limit($developer->name, 30)]
        ];
        return view('developers.V_Show', compact('developer', 'games', 'breadcrumbs'));
    }
}

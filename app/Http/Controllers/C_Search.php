<?php

namespace App\Http\Controllers;

use App\Models\M_Games;
use App\Models\M_Tags;
use App\Models\M_Prices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class C_Search extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'tags' => 'nullable|array',
            'tags.*' => 'integer|exists:tags,id',
            'sort' => 'nullable|in:price'
        ]);

        $games = M_Games::with(['developer', 'tags', 'latestPrice'])
            ->when($request->filled('tags'), function ($query) use ($request) {
                $query->whereHas('tags', function ($q) use ($request) {
                    $q->whereIn('tag_id', $request->tags);
                });
            })
            ->when($request->sort === 'price', function ($query) {
                $query->orderBy(
                    M_Prices::select('price')
                        ->whereColumn('game_id', 'games.id')
                        ->latest('date')
                        ->limit(1),
                    'asc'
                );
            })
            ->paginate(12);

        $tags = M_Tags::orderBy('name')->get();
        return view('search.V_Search', compact('games', 'tags'));
    }
}

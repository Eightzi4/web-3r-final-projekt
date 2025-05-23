<?php

namespace App\Http\Controllers;

use App\Models\M_Games;
use App\Models\M_Tags;
use App\Models\M_Prices; // Keep this if used in orderBy
use Illuminate\Http\Request;

class C_Search extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'query' => 'nullable|string|max:100', // Added search query
            'tags' => 'nullable|array',
            'tags.*' => 'integer|exists:tags,id',
            'sort' => 'nullable|in:price_asc,price_desc,name_asc,name_desc,newest', // Expanded sort options
            'platform' => 'nullable|integer|exists:platforms,id',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0|gte:min_price',
        ]);

        $gamesQuery = M_Games::query()->where('visible', true)
            ->with(['developer', 'images', 'tags', 'latestPrice']);

        if ($request->filled('query')) {
            $gamesQuery->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->query . '%')
                  ->orWhere('description', 'LIKE', '%' . $request->query . '%');
            });
        }

        if ($request->filled('tags')) {
            $gamesQuery->whereHas('tags', function ($q) use ($request) {
                $q->whereIn('tags.id', $request->tags); // Use tags.id for clarity
            }, '=', count($request->tags)); // Optional: Match ALL selected tags
        }

        if($request->filled('platform')) {
            $gamesQuery->whereHas('prices.platform', function($q) use ($request){
                $q->where('platforms.id', $request->platform);
            });
        }

        if ($request->filled('min_price')) {
            $gamesQuery->whereHas('latestPrice', function ($q) use ($request) {
                $q->where('price', '>=', $request->min_price);
            });
        }
        if ($request->filled('max_price')) {
            $gamesQuery->whereHas('latestPrice', function ($q) use ($request) {
                $q->where('price', '<=', $request->max_price);
            });
        }


        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $gamesQuery->orderBy(
                        M_Prices::select('price')
                            ->whereColumn('game_id', 'games.id')
                            ->latest('date') // ensure it's the latest price
                            ->limit(1),
                        'asc'
                    );
                    break;
                case 'price_desc':
                     $gamesQuery->orderBy(
                        M_Prices::select('price')
                            ->whereColumn('game_id', 'games.id')
                            ->latest('date')
                            ->limit(1),
                        'desc'
                    );
                    break;
                case 'name_asc':
                    $gamesQuery->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $gamesQuery->orderBy('name', 'desc');
                    break;
                // Add case for 'newest' if you have a release_date or created_at on games table
                // case 'newest':
                //     $gamesQuery->orderBy('release_date', 'desc'); // or games.created_at
                //     break;
            }
        } else {
            $gamesQuery->orderBy('name', 'asc'); // Default sort
        }

        $games = $gamesQuery->paginate(12)->appends($request->query());

        $tags = M_Tags::orderBy('name')->get();
        $platforms = \App\Models\M_Platforms::orderBy('name')->get();

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('discover')],
            ['name' => 'Search']
        ];

        return view('search.V_Search', compact('games', 'tags', 'platforms', 'breadcrumbs'));
    }
}

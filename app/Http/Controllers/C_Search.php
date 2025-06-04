<?php

namespace App\Http\Controllers;

use App\Models\M_Games;
use App\Models\M_Tags;
use App\Models\M_Prices;
use App\Models\M_Platforms;
use Illuminate\Http\Request;

class C_Search extends Controller
{
    // Handles game search requests with various filters and sorting options.
    // Validates input, applies filters for query, tags, platform, price, and sorts results.
    public function index(Request $request)
    {
        $validated = $request->validate([
            'query' => 'nullable|string|max:100',
            'tags' => 'nullable|array',
            'tags.*' => 'integer|exists:tags,id',
            'sort' => 'nullable|in:price_asc,price_desc,name_asc,name_desc,newest',
            'platform' => 'nullable|integer|exists:platforms,id',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0|gte:min_price',
        ]);

        $gamesQuery = M_Games::query()->with(['developer', 'images', 'tags', 'latestPrice']);

        if (!(auth()->check() && auth()->user()->is_admin)) {
            $gamesQuery->where('visible', true);
        }

        $searchTerm = $request->input('query');

        if ($searchTerm) {
            $gamesQuery->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhereHas('developer', function ($devQ) use ($searchTerm) {
                        $devQ->where('name', 'LIKE', '%' . $searchTerm . '%');
                    });
            });
        }

        if ($request->filled('tags')) {
            $gamesQuery->whereHas('tags', function ($q) use ($request) {
                $q->whereIn('tags.id', $request->tags);
            }, '=', count($request->tags));
        }

        if ($request->filled('platform')) {
            $gamesQuery->whereHas('prices.platform', function ($q) use ($request) {
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
                            ->latest('date')
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
            }
        } else {
            $gamesQuery->orderBy('name', 'asc');
        }

        $games = $gamesQuery->paginate(\App\Configuration::$pagination)->appends($request->query());

        $tags = M_Tags::orderBy('name')->get();
        $platforms = M_Platforms::orderBy('name')->get();

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Search']
        ];

        return view('search.V_Search', compact('games', 'tags', 'platforms', 'breadcrumbs'));
    }
}

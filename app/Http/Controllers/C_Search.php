<?php

namespace App\Http\Controllers;

use App\Models\M_Games;
use App\Models\M_Tags;
use Illuminate\Http\Request;

class C_Search extends Controller
{
    public function index(Request $request)
    {
        $games = M_Games::with(['developer', 'tags', 'prices'])
            ->when($request->tags, function ($query) use ($request) {
                $query->whereHas('tags', function ($q) use ($request) {
                    $q->whereIn('tag_id', $request->tags);
                });
            })
            ->when($request->sort, function ($query) use ($request) {
                switch ($request->sort) {
                    case 'price':
                        $query->with(['prices' => function ($q) {
                            $q->orderBy('price');
                        }]);
                        break;
                    case 'release_date':
                        $query->orderBy('release_date');
                        break;
                }
            })
            ->paginate(12);

        $tags = M_Tags::orderBy('name')->get();
        return view('search.V_Search', compact('games', 'tags'));
    }
}

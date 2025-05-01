<?php

namespace App\Http\Controllers;

use App\Models\M_Games;
use App\Models\M_Prices;
use App\Models\M_GameImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class C_Game extends Controller
{
    public function create()
    {
        return view('games.V_CreateEdit', [
            'developers' => \App\Models\M_Developers::all(),
            'tags' => \App\Models\M_Tags::all(),
            'platforms' => \App\Models\M_Platforms::all(),
            'stores' => \App\Models\M_Stores::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'developer_id' => 'required|exists:developers,id',
            'visible' => 'required|boolean',
            'tags' => 'nullable|array',
            'platforms' => 'required|array',
            'stores' => 'required|array',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Create game
        $game = M_Games::create($request->only([
            'name', 'description', 'developer_id', 'visible'
        ]));

        // Attach relationships
        $game->tags()->attach($validated['tags'] ?? []);

        // Create prices
        foreach ($validated['platforms'] as $platformId) {
            foreach ($validated['stores'] as $storeId) {
                M_Prices::create([
                    'price' => $validated['price'],
                    'discount' => $validated['discount'] ?? 0,
                    'games_id' => $game->id,
                    'platforms_id' => $platformId,
                    'stores_id' => $storeId
                ]);
            }
        }

        // Store images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/game_images');
                M_GameImages::create([
                    'image' => str_replace('public/', '', $path),
                    'games_id' => $game->id
                ]);
            }
        }

        return redirect()->back()->with('success', 'Game created successfully!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\M_Games;
use App\Models\M_Prices;
use App\Models\M_GameImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class C_Game extends Controller
{
    public function create()
    {
        return view('games.V_CreateEdit', [
            'game' => new M_Games(),
            'developers' => \App\Models\M_Developers::all(),
            'tags' => \App\Models\M_Tags::all(),
            'platforms' => \App\Models\M_Platforms::all(),
            'stores' => \App\Models\M_Stores::all(),
            'selectedTags' => [],
            'selectedPlatforms' => [],
            'selectedStores' => [],
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'visible' => 'required|boolean',
                'tags' => 'nullable|string',
                'developer_id' => 'required|exists:developers,id',
                'prices' => 'required|array|min:1',
                'prices.*.platform_id' => 'required|exists:platforms,id',
                'prices.*.store_id' => 'required|exists:stores,id',
                'prices.*.price' => 'required|numeric|min:0',
                'prices.*.discount' => 'nullable|numeric|min:0|max:100',
                'images' => 'nullable|array',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Create game
            $game = M_Games::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'developer_id' => $validated['developer_id'],
                'visible' => $validated['visible']
            ]);

            // Handle tags
            if (!empty($validated['tags'])) {
                $tags = explode(',', $validated['tags']);
                $tagIds = \App\Models\M_Tags::whereIn('name', $tags)->pluck('id');
                $game->tags()->attach($tagIds);
            }

            // Create prices
            foreach ($validated['prices'] as $priceData) {
                M_Prices::create([
                    'price' => $priceData['price'],
                    'discount' => $priceData['discount'] ?? 0,
                    'date' => now(),
                    'game_id' => $game->id,
                    'platform_id' => $priceData['platform_id'],
                    'store_id' => $priceData['store_id']
                ]);
            }

            // Handle images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('public/game_images');
                    M_GameImages::create([
                        'image' => str_replace('public/', '', $path),
                        'game_id' => $game->id
                    ]);
                }
                Log::info('Images uploaded', ['count' => count($request->file('images'))]);
            }

            return redirect()->back()->with('success', 'Game created successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit(M_Games $game)
    {
        Log::debug('Edit method data:', [
            'tags' => $game->tags->pluck('name'),
            'platforms' => $game->prices->pluck('platform.name'),
            'stores' => $game->prices->pluck('store.name')
        ]);

        return view('games.V_CreateEdit', [
            'game' => $game,
            'developers' => \App\Models\M_Developers::all(),
            'tags' => \App\Models\M_Tags::all(),
            'platforms' => \App\Models\M_Platforms::all(),
            'stores' => \App\Models\M_Stores::all(),
            'selectedTags' => $game->tags->pluck('name')->toArray(),
            'selectedPlatforms' => $game->prices->pluck('platform.name')->filter()->unique()->values()->toArray() ?? [],
            'selectedStores' => $game->prices->pluck('store.name')->filter()->unique()->values()->toArray() ?? [],
        ]);
    }

    public function update(Request $request, M_Games $game)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'visible' => 'required|boolean',
            'tags' => 'nullable|string',
            'developer_id' => 'required|exists:developers,id',
            'prices' => 'required|array|min:1',
            'prices.*.platform_id' => 'required|exists:platforms,id',
            'prices.*.store_id' => 'required|exists:stores,id',
            'prices.*.price' => 'required|numeric|min:0',
            'prices.*.discount' => 'nullable|numeric|min:0|max:100',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update game
        $game->update($request->only(['name', 'description', 'developer_id', 'visible']));

        // Sync tags
        if (!empty($validated['tags'])) {
            $tags = explode(',', $validated['tags']);
            $tagIds = \App\Models\M_Tags::whereIn('name', $tags)->pluck('id');
            $game->tags()->sync($tagIds);
        } else {
            $game->tags()->detach();
        }

        // Delete old prices and create new ones
        $game->prices()->delete();
        foreach ($validated['prices'] as $priceData) {
            M_Prices::create([
                'price' => $priceData['price'],
                'discount' => $priceData['discount'] ?? 0,
                'date' => now(),
                'game_id' => $game->id,
                'platform_id' => $priceData['platform_id'],
                'store_id' => $priceData['store_id']
            ]);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/game_images');
                M_GameImages::create([
                    'image' => str_replace('public/', '', $path),
                    'game_id' => $game->id
                ]);
            }
        }

        return redirect()->route('games.edit', $game)->with('success', 'Game updated successfully!');
    }

    public function destroy(M_Games $game)
    {
        // Delete wishlist entries (unique to this game)
        if (DB::getSchemaBuilder()->hasTable('wished_games')) {
            DB::table('wished_games')->where('game_id', $game->id)->delete();
        }

        // Delete owned games entries (unique to this game)
        if (DB::getSchemaBuilder()->hasTable('owned_games')) {
            DB::table('owned_games')->where('game_id', $game->id)->delete();
        }

        // Delete reviews (unique to this game)
        $game->reviews()->delete();

        // Delete game states relationship (just detach, don't delete states as they can be used by other games)
        if (method_exists($game, 'gameStates')) {
            $game->gameStates()->detach();
        }

        // Delete tags relationship (just detach, don't delete tags as they can be used by other games)
        $game->tags()->detach();

        // Delete prices (unique to this game)
        $game->prices()->delete();

        // Delete images (unique to this game)
        foreach ($game->images as $image) {
            Storage::delete('public/' . $image->image);
            $image->delete();
        }

        // Finally delete the game itself
        $game->delete();

        return redirect()->back()->with('success', 'Game deleted successfully!');
    }

    public function destroyImage(M_GameImages $image)
    {
        Storage::delete('public/' . $image->image);
        $image->delete();
        return back()->with('success', 'Image deleted successfully');
    }
}

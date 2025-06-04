<?php

namespace App\Http\Controllers;

use App\Models\M_Games;
use App\Models\M_Prices;
use App\Models\M_GameImages;
use App\Models\M_Developers;
use App\Models\M_Tags;
use App\Models\M_Platforms;
use App\Models\M_Stores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class C_Game extends Controller
{
    // Constructor to apply middleware.
    // Ensures admin access for CUD operations, 'show' is public.
    public function __construct()
    {
        $this->middleware('admin')->except(['show']);
    }

    // Display a specific game's details page.
    // Handles visibility and loads related data like reviews and similar games.
    public function show(M_Games $game)
    {
        if (!$game->visible && !(auth()->check() && auth()->user()->is_admin)) {
            abort(404);
        }

        $game->load([
            'developer',
            'images',
            'tags',
            'prices.platform',
            'prices.store',
            'reviews.user'
        ]);

        $relatedGames = M_Games::where('developer_id', $game->developer_id)
            ->where('id', '!=', $game->id)
            ->where('visible', true)
            ->with(['images', 'latestPrice'])
            ->inRandomOrder()
            ->take(4)
            ->get();

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Games', 'url' => '#'],
            ['name' => Str::limit($game->name, 30)]
        ];

        return view('games.V_Show', compact('game', 'relatedGames', 'breadcrumbs'));
    }

    // Show the form for creating a new game.
    // Provides necessary data like developers, tags, platforms, and stores.
    public function create()
    {
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
            ['name' => 'Add Game']
        ];
        return view('games.V_CreateEdit', [
            'game' => new M_Games(),
            'developers' => M_Developers::orderBy('name')->get(),
            'tags' => M_Tags::orderBy('name')->get(),
            'platforms' => M_Platforms::orderBy('name')->get(),
            'stores' => M_Stores::orderBy('name')->get(),
            'selectedTags' => old('tags') ? explode(',', old('tags')) : [],
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    // Store a newly created game in storage.
    // Handles validation, tags, prices, and image uploads within a database transaction.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:games,name',
            'description' => 'nullable|string',
            'trailer_link' => 'nullable|url',
            'visible' => 'required|boolean',
            'tags' => 'nullable|string',
            'developer_id' => 'required|exists:developers,id',
            'prices' => 'required|array|min:1',
            'prices.*.platform_id' => 'required|exists:platforms,id',
            'prices.*.store_id' => 'required|exists:stores,id',
            'prices.*.price' => 'required|numeric|min:0',
            'prices.*.discount' => 'nullable|numeric|min:0|max:100',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $game = M_Games::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'trailer_link' => $validated['trailer_link'],
                'developer_id' => $validated['developer_id'],
                'visible' => $validated['visible']
            ]);

            if (!empty($validated['tags'])) {
                $tagNames = explode(',', $validated['tags']);
                $tagIds = [];
                foreach ($tagNames as $tagName) {
                    $tag = M_Tags::firstOrCreate(['name' => trim($tagName)]);
                    $tagIds[] = $tag->id;
                }
                $game->tags()->attach($tagIds);
            }

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
                    $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
                    $image->storeAs('images', $filename, 'public');
                    M_GameImages::create([
                        'image' => $filename,
                        'game_id' => $game->id
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('games.edit', $game)->with('success', 'Game created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Game creation failed: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Failed to create game. ' . $e->getMessage()]);
        }
    }

    // Show the form for editing the specified game.
    // Eager loads game data and provides necessary select options.
    public function edit(M_Games $game)
    {
        $game->load('images', 'tags', 'prices');

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
            ['name' => 'Games', 'url' => route('admin.games.index')],
            ['name' => 'Edit: ' . Str::limit($game->name, 20)]
        ];

        return view('games.V_CreateEdit', [
            'game' => $game,
            'developers' => M_Developers::orderBy('name')->get(),
            'tags' => M_Tags::orderBy('name')->get(),
            'platforms' => M_Platforms::orderBy('name')->get(),
            'stores' => M_Stores::orderBy('name')->get(),
            'selectedTags' => old('tags') ? explode(',', old('tags')) : $game->tags->pluck('name')->toArray(),
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    // Update the specified game in storage.
    // Handles validation, tags, prices, image uploads, and image deletions within a transaction.
    public function update(Request $request, M_Games $game)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:games,name,' . $game->id,
            'description' => 'nullable|string',
            'trailer_link' => 'nullable|url',
            'visible' => 'required|boolean',
            'tags' => 'nullable|string',
            'developer_id' => 'required|exists:developers,id',
            'prices' => 'required|array|min:1',
            'prices.*.platform_id' => 'required|exists:platforms,id',
            'prices.*.store_id' => 'required|exists:stores,id',
            'prices.*.price' => 'required|numeric|min:0',
            'prices.*.discount' => 'nullable|numeric|min:0|max:100',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'integer|exists:game_images,id',
        ]);

        DB::beginTransaction();
        try {
            $game->update($request->only(['name', 'description', 'trailer_link', 'developer_id', 'visible']));

            if (!empty($validated['tags'])) {
                $tagNames = explode(',', $validated['tags']);
                $tagIds = [];
                foreach ($tagNames as $tagName) {
                    $tag = M_Tags::firstOrCreate(['name' => trim($tagName)]);
                    $tagIds[] = $tag->id;
                }
                $game->tags()->sync($tagIds);
            } else {
                $game->tags()->detach();
            }

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

            if ($request->has('delete_images')) {
                $gameImageIdsToDelete = M_GameImages::where('game_id', $game->id)
                    ->whereIn('id', $request->input('delete_images'))
                    ->pluck('id');

                foreach ($gameImageIdsToDelete as $imageId) {
                    $image = M_GameImages::find($imageId);
                    if ($image) {
                        Storage::disk('public')->delete('images/' . $image->image);
                        $image->delete();
                    }
                }
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
                    $image->storeAs('images', $filename, 'public');
                    M_GameImages::create([
                        'image' => $filename,
                        'game_id' => $game->id
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('admin.games.edit', $game)->with('success', 'Game updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Game update failed: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Failed to update game. ' . $e->getMessage()]);
        }
    }

    // Remove the specified game from storage.
    // Handles deletion of related data (tags, prices, images, etc.) within a transaction.
    public function destroy(M_Games $game)
    {
        DB::beginTransaction();
        try {
            $game->tags()->detach();
            $game->gameStates()->detach();
            $game->owners()->detach();
            $game->wishers()->detach();

            $game->reviews()->delete();
            $game->prices()->delete();

            foreach ($game->images as $image) {
                Storage::disk('public')->delete('images/' . $image->image);
                $image->delete();
            }

            $game->delete();
            DB::commit();
            return redirect()->route('discover')
                ->with('success', 'Game "' . $game->name . '" deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Game deletion failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete game. ' . $e->getMessage());
        }
    }

    // Delete a specific game image from storage and the database.
    // Uses Route Model Binding for the image.
    public function destroyGameImage(M_GameImages $image)
    {
        Storage::disk('public')->delete('images/' . $image->image);
        $image->delete();
        return back()->with('success', 'Image deleted successfully');
    }

    // Display an admin page listing all games for management.
    // Paginated and ordered by name.
    public function adminIndex(Request $request)
    {
        $games = M_Games::with('developer', 'latestPrice')
            ->orderBy('name')
            ->paginate(\App\Configuration::$pagination);

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
            ['name' => 'Manage Games']
        ];
        return view('admin.games.V_AdminIndex', compact('games', 'breadcrumbs'));
    }
}

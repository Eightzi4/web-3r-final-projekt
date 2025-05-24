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
use Illuminate\Support\Str; // For slug generation if needed

class C_Game extends Controller
{
    // Apply admin middleware to CUD operations
    public function __construct()
    {
        $this->middleware('admin')->except(['show']); // 'show' is public
    }

    public function show(M_Games $game)
    {
        if (!$game->visible && !(auth()->check() && auth()->user()->is_admin)) {
            abort(404); // Hide non-visible games from non-admins
        }

        $game->load([
            'developer',
            'images',
            'tags',
            'prices.platform',
            'prices.store',
            'reviews.user' // Load reviews and their users
        ]);

        // For related/recommended games (simple example: games by same developer)
        $relatedGames = M_Games::where('developer_id', $game->developer_id)
            ->where('id', '!=', $game->id)
            ->where('visible', true)
            ->with(['images', 'latestPrice'])
            ->inRandomOrder()
            ->take(4)
            ->get();

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Games', 'url' => '#'], // Or discover if no general games list
            ['name' => Str::limit($game->name, 30)]
        ];

        return view('games.V_ShowGame', compact('game', 'relatedGames', 'breadcrumbs'));
    }

    public function create()
    {
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Admin Dashboard', 'url' => route('admin.dashboard')], // Placeholder for admin dashboard
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:games,name', // Ensure name is unique
            'description' => 'nullable|string',
            'trailer_link' => 'nullable|url',
            'visible' => 'required|boolean',
            'tags' => 'nullable|string', // Comma-separated tag names
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
                        'image' => $filename, // Store 'game_images/filename.ext'
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

    public function edit(M_Games $game)
    {
        $game->load('images', 'tags', 'prices'); // Eager load for the form

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
            ['name' => 'Games', 'url' => route('admin.games.index')], // Assuming an admin games list page
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
            'delete_images' => 'nullable|array', // For handling image deletion
            'delete_images.*' => 'integer|exists:game_images,id', // <<< CORRECTED TABLE NAME
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

            // Price update: Delete old and create new.
            // Consider a more sophisticated update if historical prices are needed.
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

            // Handle image deletion
            if ($request->has('delete_images')) {
                // Get image IDs that actually belong to this game to prevent deleting images from other games
                $gameImageIdsToDelete = M_GameImages::where('game_id', $game->id)
                    ->whereIn('id', $request->input('delete_images'))
                    ->pluck('id');

                foreach ($gameImageIdsToDelete as $imageId) {
                    $image = M_GameImages::find($imageId); // Re-fetch to be safe, though not strictly necessary after pluck
                    if ($image) { // Should always be true if plucked correctly
                        Storage::disk('public')->delete('images/' . $image->image); // This is correct
                        $image->delete(); // Delete the row from game_images table
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

    public function destroy(M_Games $game)
    {
        DB::beginTransaction();
        try {
            // Detach from pivot tables first
            $game->tags()->detach();
            $game->gameStates()->detach(); // Assuming this relationship exists and is many-to-many
            $game->owners()->detach();     // Users who own the game
            $game->wishers()->detach();    // Users who wishlisted the game

            // Delete related one-to-many or one-to-one records
            $game->reviews()->delete();
            $game->prices()->delete();

            foreach ($game->images as $image) {
                Storage::disk('public')->delete('images/' . $image->image);
                $image->delete();
            }

            $game->delete();
            DB::commit();
            return redirect()->route('discover') // Or an admin game list page
                ->with('success', 'Game "' . $game->name . '" deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Game deletion failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete game. ' . $e->getMessage());
        }
    }

    // Renamed from destroyImage, specific to game images
    public function destroyGameImage(M_GameImages $image) // Use Route Model Binding
    {
        // Optional: Add authorization check to ensure user can delete this
        Storage::disk('public')->delete('images/' . $image->image);
        $image->delete();
        return back()->with('success', 'Image deleted successfully');
    }

    // Example: An admin page to list all games for management
    public function adminIndex(Request $request)
    {
        $games = M_Games::with('developer', 'latestPrice')
            ->orderBy('name')
            ->paginate(15);

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
            ['name' => 'Manage Games']
        ];
        return view('admin.games.V_AdminIndex', compact('games', 'breadcrumbs'));
    }
}

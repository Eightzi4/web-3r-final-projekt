<?php

namespace App\Http\Controllers;

use App\Models\M_Games;
use App\Models\User; // Important for type hinting if needed
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <<< IMPORT AUTH FACADE

class C_WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add(M_Games $game)
    {
        /** @var \App\Models\User|null $user */ // Type hint for IDE
        $user = Auth::user();

        if ($user && !$user->wishedGames()->where('game_id', $game->id)->exists()) {
            $user->wishedGames()->attach($game->id);
            return back()->with('success', $game->name . ' added to your wishlist.');
        }
        if ($user && $user->wishedGames()->where('game_id', $game->id)->exists()) {
             return back()->with('info', $game->name . ' is already in your wishlist.');
        }
        // Handle case where user is null if necessary, though 'auth' middleware should prevent it
        return back()->with('error', 'Could not add to wishlist. Please log in.');
    }

    public function remove(M_Games $game)
    {
        /** @var \App\Models\User|null $user */ // Type hint for IDE
        $user = Auth::user();
        if ($user && $user->wishedGames()->where('game_id', $game->id)->exists()) {
            $user->wishedGames()->detach($game->id);
            return back()->with('success', $game->name . ' removed from your wishlist.');
        }
        if ($user && !$user->wishedGames()->where('game_id', $game->id)->exists()){
            return back()->with('info', $game->name . ' was not in your wishlist.');
        }
        return back()->with('error', 'Could not remove from wishlist. Please log in.');
    }

    public function index()
    {
        /** @var \App\Models\User $user */ // Type hint for IDE
        $user = Auth::user();
        // The 'auth' middleware ensures $user is not null here
        $wishlistedGames = $user->wishedGames()->with(['images', 'developer', 'latestPrice'])->paginate(10);

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('discover')],
            // ['name' => 'My Account', 'url' => route('profile.edit')], // Link to user profile page if it exists
            ['name' => 'My Wishlist']
        ];

        return view('user.V_Wishlist', compact('wishlistedGames', 'breadcrumbs'));
    }
}

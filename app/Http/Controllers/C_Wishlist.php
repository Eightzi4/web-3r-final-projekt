<?php

namespace App\Http\Controllers;

use App\Models\M_Games;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class C_Wishlist extends Controller
{
    // Constructor to apply auth middleware.
    // Ensures only authenticated users can manage their wishlist.
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Add a game to the authenticated user's wishlist.
    // Prevents adding if already in wishlist.
    public function add(M_Games $game)
    {
        $user = Auth::user();

        if ($user && !$user->wishedGames()->where('game_id', $game->id)->exists()) {
            $user->wishedGames()->attach($game->id);
            return back()->with('success', $game->name . ' added to your wishlist.');
        }
        if ($user && $user->wishedGames()->where('game_id', $game->id)->exists()) {
             return back()->with('info', $game->name . ' is already in your wishlist.');
        }
        return back()->with('error', 'Could not add to wishlist. Please log in.');
    }

    // Remove a game from the authenticated user's wishlist.
    // Checks if the game is in the wishlist before removing.
    public function remove(M_Games $game)
    {
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

    // Display the authenticated user's wishlist.
    // Paginates wishlisted games and prepares breadcrumbs.
    public function index()
    {
        $user = Auth::user();
        $wishlistedGames = $user->wishedGames()->with(['images', 'developer', 'latestPrice'])->paginate(\App\Configuration::$pagination);

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'My Wishlist']
        ];

        return view('user.V_Wishlist', compact('wishlistedGames', 'breadcrumbs'));
    }
}

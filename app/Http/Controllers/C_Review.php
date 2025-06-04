<?php

namespace App\Http\Controllers;

use App\Models\M_Games;
use App\Models\M_Reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class C_Review extends Controller
{
    // Constructor to apply middleware.
    // Ensures only authenticated users can interact with reviews.
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Store a new review for a specific game.
    // Validates input and prevents duplicate reviews by the same user.
    public function store(Request $request, M_Games $game)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:100',
            'comment' => 'required|string|max:10000',
        ]);

        $existingReview = M_Reviews::where('user_id', Auth::id())
                                  ->where('game_id', $game->id)
                                  ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this game.');
        }

        M_Reviews::create([
            'user_id' => Auth::id(),
            'game_id' => $game->id,
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Review submitted successfully!');
    }

    // Update an existing review.
    // Authorizes the user and validates input before updating.
    public function update(Request $request, M_Reviews $review)
    {
        if ($review->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:100',
            'comment' => 'required|string|max:5000',
        ]);

        $review->update($request->only(['rating', 'title', 'comment']));
        return back()->with('success', 'Review updated successfully!');
    }

    // Delete an existing review.
    // Authorizes the user before deletion.
    public function destroy(M_Reviews $review)
    {
        if ($review->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $review->delete();
        return back()->with('success', 'Review deleted successfully.');
    }
}

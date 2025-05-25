<?php

namespace App\Http\Controllers;

use App\Models\M_Games;
use App\Models\M_Reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class C_ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Only authenticated users can post reviews
    }

    public function store(Request $request, M_Games $game)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:100',
            'comment' => 'required|string|max:10000',
        ]);

        // Check if user already reviewed this game (optional: allow editing instead)
        $existingReview = M_Reviews::where('user_id', Auth::id())
                                  ->where('game_id', $game->id)
                                  ->first();

        if ($existingReview) {
            // Optionally, update the existing review
            // $existingReview->update($request->all());
            // return back()->with('warning', 'You have already reviewed this game. Your review has been updated.');
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

    public function update(Request $request, M_Reviews $review)
    {
        // Authorization: Ensure the user owns the review
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

    public function destroy(M_Reviews $review)
    {
        // Authorization
        if ($review->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $review->delete();
        return back()->with('success', 'Review deleted successfully.');
    }
}

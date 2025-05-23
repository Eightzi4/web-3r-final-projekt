<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\C_Discover;
use App\Http\Controllers\C_Search;
use App\Http\Controllers\C_Game;
use App\Http\Controllers\C_ReviewController;
use App\Http\Controllers\C_WishlistController;

// Default Laravel Auth routes (if using Breeze)
// require __DIR__.'/auth.php'; // This line is usually added by Breeze

// Public Routes
Route::get('/', [C_Discover::class, 'index'])->name('discover'); // Homepage
Route::get('/search', [C_Search::class, 'index'])->name('search');
Route::get('/games/{game}', [C_Game::class, 'show'])->name('games.show')->where('game', '[0-9]+'); // Ensure 'game' is numeric if using ID

// Authenticated User Routes
Route::middleware(['auth'])->group(function () {
    // Reviews
    Route::post('/games/{game}/reviews', [C_ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [C_ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [C_ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Wishlist
    Route::get('/my-wishlist', [C_WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{game}/add', [C_WishlistController::class, 'add'])->name('wishlist.add');
    Route::post('/wishlist/{game}/remove', [C_WishlistController::class, 'remove'])->name('wishlist.remove');

    // Example: User profile page
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $breadcrumbs = [['name' => 'Admin Dashboard']];
        return view('admin.V_Dashboard', compact('breadcrumbs')); // Create this view
    })->name('dashboard');

    Route::get('/games', [C_Game::class, 'adminIndex'])->name('games.index'); // Admin list of games
    Route::get('/games/create', [C_Game::class, 'create'])->name('games.create');
    Route::post('/games', [C_Game::class, 'store'])->name('games.store');
    Route::get('/games/{game}/edit', [C_Game::class, 'edit'])->name('games.edit')->where('game', '[0-9]+');
    Route::put('/games/{game}', [C_Game::class, 'update'])->name('games.update')->where('game', '[0-9]+');
    Route::delete('/games/{game}', [C_Game::class, 'destroy'])->name('games.destroy')->where('game', '[0-9]+');
    Route::delete('/game-images/{image}', [C_Game::class, 'destroyGameImage'])->name('game-images.destroy')->where('image', '[0-9]+');

    // Add routes for managing Tags, Developers, Platforms, Stores, Users etc. here
    // Example for Tags:
    // Route::resource('tags', C_Admin_TagController::class);
});

// If not using Laravel Breeze for auth, you might need to define these manually:
// Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
// Route::post('login', [AuthenticatedSessionController::class, 'store']);
// Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
// Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
// Route::post('register', [RegisteredUserController::class, 'store']);

// Fallback route for 404s (optional, Laravel handles this by default)
// Route::fallback(function() {
//     return view('errors.404'); // Create a custom 404 page
// });

require __DIR__.'/auth.php';

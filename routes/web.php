<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\C_Discover;
use App\Http\Controllers\C_Search;
use App\Http\Controllers\C_Game;
use App\Http\Controllers\C_Review;
use App\Http\Controllers\C_Wishlist;
use App\Http\Controllers\C_Tag;
use App\Http\Controllers\C_Developer;
use App\Http\Controllers\Admin\C_SiteInfo;
use App\Http\Controllers\Admin\C_User;
use App\Models\M_Developers;
use App\Models\M_Games;
use App\Models\M_Platforms;
use App\Models\M_Reviews;
use App\Models\M_Stores;
use App\Models\M_Tags;
use App\Models\User;

// Publicly accessible routes for all users.
Route::get('/', function () {
    $breadcrumbs = [['name' => 'Home']];
    return view('V_Home', compact('breadcrumbs'));
})->name('home');
Route::get('/discover', [C_Discover::class, 'index'])->name('discover');
Route::get('/search', [C_Search::class, 'index'])->name('search');
Route::get('/games/{game}', [C_Game::class, 'show'])->name('games.show')->where('game', '[0-9]+');
Route::get('/site-info', [C_SiteInfo::class, 'index'])->name('siteinfo');
Route::resource('/users', C_User::class)->except(['show', 'create', 'store']);
Route::get('/developers/{developer}', [C_Developer::class, 'show'])->name('developers.show');
Route::get('/tags/{tag}', [C_Tag::class, 'show'])->name('tags.show');
Route::get('/banned', function () {
    return view('auth.banned');
})->name('banned');

// Routes requiring user authentication.
Route::middleware(['auth'])->group(function () {
    // Routes for managing game reviews.
    Route::post('/games/{game}/reviews', [C_Review::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [C_Review::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [C_Review::class, 'destroy'])->name('reviews.destroy');

    // Routes for managing user wishlists.
    Route::get('/my-wishlist', [C_Wishlist::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{game}/add', [C_Wishlist::class, 'add'])->name('wishlist.add');
    Route::post('/wishlist/{game}/remove', [C_Wishlist::class, 'remove'])->name('wishlist.remove');
});

// Routes restricted to administrators.
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin dashboard route with site statistics.
    Route::get('/dashboard', function () {
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Admin Dashboard']
        ];

        $stats = [
            'totalGames' => M_Games::count(),
            'visibleGames' => M_Games::where('visible', true)->count(),
            'hiddenGames' => M_Games::where('visible', false)->count(),
            'totalUsers' => User::count(),
            'adminUsers' => User::where('is_admin', true)->count(),
            'regularUsers' => User::where('is_admin', false)->count(),
            'totalDevelopers' => M_Developers::count(),
            'totalReviews' => M_Reviews::count(),
            'totalTags' => M_Tags::count(),
            'totalPlatforms' => M_Platforms::count(),
            'totalStores' => M_Stores::count(),
        ];

        return view('admin.V_Dashboard', compact('breadcrumbs', 'stats'));
    })->name('dashboard');

    // Admin routes for managing games.
    Route::get('/games', [C_Game::class, 'adminIndex'])->name('games.index');
    Route::get('/games/create', [C_Game::class, 'create'])->name('games.create');
    Route::post('/games', [C_Game::class, 'store'])->name('games.store');
    Route::get('/games/{game}/edit', [C_Game::class, 'edit'])->name('games.edit')->where('game', '[0-9]+');
    Route::put('/games/{game}', [C_Game::class, 'update'])->name('games.update')->where('game', '[0-9]+');
    Route::delete('/games/{game}', [C_Game::class, 'destroy'])->name('games.destroy')->where('game', '[0-9]+');
    Route::delete('/game-images/{image}', [C_Game::class, 'destroyGameImage'])->name('game-images.destroy')->where('image', '[0-9]+');

    // Admin route for site information.
    Route::get('/site-info', [C_SiteInfo::class, 'index'])->name('siteinfo');
    // Admin routes for user management.
    Route::resource('/users', C_User::class)->except(['show', 'create', 'store']);
});

// Include Laravel's default authentication routes.
require __DIR__ . '/auth.php';

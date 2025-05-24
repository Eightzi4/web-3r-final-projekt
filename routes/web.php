<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\C_Discover;
use App\Http\Controllers\C_Search;
use App\Http\Controllers\C_Game;
use App\Http\Controllers\C_ReviewController;
use App\Http\Controllers\C_WishlistController;
use App\Http\Controllers\Admin\C_Admin_SiteInfoController; // You'll create this
use App\Http\Controllers\Admin\C_Admin_UserController;   // You'll create this
use App\Models\M_Developers;
use App\Models\M_Games;
use App\Models\M_Platforms;
use App\Models\M_Reviews;
use App\Models\M_Stores;
use App\Models\M_Tags;
use App\Models\User;

// Default Laravel Auth routes (if using Breeze)
// require __DIR__.'/auth.php'; // This line is usually added by Breeze

// Public Routes
Route::get('/', function () {
    $breadcrumbs = [['name' => 'Home']];
    return view('V_Home', compact('breadcrumbs')); // New home view
})->name('home');
Route::get('/discover', [C_Discover::class, 'index'])->name('discover');
Route::get('/search', [C_Search::class, 'index'])->name('search');
Route::get('/games/{game}', [C_Game::class, 'show'])->name('games.show')->where('game', '[0-9]+'); // Ensure 'game' is numeric if using ID
Route::get('/site-info', [C_Admin_SiteInfoController::class, 'index'])->name('siteinfo');
Route::resource('/users', C_Admin_UserController::class)->except(['show', 'create', 'store']); // Common for user management

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
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Admin Dashboard']
        ];

        // Fetching stats
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
            // You can add more specific stats, e.g., average game price, games per developer, etc.
        ];

        return view('admin.V_Dashboard', compact('breadcrumbs', 'stats')); // Pass 'stats'
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
    Route::get('/site-info', [C_Admin_SiteInfoController::class, 'index'])->name('siteinfo'); // Full name: admin.siteinfo
    // Your user management routes:
    Route::resource('/users', C_Admin_UserController::class)->except(['show', 'create', 'store']);
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

require __DIR__ . '/auth.php';

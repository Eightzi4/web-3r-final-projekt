<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// Import all necessary models
use App\Models\M_Games;
use App\Models\User; // Your User model
use App\Models\M_Developers;
use App\Models\M_Reviews;
use App\Models\M_Tags;
use App\Models\M_Platforms;
use App\Models\M_Stores;
use App\Models\M_GameImages;
use App\Models\M_DeveloperImages;
use Illuminate\Support\Facades\DB; // For pivot table counts

class C_Admin_SiteInfoController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
            ['name' => 'Site Information']
        ];

        $stats = [
            // Games
            'totalGames' => M_Games::count(),
            'visibleGames' => M_Games::where('visible', true)->count(),
            'hiddenGames' => M_Games::where('visible', false)->count(),

            // Users
            'totalUsers' => User::count(),
            'adminUsers' => User::where('is_admin', true)->count(),
            'regularUsers' => User::where('is_admin', false)->count(),
            'bannedUsers' => User::where('is_banned', true)->count(), // If you implement is_banned

            // Other Entities
            'totalDevelopers' => M_Developers::count(),
            'totalReviews' => M_Reviews::count(),
            'totalTags' => M_Tags::count(),
            'totalPlatforms' => M_Platforms::count(),
            'totalStores' => M_Stores::count(),
            'totalGameImages' => M_GameImages::count(), // Images linked to games
            'totalDeveloperImages' => M_DeveloperImages::count(), // Images linked to developers

            // Pivot Table Counts (Relationships)
            'totalGameTagRelations' => DB::table('games_tags')->count(),
            'totalGamePriceEntries' => \App\Models\M_Prices::count(), // Assuming M_Prices is the prices table model
            'totalWishlistedItems' => DB::table('wished_games')->count(),
            'totalOwnedGameEntries' => DB::table('owned_games')->count(),
            'totalGameStatesRelations' => DB::table('games_states')->count(), // If your pivot is 'games_states'

            // You can add more complex stats:
            // 'averageGamePrice' => \App\Models\M_Prices::avg('price'),
            // 'averageRating' => M_Reviews::avg('rating'),
        ];

        // Add ?? 0 to ensure view doesn't break if a stat is unexpectedly null (though count() returns 0)
        foreach ($stats as $key => $value) {
            $stats[$key] = $value ?? 0;
        }

        return view('admin.siteinfo.V_Index', compact('breadcrumbs', 'stats'));
    }
}

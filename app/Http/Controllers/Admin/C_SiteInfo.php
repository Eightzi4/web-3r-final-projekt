<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\M_Games;
use App\Models\User;
use App\Models\M_Developers;
use App\Models\M_Reviews;
use App\Models\M_Tags;
use App\Models\M_Platforms;
use App\Models\M_Stores;
use App\Models\M_GameImages;
use App\Models\M_DeveloperImages;
use Illuminate\Support\Facades\DB;

class C_SiteInfo extends Controller
{

    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
            ['name' => 'Site Information']
        ];

        $stats = [
            'totalGames' => M_Games::count(),
            'visibleGames' => M_Games::where('visible', true)->count(),
            'hiddenGames' => M_Games::where('visible', false)->count(),

            'totalUsers' => User::count(),
            'adminUsers' => User::where('is_admin', true)->count(),
            'regularUsers' => User::where('is_admin', false)->count(),
            'bannedUsers' => User::where('is_banned', true)->count(),

            'totalDevelopers' => M_Developers::count(),
            'totalReviews' => M_Reviews::count(),
            'totalTags' => M_Tags::count(),
            'totalPlatforms' => M_Platforms::count(),
            'totalStores' => M_Stores::count(),
            'totalGameImages' => M_GameImages::count(),
            'totalDeveloperImages' => M_DeveloperImages::count(),

            'totalGameTagRelations' => DB::table('games_tags')->count(),
            'totalGamePriceEntries' => \App\Models\M_Prices::count(),
            'totalWishlistedItems' => DB::table('wished_games')->count(),
            'totalOwnedGameEntries' => DB::table('owned_games')->count(),
            'totalGameStatesRelations' => DB::table('games_states')->count(),
        ];

        foreach ($stats as $key => $value) {
            $stats[$key] = $value ?? 0;
        }

        return view('admin.siteinfo.V_Index', compact('breadcrumbs', 'stats'));
    }
}

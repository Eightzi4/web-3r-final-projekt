<?php

namespace Database\Seeders;

use App\Models\M_Countries;
use App\Models\M_Developers;
use App\Models\M_DeveloperImages;
use App\Models\M_GameImages;
use App\Models\M_Games;
use App\Models\M_GameStates;
use App\Models\M_Platforms;
use App\Models\M_Prices;
use App\Models\M_Reviews;
use App\Models\M_Stores;
use App\Models\M_Tags;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // For disabling foreign key checks
use Illuminate\Support\Facades\Schema; // For disabling foreign key checks


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // For MySQL, to temporarily disable foreign key checks for faster seeding
        // and to avoid order issues if not seeding perfectly.
        // For other databases, you might need different commands or skip this.
        if (DB::getDriverName() === 'mysql') {
            Schema::disableForeignKeyConstraints();
        }

        // Truncate tables (optional, good for re-seeding)
        // Be careful with this in production!
        // Order matters for truncation if foreign keys are active.
        // With checks disabled, order is less critical but still good practice.
        M_Reviews::truncate();
        M_Prices::truncate();
        M_GameImages::truncate();
        M_DeveloperImages::truncate();
        DB::table('games_tags')->truncate(); // Pivot
        DB::table('games_states')->truncate(); // Pivot
        DB::table('owned_games')->truncate(); // Pivot
        DB::table('wished_games')->truncate(); // Pivot
        M_Games::truncate();
        M_Developers::truncate();
        M_Tags::truncate();
        M_Platforms::truncate();
        M_Stores::truncate();
        M_GameStates::truncate();
        M_Countries::truncate();
        User::truncate();


        // --- Seed Users ---
        User::factory()->admin()->create(); // Create one admin
        User::factory(100)->create(); // Create 100 regular users
        $users = User::where('is_admin', false)->get(); // Get non-admin users for reviews/wishlists etc.

        // --- Seed Basic Lookup Tables ---
        M_Countries::factory(30)->create(); // ~30 countries
        $countries = M_Countries::all();

        M_Tags::factory(50)->create(); // ~50 tags
        $tags = M_Tags::all();

        M_Platforms::factory(10)->create(); // ~10 platforms
        $platforms = M_Platforms::all();

        M_Stores::factory(8)->create(); // ~8 stores
        $stores = M_Stores::all();

        // Specific Game States (if not using factory or want fixed ones)
        $gameStatesData = ['Released', 'Early Access', 'Beta', 'Alpha', 'Coming Soon'];
        foreach ($gameStatesData as $stateName) {
            M_GameStates::firstOrCreate(['name' => $stateName]);
        }
        $gameStates = M_GameStates::all();

        // --- Seed Developers ---
        M_Developers::factory(50)->recycle($countries)->create()->each(function ($developer) {
            // Assign 1 to 3 random placeholder images to each developer
            for ($i = 0; $i < rand(1, 3); $i++) {
                M_DeveloperImages::factory()->create([
                    'developer_id' => $developer->id,
                    // The 'image' field will be filled by the MDeveloperImagesFactory's definition
                ]);
            }
        });
        $developers = M_Developers::all();


        // --- Seed Games ---
        // Aim for ~500 games. Each game will get images, tags, states, prices, reviews.
        M_Games::factory(500)->recycle($developers)->create()->each(function ($game) use ($tags, $gameStates, $platforms, $stores, $users) {
            // Add 1-5 Game Images
            for ($i = 0; $i < rand(1, 5); $i++) {
                M_GameImages::factory()->create([
                    'game_id' => $game->id,
                    // The 'image' field will be filled by the MGameImagesFactory's definition
                ]);
            }

            // Attach 2-7 random tags
            $game->tags()->attach($tags->random(rand(2, min(7, $tags->count()))));

            // Attach 1-2 random game states
            $game->gameStates()->attach($gameStates->random(rand(1, min(2, $gameStates->count()))));

            // Create 1-3 price entries for the game on different platforms/stores
            for ($i = 0; $i < rand(1, 3); $i++) {
                if ($platforms->isNotEmpty() && $stores->isNotEmpty()) {
                    M_Prices::factory()->create([
                        'game_id' => $game->id,
                        'platform_id' => $platforms->random()->id,
                        'store_id' => $stores->random()->id,
                    ]);
                }
            }

            // Add 0-10 reviews per game
            if ($users->isNotEmpty()) {
                $numberOfReviews = rand(0, 10);
                for ($i = 0; $i < $numberOfReviews; $i++) {
                    M_Reviews::factory()->create([
                        'game_id' => $game->id,
                        'user_id' => $users->random()->id,
                    ]);
                }

                // Add to some users' wishlists (e.g., 5-20% of users)
                foreach ($users->random(floor($users->count() * fake()->randomFloat(2, 0.05, 0.20))) as $user) {
                    $user->wishedGames()->attach($game->id);
                }

                // Add to some users' owned games (e.g., 10-30% of users)
                // Ensure a user doesn't own a game they also wishlisted for simplicity here,
                // or handle that logic if needed.
                foreach ($users->random(floor($users->count() * fake()->randomFloat(2, 0.10, 0.30))) as $user) {
                     if (!$user->wishedGames()->where('game_id', $game->id)->exists()) {
                        $user->ownedGames()->attach($game->id);
                     }
                }
            }
        });

        // Re-enable foreign key checks
        if (DB::getDriverName() === 'mysql') {
            Schema::enableForeignKeyConstraints();
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin user created: admin@example.com / password');

        // Calculate total rows (approximate)
        $totalRows = User::count() + M_Countries::count() + M_Tags::count() + M_Platforms::count() +
                     M_Stores::count() + M_GameStates::count() + M_Developers::count() +
                     M_DeveloperImages::count() + M_Games::count() + M_GameImages::count() +
                     M_Prices::count() + M_Reviews::count() +
                     DB::table('games_tags')->count() + DB::table('games_states')->count() +
                     DB::table('owned_games')->count() + DB::table('wished_games')->count();

        $this->command->info("Approximately {$totalRows} rows created in total.");
    }
}

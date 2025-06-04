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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    // Seed the application's database.
    // Truncates tables and populates them with factory-generated data.
    public function run(): void
    {
        if (DB::getDriverName() === 'mysql') {
            Schema::disableForeignKeyConstraints();
        }

        M_Reviews::truncate();
        M_Prices::truncate();
        M_GameImages::truncate();
        M_DeveloperImages::truncate();
        DB::table('games_tags')->truncate();
        DB::table('games_states')->truncate();
        DB::table('owned_games')->truncate();
        DB::table('wished_games')->truncate();
        M_Games::truncate();
        M_Developers::truncate();
        M_Tags::truncate();
        M_Platforms::truncate();
        M_Stores::truncate();
        M_GameStates::truncate();
        M_Countries::truncate();
        User::truncate();

        User::factory()->admin()->create();
        User::factory(90)->create();
        User::factory(10)->state(['is_banned' => true])->create();
        $users = User::where('is_admin', false)->get();

        M_Countries::factory(30)->create();
        $countries = M_Countries::all();

        M_Tags::factory(50)->create();
        $tags = M_Tags::all();

        M_Platforms::factory(10)->create();
        $platforms = M_Platforms::all();

        M_Stores::factory(8)->create();
        $stores = M_Stores::all();

        $gameStatesData = ['Released', 'Early Access', 'Beta', 'Alpha', 'Coming Soon'];
        foreach ($gameStatesData as $stateName) {
            M_GameStates::firstOrCreate(['name' => $stateName]);
        }
        $gameStates = M_GameStates::all();

        M_Developers::factory(50)->recycle($countries)->create()->each(function ($developer) {
            for ($i = 0; $i < rand(1, 3); $i++) {
                M_DeveloperImages::factory()->create([
                    'developer_id' => $developer->id,
                ]);
            }
        });
        $developers = M_Developers::all();

        M_Games::factory(500)->recycle($developers)->create()->each(function ($game) use ($tags, $gameStates, $platforms, $stores, $users) {
            for ($i = 0; $i < rand(1, 5); $i++) {
                M_GameImages::factory()->create([
                    'game_id' => $game->id,
                ]);
            }

            $game->tags()->attach($tags->random(rand(2, min(7, $tags->count()))));

            $game->gameStates()->attach($gameStates->random(rand(1, min(2, $gameStates->count()))));

            for ($i = 0; $i < rand(1, 3); $i++) {
                if ($platforms->isNotEmpty() && $stores->isNotEmpty()) {
                    M_Prices::factory()->create([
                        'game_id' => $game->id,
                        'platform_id' => $platforms->random()->id,
                        'store_id' => $stores->random()->id,
                    ]);
                }
            }

            if ($users->isNotEmpty()) {
                $numberOfReviews = rand(0, 10);
                for ($i = 0; $i < $numberOfReviews; $i++) {
                    M_Reviews::factory()->create([
                        'game_id' => $game->id,
                        'user_id' => $users->random()->id,
                    ]);
                }

                foreach ($users->random(floor($users->count() * fake()->randomFloat(2, 0.05, 0.20))) as $user) {
                    $user->wishedGames()->attach($game->id);
                }

                foreach ($users->random(floor($users->count() * fake()->randomFloat(2, 0.10, 0.30))) as $user) {
                    if (!$user->wishedGames()->where('game_id', $game->id)->exists()) {
                        $user->ownedGames()->attach($game->id);
                    }
                }
            }
        });

        if (DB::getDriverName() === 'mysql') {
            Schema::enableForeignKeyConstraints();
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin user created: admin@example.com / password');

        $totalRows = User::count() + M_Countries::count() + M_Tags::count() + M_Platforms::count() +
            M_Stores::count() + M_GameStates::count() + M_Developers::count() +
            M_DeveloperImages::count() + M_Games::count() + M_GameImages::count() +
            M_Prices::count() + M_Reviews::count() +
            DB::table('games_tags')->count() + DB::table('games_states')->count() +
            DB::table('owned_games')->count() + DB::table('wished_games')->count();

        $this->command->info("Approximately {$totalRows} rows created in total.");
    }
}

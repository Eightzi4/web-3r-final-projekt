<?php

namespace Database\Factories;

use App\Models\M_Games;
use App\Models\M_Developers;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str; // Ensure Str is imported

class GameFactory extends Factory
{
    protected $model = M_Games::class;

    public function definition(): array
    {
        $name = Str::title(fake()->words(rand(2, 5), true));

        // Generate a random 11-character string using URL-safe characters
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_';
        $randomVideoId = '';
        for ($i = 0; $i < 11; $i++) {
            $randomVideoId .= $characters[rand(0, strlen($characters) - 1)];
        }


        return [
            'name' => $name,
            'description' => fake()->paragraphs(rand(2, 5), true),
            'trailer_link' => fake()->optional(0.7)->passthrough( // 70% chance to have a trailer link
                "https://www.youtube.com/watch?v=" . $randomVideoId
            ),
            'visible' => fake()->boolean(80),
            'developer_id' => M_Developers::inRandomOrder()->first()->id ?? DeveloperFactory::new(),
        ];
    }
}

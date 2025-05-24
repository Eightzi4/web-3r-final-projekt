<?php

namespace Database\Factories;

use App\Models\M_GameImages;
use App\Models\M_Games; // Keep if game_id is set here
use Illuminate\Database\Eloquent\Factories\Factory;

class GameImagesFactory extends Factory // Or GameImageFactory
{
    protected $model = M_GameImages::class;

    public function definition(): array
    {
        return [
            'image' => rand(1, 50) . '.avif', // Random number between 1 and 50
            // 'game_id' will be set when calling the factory
            'game_id' => M_Games::factory(), // Default if not provided
        ];
    }
}

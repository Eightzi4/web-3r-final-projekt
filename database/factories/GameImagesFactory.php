<?php

namespace Database\Factories;

use App\Models\M_GameImages;
use App\Models\M_Games;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameImagesFactory extends Factory
{
    // The name of the factory's corresponding model.
    protected $model = M_GameImages::class;

    // Define the model's default state.
    // Returns an array of default attribute values for a game image.
    public function definition(): array
    {
        return [
            'image' => rand(1, 50) . '.avif',
            'game_id' => M_Games::factory(),
        ];
    }
}

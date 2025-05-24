<?php

namespace Database\Factories;

use App\Models\M_GameImages;
use App\Models\M_Games;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\M_GameImages>
 */
class GameImagesFactory extends Factory // Ensure class name matches file name
{
    protected $model = M_GameImages::class;

    public function definition(): array
    {
        $width = 1280;
        $height = 720;
        return [
            'image' => "https://via.placeholder.com/{$width}x{$height}.png/002299?text=GameImage+" . fake()->word,
            // 'game_id' is usually set when calling the factory
            'game_id' => M_Games::factory(), // Or provide when calling
        ];
    }
}

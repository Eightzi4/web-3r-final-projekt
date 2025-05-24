<?php

namespace Database\Factories;

use App\Models\M_Games;
use App\Models\M_Developers;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GameFactory extends Factory
{
    protected $model = M_Games::class;

    public function definition(): array
    {
        $name = Str::title(fake()->words(rand(2, 5), true));
        return [
            'name' => $name,
            'description' => fake()->paragraphs(rand(2, 5), true),
            'trailer_link' => fake()->optional(0.7)->randomElement([
                'https://www.youtube.com/watch?v=dQw4w9WgXcQ', // Rickroll for fun
                'https://www.youtube.com/watch?v=jNQXAC9IVRw', // Example
                'https://www.youtube.com/watch?v=DLzxrzFCyOs'  // Example
            ]),
            'visible' => fake()->boolean(80), // 80% chance of being visible
            'developer_id' => M_Developers::inRandomOrder()->first()->id ?? DeveloperFactory::new(),
            // created_at and updated_at will be handled by timestamps() in migration
        ];
    }
}

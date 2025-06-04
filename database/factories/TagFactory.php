<?php

namespace Database\Factories;

use App\Models\M_Tags;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    // The name of the factory's corresponding model.
    protected $model = M_Tags::class;

    // Define the model's default state.
    // Returns an array of default attribute values for a tag.
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'description' => fake()->optional()->sentence(),
            'color' => fake()->hexColor(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\M_Tags;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    protected $model = M_Tags::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'description' => fake()->optional()->sentence(),
            'color' => fake()->hexColor(),
        ];
    }
}

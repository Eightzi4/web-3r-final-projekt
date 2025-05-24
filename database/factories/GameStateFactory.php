<?php

namespace Database\Factories;

use App\Models\M_GameStates;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameStateFactory extends Factory
{
    protected $model = M_GameStates::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(['Released', 'Early Access', 'Beta', 'Alpha', 'In Development', 'Announced']),
        ];
    }
}

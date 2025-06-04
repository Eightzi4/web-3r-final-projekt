<?php

namespace Database\Factories;

use App\Models\M_GameStates;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameStateFactory extends Factory
{
    // The name of the factory's corresponding model.
    protected $model = M_GameStates::class;

    // Define the model's default state.
    // Returns an array of default attribute values for a game state.
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(['Released', 'Early Access', 'Beta', 'Alpha', 'In Development', 'Announced']),
        ];
    }
}

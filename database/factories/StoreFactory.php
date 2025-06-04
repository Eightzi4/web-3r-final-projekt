<?php

namespace Database\Factories;

use App\Models\M_Stores;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    // The name of the factory's corresponding model.
    protected $model = M_Stores::class;

    // Define the model's default state.
    // Returns an array of default attribute values for a store.
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(['Steam', 'Epic Games Store', 'GOG.com', 'PlayStation Store', 'Microsoft Store', 'Nintendo eShop', 'Itch.io', 'Humble Store']),
            'website_link' => fake()->url(),
        ];
    }
}

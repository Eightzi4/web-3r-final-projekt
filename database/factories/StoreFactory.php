<?php

namespace Database\Factories;

use App\Models\M_Stores;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    protected $model = M_Stores::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(['Steam', 'Epic Games Store', 'GOG.com', 'PlayStation Store', 'Microsoft Store', 'Nintendo eShop', 'Itch.io', 'Humble Store']),
            'website_link' => fake()->url(),
        ];
    }
}

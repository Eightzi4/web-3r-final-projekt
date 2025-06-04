<?php

namespace Database\Factories;

use App\Models\M_Countries;
use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory
{
    // The name of the factory's corresponding model.
    protected $model = M_Countries::class;

    // Define the model's default state.
    // Returns an array of default attribute values for a country.
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->country(),
        ];
    }
}

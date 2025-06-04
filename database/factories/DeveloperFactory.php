<?php

namespace Database\Factories;

use App\Models\M_Developers;
use App\Models\M_Countries;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeveloperFactory extends Factory
{
    // The name of the factory's corresponding model.
    protected $model = M_Developers::class;

    // Define the model's default state.
    // Returns an array of default attribute values for a developer.
    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' ' . fake()->randomElement(['Studios', 'Interactive', 'Games', 'Entertainment']),
            'founded_date' => fake()->dateTimeThisCentury(),
            'description' => fake()->paragraph(3),
            'country_id' => M_Countries::inRandomOrder()->first()->id ?? CountryFactory::new(),
            'website_link' => fake()->optional()->url(),
        ];
    }
}

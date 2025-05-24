<?php

namespace Database\Factories;

use App\Models\M_Developers;
use App\Models\M_Countries;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeveloperFactory extends Factory
{
    protected $model = M_Developers::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' ' . fake()->randomElement(['Studios', 'Interactive', 'Games', 'Entertainment']),
            'founded_date' => fake()->dateTimeThisCentury(),
            'description' => fake()->paragraph(3),
            'country_id' => M_Countries::inRandomOrder()->first()->id ?? CountryFactory::new(), // Get random or create
            'website_link' => fake()->optional()->url(),
        ];
    }
}

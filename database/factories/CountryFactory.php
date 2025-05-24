<?php

namespace Database\Factories;

use App\Models\M_Countries;
use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory
{
    protected $model = M_Countries::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->country(),
        ];
    }
}

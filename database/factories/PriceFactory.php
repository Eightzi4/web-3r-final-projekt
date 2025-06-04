<?php

namespace Database\Factories;

use App\Models\M_Games;
use App\Models\M_Platforms;
use App\Models\M_Stores;
use App\Models\M_Prices;
use Illuminate\Database\Eloquent\Factories\Factory;

class PriceFactory extends Factory
{
    // The name of the factory's corresponding model.
    protected $model = M_Prices::class;

    // Define the model's default state.
    // Returns an array of default attribute values for a price entry.
    public function definition(): array
    {
        return [
            'price' => fake()->randomFloat(2, 5, 70),
            'date' => fake()->dateTimeBetween('-1 year', 'now'),
            'discount' => fake()->optional(0.3, 0)->numberBetween(5, 75),
            'game_id' => M_Games::inRandomOrder()->first()->id ?? GameFactory::new(),
            'platform_id' => M_Platforms::inRandomOrder()->first()->id ?? PlatformFactory::new(),
            'store_id' => M_Stores::inRandomOrder()->first()->id ?? StoreFactory::new(),
        ];
    }
}

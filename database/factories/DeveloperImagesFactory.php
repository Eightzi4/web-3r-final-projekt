<?php

namespace Database\Factories;

use App\Models\M_DeveloperImages;
use App\Models\M_Developers;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeveloperImagesFactory extends Factory
{
    // The name of the factory's corresponding model.
    protected $model = M_DeveloperImages::class;

    // Define the model's default state.
    // Returns an array of default attribute values for a developer image.
    public function definition(): array
    {
        return [
            'image' => rand(1, 50) . '.avif',
            'developer_id' => M_Developers::factory(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\M_DeveloperImages;
use App\Models\M_Developers; // Keep if developer_id is set here
use Illuminate\Database\Eloquent\Factories\Factory;

class DeveloperImagesFactory extends Factory // Or DeveloperImageFactory
{
    protected $model = M_DeveloperImages::class;

    public function definition(): array
    {
        return [
            'image' => rand(1, 50) . '.avif', // Random number between 1 and 50
            // 'developer_id' will be set when calling the factory
            'developer_id' => M_Developers::factory(), // Default if not provided
        ];
    }
}

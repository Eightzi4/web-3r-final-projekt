<?php

namespace Database\Factories;

use App\Models\M_Platforms;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlatformFactory extends Factory
{
    // The name of the factory's corresponding model.
    protected $model = M_Platforms::class;

    // Define the model's default state.
    // Returns an array of default attribute values for a platform.
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(['PC (Windows)', 'PlayStation 5', 'Xbox Series X/S', 'Nintendo Switch', 'macOS', 'Linux', 'PlayStation 4', 'Xbox One', 'Android', 'iOS', 'Google Stadia', 'Oculus Quest 2'])];
    }
}

<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    // The name of the factory's corresponding model.
    protected $model = User::class;

    // Define the model's default state.
    // Returns an array of default attribute values for a user.
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'is_admin' => false,
        ];
    }

    // Indicate that the user should be an administrator.
    // Sets the 'is_admin' flag to true and uses a specific admin email.
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_admin' => true,
            'email' => 'admin@example.com',
        ]);
    }

    // Indicate that the user's email address should be unverified.
    // Sets 'email_verified_at' to null.
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}

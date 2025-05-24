<?php

namespace Database\Factories;

use App\Models\M_Games;
use App\Models\M_Reviews;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ReviewFactory extends Factory
{
    protected $model = M_Reviews::class;

    public function definition(): array
    {
        return [
            'title' => Str::title(fake()->words(rand(3, 7), true)),
            'comment' => fake()->paragraphs(rand(1, 4), true),
            'rating' => fake()->numberBetween(1, 5),
            'game_id' => M_Games::inRandomOrder()->first()->id ?? GameFactory::new(),
            'user_id' => User::where('is_admin', false)->inRandomOrder()->first()->id ?? UserFactory::new(), // Non-admin user
        ];
    }
}

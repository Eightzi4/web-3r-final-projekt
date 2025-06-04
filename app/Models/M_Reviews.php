<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\ReviewFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class M_Reviews extends Model
{
    use HasFactory, SoftDeletes;

    // The table associated with the model.
    protected $table = 'reviews';
    // The attributes that are mass assignable.
    protected $fillable = [
        'user_id', 'game_id', 'rating', 'comment', 'title'
    ];

    // Define the relationship to the user who wrote the review.
    // A review belongs to one user.
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Define the relationship to the game being reviewed.
    // A review belongs to one game.
    public function game()
    {
        return $this->belongsTo(M_Games::class, 'game_id');
    }

    // Create a new factory instance for the model.
    // Used for seeding and testing.
    protected static function newFactory()
    {
        return ReviewFactory::new();
    }
}

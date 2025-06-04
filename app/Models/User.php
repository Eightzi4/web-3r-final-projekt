<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    // The table associated with the model.
    protected $table = 'users';

    // The attributes that are mass assignable.
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_banned',
    ];

    // The attributes that should be hidden for serialization.
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // The attributes that should be cast to native types.
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
        'is_banned' => 'boolean',
    ];

    // Define the many-to-many relationship for games owned by the user.
    // A user can own many games.
    public function ownedGames()
    {
        return $this->belongsToMany(M_Games::class, 'owned_games', 'user_id', 'game_id');
    }

    // Define the one-to-many relationship for reviews written by the user.
    // A user can write many reviews.
    public function reviews()
    {
        return $this->hasMany(M_Reviews::class, 'user_id');
    }

    // Define the many-to-many relationship for games wishlisted by the user.
    // A user can wishlist many games.
    public function wishedGames()
    {
        return $this->belongsToMany(M_Games::class, 'wished_games', 'user_id', 'game_id');
    }

    // Create a new factory instance for the model.
    // Used for seeding and testing.
    protected static function newFactory()
    {
        return UserFactory::new();
    }
}

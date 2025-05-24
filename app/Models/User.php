<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // <<< THIS LINE
use Database\Factories\UserFactory;

class User extends Authenticatable // Extend Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // Added HasApiTokens and Notifiable

    // If your table is 'users2', uncomment this. Otherwise, Laravel expects 'users'.
    // protected $table = 'users2';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin', // Add this if you added the column
        // Add any other fields from your original M_Users2 if they are fillable
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean', // Cast to boolean
    ];

    public function ownedGames()
    {
        // Ensure 'owned_games' pivot table uses 'user_id'
        return $this->belongsToMany(M_Games::class, 'owned_games', 'user_id', 'game_id');
    }

    public function reviews()
    {
        // Ensure 'reviews' table uses 'user_id'
        return $this->hasMany(M_Reviews::class, 'user_id');
    }

    public function wishedGames()
    {
        return $this->belongsToMany(M_Games::class, 'wished_games', 'user_id', 'game_id');
    }

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}

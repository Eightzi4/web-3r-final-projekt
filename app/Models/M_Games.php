<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; // Added for wishlist check

class M_Games extends Model
{
    use HasFactory;

    public $timestamps = false; // Consider if created_at/updated_at for game metadata is useful

    protected $table = 'games';
    protected $fillable = [
        'id',
        'name',
        'description',
        'trailer_link',
        'visible',
        'developer_id'
    ];

    // Eager load common relationships for performance
    // protected $with = ['developer', 'latestPrice'];

    public function developer()
    {
        return $this->belongsTo(M_Developers::class, 'developer_id');
    }

    public function images()
    {
        return $this->hasMany(M_GameImages::class, 'game_id');
    }

    public function gameStates() // Assuming 'M_GameStates' defines state types (e.g. Released, Beta)
    {
        return $this->belongsToMany(M_GameStates::class, 'games_states_pivot', 'game_id', 'game_state_id');
        // 'games_states_pivot' would be the name of your pivot table.
        // If 'games_states' is the pivot table, then it was:
        // return $this->belongsToMany(M_GameStates::class, 'games_states', 'game_id', 'game_state_id');
    }

    public function prices()
    {
        return $this->hasMany(M_Prices::class, 'game_id');
    }

    public function tags()
    {
        return $this->belongsToMany(M_Tags::class, 'games_tags', 'game_id', 'tag_id');
    }

    public function owners() // Renamed M_Users2 to User
    {
        return $this->belongsToMany(User::class, 'owned_games', 'game_id', 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(M_Reviews::class, 'game_id');
    }

    public function wishers() // Renamed M_Users2 to User
    {
        return $this->belongsToMany(User::class, 'wished_games', 'game_id', 'user_id');
    }

    // Corrected hasManyThrough relationships
    public function platforms() // Renamed from platform to platforms for clarity
    {
        return $this->hasManyThrough(
            M_Platforms::class,
            M_Prices::class,
            'game_id',     // Foreign key on M_Prices table (intermediate)
            'id',          // Foreign key on M_Platforms table (far)
            'id',          // Local key on M_Games table (this)
            'platform_id'  // Local key on M_Prices table (intermediate)
        )->distinct(); // Add distinct if you only want unique platforms
    }

    public function stores() // Renamed from store to stores for clarity
    {
        return $this->hasManyThrough(
            M_Stores::class,
            M_Prices::class,
            'game_id',   // Foreign key on M_Prices table
            'id',        // Foreign key on M_Stores table
            'id',        // Local key on M_Games table
            'store_id'   // Local key on M_Prices table
        )->distinct(); // Add distinct if you only want unique stores
    }

    // Removed custom exists() method, Eloquent models have an 'exists' property.

    public function latestPrice()
    {
        return $this->hasOne(M_Prices::class, 'game_id')->latest('date');
    }

    // Accessor to check if the current authenticated user has wishlisted this game
    public function getIsWishlistedAttribute()
    {
        if (!Auth::check()) {
            return false;
        }
        return $this->wishers()->where('user_id', Auth::id())->exists();
    }

    // Accessor for average rating
    public function getAverageRatingAttribute()
    {
        // Ensure reviews are loaded with 'rating' or query it.
        // Add 'rating' to M_Reviews fillable if it's not there.
        return $this->reviews()->avg('rating');
    }
}

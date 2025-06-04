<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Database\Factories\GameFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class M_Games extends Model
{
    use HasFactory, SoftDeletes;

    // The table associated with the model.
    protected $table = 'games';
    // The attributes that are mass assignable.
    protected $fillable = [
        'id',
        'name',
        'description',
        'trailer_link',
        'visible',
        'developer_id'
    ];

    // Relationships to be eager loaded by default. (Currently commented out)
    // protected $with = ['developer', 'latestPrice'];

    // Define the relationship with the developer.
    // A game belongs to one developer.
    public function developer()
    {
        return $this->belongsTo(M_Developers::class, 'developer_id');
    }

    // Define the relationship with game images.
    // A game can have many images.
    public function images()
    {
        return $this->hasMany(M_GameImages::class, 'game_id');
    }

    // Define the many-to-many relationship with game states.
    // A game can have multiple states (e.g., owned, playing).
    public function gameStates()
    {
        return $this->belongsToMany(M_GameStates::class, 'games_states', 'game_id', 'game_state_id');
    }

    // Define the relationship with prices.
    // A game can have many price entries over time.
    public function prices()
    {
        return $this->hasMany(M_Prices::class, 'game_id');
    }

    // Define the many-to-many relationship with tags.
    // A game can have multiple tags.
    public function tags()
    {
        return $this->belongsToMany(M_Tags::class, 'games_tags', 'game_id', 'tag_id');
    }

    // Define the many-to-many relationship with users who own the game.
    // Many users can own many games.
    public function owners()
    {
        return $this->belongsToMany(User::class, 'owned_games', 'game_id', 'user_id');
    }

    // Define the relationship with reviews.
    // A game can have many reviews.
    public function reviews()
    {
        return $this->hasMany(M_Reviews::class, 'game_id');
    }

    // Define the many-to-many relationship with users who wishlisted the game.
    // Many users can wishlist many games.
    public function wishers()
    {
        return $this->belongsToMany(User::class, 'wished_games', 'game_id', 'user_id');
    }

    // Define a has-many-through relationship to get platforms via prices.
    // A game can be available on multiple platforms.
    public function platforms()
    {
        return $this->hasManyThrough(
            M_Platforms::class,
            M_Prices::class,
            'game_id',
            'id',
            'id',
            'platform_id'
        )->distinct();
    }

    // Define a has-many-through relationship to get stores via prices.
    // A game can be sold in multiple stores.
    public function stores()
    {
        return $this->hasManyThrough(
            M_Stores::class,
            M_Prices::class,
            'game_id',
            'id',
            'id',
            'store_id'
        )->distinct();
    }

    // Define a one-to-one relationship to get the latest price.
    // Retrieves the most recent price entry for the game.
    public function latestPrice()
    {
        return $this->hasOne(M_Prices::class, 'game_id')->latest('date');
    }

    // Accessor to check if the current authenticated user has wishlisted this game.
    // Returns true if wishlisted, false otherwise.
    public function getIsWishlistedAttribute()
    {
        if (!Auth::check()) {
            return false;
        }
        return $this->wishers()->where('user_id', Auth::id())->exists();
    }

    // Accessor for the average rating of the game.
    // Calculates the average based on all its reviews.
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating');
    }

    // Create a new factory instance for the model.
    // Used for seeding and testing.
    protected static function newFactory()
    {
        return GameFactory::new();
    }
}

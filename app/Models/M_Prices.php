<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\PriceFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class M_Prices extends Model
{
    use HasFactory, SoftDeletes;

    // The table associated with the model.
    protected $table = 'prices';
    // The attributes that are mass assignable.
    protected $fillable = [
        'id', 'price', 'date', 'discount', 'game_id', 'platform_id', 'store_id'
    ];

    // Define the relationship to the game.
    // A price entry belongs to one game.
    public function game()
    {
        return $this->belongsTo(M_Games::class, 'game_id');
    }

    // Define the relationship to the platform.
    // A price entry is for a specific platform.
    public function platform()
    {
        return $this->belongsTo(M_Platforms::class, 'platform_id');
    }

    // Define the relationship to the store.
    // A price entry is for a specific store.
    public function store()
    {
        return $this->belongsTo(M_Stores::class, 'store_id');
    }

    // Create a new factory instance for the model.
    // Used for seeding and testing.
    protected static function newFactory()
    {
        return PriceFactory::new();
    }
}

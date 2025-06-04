<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\GameStateFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class M_GameStates extends Model
{
    use HasFactory, SoftDeletes;

    // The table associated with the model.
    protected $table = 'game_states';
    // The attributes that are mass assignable.
    protected $fillable = [
        'id',
        'name'
    ];

    // Define the many-to-many relationship with games.
    // A game state can be applied to many games.
    public function games()
    {
        return $this->belongsToMany(M_Games::class, 'games_states', 'game_state_id', 'game_id');
    }

    // Create a new factory instance for the model.
    // Used for seeding and testing.
    protected static function newFactory()
    {
        return GameStateFactory::new();
    }
}

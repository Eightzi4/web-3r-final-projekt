<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\GameStateFactory;

class M_GameStates extends Model // This model represents a state like "Released", "Beta"
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'game_states'; // This table should contain state definitions (e.g., id, name)
    protected $fillable = [
        'id', // Assuming 'id' is fillable if you manually set it
        'name' // The name of the game state e.g. "Released", "Beta"
        // Add other attributes of a game state if any
    ];

    public function games()
    {
        // return $this->belongsToMany(M_Games::class, 'games_states_pivot', 'game_state_id', 'game_id'); // Old
        return $this->belongsToMany(M_Games::class, 'games_states', 'game_state_id', 'game_id'); // New - matches migration
    }

    protected static function newFactory()
    {
        return GameStateFactory::new();
    }
}

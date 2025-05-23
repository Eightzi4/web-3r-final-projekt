<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        // A game state (e.g. "Released") can apply to many games
        return $this->belongsToMany(M_Games::class, 'games_states_pivot', 'game_state_id', 'game_id');
        // 'games_states_pivot' is the conventional name for the pivot table.
        // If your pivot table is indeed named 'games_states', then:
        // return $this->belongsToMany(M_Games::class, 'games_states', 'game_state_id', 'game_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_GameStates extends Model
{
    use HasFactory;

    protected $table = 'game_states';

    public function games()
    {
        return $this->belongsToMany(M_Games::class, 'games_states', 'game_state_id', 'game_id');
    }
}

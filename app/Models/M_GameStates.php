<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_GameStates extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'game_states';
    protected $fillable = [
        'game_id',
        'game_state_id'
    ];

    public function games()
    {
        return $this->belongsToMany(M_Games::class, 'games_states', 'game_state_id', 'game_id');
    }
}

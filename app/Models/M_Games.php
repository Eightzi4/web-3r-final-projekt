<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Games extends Model
{
    use HasFactory;

    protected $table = 'games';

    public function developer()
    {
        return $this->belongsTo(M_Developers::class, 'developer_id');
    }

    public function images()
    {
        return $this->hasMany(M_GameImages::class, 'game_id');
    }

    public function gameStates()
    {
        return $this->belongsToMany(M_GameStates::class, 'games_states', 'game_id', 'game_state_id');
    }

    public function prices()
    {
        return $this->hasMany(M_Prices::class, 'game_id');
    }

    public function tags()
    {
        return $this->belongsToMany(M_Tags::class, 'games_tags', 'game_id', 'tag_id');
    }

    public function owners()
    {
        return $this->belongsToMany(M_Users2::class, 'owned_games', 'game_id', 'user2_id');
    }

    public function reviews()
    {
        return $this->hasMany(M_Reviews::class, 'game_id');
    }

    public function wishers()
    {
        return $this->belongsToMany(M_Users2::class, 'wished_games', 'game_id', 'user2_id');
    }
}

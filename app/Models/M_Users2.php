<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Users2 extends Model
{
    use HasFactory;

    protected $table = 'users2';

    public function ownedGames()
    {
        return $this->belongsToMany(M_Games::class, 'owned_games', 'user2_id', 'game_id');
    }

    public function reviews()
    {
        return $this->hasMany(M_Reviews::class, 'user2_id');
    }

    public function wishedGames()
    {
        return $this->belongsToMany(M_Games::class, 'wished_games', 'user2_id', 'game_id');
    }
}

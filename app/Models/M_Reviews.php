<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Reviews extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    public function user()
    {
        return $this->belongsTo(M_Users2::class, 'user_id');
    }

    public function game()
    {
        return $this->belongsTo(M_Games::class, 'game_id');
    }
}

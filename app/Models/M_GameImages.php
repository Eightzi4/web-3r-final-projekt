<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_GameImages extends Model
{
    use HasFactory;

    protected $table = 'game_images';

    public function game()
    {
        return $this->belongsTo(M_Games::class, 'game_id');
    }
}

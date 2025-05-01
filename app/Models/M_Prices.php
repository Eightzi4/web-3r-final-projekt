<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Prices extends Model
{
    use HasFactory;

    protected $table = 'prices';

    public function game()
    {
        return $this->belongsTo(M_Games::class, 'game_id');
    }

    public function platform()
    {
        return $this->belongsTo(M_Platforms::class, 'platform_id');
    }

    public function store()
    {
        return $this->belongsTo(M_Stores::class, 'store_id');
    }
}

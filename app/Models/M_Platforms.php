<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Platforms extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'platforms';
    protected $fillable = [
        'id',
        'name'
    ];

    public function prices()
    {
        return $this->hasMany(M_Prices::class, 'platform_id');
    }

    public function games()
    {
        return $this->belongsToMany(M_Games::class, 'prices', 'platform_id', 'game_id');
    }
}

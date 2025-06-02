<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\PriceFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class M_Prices extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'prices';
    protected $fillable = [
        'id', 'price', 'date', 'discount', 'game_id', 'platform_id', 'store_id'
    ];

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

    protected static function newFactory()
    {
        return PriceFactory::new();
    }
}

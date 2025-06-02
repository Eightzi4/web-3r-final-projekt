<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\GameImagesFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class M_GameImages extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'game_images';
    protected $fillable = [
        'id',
        'image',
        'game_id'
    ];

    public function game()
    {
        return $this->belongsTo(M_Games::class, 'game_id');
    }

    protected static function newFactory()
    {
        return GameImagesFactory::new();
    }
}

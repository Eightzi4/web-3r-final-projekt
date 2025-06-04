<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\GameImagesFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class M_GameImages extends Model
{
    use HasFactory, SoftDeletes;

    // The table associated with the model.
    protected $table = 'game_images';
    // The attributes that are mass assignable.
    protected $fillable = [
        'id',
        'image',
        'game_id'
    ];

    // Define the relationship with its game.
    // An image belongs to one game.
    public function game()
    {
        return $this->belongsTo(M_Games::class, 'game_id');
    }

    // Create a new factory instance for the model.
    // Used for seeding and testing.
    protected static function newFactory()
    {
        return GameImagesFactory::new();
    }
}

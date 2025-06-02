<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\ReviewFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class M_Reviews extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reviews';
    protected $fillable = [ // Add fillable properties
        'user_id', 'game_id', 'rating', 'comment', 'title' // Assuming you have these fields
    ];

    public function user() // Renamed M_Users2 to User
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function game()
    {
        return $this->belongsTo(M_Games::class, 'game_id');
    }

    protected static function newFactory()
    {
        return ReviewFactory::new();
    }
}

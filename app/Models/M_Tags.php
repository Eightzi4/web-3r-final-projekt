<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\TagFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class M_Tags extends Model
{
    use HasFactory, SoftDeletes;

    // The table associated with the model.
    protected $table = 'tags';
    // The attributes that are mass assignable.
    protected $fillable = ['id', 'name', 'description', 'color'];

    // Define the many-to-many relationship with games.
    // A tag can be applied to many games.
    public function games()
    {
        return $this->belongsToMany(M_Games::class, 'games_tags', 'tag_id', 'game_id');
    }

    // Create a new factory instance for the model.
    // Used for seeding and testing.
    protected static function newFactory()
    {
        return TagFactory::new();
    }
}

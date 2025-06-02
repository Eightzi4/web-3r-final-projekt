<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\TagFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class M_Tags extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tags';
    protected $fillable = ['id', 'name', 'description', 'color'];

    public function games()
    {
        return $this->belongsToMany(M_Games::class, 'games_tags', 'tag_id', 'game_id');
    }

    protected static function newFactory()
    {
        return TagFactory::new();
    }
}

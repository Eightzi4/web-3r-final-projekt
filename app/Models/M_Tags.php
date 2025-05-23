<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Tags extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tags';
    protected $fillable = ['id', 'name', 'description', 'color'];

    public function games()
    {
        return $this->belongsToMany(M_Games::class, 'games_tags', 'tag_id', 'game_id');
    }
}

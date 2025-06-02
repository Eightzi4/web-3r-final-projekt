<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\PlatformFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class M_Platforms extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'platforms';
    protected $fillable = ['id', 'name'];

    public function prices()
    {
        return $this->hasMany(M_Prices::class, 'platform_id');
    }

    // This relationship might be more complex if you want games directly.
    // Games are linked via prices. The M_Games->platforms() is likely more useful.
    public function games()
    {
        return $this->belongsToMany(M_Games::class, 'prices', 'platform_id', 'game_id')->distinct();
    }

    protected static function newFactory()
    {
        return PlatformFactory::new();
    }
}

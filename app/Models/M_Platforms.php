<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\PlatformFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class M_Platforms extends Model
{
    use HasFactory, SoftDeletes;

    // The table associated with the model.
    protected $table = 'platforms';
    // The attributes that are mass assignable.
    protected $fillable = ['id', 'name'];

    // Define the relationship with prices.
    // A platform can have many price entries.
    public function prices()
    {
        return $this->hasMany(M_Prices::class, 'platform_id');
    }

    // Define a many-to-many relationship with games through the prices table.
    // A platform can have many games available on it.
    public function games()
    {
        return $this->belongsToMany(M_Games::class, 'prices', 'platform_id', 'game_id')->distinct();
    }

    // Create a new factory instance for the model.
    // Used for seeding and testing.
    protected static function newFactory()
    {
        return PlatformFactory::new();
    }
}

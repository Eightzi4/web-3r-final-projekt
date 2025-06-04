<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\DeveloperFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class M_Developers extends Model
{
    use HasFactory, SoftDeletes;

    // The table associated with the model.
    protected $table = 'developers';
    // The attributes that are mass assignable.
    protected $fillable = [
        'id', 'name', 'founded_date', 'description', 'country_id', 'website_link'
    ];

    // Define the relationship to the country.
    // A developer belongs to one country.
    public function country()
    {
        return $this->belongsTo(M_Countries::class, 'country_id');
    }

    // Define the relationship to games.
    // A developer can have many games.
    public function games()
    {
        return $this->hasMany(M_Games::class, 'developer_id');
    }

    // Define the relationship to developer images.
    // A developer can have many images.
    public function images()
    {
        return $this->hasMany(M_DeveloperImages::class, 'developer_id');
    }

    // Create a new factory instance for the model.
    // Used for seeding and testing.
    protected static function newFactory()
    {
        return DeveloperFactory::new();
    }
}

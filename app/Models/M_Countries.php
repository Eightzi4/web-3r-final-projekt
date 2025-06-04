<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\CountryFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class M_Countries extends Model
{
    use HasFactory, SoftDeletes;

    // The table associated with the model.
    protected $table = 'countries';
    // The attributes that are mass assignable.
    protected $fillable = ['id', 'name'];

    // Define the relationship with developers.
    // A country can have many developers.
    public function developers()
    {
        return $this->hasMany(M_Developers::class, 'country_id');
    }

    // Create a new factory instance for the model.
    // Used for seeding and testing.
    protected static function newFactory()
    {
        return CountryFactory::new();
    }
}

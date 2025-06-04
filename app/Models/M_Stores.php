<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\StoreFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class M_Stores extends Model
{
    use HasFactory, SoftDeletes;

    // The table associated with the model.
    protected $table = 'stores';
    // The attributes that are mass assignable.
    protected $fillable = ['id', 'name', 'url'];

    // Define the relationship with prices.
    // A store can have many price entries.
    public function prices()
    {
        return $this->hasMany(M_Prices::class, 'store_id');
    }

    // Create a new factory instance for the model.
    // Used for seeding and testing.
    protected static function newFactory()
    {
        return StoreFactory::new();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\StoreFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class M_Stores extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'stores';
    protected $fillable = ['id', 'name', 'url']; // Assuming 'name' and 'url'

    public function prices()
    {
        return $this->hasMany(M_Prices::class, 'store_id');
    }

    protected static function newFactory()
    {
        return StoreFactory::new();
    }
}

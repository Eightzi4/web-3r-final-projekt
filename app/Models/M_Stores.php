<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Stores extends Model
{
    use HasFactory;

    protected $table = 'stores';

    public function prices()
    {
        return $this->hasMany(M_Prices::class, 'store_id');
    }
}

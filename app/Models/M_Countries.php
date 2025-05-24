<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\CountryFactory;


class M_Countries extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'countries';
    protected $fillable = ['id', 'name'];

    public function developers()
    {
        return $this->hasMany(M_Developers::class, 'country_id');
    }

    protected static function newFactory()
    {
        return CountryFactory::new();
    }
}

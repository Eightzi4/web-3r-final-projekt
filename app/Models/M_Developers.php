<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class M_Developers extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'developers';
    protected $fillable = [
        'id',
        'name',
        'founded_date',
        'description',
        'country_id',
        'website_link'
    ];

    public function games()
    {
        return $this->hasMany(M_Games::class, 'developer_id');
    }

    public function images()
    {
        return $this->hasMany(M_DeveloperImages::class, 'developer_id');
    }
}

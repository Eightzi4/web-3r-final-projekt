<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Developers extends Model
{
    protected $table = 'developers';

    public function games()
    {
        return $this->hasMany(M_Games::class, 'developer_id');
    }

    public function images()
    {
        return $this->hasMany(M_DeveloperImages::class, 'developer_id');
    }
}

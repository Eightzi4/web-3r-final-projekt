<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class M_DeveloperImages extends Model
{
    use HasFactory;

    protected $table = 'developer_images';

    public function developer()
    {
        return $this->belongsTo(M_Developers::class, 'developer_id');
    }
}

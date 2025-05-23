<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\DeveloperImagesFactory;

class M_DeveloperImages extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'developer_images';
    protected $fillable = ['id', 'image', 'developer_id'];

    public function developer()
    {
        return $this->belongsTo(M_Developers::class, 'developer_id');
    }

    protected static function newFactory()
    {
        return DeveloperImagesFactory::new();
    }
}

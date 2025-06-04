<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\DeveloperImagesFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class M_DeveloperImages extends Model
{
    use HasFactory, SoftDeletes;

    // The table associated with the model.
    protected $table = 'developer_images';
    // The attributes that are mass assignable.
    protected $fillable = ['id', 'image', 'developer_id'];

    // Define the relationship with its developer.
    // An image belongs to one developer.
    public function developer()
    {
        return $this->belongsTo(M_Developers::class, 'developer_id');
    }

    // Create a new factory instance for the model.
    // Used for seeding and testing.
    protected static function newFactory()
    {
        return DeveloperImagesFactory::new();
    }
}

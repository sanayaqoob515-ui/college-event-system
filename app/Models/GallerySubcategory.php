<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GallerySubcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gallery_category_id',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(GalleryCategory::class, 'gallery_category_id');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'subcategory_id');
    }
}

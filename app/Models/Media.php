<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = ['event_id','file_type','file_url','caption','uploaded_by','subcategory_id'];
    public $timestamps = true;

    public function subcategory()
    {
        return $this->belongsTo(GallerySubcategory::class, 'subcategory_id');
    }
}

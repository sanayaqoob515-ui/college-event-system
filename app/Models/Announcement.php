<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'title', 'message', 'target_role', 'target_user_id', 'created_by'
    ];
    public $timestamps = true;
}

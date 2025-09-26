<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventShareLog extends Model
{
    protected $fillable = [
        'user_id', 'event_id', 'platform', 'share_message', 'share_timestamp'
    ];
    public $timestamps = false;
}

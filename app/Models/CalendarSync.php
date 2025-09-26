<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarSync extends Model
{
    protected $fillable = [
        'user_id', 'event_id', 'calendar_type', 'calendar_url', 'sync_timestamp'
    ];
    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'category', 'date', 'time', 'venue', 'organizer_id', 'max_participants', 'seats_booked', 'status'
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
    public function eventReviews()
    {
        return $this->hasMany(EventReview::class);
    }
}

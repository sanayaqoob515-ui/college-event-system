<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    public function run()
    {
        Event::create([
            'title' => 'Tech Symposium 2025',
            'description' => 'A one-day technical symposium with workshops and paper presentations.',
            'category' => 'technical',
            'date' => '2025-10-15',
            'time' => '10:00:00',
            'venue' => 'Main Auditorium',
            'organizer_id' => 2,
            'max_participants' => 200,
            'seats_booked' => 0,
            'status' => 'approved'
        ]);

        Event::create([
            'title' => 'Cultural Fest 2025',
            'description' => 'Three-day cultural activities including music, dance and theatre.',
            'category' => 'cultural',
            'date' => '2025-11-05',
            'time' => '09:00:00',
            'venue' => 'Open Lawn',
            'organizer_id' => 2,
            'max_participants' => 500,
            'seats_booked' => 0,
            'status' => 'approved'
        ]);
    }
}

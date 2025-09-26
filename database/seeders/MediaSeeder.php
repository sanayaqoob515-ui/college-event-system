<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Media;

class MediaSeeder extends Seeder
{
    public function run()
    {
        Media::create([
            'event_id' => 1,
            'file_type' => 'image',
            'file_url' => 'gallery/techsymposium1.jpg',
            'uploaded_by' => 2,
            'caption' => 'Tech Symposium Opening Ceremony',
            'uploaded_on' => now(),
        ]);
        Media::create([
            'event_id' => 2,
            'file_type' => 'image',
            'file_url' => 'gallery/culturalfest1.jpg',
            'uploaded_by' => 2,
            'caption' => 'Cultural Fest Dance Performance',
            'uploaded_on' => now(),
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([ 'name'=>'Admin User', 'email'=>'admin@example.com', 'password'=>Hash::make('password'), 'role'=>'admin' ]);
        User::create([ 'name'=>'Organizer User', 'email'=>'organizer@example.com', 'password'=>Hash::make('password'), 'role'=>'organizer' ]);
        User::create([ 'name'=>'Student User', 'email'=>'student@example.com', 'password'=>Hash::make('password'), 'role'=>'participant' ]);
    }
}

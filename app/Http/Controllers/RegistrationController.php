<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use App\Models\Waitlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function cancel($id)
    {
        $user = Auth::user();
        $registration = Registration::where('id', $id)->where('student_id', $user->id)->firstOrFail();
        $event = Event::findOrFail($registration->event_id);
        $registration->delete();
        // Decrement seats booked
        $event->seats_booked = max(0, $event->seats_booked - 1);
        $event->save();
        // Promote first waitlisted user if any
        $waitlisted = Waitlist::where('event_id', $event->id)->where('status', 'waiting')->orderBy('created_at')->first();
        if ($waitlisted) {
            Registration::create([
                'event_id' => $event->id,
                'student_id' => $waitlisted->user_id,
                'registered_on' => now(),
                'status' => 'active',
            ]);
            $event->seats_booked += 1;
            $event->save();
            $waitlisted->status = 'promoted';
            $waitlisted->save();
        }
        return back()->with('success', 'Registration cancelled.');
    }

    public function joinWaitlist(Request $request, $eventId)
    {
        $user = Auth::user();
        $exists = Waitlist::where('event_id', $eventId)->where('user_id', $user->id)->first();
        if (!$exists) {
            Waitlist::create([
                'event_id' => $eventId,
                'user_id' => $user->id,
                'status' => 'waiting',
            ]);
        }
        return back()->with('success', 'Added to waitlist.');
    }
}

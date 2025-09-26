<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    // Organizer marks attendance (manual or QR)
    public function mark(Request $request, $eventId, $studentId)
    {
        $attendance = Attendance::firstOrCreate([
            'event_id' => $eventId,
            'student_id' => $studentId,
        ]);
        $attendance->attended = true;
        $attendance->marked_on = now();
        $attendance->save();
        return back()->with('success', 'Attendance marked!');
    }

    // Organizer view attendance list
    public function list($eventId)
    {
        $event = Event::findOrFail($eventId);
        $attendances = Attendance::where('event_id', $eventId)->with('user')->get();
        $registrations = Registration::where('event_id', $eventId)->with('student')->get();
        return view('attendance.list', compact('event', 'attendances', 'registrations'));
    }
}

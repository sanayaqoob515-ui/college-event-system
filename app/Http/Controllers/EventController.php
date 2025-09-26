<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $query = Event::where('status', 'approved');
        if (request('q')) {
            $query->where(function($q) {
                $q->where('title', 'like', '%'.request('q').'%')
                  ->orWhere('description', 'like', '%'.request('q').'%');
            });
        }
        if (request('category')) {
            $query->where('category', 'like', '%'.request('category').'%');
        }
        if (request('department')) {
            $query->where('organizer_id', function($q) {
                $q->select('id')->from('users')->where('role', 'organizer')->where('name', 'like', '%'.request('department').'%');
            });
        }
        if (request('date_from')) {
            $query->where('date', '>=', request('date_from'));
        }
        if (request('date_to')) {
            $query->where('date', '<=', request('date_to'));
        }
        $events = $query->orderBy('date', 'asc')->paginate(10);
        return view('events.index', compact('events'));
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        // Get feedbacks for this event
        $feedbacks = \App\Models\Feedback::where('event_id', $id)->with('user')->latest()->get();
        $reviews = $event->eventReviews()->with('user')->latest()->get();
        $avg = [
            'content' => $event->eventReviews()->avg('content_rating'),
            'organization' => $event->eventReviews()->avg('organization_rating'),
            'venue' => $event->eventReviews()->avg('venue_rating'),
            'speakers' => $event->eventReviews()->avg('speakers_rating'),
        ];
        return view('events.show', compact('event', 'feedbacks', 'reviews', 'avg'));
    }

    public function logShare(Request $request, $id)
    {
        if (Auth::check()) {
            \App\Models\EventShareLog::create([
                'user_id' => Auth::id(),
                'event_id' => $id,
                'platform' => $request->platform,
                'share_message' => $request->message,
                'share_timestamp' => now(),
            ]);
        }
        return response()->json(['status' => 'ok']);
    }

    public function logCalendarSync(Request $request, $id)
    {
        if (Auth::check()) {
            \App\Models\CalendarSync::create([
                'user_id' => Auth::id(),
                'event_id' => $id,
                'calendar_type' => $request->calendar_type,
                'calendar_url' => $request->calendar_url,
                'sync_timestamp' => now(),
            ]);
        }
        return response()->json(['status' => 'ok']);
    }

    public function dashboard()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $pending = Event::where('status','pending')->get();
            $approved = Event::where('status','approved')->get();
            return view('dashboards.admin', compact('user','pending','approved'));
        } elseif ($user->role === 'organizer') {
            $events = Event::where('organizer_id',$user->id)->get();
            return view('dashboards.organizer', compact('user','events'));
        } else {
            $regs = Registration::where('student_id',$user->id)->with('event')->get();
            return view('dashboards.participant', compact('user','regs'));
        }
    }

    public function registerForEvent(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $user = Auth::user();
        $already = Registration::where('event_id',$id)->where('student_id',$user->id)->first();
        if ($already) return back()->with('info','Already registered.');

        if ($event->seats_booked >= $event->max_participants) {
            Registration::create(['event_id'=>$id,'student_id'=>$user->id,'status'=>'waitlist']);
            return back()->with('warning','Event full, added to waitlist.');
        }

        Registration::create(['event_id'=>$id,'student_id'=>$user->id,'status'=>'confirmed']);
        $event->increment('seats_booked');

        return back()->with('success','Registered successfully.');
    }

    public function approve($id)
    {
        $event = Event::findOrFail($id);
        $event->status = 'approved';
        $event->save();
        Notification::create(['user_id'=>$event->organizer_id,'message'=>'Your event '.$event->title.' was approved.']);
        return back()->with('success','Event approved.');
    }

    public function reject($id)
    {
        $event = Event::findOrFail($id);
        $event->status = 'cancelled';
        $event->save();
        Notification::create(['user_id'=>$event->organizer_id,'message'=>'Your event '.$event->title.' was rejected.']);
        return back()->with('error','Event rejected.');
    }
    public function updateSlots(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $user = Auth::user();
        if ($user->role !== 'organizer' || $event->organizer_id !== $user->id) {
            abort(403);
        }
        $request->validate([
            'max_participants' => 'required|integer|min:1',
        ]);
        $event->max_participants = $request->max_participants;
        $event->save();
        return back()->with('success', 'Event slots updated!');
    }
}

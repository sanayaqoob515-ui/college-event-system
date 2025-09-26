<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventReview;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventReviewController extends Controller
{
    public function store(Request $request, $eventId)
    {
        $request->validate([
            'content_rating' => 'required|integer|min:1|max:5',
            'organization_rating' => 'required|integer|min:1|max:5',
            'venue_rating' => 'required|integer|min:1|max:5',
            'speakers_rating' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string|max:2000',
        ]);

        EventReview::updateOrCreate(
            [
                'event_id' => $eventId,
                'user_id' => Auth::id(),
            ],
            [
                'content_rating' => $request->content_rating,
                'organization_rating' => $request->organization_rating,
                'venue_rating' => $request->venue_rating,
                'speakers_rating' => $request->speakers_rating,
                'comments' => $request->comments,
            ]
        );

        return back()->with('success', 'Thank you for your review!');
    }
}

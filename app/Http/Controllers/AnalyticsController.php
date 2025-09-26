<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\Registration;
use App\Models\Feedback;
use App\Models\EventReview;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $eventCount = Event::count();
        $userCount = User::count();
        $registrationCount = Registration::count();
        $feedbackCount = Feedback::count();
        $reviewCount = EventReview::count();
        $registrationsByMonth = Registration::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as total'))
            ->groupBy('month')->orderBy('month')->pluck('total','month');
        $eventsByCategory = Event::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')->pluck('total','category');
        $avgReviewScores = [
            'content' => EventReview::avg('content_rating'),
            'organization' => EventReview::avg('organization_rating'),
            'venue' => EventReview::avg('venue_rating'),
            'speakers' => EventReview::avg('speakers_rating'),
        ];
        return view('admin.analytics', compact(
            'eventCount','userCount','registrationCount','feedbackCount','reviewCount',
            'registrationsByMonth','eventsByCategory','avgReviewScores'
        ));
    }
}

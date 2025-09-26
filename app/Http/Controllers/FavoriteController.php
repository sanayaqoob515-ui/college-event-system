<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function addEvent($eventId)
    {
        $user = Auth::user();
        Favorite::firstOrCreate([
            'user_id' => $user->id,
            'event_id' => $eventId,
            'type' => 'event',
        ]);
        return back()->with('success', 'Event added to favorites!');
    }

    public function addMedia($mediaId)
    {
        $user = Auth::user();
        Favorite::firstOrCreate([
            'user_id' => $user->id,
            'media_id' => $mediaId,
            'type' => 'media',
        ]);
        return back()->with('success', 'Media added to favorites!');
    }

    public function myFavorites()
    {
        $user = Auth::user();
        $events = Favorite::where('user_id', $user->id)->where('type', 'event')->with('event')->get();
        $media = Favorite::where('user_id', $user->id)->where('type', 'media')->with('media')->get();
        return view('favorites.index', compact('events', 'media'));
    }
}

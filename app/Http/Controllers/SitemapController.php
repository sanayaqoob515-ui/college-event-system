<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use App\Models\Event;
use App\Models\Media;
use App\Models\User;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = Cache::remember('sitemap.xml', 60, function() {
            $urls = [];
            $urls[] = url('/');
            $urls[] = url('/about');
            $urls[] = url('/contact');
            $urls[] = url('/faq');
            $urls[] = url('/gallery');
            $urls[] = url('/announcements');
            // Events
            foreach (Event::all() as $event) {
                $urls[] = route('events.show', $event->id);
            }
            // Media
            foreach (Media::all() as $media) {
                $urls[] = url('/storage/' . $media->file_url);
            }
            // Users (public profiles)
            foreach (User::all() as $user) {
                $urls[] = url('/users/' . $user->id);
            }
            $xml = view('sitemap.xml', ['urls' => $urls])->render();
            return $xml;
        });
        return response($sitemap, 200)->header('Content-Type', 'application/xml');
    }
}

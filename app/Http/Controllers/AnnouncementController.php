<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $announcements = Announcement::where(function($q) use ($user) {
            $q->whereNull('target_role')
              ->orWhere('target_role', $user->role)
              ->orWhere('target_user_id', $user->id);
        })->latest()->get();
        return view('announcements.index', compact('announcements'));
    }

    public function create()
    {
        $users = User::all();
        return view('announcements.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'message' => 'required',
        ]);
        Announcement::create([
            'title' => $request->title,
            'message' => $request->message,
            'target_role' => $request->target_role,
            'target_user_id' => $request->target_user_id,
            'created_by' => Auth::id(),
        ]);
        return redirect()->route('announcements.index')->with('success', 'Announcement sent!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Feedback;
use App\Models\Media;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();
        return back()->with('success', 'User role updated!');
    }

    public function suspend($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'suspended';
        $user->save();
        return back()->with('success', 'User suspended!');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'User deleted!');
    }

    public function moderateFeedback()
    {
        $feedbacks = Feedback::latest()->get();
        return view('admin.feedbacks', compact('feedbacks'));
    }

    public function moderateMedia()
    {
        $media = Media::latest()->get();
        return view('admin.media', compact('media'));
    }
}

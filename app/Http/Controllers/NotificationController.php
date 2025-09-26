<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller {
    public function index() {
        $notes = Notification::where('user_id',Auth::id())->orderBy('created_at','desc')->get();
        return view('notifications.index', compact('notes'));
    }
}

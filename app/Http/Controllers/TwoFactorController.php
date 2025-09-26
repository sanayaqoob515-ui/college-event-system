<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCodeMail;

class TwoFactorController extends Controller
{
    public function show()
    {
        return view('auth.twofactor');
    }

    public function send(Request $request)
    {
        $user = Auth::user();
        $user->generateTwoFactorCode();
        Mail::to($user->email)->send(new TwoFactorCodeMail($user));
        return back()->with('status', 'A two-factor code has been sent to your email.');
    }

    public function verify(Request $request)
    {
        $request->validate(['two_factor_code' => 'required|digits:6']);
        $user = Auth::user();
        if ($request->two_factor_code == $user->two_factor_code && now()->lt($user->two_factor_expires_at)) {
            $user->resetTwoFactorCode();
            session(['2fa_passed' => true]);
            return redirect()->intended('/');
        }
        return back()->withErrors(['two_factor_code' => 'Invalid or expired code.']);
    }
}

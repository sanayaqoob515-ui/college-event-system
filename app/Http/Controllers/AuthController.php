<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email','password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard');
        }
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:student,organizer',
            'mobile' => 'nullable|string|max:15',
            'department' => 'nullable|string|max:100',
            'enrollment_no' => 'nullable|string|max:50',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role']
        ]);
        \App\Models\UserDetail::create([
            'user_id' => $user->id,
            'full_name' => $data['name'],
            'mobile' => $data['mobile'] ?? null,
            'department' => $data['department'] ?? null,
            'enrollment_no' => $data['enrollment_no'] ?? null,
        ]);

        Auth::login($user);
        return redirect('/dashboard');
    }
}

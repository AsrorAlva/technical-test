<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function login()
    {
        return view('login.login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"]
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            Log::info('User logged in.', [
                'user_id' => Auth::id(),
                'email' => Auth::user()->email,
                'role' => Auth::user()->role,
            ]);

            return redirect()->route('dashboard');
        }

        Log::warning('Failed login attempt.', [
            'email' => $request->email,
        ]);

        return back()->with('error', 'Email atau password salah');
    }

    public function logout(Request $request)
    {
        Log::info('User logged out.', [
            'user_id' => Auth::id(),
            'email' => Auth::user()->email,
            'role' => Auth::user()->role,
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }
}

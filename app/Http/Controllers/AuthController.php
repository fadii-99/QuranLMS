<?php

// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $req)
    {
        $credentials = $req->validate([
            'email'    => ['required','email'],
            'password' => ['required'],
        ]);

        
        if (Auth::attempt($credentials, $req->boolean('remember'))) {
            $req->session()->regenerate();
            
            $user = Auth::user();
            if ($user->role === USER::ROLE_SUPER_ADMIN) {
                return redirect()->route('superadmin.dashboard');
            } elseif ($user->role === USER::ROLE_ADMIN) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === USER::ROLE_TEACHER) {
                return redirect()->route('teacher.dashboard');
            } else {
                return redirect()->route('student.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    public function showSignupForm()
    {
        return view('auth.signup');
    }

    public function logout(Request $req)
    {
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        return redirect()->route('login');
    }
}

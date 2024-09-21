<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Debugging: Check user role
            \Log::info('User role: ' . $user->role);

            if ($user->role === 'superadmin') {
                return redirect()->intended('admin/dashboard');
            } elseif ($user->role === 'admin') {
                return redirect()->intended('admin/dashboard');
            }

            return redirect()->intended('dashboard');
        }

        return redirect()->back()->withErrors([
            'email' => 'Username dan password yang anda masukan salah.',
        ])->withInput();
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}

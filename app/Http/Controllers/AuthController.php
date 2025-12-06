<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show login page.
     */
    public function showLogin()
    {
        // Jika sudah login, redirect ke dashboard
        if (session()->has('user')) {
            return redirect('/dashboard');
        }

        return view('login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // Ambil user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Cek user dan password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()
                ->with('error', 'Invalid email or password!')
                ->withInput();
        }

        // Simpan ke session
        session(['user' => [
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'logged_in_at' => now()
        ]]);

        return redirect('/dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
    }

    /**
     * Logout user.
     */
    public function logout()
    {
        session()->forget('user');
        return redirect('/login')->with('success', 'Logged out successfully.');
    }
}
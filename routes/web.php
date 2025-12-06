<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    // Manual check session
    if (!session()->has('user')) {
        return redirect('/login')->with('error', 'Please login first!');
    }
    
    $user = session('user');
    return view('dashboard', compact('user'));
})->name('dashboard');
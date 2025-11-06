<?php

use Illuminate\Support\Facades\Schedule;

// Jalanin test scheduler setiap menit
Schedule::command('test:scheduler')->everyMinute();

// Atau kalo mau test lebih jarang, setiap 5 menit
// Schedule::command('test:scheduler')->everyFiveMinutes();

// Atau setiap jam
// Schedule::command('test:scheduler')->hourly();

// Atau setiap hari jam 9 pagi
// Schedule::command('test:scheduler')->dailyAt('09:00');

// Contoh pake closure langsung
Schedule::call(function () {
    \Illuminate\Support\Facades\Log::info('Closure scheduler jalan: ' . now());
})->everyTenMinutes();
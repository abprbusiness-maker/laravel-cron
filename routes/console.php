<?php

use Illuminate\Support\Facades\Schedule;

// Jalanin test scheduler setiap menit
Schedule::command('test:scheduler')->everyMinute();

// Kirim notifikasi Discord setiap hari jam 00:00 (tengah malam)
Schedule::command('discord:notify', ['🌙 Daily Check - Tengah malam nih bro!'])->dailyAt('00:00');

// Atau kalo mau custom message lain:
// Schedule::command('discord:notify', ['💤 Selamat tidur! Server masih jalan nih.'])->dailyAt('00:00');

// Pilihan lain (uncomment yang lo mau):
// Setiap jam (jam 00:00, 01:00, 02:00, dst)
// Schedule::command('discord:notify', ['⏰ Hourly check-in'])->hourly();

// Setiap 6 jam
// Schedule::command('discord:notify')->everySixHours();

// Setiap hari jam tertentu
// Schedule::command('discord:notify', ['☀️ Selamat pagi!'])->dailyAt('08:00');
// Schedule::command('discord:notify', ['🌆 Selamat sore!'])->dailyAt('17:00');

// Atau kalo mau test lebih jarang, setiap 5 menit
// Schedule::command('test:scheduler')->everyFiveMinutes();

// Atau setiap jam
// Schedule::command('test:scheduler')->hourly();

// Atau setiap hari jam 9 pagi
// Schedule::command('test:scheduler')->dailyAt('09:00');

// Contoh pake closure langsung
Schedule::call(function () {
    \Illuminate\Support\Facades\Log::info('🔥 Closure scheduler jalan: ' . now());
    \Illuminate\Support\Facades\Log::info('Memory usage: ' . memory_get_usage(true) / 1024 / 1024 . ' MB');
})->everyTenMinutes();

// Ping endpoint external buat monitoring (optional)
// Schedule::call(function () {
//     \Illuminate\Support\Facades\Http::get('https://your-monitoring-service.com/ping');
// })->everyFiveMinutes();
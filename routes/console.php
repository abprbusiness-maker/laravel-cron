<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Schedule as ScheduleFacade;

// LOG SETIAP MENIT untuk pastikan cron jalan
ScheduleFacade::call(function () {
    Log::info('✅ CRON ACTIVE: ' . now()->format('H:i:s'));
})->everyMinute();

// Jalanin test scheduler setiap menit
// ScheduleFacade::command('discord:notify', ['⚡ Test Scheduler Every Minute'])->everyMinute();

// Atau kalo mau custom message lain:
// ScheduleFacade::command('discord:notify', ['💤 Selamat tidur! Server masih jalan nih.'])->dailyAt('00:00');

// Pilihan lain (uncomment yang lo mau):
// Setiap jam (jam 00:00, 01:00, 02:00, dst)
// ScheduleFacade::command('discord:notify', ['⏰ Hourly check-in'])->hourly();

// Setiap 6 jam
// ScheduleFacade::command('discord:notify')->everySixHours();

// Setiap hari jam tertentu
ScheduleFacade::command('discord:notify', ['☀️ Selamat pagi!'])->dailyAt('08:00');
// ScheduleFacade::command('discord:notify', ['🌆 Selamat sore!'])->dailyAt('17:00');

// Atau kalo mau test lebih jarang, setiap 5 menit
// ScheduleFacade::command('test:scheduler')->everyFiveMinutes();

// Atau setiap jam
// ScheduleFacade::command('test:scheduler')->hourly();

// Atau setiap hari jam 9 pagi
// ScheduleFacade::command('test:scheduler')->dailyAt('09:00');

// Contoh pake closure langsung
ScheduleFacade::call(function () {
    \Illuminate\Support\Facades\Log::info('🔥 Closure scheduler jalan: ' . now());
    \Illuminate\Support\Facades\Log::info('Memory usage: ' . memory_get_usage(true) / 1024 / 1024 . ' MB');
})->everyTenMinutes();

// Ping endpoint external buat monitoring (optional)
// ScheduleFacade::call(function () {
//     \Illuminate\Support\Facades\Http::get('https://your-monitoring-service.com/ping');
// })->everyFiveMinutes();
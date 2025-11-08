<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Schedule as ScheduleFacade;

// Debug: Log environment variables
// ScheduleFacade::call(function () {
//     \Illuminate\Support\Facades\Log::info('🔧 DEBUG CRON JOB', [
//         'time' => now()->format('Y-m-d H:i:s'),
//         'timezone' => config('app.timezone'),
//         'env_timezone' => env('APP_TIMEZONE'),
//         'discord_webhook_set' => !empty(env('DISCORD_WEBHOOK_URL')),
//         'memory' => memory_get_usage(true) / 1024 / 1024 . ' MB'
//     ]);
// })->everyMinute();

// LOG SETIAP MENIT untuk pastikan cron jalan
// ScheduleFacade::call(function () {
//     Log::info('✅ CRON ACTIVE: ' . now()->format('H:i:s'));
// })->everyMinute();

// Schedule yang lain tetap...
ScheduleFacade::command('discord:notify', ['☀️ Selamat pagi!'])->dailyAt('08:00');
ScheduleFacade::command('discord:main')->dailyAt('20:00');
ScheduleFacade::command('discord:weather')->dailyAt('09:00');
ScheduleFacade::command('discord:weather')->dailyAt('12:00');
ScheduleFacade::command('discord:weather')->dailyAt('15:00');
ScheduleFacade::command('discord:weather')->dailyAt('18:00');
ScheduleFacade::command('discord:weather')->dailyAt('21:00');

// Contoh pake closure langsung
// ScheduleFacade::call(function () {
//     \Illuminate\Support\Facades\Log::info('🔥 Closure scheduler jalan: ' . now());
// })->everyTenMinutes();
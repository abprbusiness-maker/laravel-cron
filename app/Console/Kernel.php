<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     */
    protected $commands = [
        // Daftarkan semua command custom di sini
        \App\Console\Commands\SendDiscordNotification::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Semua scheduler closure atau command bisa dimasukin sini
        $schedule->call(function () {
            \Illuminate\Support\Facades\Log::info('🔧 DEBUG CRON JOB', [
                'time' => now()->format('Y-m-d H:i:s'),
                'timezone' => config('app.timezone'),
                'env_timezone' => env('APP_TIMEZONE'),
                'discord_webhook_set' => !empty(env('DISCORD_WEBHOOK_URL')),
                'memory' => memory_get_usage(true) / 1024 / 1024 . ' MB'
            ]);
        })->everyMinute();

        $schedule->call(function () {
            \Illuminate\Support\Facades\Log::info('✅ CRON ACTIVE: ' . now()->format('H:i:s'));
        })->everyMinute();

        // Command custom
        $schedule->command('discord:notify', ['☀️ Selamat pagi!'])->dailyAt('09:00');

        $schedule->command('discord:notify', ['Test cepat'])->everyFiveMinutes();


        // Contoh closure lain
        $schedule->call(function () {
            \Illuminate\Support\Facades\Log::info('🔥 Closure scheduler jalan: ' . now());
        })->everyTenMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        // Auto-load semua command di folder Commands
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

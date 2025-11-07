<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Tidak perlu mendaftarkan command secara manual karena menggunakan auto-load.
     */
    protected $commands = [];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Debug log setiap menit (optional)
        $schedule->call(function () {
            \Illuminate\Support\Facades\Log::info('🔧 DEBUG CRON JOB - ' . now()->format('H:i:s'));
        })->everyMinute();

        // ✅ Jalankan discord:notify setiap 10 menit
        $schedule->command('discord:notify', ['message' => 'Scheduled ping'])
                ->everyTenMinutes()
                ->before(function () {
                    \Illuminate\Support\Facades\Log::info('🔄 DISCORD COMMAND WILL EXECUTE (10 min)');
                })
                ->onSuccess(function () {
                    \Illuminate\Support\Facades\Log::info('✅ DISCORD COMMAND SUCCESS (10 min)');
                })
                ->onFailure(function () {
                    \Illuminate\Support\Facades\Log::warning('❌ DISCORD COMMAND FAILED (10 min)');
                });

        // OPTIONAL: debug closure
        $schedule->call(function () {
            \Illuminate\Support\Facades\Log::info('🔥 Closure scheduler jalan (10 min): ' . now());
        })->everyTenMinutes();
    }


    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
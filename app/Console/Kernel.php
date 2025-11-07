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
        // Debug existing
        $schedule->call(function () {
            \Illuminate\Support\Facades\Log::info('🔧 DEBUG CRON JOB - ' . now()->format('H:i:s'));
        })->everyMinute();

        // Test: Jalankan command discord:notify setiap menit
        $schedule->command('discord:notify')
                 ->everyMinute()
                 ->before(function () {
                     \Illuminate\Support\Facades\Log::info('🔄 DISCORD COMMAND WILL EXECUTE');
                 })
                 ->onSuccess(function () {
                     \Illuminate\Support\Facades\Log::info('✅ DISCORD COMMAND SUCCESS');
                 })
                 ->onFailure(function () {
                     \Illuminate\Support\Facades\Log::info('❌ DISCORD COMMAND FAILED');
                 });

        // Atau, sebagai alternatif, kita bisa menggunakan closure untuk memanggil Artisan command
        // $schedule->call(function () {
        //     \Illuminate\Support\Facades\Artisan::call('discord:notify', [
        //         'message' => 'TEST FROM CLOSURE'
        //     ]);
        // })->everyMinute();

        $schedule->call(function () {
            \Illuminate\Support\Facades\Log::info('🔥 Closure scheduler jalan: ' . now());
        })->everyTenMinutes();
        $schedule->call(function () {
            \Illuminate\Support\Facades\Artisan::call('discord:notify', [
                'message' => 'TEST FROM CLOSURE'
            ]);
        })->everyMinute();
        $schedule->call(function () {
            \Illuminate\Support\Facades\Log::info('ENV Discord:', [
                'url' => env('DISCORD_WEBHOOK_URL')
            ]);
        })->everyMinute();
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
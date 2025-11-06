<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TestScheduler extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'test:scheduler';

    /**
     * The console command description.
     */
    protected $description = 'Test scheduler command - nulis log setiap jalan';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $timestamp = now()->format('Y-m-d H:i:s');
        $appName = config('app.name');
        $password = env('CUSTOM_PASSWORD', 'default');
        
        // Tulis ke log
        Log::info("Scheduler jalan di: {$timestamp}");
        Log::info("App Name: {$appName}");
        Log::info("Password configured: " . (env('CUSTOM_PASSWORD') ? 'Yes' : 'No'));
        
        // Output ke console
        $this->info("✅ Scheduler berhasil jalan!");
        $this->info("⏰ Waktu: {$timestamp}");
        $this->info("📱 App: {$appName}");
        
        return Command::SUCCESS;
    }
}
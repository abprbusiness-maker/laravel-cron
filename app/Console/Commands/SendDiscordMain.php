<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendDiscordMain extends Command
{
    protected $signature = 'discord:main {message?}';
    protected $description = 'Kirim notifikasi ke Discord channel via webhook';

    public function handle()
    {
        Log::info('DEBUG: Discord job dijalankan', ['env' => env('DISCORD_WEBHOOK_URL')]);
        $webhookUrl = env('DISCORD_WEBHOOK_URL');
        
        if (!$webhookUrl) {
            $this->error('❌ DISCORD_WEBHOOK_URL belum di-set di .env!');
            Log::error('Discord webhook URL tidak ditemukan');
            return Command::FAILURE;
        }

        // Ambil message dari argument atau pake default
        $customMessage = $this->argument('message');
        
        $timestamp = now()->timezone('Asia/Jakarta')->format('H:i'); // Jam WIB
        $isoTime = now()->toIso8601String();

        $payload = [
            "username" => "NightRunner Bot",
            "avatar_url" => config('app.url') . "/images.jpg",
            "embeds" => [
                [
                    "title" => "🌙 NIGHTRUNNER's CALLING!",
                    "description" =>
                        "**Time Check:** {$timestamp} WIB\n" .
                        "**Squad:** NightRunners ✅\n" .
                        "**Energy:** MAXIMUM! 🔥\n\n" .
                        "🎧 **Join Voice Channel**\n" .
                        "Yang online langsung join sekarang!\n\n" .
                        "🙋 **Belum ready?**\n" .
                        "Drop aja emoji ✋ kalau mau ikut!\n\n" .
                        "#NightRunners • #Gaming • #LetsPlay • Today {$timestamp}",
                    "color" => 10181046,
                    "footer" => [
                        "text" => "NightRunner Automated Schedule"
                    ],
                    "timestamp" => $isoTime
                ]
            ]
        ];

        try {
            $response = Http::timeout(10)->post($webhookUrl, $payload);
            
            if ($response->successful()) {
                $this->info('✅ Webhook berhasil dikirim ke Discord!');
                Log::info('Discord webhook sent successfully', [
                    'timestamp' => $timestamp,
                    'status' => $response->status()
                ]);
                return Command::SUCCESS;
            } else {
                $this->error('❌ Gagal kirim webhook. Status: ' . $response->status());
                Log::error('Discord webhook failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return Command::FAILURE;
            }
            
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            Log::error('Discord webhook exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return Command::FAILURE;
        }
    }
}
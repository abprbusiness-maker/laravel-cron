<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendDiscordNotification extends Command
{
    protected $signature = 'discord:notify {message?}';
    protected $description = 'Kirim notifikasi ke Discord channel via webhook';

    public function handle()
    {
        $webhookUrl = env('DISCORD_WEBHOOK_URL');
        
        if (!$webhookUrl) {
            $this->error('❌ DISCORD_WEBHOOK_URL belum di-set di .env!');
            Log::error('Discord webhook URL tidak ditemukan');
            return Command::FAILURE;
        }

        // Ambil message dari argument atau pake default
        $customMessage = $this->argument('message');
        
        $timestamp = now()->timezone('Asia/Jakarta')->format('Y-m-d H:i:s');
        $appName = config('app.name');
        
        // Buat payload Discord dengan embeds (lebih keren)
        $payload = [
            'username' => $appName . ' Bot',
            'avatar_url' => 'https://cdn.discordapp.com/embed/avatars/0.png',
            'embeds' => [
                [
                    'title' => $customMessage ?: '🤖 Scheduler Notification',
                    'description' => $customMessage ?: 'Halo bro! Scheduler Laravel gue jalan nih.',
                    'color' => 3447003, // Biru
                    'fields' => [
                        [
                            'name' => '⏰ Waktu',
                            'value' => $timestamp,
                            'inline' => true
                        ],
                        [
                            'name' => '🚀 App',
                            'value' => $appName,
                            'inline' => true
                        ],
                        [
                            'name' => '🌍 Environment',
                            'value' => config('app.env'),
                            'inline' => true
                        ],
                        [
                            'name' => '📊 Status',
                            'value' => '✅ Running',
                            'inline' => true
                        ]
                    ],
                    'footer' => [
                        'text' => 'Laravel Scheduler on Zeabur'
                    ],
                    'timestamp' => now()->toIso8601String()
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
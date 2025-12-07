<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

function calculateRainProbability($tp, $tcc, $ws)
{
    // Normalisasi nilai
    $tp_norm = min($tp / 20, 1);       // Curah hujan dihitung 0–20 mm
    $tcc_norm = $tcc / 100;           // Tutupan awan 0–100%
    $ws_norm = min($ws / 20, 1);      // Kecepatan angin 0–20 km/jam

    // Bobot pengaruh
    $prob =
        ($tp_norm * 0.6) +            // Curah hujan paling berpengaruh
        ($tcc_norm * 0.3) +           // Tutupan awan
        ($ws_norm * 0.1);             // Angin

    return round($prob * 100);        // persen
}

function interpretRainChance($percent)
{
    if ($percent >= 80) {
        return [
            'label' => '⚠️ Sangat Berpotensi Hujan',
            'emoji' => '⛈️'
        ];
    } elseif ($percent >= 60) {
        return [
            'label' => '🌧️ Potensi Hujan Tinggi',
            'emoji' => '🌧️'
        ];
    } elseif ($percent >= 40) {
        return [
            'label' => '🌦️ Peluang Hujan Sedang',
            'emoji' => '🌦️'
        ];
    } elseif ($percent >= 20) {
        return [
            'label' => '🌤️ Peluang Hujan Rendah',
            'emoji' => '🌤️'
        ];
    }

    return [
        'label' => '☀️ Hampir Tidak Berpeluang Hujan',
        'emoji' => '☀️'
    ];
}

class SendWeatherToDiscord extends Command
{
    protected $signature = 'discord:weather';
    protected $description = 'Kirim info cuaca terkini dari BMKG ke Discord';

    public function handle()
    {
        $webhookUrl = env('DISCORD_WEBHOOK_URL_WEATHER');
        $adm4 = '31.73.05.1002';

        if (!$webhookUrl) {
            $this->error('❌ DISCORD_WEBHOOK_URL belum di-set.');
            return Command::FAILURE;
        }

        try {
            $apiUrl = "https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4={$adm4}";

            $response = Http::timeout(15)->get($apiUrl);

            if (!$response->successful()) {
                Log::error("BMKG ERROR", ['body' => $response->body()]);
                $this->error("Gagal fetch BMKG.");
                return Command::FAILURE;
            }

            $json = $response->json();

            // Ambil data cuaca pertama (paling dekat ke jam sekarang)
            $firstData = $json['data'][0]['cuaca'][0][0];

            $lokasi = $json['lokasi'];
            $desa = $lokasi['desa'];
            $kecamatan = $lokasi['kecamatan'];
            $kotkab = $lokasi['kotkab'];

            // Extract
            $desc = $firstData['weather_desc'];
            $icon = $firstData['image'];
            $temp = $firstData['t'];
            $humidity = $firstData['hu'];
            $tp = $firstData['tp'] ?? 0;
            $tcc = $firstData['tcc'] ?? 0;   // Tutupan awan
            $ws = $firstData['ws'] ?? 0;    // Wind speed (alias $wind)
            $localTime = $firstData['local_datetime'];

            $timestamp = now()->timezone('Asia/Jakarta')->toIso8601String();

            // Hitung probabilitas hujan
            $rainPercent = calculateRainProbability($tp, $tcc, $ws);

            // Interpretasi (emoji + teks)
            $rainInfo = interpretRainChance($rainPercent);
            $rainLabel = $rainInfo['label'];
            $rainEmoji = $rainInfo['emoji'];

            // Embed Discord
            $payload = [
                'username' => 'NightRunner Bot',
                'avatar_url' => 'https://laravel-cron.zeabur.app/images.jpg',
                'embeds' => [
                    [
                        'title' => "🌤️ Weather Pulse",
                        'description' =>
                            "**Lokasi:** {$desa}, {$kecamatan}, {$kotkab}\n"
                            . "**Waktu:** {$localTime} WIB\n\n"
                            . "**Cuaca:** {$desc}\n"
                            . "**Suhu:** {$temp}°C\n"
                            . "**Kelembapan:** {$humidity}%\n"
                            . "**Angin:** {$ws} km/jam\n"
                            . "**Curah Hujan:** {$tp} mm\n\n"
                            . "**Peluang Hujan:** {$rainPercent}% {$rainEmoji}\n"
                            . "{$rainLabel}\n\n"
                            . "_Sumber data: BMKG_",
                        'color' => 10181046,
                        'thumbnail' => [
                            'url' => $icon
                        ],
                        'footer' => [
                            'text' => 'NightRunner Automated Weather • BMKG'
                        ],
                        'timestamp' => $timestamp
                    ]
                ]
            ];

            $send = Http::timeout(10)->post($webhookUrl, $payload);

            if ($send->successful()) {
                $this->info("✅ Weather berhasil dikirim!");
                return Command::SUCCESS;
            } else {
                Log::error("DISCORD ERROR", ['body' => $send->body()]);
                $this->error("Gagal kirim ke Discord.");
                return Command::FAILURE;
            }

        } catch (\Exception $e) {
            Log::error("WEATHER ERROR", ['msg' => $e->getMessage()]);
            $this->error("Error: {$e->getMessage()}");
            return Command::FAILURE;
        }
    }
}

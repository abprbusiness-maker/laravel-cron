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
        $adm4 = '31.73.06.1003'; // ✅ Tegal Alur

        if (!$webhookUrl) {
            $this->error('❌ DISCORD_WEBHOOK_URL belum di-set.');
            return Command::FAILURE;
        }

        try {
            $apiUrl = "https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4={$adm4}";

            // Fetch dari BMKG (GET request)
            $response = Http::timeout(10)->get($apiUrl);

            if (!$response->successful()) {
                Log::error("BMKG ERROR", ['body' => $response->body()]);
                $this->error("Gagal fetch BMKG.");
                return Command::FAILURE;
            }

            $json = $response->json();

            // 🔍 DEBUG: Cek struktur data BMKG
            Log::info('BMKG RESPONSE', ['json' => $json]);

            // Validasi struktur data
            if (empty($json['data']) || empty($json['lokasi'])) {
                Log::error('BMKG INVALID STRUCTURE', ['response' => $json]);
                $this->error("Data BMKG tidak valid.");
                return Command::FAILURE;
            }

            // Ambil data dengan cara yang lebih aman
            $cuacaData = $json['data'][0]['cuaca'] ?? [];
            if (empty($cuacaData)) {
                Log::error('BMKG NO WEATHER DATA');
                $this->error("Tidak ada data cuaca.");
                return Command::FAILURE;
            }

            $firstData = $cuacaData[0][0] ?? [];

            $lokasi = $json['lokasi'];
            $desa = $lokasi['desa'] ?? 'Unknown';
            $kecamatan = $lokasi['kecamatan'] ?? 'Unknown';
            $kotkab = $lokasi['kotkab'] ?? 'Unknown';

            // Extract dengan default values yang lebih baik
            $desc = $firstData['weather_desc'] ?? 'Tidak tersedia';
            $temp = $firstData['t'] ?? 0;
            $humidity = $firstData['hu'] ?? 0;
            $tp = floatval($firstData['tp'] ?? 0);
            $tcc = floatval($firstData['tcc'] ?? 0);
            $ws = floatval($firstData['ws'] ?? 0);
            $icon = $firstData['image'] ?? 'https://laravel-cron.zeabur.app/default.png';
            if (!empty($icon)) {
                $icon = str_replace(' ', '%20', $icon); // encode spasi
            }

            $localTime = $firstData['local_datetime'] ?? now()->timezone('Asia/Jakarta')->format('Y-m-d H:i:s');
            $timestamp = now()->timezone('Asia/Jakarta')->toIso8601String();

            // Hitung probabilitas hujan
            $rainPercent = calculateRainProbability($tp, $tcc, $ws);
            $rainInfo = interpretRainChance($rainPercent);

            // Build description (TANPA indentasi heredoc!)
            $description = "**Lokasi:** {$desa}, {$kecamatan}, {$kotkab}\n"
                . "**Waktu:** {$localTime} WIB\n\n"
                . "**Cuaca:** {$desc}\n"
                . "**Suhu:** {$temp}°C\n"
                . "**Kelembapan:** {$humidity}%\n"
                . "**Angin:** {$ws} km/jam\n"
                . "**Curah Hujan:** {$tp} mm\n\n"
                . "**Peluang Hujan:** {$rainPercent}% {$rainInfo['emoji']}\n"
                . "{$rainInfo['label']}\n\n"
                . "_Sumber data: BMKG_";


            // Embed Discord dengan struktur yang lebih strict
            $payload = [
                'username' => 'NightRunner Bot',
                'avatar_url' => 'https://laravel-cron.zeabur.app/images.jpg',
                'embeds' => [
                    [
                        'title' => '🌤️ Weather Pulse',
                        'description' => $description,
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

            // Debug payload sebelum kirim
            Log::info('DISCORD PAYLOAD', ['payload' => $payload]);

            $send = Http::timeout(10)->asJson()->post($webhookUrl, $payload);

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
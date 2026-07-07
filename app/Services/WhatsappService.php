<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    /**
     * Kirim pesan WhatsApp
     *
     * @param string $noTelp Nomor tujuan (Contoh: 08123456789 atau 628123456789)
     * @param string $pesan Isi pesan teks
     */
    public static function send($noTelp, $pesan)
    {
        // 1. Standarisasi nomor telepon ke format 62...
        if (substr($noTelp, 0, 1) === '0') {
            $noTelp = '62' . substr($noTelp, 1);
        } elseif (substr($noTelp, 0, 2) !== '62') {
            $noTelp = '62' . $noTelp;
        }

        // 2. Tembak API Gateway WA (Contoh di bawah menggunakan Fonnte)
        // Silakan ganti URL & TOKEN sesuai penyedia API WA yang kamu pakai nanti saat deploy
        $token = env('WHATSAPP_TOKEN', 'CONTOH_TOKEN_FONNTE_KAMU_DISINI');

        try {
            $response = Http::withHeaders([
                'Authorization' => $token
            ])->post('https://api.fonnte.com/send', [
                'target' => $noTelp,
                'message' => $pesan,
                'countryCode' => '62', // default Indonesia
            ]);

            Log::info("WA Terkirim ke {$noTelp}. Response: " . $response->body());
            return $response->successful();
        } catch (\Exception $e) {
            Log::error("Gagal kirim WA ke {$noTelp}. Error: " . $e->getMessage());
            return false;
        }
    }
}
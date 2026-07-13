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
        // 1. Bersihkan nomor dari spasi atau karakter aneh, lalu standarisasi ke 62...
        $noTelp = preg_replace('/[^0-9]/', '', $noTelp);
        if (substr($noTelp, 0, 1) === '0') {
            $noTelp = '62' . substr($noTelp, 1);
        } elseif (substr($noTelp, 0, 2) !== '62') {
            $noTelp = '62' . $noTelp;
        }

        $token = 'gpFpzb4KSSFEDvJbmFoH';

        try {
            // 🔥 TAMBAHKAN ->withoutVerifying() di bawah ini untuk bypass error cURL 60
            $response = Http::withHeaders([
                'Authorization' => $token
            ])->asForm()->withoutVerifying()->post('https://api.fonnte.com/send', [
                'target' => $noTelp,
                'message' => $pesan,
                'countryCode' => '62',
            ]);

            Log::info("WA Terkirim ke {$noTelp}. Response: " . $response->body());
            return $response->successful();
        } catch (\Exception $e) {
            Log::error("Gagal kirim WA ke {$noTelp}. Error: " . $e->getMessage());
            return false;
        }
    }
}

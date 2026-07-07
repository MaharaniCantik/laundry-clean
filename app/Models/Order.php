<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // 1. Kasih tahu Laravel kalau model ini berpasangan dengan tabel 'orders' di Supabase
    protected $table = 'orders';
    protected $appends = ['satuan'];

    // 2. Daftarkan kolom-kolom yang ada di database kamu agar diizinkan dibaca oleh Laravel
    protected $fillable = [
        'id',
        'user_id',
        'kurir_id',
        'nama_pelanggan',
        'jenis_layanan',
        'alamat_lengkap',
        'jarak_km',
        'ongkos_kirim',
        'berat_laundry',
        'metode_pembayaran',
        'tipe_durasi',
        'status',
        'total_harga',
        'instruksi_pencucian',
        'created_at',
        'updated_at'
    ];

    // Di dalam class Order extends Model
    public function getSatuanAttribute()
    {
        // Ubah data string menjadi lowercase agar pencarian tidak sensitif huruf kapital
        $layanan = strtolower($this->jenis_layanan ?? '');

        // 1. Kelompok Meter Persegi (m²)
        if (str_contains($layanan, 'gorden') || str_contains($layanan, 'permadani') || str_contains($layanan, 'karpet')) {
            return 'm²';
        }

        // 2. Kelompok Pasang
        if (str_contains($layanan, 'sepatu')) {
            return 'pasang';
        }

        // 3. Kelompok Pcs
        if (str_contains($layanan, 'boneka') || str_contains($layanan, 'bedcover')) {
            return 'pcs';
        }

        // 4. Kelompok Kiloan / Setrika Only (Default)
        if (str_contains($layanan, 'kiloan') || str_contains($layanan, 'setrika')) {
            return 'kg';
        }

        return 'kg'; // Fallback aman jika tidak terdeteksi
    }

    public function kurir()
{
    return $this->belongsTo(\App\Models\Kurir::class, 'kurir_id', 'id');
}
}

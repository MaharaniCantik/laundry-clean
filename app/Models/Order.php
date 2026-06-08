<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // 1. Kasih tahu Laravel kalau model ini berpasangan dengan tabel 'orders' di Supabase
    protected $table = 'orders'; 

    // 2. Daftarkan kolom-kolom yang ada di database kamu agar diizinkan dibaca oleh Laravel
   protected $fillable = [
    'id',
    'user_id',
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
}
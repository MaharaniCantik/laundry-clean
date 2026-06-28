<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'nik',
    'nama_lengkap',
    'email',
    'no_hp',
    'kendaraan',
    'plat_nomor',
    'area_tugas',
    'status_kerja', // 🔥 PASTIKAN INI ADA
    'status_aktif'
    ];// Sesuaikan kolom Anda

    /**
     * Scope untuk mengambil satu kurir acak yang berstatus tersedia (available)
     */
    public static function getRandomAvailableKurir()
    {
        // Mencari kurir yang statusnya 'available' dan user_id tidak kosong, lalu diacak (inRandomOrder)
        return self::where('status', 'available')
                   ->whereNotNull('user_id')
                   ->inRandomOrder()
                   ->first();
    }
}
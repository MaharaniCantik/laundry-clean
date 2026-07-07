<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    use HasFactory;

    // Pastikan nama tabelnya disesuaikan dengan database Supabase lu (biasanya 'kurirs' atau 'kurir')
    protected $table = 'kurirs';

    protected $fillable = [
        'user_id',
        'nik',
        'nama_lengkap',
        'email',
        'no_hp',
        'kendaraan',
        'plat_nomor',
        'area_tugas',
        'status_kerja',
        'status_aktif'
    ];

    /**
     * Scope untuk mengambil satu kurir acak yang berstatus tersedia (available)
     */
    public static function getRandomAvailableKurir()
    {
        return self::where('status_kerja', 'available')
            ->whereNotNull('user_id')
            ->inRandomOrder()
            ->first();
    }

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
}
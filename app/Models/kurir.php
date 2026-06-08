<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    use HasFactory;

    protected $table = 'kurirs';

    protected $fillable = ['nik', 'nama_lengkap', 'email', 'no_hp', 'kendaraan', 'plat_nomor', 'area_tugas', 'status_kerja'];
    // Relasi ke User (Jika kurir ingin melihat data loginnya)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
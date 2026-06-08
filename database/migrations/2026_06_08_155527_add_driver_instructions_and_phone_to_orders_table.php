<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk menambahkan kolom ke Supabase.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Menambahkan kolom nomor telepon pengiriman/penjemputan setelah kolom alamat_lengkap
            $table->string('nomor_telepon_order')->nullable()->after('alamat_lengkap');
            
            // Menambahkan kolom instruksi khusus untuk driver/kurir setelah nomor telepon order
            $table->text('instruksi_driver')->nullable()->after('nomor_telepon_order');
        });
    }

    /**
     * Batalkan migrasi (jika diperlukan rollback).
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Menghapus kembali kolom jika migrasi di-rollback
            $table->dropColumn(['nomor_telepon_order', 'instruksi_driver']);
        });
    }
};
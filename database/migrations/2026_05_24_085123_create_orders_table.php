<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel users (pake foreignId agar otomatis sinkron dengan id di tabel users)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('nama_pelanggan')->nullable();
            $table->text('alamat_lengkap')->nullable();
            $table->decimal('jarak_km', 8, 2)->default(0);
            $table->decimal('ongkos_kirim', 12, 2)->default(0);
            $table->decimal('berat_laundry', 8, 2)->default(1);
            $table->string('metode_pembayaran', 50);
            $table->text('instruksi_pencucian')->nullable();
            $table->string('status', 50)->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
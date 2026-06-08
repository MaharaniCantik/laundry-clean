<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('kurirs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
        $table->string('nik', 16)->unique();
        $table->string('nama_lengkap');
        $table->string('no_hp');
        $table->string('email')->unique();
        
        // Kolom tambahan penunjang tampilan Admin Lu
        $table->string('kendaraan')->nullable();     // Contoh: Honda Vario / Suzuki Gran Max
        $table->string('plat_nomor')->nullable();    // Contoh: B 4123 SKZ
        $table->string('area_tugas')->nullable();    // Contoh: Jakarta Selatan
        
        // Menampung 3 status sesuai dropdown filter di Blade lu
        $table->enum('status_kerja', ['available', 'on-delivery', 'inactive'])->default('available'); 
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('kurirs');
    }
};
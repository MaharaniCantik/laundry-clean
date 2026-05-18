<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom role setelah kolom password
            // Kita gunakan enum agar pilihan role-nya terbatas/pasti
            $table->enum('role', ['admin', 'owner', 'kurir', 'user'])->default('user')->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kolom role jika migration dibatalkan
            $table->dropColumn('role');
        });
    }
};

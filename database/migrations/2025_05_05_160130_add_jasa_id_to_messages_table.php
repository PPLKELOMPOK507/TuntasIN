<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migrasi
     */
    public function up(): void
    {
        // Kosongkan karena kolom jasa_id sudah ada di tabel messages
        // Ini mencegah duplikasi kolom yang sama
    }

    /**
     * Membatalkan migrasi
     */
    public function down(): void
    {
        // Kosongkan karena tidak perlu mengembalikan perubahan
        // Kolom jasa_id akan tetap ada karena dibuat di migrasi lain
    }
};

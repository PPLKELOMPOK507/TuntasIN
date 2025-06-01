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
        Schema::table('reviewratings', function (Blueprint $table) {
            $table->foreignId('pemesanan_id')
                  ->after('jasa_id')
                  ->constrained('pemesanans')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviewratings', function (Blueprint $table) {
            $table->dropForeign(['pemesanan_id']);
            $table->dropColumn('pemesanan_id');
        });
    }
};

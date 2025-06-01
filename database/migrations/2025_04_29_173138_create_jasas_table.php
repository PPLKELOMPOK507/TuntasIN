<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJasasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jasas', function (Blueprint $table) {
            $table->id(); // ID auto-increment
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_jasa'); // nama jasa
            $table->text('deskripsi'); // deskripsi jasa
            $table->integer('minimal_harga'); // minimal harga (harus integer)
            $table->string('gambar')->nullable(); // nama file gambar (opsional)
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jasas');
    }
}

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
        Schema::create('reviewratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('jasa_id')->references('id')->on('jasas')->onDelete('cascade');
            $table->integer('rating')->comment('Rating 1-5');
            $table->text('review')->nullable();
            $table->timestamps();
            
            // Memastikan satu user hanya bisa review satu jasa satu kali
            $table->unique(['user_id', 'jasa_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviewratings');
    }
};

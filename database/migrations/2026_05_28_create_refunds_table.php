<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemesanan_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('reason');
            $table->text('bukti_refund')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            // Kolom untuk penyedia jasa
            $table->text('provider_response')->nullable();
            $table->timestamp('provider_responded_at')->nullable();
            // Kolom untuk admin
            $table->text('admin_notes')->nullable();
            $table->timestamp('admin_reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('refunds');
    }
};
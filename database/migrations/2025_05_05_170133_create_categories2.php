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
        Schema::create('categories2', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::table('jasas', function (Blueprint $table) {
            $table->foreignId('category_id')
                  ->nullable()
                  ->after('user_id')
                  ->constrained()
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jasas', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });

        Schema::dropIfExists('categories2');
    }
};

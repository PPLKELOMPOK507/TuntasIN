<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('refunds', function (Blueprint $table) {
            $table->timestamp('provider_responded_at')->nullable()->after('provider_response');
            $table->string('provider_response')->nullable()->change(); // Make sure provider_response exists and is nullable
        });
    }

    public function down(): void
    {
        Schema::table('refunds', function (Blueprint $table) {
            $table->dropColumn('provider_responded_at');
        });
    }
};
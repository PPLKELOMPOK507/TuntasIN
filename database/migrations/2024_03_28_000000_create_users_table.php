<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('role', ['Admin', 'Penyedia Jasa', 'Pengguna Jasa']);
            $table->string('email')->unique();
            $table->string('mobile_number');
            $table->string('photo')->nullable();
            $table->string('password');
            $table->decimal('balance', 10, 2)->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
        
    }
};
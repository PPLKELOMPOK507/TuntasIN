<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'System',
            'role' => 'Admin', // Pastikan role Admin sudah ditambahkan di enum
            'email' => 'admin@tuntasin.com',
            'mobile_number' => '081234567890',
            'password' => Hash::make('admin123'),
        ]);
    }
}
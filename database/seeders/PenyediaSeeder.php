<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenyediaSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'email' => 'penyedia@gmail.com',
            'first_name' => 'Danis',
            'last_name' => 'Apta',
            'role' => 'penyedia jasa', // Pastikan role Admin sudah ditambahkan di enum
            'mobile_number' => '081234567890',
            'password' => Hash::make('12345678'),
        ]);
    }
}
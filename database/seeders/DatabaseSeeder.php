<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
        ]);

        $this->call(AdminSeeder::class);
        $faker = Faker::create();

        foreach (range(1, 10) as $i) {
            DB::table('users')->insert([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'role' => $faker->randomElement(['Penyedia Jasa', 'Pengguna Jasa']),
                'email' => $faker->unique()->safeEmail,
                'mobile_number' => $faker->phoneNumber,
                'photo' => $faker->imageUrl(200, 200, 'people', true),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

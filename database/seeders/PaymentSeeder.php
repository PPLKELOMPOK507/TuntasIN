<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PaymentSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Misal, isi 10 data pembayaran dummy
        foreach (range(1, 10) as $index) {
            DB::table('payments')->insert([
                'user_id' => rand(1, 5), // sesuaikan dengan user yang sudah ada
                'amount' => $faker->randomFloat(2, 10, 500),
                'payment_method' => $faker->randomElement(['credit_card', 'paypal', 'bank_transfer']),
                'status' => $faker->randomElement(['pending', 'completed', 'failed']),
                'payment_reference' => strtoupper(Str::random(10)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

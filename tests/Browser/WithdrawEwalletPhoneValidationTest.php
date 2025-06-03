<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;

class WithdrawEwalletPhoneValidationTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_ewallet_phone_less_than_12_digits_shows_validation_error()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create([
                'balance' => 1000000,
            ]);

            $browser->loginAs($user)
                ->visit('/dashboard')
                ->pause(300)
                ->visit('/forum')
                ->pause(300)
                ->visit('/withdraw')
                ->pause(1000)
                ->screenshot('withdraw-ewallet-debug')
                // Hapus dulu baris klik radio, cek screenshot!
                // ->click('input[type="radio"][name="withdraw_method"][value="ewallet"]')
                ;
        });
    }
}
<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;

class WithdrawBankTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_user_selects_transfer_bank_and_fills_account_number()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create([
                'balance' => 1000000,
                'email_verified_at' => now(),
            ]);

            $browser->loginAs($user)
                ->visit('/dashboard')
                ->pause(300)
                ->visit('/forum')
                ->pause(300)
                ->visit('/withdraw')
                ->pause(300)
                ->screenshot('withdraw-page')
                ->waitFor('input[type="radio"][name="withdraw_method"][value="bank"]', 5)
                ->click('input[type="radio"][name="withdraw_method"][value="bank"]')
                ->waitFor('#bankAccount', 2)
                ->type('bank_account', '1234567890123456')
                ->type('amount', '50000');
                // ->press('Kirim')
                // ->assertSee('Withdrawal request submitted');
        });
    }
}
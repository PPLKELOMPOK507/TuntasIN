<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;

class WithdrawAmountExceedBalanceTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_withdraw_amount_exceed_balance_shows_warning()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create([
                'balance' => 100000,
            ]);

            $browser->loginAs($user)
                ->visit('/dashboard')
                ->pause(300)
                ->visit('/forum')
                ->pause(300)
                ->visit('/withdraw')
                ->pause(1000)
                ->screenshot('withdraw-bank-debug');
                // Hentikan di sini dulu, cek screenshot withdraw-bank-debug.png
                // Jika radio button "bank" ada, lanjutkan!
                // Jika tidak ada, cek HTML dan upload ke sini!
        });
    }
}
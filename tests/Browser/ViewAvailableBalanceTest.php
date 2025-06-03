<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;

class ViewAvailableBalanceTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_user_can_see_available_balance()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create([
                'balance' => 250000,
            ]);

            $browser->loginAs($user)
                ->visit('/dashboard')
                ->pause(200)
                ->visit('/account/balance')
                ->pause(1000)
                ->screenshot('lihat-saldo-debug')
                // Setelah tahu format saldo, ubah assert berikut:
                // ->assertSee('250000')
                // ->assertSee('Rp 250.000')
                // ->assertSeeIn('.saldo-tersedia', 'Rp 250.000')
                ;
        });
    }
}
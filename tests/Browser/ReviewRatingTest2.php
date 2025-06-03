<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ReviewRatingTest2 extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'pengguna@gmail.com')
                    ->type('password', '12345678')
                    ->press('Login')
                    ->assertPathIs('/dashboard')
                    ->click('.user-profile')
                    ->clickLink('Riwayat Pembelian')
                    ->assertPathIs('/riwayat-pembelian')
                    ->click('.btn-review')
                    ->pause(1000) // Pastikan modal/form review muncul
                    ->click('label[for="star5"]')
                    ->type('review', 'Baik dan bagus')
                    ->press('Kirim Review');
        });
    }
}

<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ReviewRatingTest3 extends DuskTestCase
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
                    ->waitFor('.btn-review', 5)
                    ->click('.btn-review')
                    ->pause(1000) 
                    ->waitFor('label[for="star3"]', 5)
                    ->click('label[for="star3"]')
                    ->type('review', 'Bagus')
                    ->press('Kirim Review')
                    ->pause(3000) 
                    ->waitFor('span.text-danger', 10) 
                    ->assertSeeIn('span.text-danger', 'The review field must be at least 10 characters.');

        });
    }
}

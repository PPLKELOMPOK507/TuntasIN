<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ReviewRatingTest4 extends DuskTestCase
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
                    ->waitFor('.btn-edit-review', 5)
                    ->click('.btn-edit-review')
                    ->waitFor('label[for="star4"]', 5)
                    ->click('label[for="star4"]')
                    ->type('review', 'Sangat memuaskan dan profesional!')
                    ->press('.btn-submit')
                    ->pause(2000);

        });
    }
}

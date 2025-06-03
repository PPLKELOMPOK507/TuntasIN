<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TotalRefaundTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group awww
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->press('Login')
                ->type('email', 'admin@tuntasin.com')
                ->type('password', 'admin123')
                ->press('Login')
                ->assertPathIs('/manage')
                ->click('label[for="refunds-tab"]');
        });
    }
}

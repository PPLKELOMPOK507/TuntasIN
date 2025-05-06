<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group log
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'john.doe@example.com')
                    ->type('password', 'password123')
                    ->press('Login')
                    ->assertPathIs('/dashboard');

        });
    }
}

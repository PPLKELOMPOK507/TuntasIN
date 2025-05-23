<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group regs
     */

    use DatabaseMigrations;
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
            ->type('first_name', 'rizki')
            ->type('last_name', 'apta')
            ->type('email', 'johndoe@email.com')
            ->select('user_as', 'Penyedia Jasa')
            ->type('mobile_number', '081234567890')
            ->type('password', '')
            ->press('Done')
            ->pause(500)
            ->waitFor('.alert-danger', 5)
            ->assertSee('The password field is required.');
        });
    }
}
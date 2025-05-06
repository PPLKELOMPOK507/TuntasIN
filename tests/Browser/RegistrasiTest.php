<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegistrasiTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group regs
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
            ->type('first_name', 'John')
                ->type('last_name', 'Doe')
                ->type('email', 'john.doe@example.com')
                ->select('user_as', 'Penyedia Jasa')
                ->type('mobile_number', '081234567890')
                ->type('password', 'password123')
                ->press('Done');
        });
    }
}

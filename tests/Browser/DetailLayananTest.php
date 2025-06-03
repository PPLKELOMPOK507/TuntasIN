<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DetailLayananTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group detail-layanan
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/jasa/1');
        });
    }
}

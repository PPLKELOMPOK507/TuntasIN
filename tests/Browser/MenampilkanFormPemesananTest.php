<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MenampilkanFormPemesananTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group auah
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/pesan/1');
        });
    }
}

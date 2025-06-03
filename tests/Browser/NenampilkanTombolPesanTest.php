<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class NenampilkanTombolPesanTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group nenampilkan-tombol-pesan
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/pesan/1')
                ->assertPathIs('/pesan/1');
        });
    }
}

<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ChatNegosiasiTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group chat-negosiasi
     */
    public function testExample(): void
    {
        $jasaId = 1; // Ganti dengan ID jasa yang valid di database Anda

        $this->browse(function (Browser $browser) use ($jasaId) {
            $browser->visit("/jasa/{$jasaId}")
                ->assertSee('Curhat YUKKSSS')
                ->press('Curhat YUKKSSS')
                ->assertPathIs("/chat/{$jasaId}")
                ->assertSee('Negosiasi')
                ->type('message', 'Halo, saya ingin menanyakan tentang jasa ini.')
                ->press('Kirim')
                ->assertSee('Halo, saya ingin menanyakan tentang jasa ini.');
        });
    }
}

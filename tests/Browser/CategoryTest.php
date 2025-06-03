<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoryTest extends DuskTestCase
{
    /**
     * Test creating a new category
     * @group cat
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                // Login sebagai admin
                ->type('email', 'admin@tuntasin.com')
                ->type('password', 'admin123')
                ->press('Login')
                // Verifikasi di dashboard admin
                ->assertPathIs('/manage')
                ->click('label[for="categories-tab"]')
                // Tunggu section kategori muncul
                ->click('.edit-btn')
                ->type('name', 'Kesehatan')
                ->press('Simpan Perubahan')
                ->assertSee('The name has already been taken.');

        });
    }
}

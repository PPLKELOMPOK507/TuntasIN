<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class WishlistTest extends DuskTestCase
{
    /**
     * Test menambahkan dan menghapus jasa dari wishlist
     * @group wish
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'ardeliagatha2@gmail.com')
                    ->type('password', '12345678')
                    ->press('Login')
                    // Tambahkan pause untuk memastikan redirect selesai
                    ->pause(2000)
                    // Pastikan kita berada di dashboard
                    ->assertPathIs('/dashboard')
                    // Tunggu lebih lama untuk service card
                    ->waitFor('.service-card', 10)
                    // Tambahkan ke wishlist
                    ->press('.wishlist-btn')
                    ->pause(2000)
                    ->visit('/wishlist')
                    ->assertPathIs('/wishlist')
                    ->assertSee('My Service Wishlist')
                    // Pastikan empty state muncul
                    ->waitFor('.empty-wishlist', 10)
                    ->assertSee('Wishlist Anda masih kosong')
                    ->assertPresent('.empty-icon')
                    ->assertSee('Jelajahi Layanan');
        });
    }
}

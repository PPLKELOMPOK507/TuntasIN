<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Jasa;
use App\Models\Category;
use App\Models\Pemesanan;

class ReviewRating3Test extends DuskTestCase
{
    use DatabaseMigrations;
    
    public function testExample(): void
    {
        // Create test user
        $user = User::create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'pengguna@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'Pengguna Jasa',
            'mobile_number' => '081234567890'
        ]);

        // Create category
        $category = Category::create([
            'name' => 'Test Category'
        ]);

        // Create service provider
        $provider = User::create([
            'first_name' => 'Provider',
            'last_name' => 'Test',
            'email' => 'provider@test.com',
            'password' => bcrypt('password123'),
            'role' => 'Penyedia Jasa',
            'mobile_number' => '081234567891'
        ]);

        // Create service
        $jasa = Jasa::create([
            'user_id' => $provider->id,
            'category_id' => $category->id,
            'nama_jasa' => 'Test Service',
            'deskripsi' => 'Test Description',
            'minimal_harga' => 100000,
            'gambar' => 'test.jpg'
        ]);

        // Create order with paid status
        $pemesanan = Pemesanan::create([
            'user_id' => $user->id,
            'jasa_id' => $jasa->id,
            'harga' => 150000,
            'status' => 'paid',
            'tanggal_mulai' => now(),
            'catatan' => 'Test order'
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', 'pengguna@gmail.com')
                    ->type('password', '12345678')
                    ->press('Login')
                    ->assertPathIs('/dashboard')
                    ->pause(1000) // Add pause after login
                    
                    // Navigate to purchase history
                    ->waitFor('.dropdown-toggle') // Wait for dropdown menu
                    ->click('.dropdown-toggle') // Click to open dropdown
                    ->pause(500) // Wait for dropdown animation
                    ->clickLink('Riwayat Pembelian')
                    ->waitForPath('/riwayat-pembelian')
                    ->pause(1000) // Wait for page load
                    
                    // Find and click review button
                    ->waitFor('.btn-review')
                    ->click('.btn-review')
                    ->pause(1000) // Wait for modal/form to load
                    
                    // Fill review form
                    ->waitFor('.star-rating')
                    ->radio('rating', '5')
                    ->type('review', 'bagus dan baik')
                    
                    // Submit review
                    ->press('Kirim Review')
                    ->waitForPath('/riwayat-pembelian')
                    ->assertSee('Review berhasil ditambahkan');
        });
    }
}

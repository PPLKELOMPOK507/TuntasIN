<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Jasa;
use App\Models\Category;
use App\Models\Pemesanan;

class ReviewRating2Test extends DuskTestCase
{
    use DatabaseMigrations;

    public function testExample(): void
    {
        // Buat user pengguna jasa
        $user = User::create([
            'first_name' => 'Ardelia',
            'last_name' => 'Luthfi Agata',
            'email' => 'pengguna@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'Pengguna Jasa',
            'mobile_number' => '087749019312'
        ]);

        // Buat kategori
        $category = Category::create([
            'name' => 'cobates'
        ]);

        // Buat penyedia jasa
        $provider = User::create([
            'first_name' => 'Ardelia',
            'last_name' => 'Agata',
            'email' => 'penyedia@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'Penyedia Jasa',
            'mobile_number' => '087749019312'
        ]);

        // Buat jasa
        $jasa = Jasa::create([
            'user_id' => $provider->id,
            'category_id' => $category->id,
            'nama_jasa' => 'Jasa Buat Logo',
            'deskripsi' => 'cobates',
            'minimal_harga' => 100000,
            'gambar' => 'wishlist.png'
        ]);

        // Buat pemesanan dengan status selesai
        $pemesanan = Pemesanan::create([
            'user_id' => $user->id,
            'jasa_id' => $jasa->id,
            'harga' => 150000,
            'status' => 'paid',
            'tanggal_mulai' => now(),
            'catatan' => 'Test order'
        ]);

        $this->browse(function (Browser $browser) use ($pemesanan) {
            $browser->visit('/login')
                    ->type('email', 'pengguna@gmail.com')
                    ->type('password', '12345678')
                    ->press('Login')
                    ->assertPathIs('/dashboard')
                    ->pause(1000)
                    
                    // Ke halaman riwayat pembelian
                    ->visit('/riwayat-pembelian')
                    ->pause(1000)
                    
                    // Klik tombol Beri Review
                    ->waitFor('.btn-review')
                    ->click('.btn-review')
                    ->pause(2000)

                                        // Tunggu modal muncul
                    ->waitFor('#reviewModal-' . $pemesanan->id)
                    
                    // Isi form review
                    ->waitFor('textarea[name="review"]')
                    ->type('review', 'bagus dan baik')
                    ->radio('rating', '5')
                    ->press('Kirim Review')
                    ->pause(2000)
                    
                    // Verifikasi review berhasil
                    ->assertSee('Review berhasil ditambahkan')
                    ->assertPathIs('/riwayat-pembelian');
        });
    }
}
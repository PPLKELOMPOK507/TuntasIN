<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;

class ForumCategoryEndToEndTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_admin_create_category_user_create_post_and_filter()
    {
        $this->browse(function (Browser $browser, Browser $browser2) {
            // 1. Buat akun admin dan user
            $admin = User::factory()->create([
                'email' => 'admin@site.com', 'password' => bcrypt('password')
            ]);
            $user = User::factory()->create([
                'email' => 'user@site.com', 'password' => bcrypt('password')
            ]);
            $kategori = 'Kategori Dusk';

            // 2. Login sebagai admin, buat kategori via UI
            $browser->loginAs($admin)
                ->visit('/admin/categories/create') // sesuaikan jika route beda
                ->type('name', $kategori)
                ->press('Save') // sesuaikan dengan tombol di UI
                ->assertSee($kategori);

            // 3. Login sebagai user, buat thread pakai kategori tadi
            $title = 'Thread oleh User';
            $content = 'Isi thread oleh user';

            $browser2->loginAs($user)
                ->visit('/forum/create') // sesuaikan jika route beda
                ->type('title', $title)
                ->type('content', $content)
                ->select('category_id', 1) // asumsi kategori baru punya id 1, sesuaikan jika perlu
                ->press('Publish Post')
                ->assertPathIs('/forum')
                ->assertSee($title)
                ->assertSee($kategori);

            // 4. Di halaman forum index, kategori muncul sebagai link
            $browser2->visit('/forum')
                ->assertSee($kategori)
                ->clickLink($kategori)
                ->assertSee($title)
                ->assertDontSee(''); // tambahkan thread lain jika perlu
        });
    }
}
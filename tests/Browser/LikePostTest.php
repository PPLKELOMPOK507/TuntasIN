<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Post;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;

class LikePostTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_user_can_like_a_post()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $post = Post::factory()->create();

            // Pastikan awalnya user belum like
            $this->assertEquals(0, $post->likes()->count());

            // Kunjungi halaman detail post, tekan tombol like, cek jumlah like bertambah
            $browser->loginAs($user)
                ->visit(route('posts.show', $post))
                // Pastikan jumlah like awal 0 (atau sesuaikan tampilan)
                ->assertSee('(0) Likes')
                // Tekan tombol like (pastikan selector sesuai, bisa juga ->press('button[type=submit]') )
                ->press('Likes')
                ->pause(500) // tunggu sejenak jika pakai ajax
                // Cek jumlah like sudah bertambah (atau ganti sesuai tampilan)
                ->assertSee('(1) Likes');
        });
    }
}
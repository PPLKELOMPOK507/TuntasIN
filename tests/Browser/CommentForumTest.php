<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Post;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;

class CommentForumTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_user_cannot_send_empty_comment()
    {
        $this->browse(function (Browser $browser) {
            // Arrange: buat user dan post di database testing
            $user = User::factory()->create();
            $post = Post::factory()->create();

            // Act: login, kunjungi detail post, coba submit komentar kosong
            $browser->loginAs($user)
                ->visit(route('posts.show', $post)) // pastikan route ini benar sesuai web.php, bisa juga '/forum/post/'.$post->id
                ->press('Send Comment')
                // Assert: cek pesan error validasi muncul
                ->assertSee('The body field is required'); // atau sesuaikan dengan pesan validasi di halamanmu
        });
    }

    public function test_user_can_send_valid_comment()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $post = Post::factory()->create();

            $comment = 'Ini komentar valid dari Dusk!';

            $browser->loginAs($user)
                ->visit(route('posts.show', $post)) // sesuaikan jika route berbeda
                ->type('body', $comment)
                ->press('Send Comment')
                // Cek halaman reload dan komentar muncul
                ->assertSee($comment);
        });
    }
}
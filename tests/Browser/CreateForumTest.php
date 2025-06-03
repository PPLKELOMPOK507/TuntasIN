<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Category;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;

class CreateForumTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_user_can_create_thread()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();

            // Tambahkan kategori langsung di test
            $category = \App\Models\Category::factory()->create([
                'name' => 'Kategori Test',
            ]);

            $title = 'Judul Thread Test Dusk';
            $body = 'Ini adalah isi thread yang dibuat lewat Dusk test.';

            $browser->loginAs($user)
                ->visit(route('forum.create'))
                ->select('category_id', $category->id) // pasti ada, karena baru dibuat
                ->press('Publish Post')
                ->pause(1000);
        });
    }
}
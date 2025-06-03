<?php

namespace Tests\Browser;

use App\Models\Category;
use App\Models\Jasa;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class FilterByCategoryTest extends DuskTestCase
{
    use DatabaseMigrations;
 /**
     * Test creating a new category
     * @group kiw
     */

    public function test_can_filter_services_by_category()
    {
        // Buat user, kategori, dan jasa dummy
        $user = User::factory()->create();
        $category = Category::factory()->create(['nama_kategori' => 'Kategori Test']);
        $jasa = Jasa::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'nama_jasa' => 'Jasa Unik'
        ]);

        $this->browse(function (Browser $browser) use ($category, $jasa) {
            $browser->visit('/?category=' . $category->id)
                    ->assertSee($jasa->nama_jasa);
        });
    }
}
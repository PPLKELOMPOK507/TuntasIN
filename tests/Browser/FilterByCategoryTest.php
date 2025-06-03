<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Category;
use App\Models\Jasa;
use App\Models\User;


class FilterByCategoryTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group ayy
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            // Asumsi sudah ada user dan kategori di database
            $user = User::where('role', 'Pengguna Jasa')->first();
            $category = Category::first(); // Ambil kategori pertama
            $jasa = Jasa::where('category_id', $category->id)->first();

            $browser->loginAs($user)
                ->visit('/dashboard')
                ->select('category', $category->id)
                ->pause(500) // Tunggu filter bekerja (jika pakai JS)
                ->assertSee($category->name)
                ->assertSee($jasa->nama_jasa);
        });
    }
}

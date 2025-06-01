<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Hash;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     */

    public function testSuccessfulLogin(): void
    {
        // Create a test user first
        $user = User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@gmail.com',
            'role' => 'Penyedia Jasa',
            'mobile_number' => '081234567890',
            'password' => Hash::make('password123')
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'johndoe@gmail.com')
                ->type('password', 'password123')
                ->press('Login')
                ->assertPathIs('/dashboard');
        });
    }
}

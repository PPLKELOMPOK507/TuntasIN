<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProfileTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     */

    // public function testExample(): void
    // {
    //     $user = User::create([
    //         'first_name' => 'John',
    //         'last_name' => 'Doe',
    //         'email' => 'johndoe@gmail.com',
    //         'role' => 'Penyedia Jasa',
    //         'mobile_number' => '081234567890',
    //         'password' => Hash::make('password123')
    //     ]);

    //     $this->browse(function (Browser $browser) {
    //         $pdf = UploadedFile::fake()->create('cv.pdf', 100);
            
    //         $browser->visit('/login')
    //             ->type('email', 'johndoe@gmail.com')
    //             ->type('password', 'password123')
    //             ->press('Login')
    //             ->assertPathIs('/dashboard')


    //             ->click('.user-profile')
    //             ->clickLink('Profile')
    //             ->assertPathIs('/profile')


    //             // ->clear('first_name')
    //             // ->type('first_name', '/')
    //             // ->type('last_name', 'Smith')

    //             // Change password
    //             // ->type('current_password', 'password123')
    //             // ->type('new_password', 'password1234')
    //             // ->type('new_password_confirmation', 'password1234')
    //             ->press('Save Changes')
    //             ->pause(500)
    //             ->waitFor('.alert-danger', 5)
    //             // ->assertSee('The new password field must be at least 8 characters.')
    //             ->assertSee('The first name field format is invalid.');

    //             // ->assertInputValue('first_name', 'Jane')
    //             // ->assertInputValue('last_name', 'Smith');
                
    //     });

    // }

    public function testCvUpload(): void
    {
        Storage::fake('public');

        $user = User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@gmail.com',
            'role' => 'Penyedia Jasa',
            'mobile_number' => '081234567890',
            'password' => Hash::make('password123')
        ]);

        $this->browse(function (Browser $browser) {
            // Create a fake PDF file
            $pdf = UploadedFile::fake()->create('cv.pd', 100);
            
            $browser->visit('/login')
                ->type('email', 'johndoe@gmail.com')
                ->type('password', 'password123')
                ->press('Login')
                ->assertPathIs('/dashboard')
                ->click('.user-profile')
                ->clickLink('Profile')
                ->assertPathIs('/profile')
                
                // Attach CV file
                ->attach('cv_file', $pdf->path())
                ->press('Save Changes')
                ->pause(500)
                ->waitFor('.alert-danger', 5)
                ->assertSee('The cv file must be a file of type: pdf, doc, docx');
        });
    }
}

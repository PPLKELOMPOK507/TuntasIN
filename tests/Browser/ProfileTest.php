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
            
    // }

    
//     public function testUpdateProfilePhoto(): void
//     {
//         Storage::fake('public');

//         $user = User::create([
//             'first_name' => 'John',
//             'last_name' => 'Doe', 
//             'email' => 'johndoe@gmail.com',
//             'role' => 'Penyedia Jasa',
//             'mobile_number' => '081234567890',
//             'password' => Hash::make('password123')
//         ]);

//         $this->browse(function (Browser $browser) {
//             $image = UploadedFile::fake()->image('profile.jpg');
            
//             $browser->visit('/login')
//                 ->type('email', 'johndoe@gmail.com')
//                 ->type('password', 'password123')
//                 ->press('Login')
//                 ->assertPathIs('/dashboard')
//                 ->click('.user-profile')
//                 ->clickLink('Profile')
//                 ->assertPathIs('/profile')
                
//                 // Upload foto profile
//                 ->attach('photo', $image->path());
//         });
//     }

//     public function testInvalidProfileNameChange(): void
//     {
//         // Create user with complete data
//         $user = User::create([
//             'first_name' => 'John',
//             'last_name' => 'Doe',
//             'email' => 'johndoe@gmail.com',
//             'role' => 'Penyedia Jasa',
//             'mobile_number' => '081234567890',
//             'password' => Hash::make('password123')
//         ]);

//         $this->browse(function (Browser $browser) use ($user) {
//             $browser->visit('/login')
//                 ->type('email', 'johndoe@gmail.com')
//                 ->type('password', 'password123')
//                 ->press('Login')
//                 ->assertPathIs('/dashboard')
//                 ->click('.user-profile')
//                 ->clickLink('Profile')
//                 ->assertPathIs('/profile')
                
//                 // Verify initial state
//                 ->assertInputValue('first_name', 'John')
//                 ->assertInputValue('last_name', 'Doe')
                
//                 // Clear and type invalid input
//                 ->clear('first_name')
//                 ->clear('last_name')
//                 ->type('first_name', '@#$%')
//                 ->type('last_name', '&*()')
                
//                 // Submit and check error
//                 ->press('Save Changes')
//                 ->waitFor('.swal2-popup')
//                 ->waitForText('The first name must only contain letters')
//                 ->assertSee('The first name must only contain letters');
//         });
//     }

    public function testUpdateLocation(): void 
    {
        // Create user with complete data
        $user = User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@gmail.com',
            'role' => 'Pengguna Jasa', // Make sure role is Pengguna Jasa to see address section
            'mobile_number' => '081234567890',
            'password' => Hash::make('password123')
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->type('email', 'johndoe@gmail.com')
                ->type('password', 'password123')
                ->press('Login')
                ->assertPathIs('/dashboard')
                ->click('.user-profile')
                ->clickLink('Profile')
                ->assertPathIs('/profile')
                
                // Langsung aktifkan address section menggunakan JavaScript
                ->script([
                    "document.querySelectorAll('.profile-section').forEach(s => s.classList.remove('active'));",
                    "document.getElementById('address-section').classList.add('active');"
                ])
                
                // Fill in address details
                ->type('address', 'Jl. Test Address No. 123')
                ->type('latitude', '-6.200000')
                ->type('longitude', '106.816666')
                
                // Submit and check success message
                ->press('Save Changes')
                ->waitFor('.swal2-popup')
                ->waitForText('Profile updated successfully')
                ->assertSee('Profile updated successfully');
        });
    }
}


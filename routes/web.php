<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;

// Registration routes
Route::get('/register', [RegistrationController::class, 'create'])->name('register');
Route::post('/register', [RegistrationController::class, 'store'])->name('register.submit');
Route::get('/registration-success', [RegistrationController::class, 'showSuccessPage'])->name('registration.success');

// Home page
Route ::get('/', function(){
    return view('welcome');
})->name('home');

// Login route (if you're implementing this)
Route::get('/login', function() {
    return view('login');
})->name('login');
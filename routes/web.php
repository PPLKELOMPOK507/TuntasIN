<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SalesController;

// Registration routes
Route::get('/register', [RegistrationController::class, 'create'])->name('register');
Route::post('/register', [RegistrationController::class, 'store'])->name('register.submit');
Route::get('/registration-success', [RegistrationController::class, 'showSuccessPage'])->name('registration.success');

// Home page
Route::get('/', function () {
    return view('welcome'); // home view
})->name('home');

// Login Routes
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard Route (Protected)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Sales History Routes (Protected + Penyedia Jasa Only)
Route::get('/sales-history', [SalesController::class, 'history'])
    ->middleware(['auth', 'provider'])
    ->name('sales.history');
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CategoryController;

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
Route::get('/riwayat-penjualan', [SalesController::class, 'history'])
    ->middleware(['auth'])
    ->name('sales.history');

// Profile Route
Route::get('/profile', function () {
    return view('profile');
})->middleware(['auth'])->name('profile');


// Definisikan route untuk setiap kategori
Route::get('/', [CategoryController::class, 'index'])->name('home');
Route::get('/graphics-design', [CategoryController::class, 'graphicsDesign'])->name('graphics-design');
Route::get('/programming-tech', [CategoryController::class, 'programmingTech'])->name('programming-tech');
Route::get('/digital-marketing', [CategoryController::class, 'digitalMarketing'])->name('digital-marketing');
Route::get('/video-animation', [CategoryController::class, 'videoAnimation'])->name('video-animation');
Route::get('/writing-translation', [CategoryController::class, 'writingTranslation'])->name('writing-translation');
Route::get('/music-audio', [CategoryController::class, 'musicAudio'])->name('music-audio');
Route::get('/business', [CategoryController::class, 'business'])->name('business');
Route::get('show', [CategoryController::class, 'show'])->name('show');
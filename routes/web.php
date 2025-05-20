<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\JasaController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChatController;

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
Route::get('/dashboard', [JasaController::class, 'dashboard'])
    ->middleware(['auth'])->name('dashboard');

// Sales History Routes (Protected + Penyedia Jasa Only)
Route::get('/riwayat-penjualan', [SalesController::class, 'history'])
    ->middleware(['auth'])
    ->name('sales.history');

// Jasa saya Routes (Protected + Penyedia Jasa Only)
Route::get('/jasa-saya', [JasaController::class, 'dashboard'])->name('services');  // Digunakan untuk penyedia jasa menampilkan jasa mereka
Route::get('/tambah-jasa', [JasaController::class, 'create'])->name('jasa.tambah');
Route::post('/tambah-jasa', [JasaController::class, 'store'])->name('jasa.store');

// Profile Route
Route::get('/profile', function () {
    return view('profile');
})->middleware(['auth'])->name('profile');

// Route untuk menampilkan form edit jasa
Route::get('/jasa/{id}/edit', [JasaController::class, 'edit'])->name('jasa.edit');
Route::put('/jasa/{id}', [JasaController::class, 'update'])->name('jasa.update');

// Route delete jasa
Route::delete('/jasa/{id}', [JasaController::class, 'destroy'])->name('jasa.destroy');

// Wishlist Routes
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');

// Forum Routes
Route::get('/forum', [ForumController::class, 'index'])->name('forum');

// Menampilkan semua jasa dari semua penyedia jasa
Route::get('/semua-jasa', [JasaController::class, 'allServices'])->name('jasa.semua');

// Route untuk melihat profile penyedia jasa
Route::get('/provider/{id}', [ProviderController::class, 'show'])->name('provider.profile');

// Route untuk melihat detail jasa
Route::get('/jasa/{id}', [JasaController::class, 'show'])->name('jasa.detail');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/pesan/{jasa}', [App\Http\Controllers\PemesananController::class, 'create'])->name('pesanan.create');
Route::post('/pesan/{jasa}', [App\Http\Controllers\PemesananController::class, 'store'])->name('pesanan.store');

Route::post('/messages', [ChatController::class, 'store'])->name('messages.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/add/{id}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::get('/chat/{jasa_id}', [ChatController::class, 'show'])->name('chat.show');
    Route::get('/chat/{jasa_id}/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/send', [ChatController::class, 'store'])->name('chat.store');
});


<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\JasaController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\AdminController;
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

// Admin Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', function () {
        if (auth()->user()->role !== 'Admin') {
            return redirect()->route('dashboard');
        }
        $jasa = \App\Models\Jasa::with('user')->get();
        $totalUsers = \App\Models\User::count();
        $users = \App\Models\User::all(); // Add this line
        $categories = \App\Models\Category::withCount('services')->get();
        
        return view('admin', compact('jasa', 'totalUsers', 'categories', 'users'));
    })->name('admin.dashboard');
    
    Route::delete('/admin/jasa/{id}', [AdminController::class, 'destroyJasa'])->name('admin.jasa.destroy');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])
        ->name('admin.users.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class)->except(['create', 'edit', 'show']);
});


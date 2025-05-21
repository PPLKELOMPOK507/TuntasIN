<?php
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\JasaController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\WithdrawalsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Admin\UserController;

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

Route::put('/profile', [ProfileController::class, 'update'])
    ->middleware(['auth'])
    ->name('profile.update');
// Route untuk menampilkan form edit jasa
Route::get('/jasa/{id}/edit', [JasaController::class, 'edit'])->name('jasa.edit');
Route::put('/jasa/{id}', [JasaController::class, 'update'])->name('jasa.update');

// Route delete jasa
Route::delete('/jasa/{id}', [JasaController::class, 'destroy'])->name('jasa.destroy');

// Wishlist Routes
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');

// Forum Routes
Route::get('/forum/discussions', [DiscussionController::class, 'index'])->name('forum.index');

// Menampilkan semua jasa dari semua penyedia jasa
Route::get('/semua-jasa', [JasaController::class, 'allServices'])->name('jasa.semua');

// Route untuk melihat profile penyedia jasa
Route::get('/provider/{id}', [ProviderController::class, 'show'])->name('provider.profile');

// Route untuk melihat detail jasa
Route::get('/jasa/{id}', [JasaController::class, 'show'])->name('jasa.detail');

Route::middleware(['auth'])->group(function () {
    Route::get('/account/balance', [AccountController::class, 'balance'])
        ->middleware('auth')
        ->name('account.balance');
    
    Route::get('/account/balance', [AccountController::class, 'balance'])->name('account.balance');
    Route::get('/account/withdrawals', [AccountController::class, 'withdrawals'])->name('account.withdrawals');
    Route::post('/account/withdraw', [WithdrawalsController::class, 'withdraw'])->name('account.withdraw');
    Route::post('/account/deposit', [AccountController::class, 'deposit'])->name('account.deposit');
});
// Route untuk forum page
Route::middleware(['auth'])->group(function () {
    Route::get('/forum', [PostController::class, 'index'])->name('forum');

    Route::post('/forum/{post}/like', [LikeController::class, 'toggle'])->name('post.like');
    Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/forum/create', [PostController::class, 'create'])->name('forum.create');
    Route::post('/forum/create', [PostController::class, 'create'])->name('forum.create');
    Route::post('/forum/create-post', [PostController::class, 'store'])->name('posts.store');
    Route::get('/forum/{post}', [PostController::class, 'show'])->name('post.show');
    Route::get('/my-posts', [PostController::class, 'myPosts'])->name('user.posts');
    Route::get('/my-comments', [PostController::class, 'myComments'])->name('user.comments');
    Route::post('/my-posts', [PostController::class, 'myPosts'])->name('user.posts');
    Route::post('/my-comments', [PostController::class, 'myComments'])->name('user.comments');
    Route::delete('/forum/{post}', [PostController::class, 'destroy'])->name('post.destroy');
    Route::get('/dashboard', [JasaController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');
    Route::get('/forum/category/{category}', [PostController::class, 'filterByCategory'])->name('forum.category');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('post.destroy');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/my-posts', [PostController::class, 'myPosts'])->name('user.posts');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comment.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comment.update');
    Route::get('/my-comments', [CommentController::class, 'myComments'])->name('user.comments');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');
    Route::get('/forum/discussion/create', [DiscussionController::class, 'create'])->name('discussion.create');
    Route::get('/forum/discussions', [DiscussionController::class, 'index'])->name('forum.index');
    Route::post('/forum/discussions', [DiscussionController::class, 'store'])->name('discussion.store');
    Route::get('/forum/discussions/{id}', [DiscussionController::class, 'show'])->name('discussion.show');
    Route::delete('/forum/discussions/{id}', [DiscussionController::class, 'destroy'])->name('discussion.destroy');
});
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

Route::prefix('admin')->name('admin.')->middleware('auth', 'admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});


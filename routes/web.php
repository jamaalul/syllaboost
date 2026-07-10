<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DeckController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/deck.php';
require __DIR__.'/folder.php';
require __DIR__.'/community.php';

// Public Articles
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');

// User routes (Store, Cart, Checkout, Transactions)
Route::middleware(['auth'])->group(function () {
    Route::get('/store', [StoreController::class, 'index'])->name('store.index');
    Route::get('/store/{slug}', [StoreController::class, 'show'])->name('store.show');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{deck}', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/finish', [CheckoutController::class, 'finish'])->name('checkout.finish');

    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
});

// Admin routes
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('articles', App\Http\Controllers\Admin\ArticleController::class);
    Route::resource('decks', DeckController::class);
    Route::resource('users', UserController::class);
    Route::resource('transactions', App\Http\Controllers\Admin\TransactionController::class)->only(['index', 'show']);
});

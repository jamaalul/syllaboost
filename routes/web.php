<?php

use App\Http\Controllers\ProfileController;
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

use App\Http\Controllers\DeckController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/decks/create', [DeckController::class, 'create'])->name('decks.create');
    Route::get('/decks/create/json', [DeckController::class, 'createFromJson'])->name('decks.create.json');
    Route::post('/decks', [DeckController::class, 'store'])->name('decks.store');
    Route::post('/decks/json', [DeckController::class, 'storeFromJson'])->name('decks.store.json');
});

use App\Http\Controllers\Auth\GoogleController;

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');

require __DIR__.'/auth.php';

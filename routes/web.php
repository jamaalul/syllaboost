<?php

use App\Http\Controllers\FolderController;
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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/folders', [FolderController::class, 'store'])->name('folders.store');
    Route::get('/folders/{folder:slug}', [FolderController::class, 'show'])->name('folders.show');
    Route::put('/folders/{folder:slug}', [FolderController::class, 'update'])->name('folders.update');
    Route::delete('/folders/{folder:slug}', [FolderController::class, 'destroy'])->name('folders.destroy');
    Route::post('/folders/{folder:slug}/decks', [FolderController::class, 'addDeck'])->name('folders.decks.add');
    Route::delete('/folders/{folder:slug}/decks/{deck}', [FolderController::class, 'removeDeck'])->name('folders.decks.remove');
    Route::put('/folders/{folder:slug}/decks/{deck}/tag', [FolderController::class, 'updateTag'])->name('folders.decks.tag');
});

require __DIR__.'/auth.php';
require __DIR__.'/deck.php';

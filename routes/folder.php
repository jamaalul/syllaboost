<?php

use App\Http\Controllers\FolderController;
use Illuminate\Support\Facades\Route;

Route::prefix('folders')->middleware('auth')->group(function () {
    Route::post('/', [FolderController::class, 'store'])->name('folders.store');
    Route::get('/{folder:slug}', [FolderController::class, 'show'])->name('folders.show');
    Route::put('/{folder:slug}', [FolderController::class, 'update'])->name('folders.update');
    Route::delete('/{folder:slug}', [FolderController::class, 'destroy'])->name('folders.destroy');

    Route::post('/{folder:slug}/decks', [FolderController::class, 'addDeck'])->name('folders.decks.add');
    Route::delete('/{folder:slug}/decks/{deck}', [FolderController::class, 'removeDeck'])->name('folders.decks.remove');
    Route::put('/{folder:slug}/decks/{deck}/tag', [FolderController::class, 'updateTag'])->name('folders.decks.tag');
});
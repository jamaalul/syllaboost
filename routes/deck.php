<?php

use App\Http\Controllers\DeckController;
use App\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');
});

Route::middleware('auth')->prefix('decks')->controller(DeckController::class)->group(function () {
    Route::get('/', 'index')->name('decks.index');
    Route::get('/create', 'create')->name('decks.create');
    Route::get('/create/json', 'createFromJson')->name('decks.create.json');
    Route::post('/', 'store')->name('decks.store');
    Route::post('/json', 'storeFromJson')->name('decks.store.json');

    Route::get('/mixed-study', 'mixedStudy')->name('decks.mixed-study');
    Route::get('{deck:slug}/edit', 'edit')->name('decks.edit');
    Route::put('{deck:slug}', 'update')->name('decks.update');
    Route::get('{deck:slug}/study', 'study')->name('decks.study');
    Route::get('{deck:slug}/srs-study', 'srsStudy')->name('decks.srs-study');
    Route::delete('{deck:slug}', 'destroy')->name('decks.destroy');
});

Route::get('/decks/public/{deck:slug}/study', [DeckController::class, 'publicStudy'])->name('decks.public.study');

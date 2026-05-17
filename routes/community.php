<?php

use App\Http\Controllers\CommunityController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('community')->controller(CommunityController::class)->group(function () {
    Route::get('/', 'index')->name('community.index');
    Route::post('/{deck:slug}/fork', 'fork')->name('community.fork');
});

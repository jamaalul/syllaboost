<?php

use App\Http\Controllers\ProfileController;
use App\Models\Deck;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    $userId = auth()->id();

    $dueDecks = Deck::where('user_id', $userId)
        ->whereHas('cards', function ($query) use ($userId) {
            $query->leftJoin('card_study_progresses', function ($join) use ($userId) {
                $join->on('cards.id', '=', 'card_study_progresses.card_id')
                    ->where('card_study_progresses.user_id', '=', $userId);
            })
                ->where(function ($q) {
                    $q->whereNull('card_study_progresses.id')
                        ->orWhere('card_study_progresses.next_review_at', '<=', now());
                });
        })
        ->withCount([
            'cards as due_cards_count' => function ($query) use ($userId) {
                $query->leftJoin('card_study_progresses', function ($join) use ($userId) {
                    $join->on('cards.id', '=', 'card_study_progresses.card_id')
                        ->where('card_study_progresses.user_id', '=', $userId);
                })
                    ->where(function ($q) {
                        $q->whereNull('card_study_progresses.id')
                            ->orWhere('card_study_progresses.next_review_at', '<=', now());
                    });
            },
        ])
        ->get();

    return view('dashboard', compact('dueDecks'));
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

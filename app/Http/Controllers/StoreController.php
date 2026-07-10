<?php

namespace App\Http\Controllers;

use App\Models\Deck;

class StoreController extends Controller
{
    public function index()
    {
        $decks = Deck::where('is_public', true)
            ->where('price', '>', 0)
            ->with('user')
            ->withCount('cards')
            ->latest()
            ->paginate(12);

        return view('store.index', compact('decks'));
    }

    public function show($slug)
    {
        $deck = Deck::where('slug', $slug)
            ->where('is_public', true)
            ->where('price', '>', 0)
            ->with(['user', 'cards' => fn ($q) => $q->limit(3)])
            ->withCount('cards')
            ->firstOrFail();

        return view('store.show', compact('deck'));
    }
}

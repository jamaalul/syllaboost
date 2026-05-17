<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CommunityController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();
        $userId = auth()->id();

        $decks = $search
            ? Deck::where('is_public', true)
                ->when($userId, fn ($query) => $query->where('user_id', '!=', $userId))
                ->with('user')
                ->withCount('cards')
                ->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                })
                ->latest()
                ->paginate(9)
                ->withQueryString()
            : null;

        $mostForkedDecks = $search
            ? collect()
            : Deck::where('is_public', true)
                ->when($userId, fn ($query) => $query->where('user_id', '!=', $userId))
                ->with('user')
                ->withCount('cards')
                ->orderByDesc('fork_count')
                ->limit(18)
                ->get();

        return view('community.index', compact('decks', 'mostForkedDecks', 'search'));
    }

    public function fork(Deck $deck): RedirectResponse
    {
        abort_if(! $deck->is_public, 403);

        DB::transaction(function () use ($deck) {
            $forked = Deck::create([
                'user_id' => auth()->id(),
                'name' => $deck->name,
                'description' => $deck->description,
                'is_public' => false,
            ]);

            $deck->cards()->orderBy('order')->each(function ($card) use ($forked) {
                $forked->cards()->create([
                    'front_content' => $card->front_content,
                    'back_content' => $card->back_content,
                    'order' => $card->order,
                ]);
            });

            $deck->increment('fork_count');
        });

        return redirect()->route('decks.index')->with('success', "Deck \"{$deck->name}\" forked to your decks!");
    }
}

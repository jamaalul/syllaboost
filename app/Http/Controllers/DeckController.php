<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeckRequest;
use App\Http\Requests\UpdateDeckRequest;
use App\Models\CardRatingLog;
use App\Models\Deck;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class DeckController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $decks = Deck::where('user_id', auth()->id())
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->withCount('cards')
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('decks.index', compact('decks'));
    }

    public function create(): View
    {
        return view('decks.create');
    }

    public function store(StoreDeckRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $deck = Deck::create([
                'user_id' => auth()->id(),
                'name' => $request->name,
                'description' => $request->description,
                'is_public' => $request->boolean('is_public'),
            ]);

            foreach ($request->cards as $index => $card) {
                $deck->cards()->create([
                    'front_content' => $card['front_content'],
                    'back_content' => $card['back_content'],
                    'order' => $index,
                ]);
            }
        });

        return redirect()->route('decks.index')->with('success', 'Deck created successfully!');
    }

    public function edit(Deck $deck): View
    {
        abort_if($deck->user_id !== auth()->id(), 403);

        $deck->load('cards');

        return view('decks.edit', compact('deck'));
    }

    public function update(UpdateDeckRequest $request, Deck $deck): RedirectResponse
    {
        abort_if($deck->user_id !== auth()->id(), 403);

        DB::transaction(function () use ($request, $deck) {
            $deck->update([
                'name' => $request->name,
                'description' => $request->description,
                'is_public' => $request->boolean('is_public'),
            ]);

            $deck->cards()->delete();

            foreach ($request->cards as $index => $card) {
                $deck->cards()->create([
                    'front_content' => $card['front_content'],
                    'back_content' => $card['back_content'],
                    'order' => $index,
                ]);
            }
        });

        return redirect()->route('decks.index')->with('success', 'Deck updated successfully!');
    }

    public function createFromJson(): View
    {
        return view('decks.create-json');
    }

    public function storeFromJson(Request $request): RedirectResponse
    {
        $data = json_decode($request->json_data, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return back()
                ->withErrors(['json_data' => 'Invalid JSON format: '.json_last_error_msg()])
                ->with('error', 'The JSON structure is incorrect. Please check your syntax.')
                ->withInput();
        }

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_public' => ['boolean'],
            'cards' => ['required', 'array', 'min:1'],
            'cards.*.front' => ['required', 'string'],
            'cards.*.back' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->with('error', 'Validation failed. Please check the JSON data.')
                ->withInput();
        }

        DB::transaction(function () use ($data) {
            $deck = Deck::create([
                'user_id' => auth()->id(),
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'is_public' => $data['is_public'] ?? false,
            ]);

            foreach ($data['cards'] as $index => $card) {
                $deck->cards()->create([
                    'front_content' => $card['front'],
                    'back_content' => $card['back'],
                    'order' => $index,
                ]);
            }
        });

        return redirect()->route('decks.index')->with('success', 'Deck created successfully from JSON!');
    }

    public function study(Deck $deck): View
    {
        if ($deck->user_id !== Auth::id() && ! $deck->is_public) {
            abort(404);
        }

        $cards = $deck->cards()->orderBy('order')->select('id', 'front_content', 'back_content', 'order')->get();

        // Compute resume index from the rating log
        $lastRatedCardId = CardRatingLog::where('user_id', Auth::id())
            ->where('deck_id', $deck->id)
            ->latest('rated_at')
            ->value('card_id');

        $startIndex = 0;
        if ($lastRatedCardId) {
            $position = $cards->search(fn ($c) => $c->id === $lastRatedCardId);
            $startIndex = $position !== false ? $position + 1 : 0;
        }

        // Pre-compute summary counts (most recent rating per card)
        $latestRatings = CardRatingLog::where('user_id', Auth::id())
            ->where('deck_id', $deck->id)
            ->select('card_id', 'rating')
            ->latest('rated_at')
            ->get()
            ->unique('card_id');

        $previousRatings = $latestRatings->pluck('rating', 'card_id');

        return view('decks.study', compact('deck', 'cards', 'startIndex', 'previousRatings'));
    }

    public function publicStudy(Deck $deck): View
    {
        if (! $deck->is_public) {
            abort(404);
        }

        $cards = $deck->cards()->orderBy('order')->select('id', 'front_content', 'back_content', 'order')->get();

        return view('decks.public-study', compact('deck', 'cards'));
    }

    public function destroy(Deck $deck): RedirectResponse
    {
        abort_if($deck->user_id !== auth()->id(), 403);

        $deck->delete();

        return redirect()->route('decks.index')->with('success', 'Deck deleted successfully!');
    }
}

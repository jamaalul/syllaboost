<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeckRequest;
use App\Models\Deck;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class DeckController extends Controller
{
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

        return redirect()->route('dashboard')->with('success', 'Deck created successfully!');
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
                ->withErrors(['json_data' => 'Invalid JSON format: ' . json_last_error_msg()])
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

        return redirect()->route('dashboard')->with('success', 'Deck created successfully from JSON!');
    }
}

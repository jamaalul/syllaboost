<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deck;
use Illuminate\Http\Request;

class DeckController extends Controller
{
    public function index()
    {
        $decks = Deck::with('user')->latest()->paginate(15);

        return view('admin.decks.index', compact('decks'));
    }

    public function edit(Deck $deck)
    {
        return view('admin.decks.edit', compact('deck'));
    }

    public function update(Request $request, Deck $deck)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);
        $data['is_public'] = $request->has('is_public');

        $deck->update($data);

        return redirect()->route('admin.decks.index')->with('success', 'Deck updated successfully.');
    }

    public function destroy(Deck $deck)
    {
        $deck->delete();

        return back()->with('success', 'Deck deleted successfully.');
    }
}

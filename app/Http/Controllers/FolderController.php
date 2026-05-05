<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFolderRequest;
use App\Models\Deck;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FolderController extends Controller
{
    public function store(StoreFolderRequest $request)
    {
        $folder = $request->user()->folders()->create($request->validated());

        return redirect()->route('folders.show', $folder->slug);
    }

    public function show(Request $request, Folder $folder)
    {
        abort_if($folder->user_id !== auth()->id(), 403);

        $search = $request->query('search');
        $tagId = $request->query('tag');

        $decks = $folder->decks()
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($tagId, function ($query, $tagId) {
                return $query->where('deck_folder.tag_id', $tagId);
            })
            ->withCount('cards')
            ->latest()
            ->paginate(9)
            ->withQueryString();

        $userDecks = auth()->user()->decks()->whereDoesntHave('folders', function ($query) use ($folder) {
            $query->where('folder_id', $folder->id);
        })->paginate(10, ['*'], 'user_decks_page')->withQueryString();

        $tags = $folder->tags()->get();

        return view('folders.show', compact('folder', 'decks', 'userDecks', 'tags'));
    }

    public function update(Request $request, Folder $folder)
    {
        abort_if($folder->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $folder->update($validated);

        return redirect()->route('folders.show', $folder->slug)->with('success', 'Folder updated successfully!');
    }

    public function destroy(Folder $folder)
    {
        abort_if($folder->user_id !== auth()->id(), 403);

        $folder->delete();

        return redirect()->route('dashboard')->with('success', 'Folder deleted successfully!');
    }

    public function addDeck(Request $request, Folder $folder)
    {
        abort_if($folder->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'deck_ids' => ['required', 'array'],
            'deck_ids.*' => ['exists:decks,id'],
        ]);

        $validDeckIds = Deck::whereIn('id', $validated['deck_ids'])
            ->where('user_id', auth()->id())
            ->pluck('id');

        $folder->decks()->syncWithoutDetaching($validDeckIds);

        return back()->with('success', 'Decks added to folder!');
    }

    public function removeDeck(Folder $folder, Deck $deck)
    {
        abort_if($folder->user_id !== auth()->id(), 403);
        abort_if($deck->user_id !== auth()->id(), 403);

        $folder->decks()->detach($deck->id);

        $this->cleanupUnusedTags($folder);

        return back()->with('success', 'Deck removed from folder!');
    }

    public function updateTag(Request $request, Folder $folder, Deck $deck)
    {
        abort_if($folder->user_id !== auth()->id(), 403);
        abort_if($deck->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'tag_name' => ['nullable', 'string', 'max:255'],
        ]);

        if (empty($validated['tag_name'])) {
            $folder->decks()->updateExistingPivot($deck->id, ['tag_id' => null]);

            $this->cleanupUnusedTags($folder);

            return back()->with('success', 'Tag removed from deck!');
        }

        $tag = $folder->tags()->firstOrCreate(['name' => $validated['tag_name']]);

        $folder->decks()->updateExistingPivot($deck->id, ['tag_id' => $tag->id]);

        $this->cleanupUnusedTags($folder);

        return back()->with('success', 'Tag updated for deck!');
    }

    private function cleanupUnusedTags(Folder $folder)
    {
        $usedTagIds = DB::table('deck_folder')
            ->where('folder_id', $folder->id)
            ->whereNotNull('tag_id')
            ->pluck('tag_id');

        $folder->tags()->whereNotIn('id', $usedTagIds)->delete();
    }
}

@props(['folder', 'tags'])

<div x-show="tagModalOpen" class="z-50 fixed inset-0 flex justify-center items-center" style="display: none;">
    <div x-show="tagModalOpen" x-transition.opacity class="fixed inset-0 bg-black/40 backdrop-blur-sm"
        @click="tagModalOpen = false"></div>

    <div x-show="tagModalOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative bg-white shadow-xl mx-4 p-6 rounded-3xl w-full max-w-md overflow-hidden">
        <div class="flex justify-between items-center mb-5">
            <h3 class="font-bold text-zinc-900 text-lg">Update Deck Tag</h3>
            <button @click="tagModalOpen = false" class="text-zinc-400 hover:text-zinc-600"><svg class="w-5 h-5"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg></button>
        </div>

        <form
            :action="`{{ route('folders.decks.tag', ['folder' => $folder->slug, 'deck' => 'DECK_ID']) }}`.replace('DECK_ID', activeDeckId)"
            method="POST">
            @csrf
            @method('PUT')
            <div class="mb-5">
                <label class="block mb-1 font-medium text-zinc-700 text-sm">Tag Name (e.g. Semester 1, Quiz
                    Prep)</label>
                <input type="text" name="tag_name" x-model="activeTagName"
                    class="bg-white px-3 py-2 border border-zinc-300 rounded-lg focus:outline-sky-600 w-full"
                    placeholder="Leave empty to remove tag">

                <div class="flex flex-wrap gap-2 mt-3">
                    @foreach($tags as $tag)
                        <button type="button" @click="activeTagName = '{{ addslashes($tag->name) }}'"
                            class="bg-zinc-100 hover:bg-zinc-200 px-2.5 py-1 rounded-md text-zinc-700 text-xs transition-colors">{{ $tag->name }}</button>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" @click="tagModalOpen = false"
                    class="bg-zinc-100 hover:bg-zinc-200 px-4 py-2 rounded-full font-medium text-zinc-700 transition-colors">Cancel</button>
                <button type="submit"
                    class="bg-zinc-900 hover:bg-zinc-800 px-4 py-2 rounded-full font-medium text-white transition-colors">Save
                    Tag</button>
            </div>
        </form>
    </div>
</div>
@extends('layouts.dashboard')

@section('title', $folder->name . ' \ Syllaboost')

@section('main')
    <div x-data="{ editing: {{ $errors->has('name') || $errors->has('description') ? 'true' : 'false' }}, addDeckModalOpen: false, tagModalOpen: false, activeDeckId: null, activeTagName: '' }"
        class="flex flex-col space-y-8">

        <!-- Folder Header -->
        <div class="flex justify-between items-start">
            <div class="flex flex-col flex-1 gap-4">
                @php
                    $colors = [
                        ['bg' => 'bg-sky-100', 'text' => 'text-sky-600', 'icon' => 'bg-sky-500'],
                        ['bg' => 'bg-purple-100', 'text' => 'text-purple-600', 'icon' => 'bg-purple-500'],
                        ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-600', 'icon' => 'bg-yellow-500'],
                        ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-600', 'icon' => 'bg-emerald-500'],
                        ['bg' => 'bg-rose-100', 'text' => 'text-rose-600', 'icon' => 'bg-rose-500'],
                        ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-600', 'icon' => 'bg-indigo-500'],
                    ];
                    $color = $colors[$folder->id % count($colors)];
                @endphp
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="size-16 {{ $color['text'] }}">
                        <path
                            d="M19.906 9c.382 0 .749.057 1.094.162V9a3 3 0 0 0-3-3h-3.879a.75.75 0 0 1-.53-.22L11.47 3.66A2.25 2.25 0 0 0 9.879 3H6a3 3 0 0 0-3 3v3.162A3.756 3.756 0 0 1 4.094 9h15.812ZM4.094 10.5a2.25 2.25 0 0 0-2.227 2.568l.857 6A2.25 2.25 0 0 0 4.951 21H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-2.227-2.568H4.094Z" />
                    </svg>
                </span>

                <!-- Display Mode -->
                <div x-show="!editing">
                    <div class="flex items-center gap-3">
                        <h1 class="font-bold text-gray-950 text-4xl">{{ $folder->name }}</h1>
                        <button @click="editing = true" class="text-zinc-400 hover:text-zinc-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </button>
                    </div>
                    <p class="mt-2 font-sm text-gray-500">{{ $folder->description ?: 'No description' }}</p>
                </div>

                <!-- Edit Mode -->
                <form x-show="editing" style="display: none;" action="{{ route('folders.update', $folder->slug) }}"
                    method="POST" class="w-full max-w-xl">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block mb-1 font-medium text-zinc-700 text-sm">Folder Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $folder->name) }}"
                                class="bg-white px-3 py-2 border border-zinc-300 rounded-lg focus:outline-sky-600 w-full"
                                required>
                            @error('name')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="description"
                                class="block mb-1 font-medium text-zinc-700 text-sm">Description</label>
                            <textarea name="description" id="description" rows="3"
                                class="bg-white px-3 py-2 border border-zinc-300 rounded-lg focus:outline-sky-600 w-full">{{ old('description', $folder->description) }}</textarea>
                            @error('description')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
                        </div>
                        <div class="flex gap-2">
                            <button type="button" @click="editing = false"
                                class="bg-zinc-100 hover:bg-zinc-200 px-4 py-2 rounded-lg font-medium text-zinc-700 transition-colors">Cancel</button>
                            <button type="submit"
                                class="bg-zinc-900 hover:bg-zinc-800 px-4 py-2 rounded-lg font-medium text-white transition-colors">Save
                                Changes</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Folder Actions -->
            <div class="flex gap-2 mt-auto">
                <button @click="addDeckModalOpen = true"
                    class="flex items-center gap-2 bg-zinc-950 px-4 py-2 rounded-full font-semibold text-white hover:scale-105 transition-all cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Deck
                </button>
                <button type="button" @click="$dispatch('confirm-action', { action: " {{ route('folders.destroy', $folder->slug) }}", method: 'DELETE' , title: 'Delete this folder?' ,
                    description: 'This will only delete the folder. The decks inside will not be deleted.' ,
                    confirmText: 'Delete Folder' })"
                    class="bg-white p-2 border border-zinc-200 rounded-full text-zinc-400 hover:text-rose-500 transition-colors cursor-pointer"
                    title="Delete Folder">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="group relative pt-4 border-zinc-200 border-t">
            <form action="{{ route('folders.show', $folder->slug) }}" method="GET">
                @if(request('tag'))
                    <input type="hidden" name="tag" value="{{ request('tag') }}">
                @endif
                <div
                    class="top-4 left-0 absolute inset-y-0 flex items-center pl-4 text-zinc-400 group-focus-within:text-purple-600 transition-colors pointer-events-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search decks in this folder..."
                    class="block bg-white py-3.5 pr-24 pl-11 border border-zinc-200 rounded-full focus:outline-purple-600 w-full text-zinc-900 transition-all"
                    @keydown.escape="$el.value = ''; $el.form.submit()">

                <div class="top-4 right-0 absolute inset-y-0 flex items-center pr-2">
                    @if (request('search'))
                        <a href="{{ route('folders.show', $folder->slug) }}"
                            class="p-2 text-zinc-400 hover:text-zinc-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                                </path>
                            </svg>
                        </a>
                    @endif
                    <button type="submit"
                        class="bg-zinc-100 hover:bg-zinc-200 mr-1 px-4 py-1.5 rounded-full font-medium text-zinc-700 text-sm transition-colors cursor-pointer">
                        Search
                    </button>
                </div>
            </form>
        </div>

        <!-- Tags Filter -->
        @if ($tags->count() > 0)
            <div class="flex flex-wrap items-center gap-2">
                <span class="mr-1 font-medium text-zinc-500 text-sm">Filter by tag:</span>
                <a href="{{ route('folders.show', ['folder' => $folder->slug, 'search' => request('search')]) }}"
                    class="px-3 py-1.5 rounded-full text-xs font-medium transition-colors {{ !request('tag') ? 'bg-zinc-900 text-white' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200' }}">
                    All
                </a>
                @foreach ($tags as $tag)
                    <a href="{{ route('folders.show', ['folder' => $folder->slug, 'tag' => $tag->id, 'search' => request('search')]) }}"
                        class="px-3 py-1.5 rounded-full text-xs font-medium transition-colors {{ request('tag') == $tag->id ? 'bg-zinc-900 text-white' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200' }}">
                        {{ $tag->name }}
                    </a>
                @endforeach
            </div>
        @endif

        <!-- Decks Grid -->
        @if ($decks->count() > 0)
            <div class="gap-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($decks as $deck)
                    @php
                        $deckColors = [
                            ['bg' => 'bg-sky-100', 'text' => 'text-sky-600', 'icon' => 'bg-sky-500'],
                            ['bg' => 'bg-purple-100', 'text' => 'text-purple-600', 'icon' => 'bg-purple-500'],
                            ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-600', 'icon' => 'bg-yellow-500'],
                            ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-600', 'icon' => 'bg-emerald-500'],
                            ['bg' => 'bg-rose-100', 'text' => 'text-rose-600', 'icon' => 'bg-rose-500'],
                            ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-600', 'icon' => 'bg-indigo-500'],
                        ];
                        $deckColor = $deckColors[$deck->id % count($deckColors)];

                        $tagName = null;
                        if ($deck->pivot && $deck->pivot->tag_id) {
                            $tag = $tags->firstWhere('id', $deck->pivot->tag_id);
                            if ($tag) {
                                $tagName = $tag->name;
                            }
                        }
                    @endphp
                    <div class="group relative flex flex-col bg-zinc-100 p-4 rounded-3xl h-full overflow-hidden">

                        <div class="flex justify-between items-start mb-4">
                            <div class="p-2 {{ $deckColor['text'] }}">
                                <svg class="size-6" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M16.5 6a3 3 0 0 0-3-3H6a3 3 0 0 0-3 3v7.5a3 3 0 0 0 3 3v-6A4.5 4.5 0 0 1 10.5 6h6Z" />
                                    <path d="M18 7.5a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-7.5a3 3 0 0 1-3-3v-7.5a3 3 0 0 1 3-3H18Z" />
                                </svg>
                            </div>

                            <div class="flex gap-2">
                                <button type="button"
                                    @click="activeDeckId = {{ $deck->id }}; activeTagName = '{{ $tagName ?? '' }}'; tagModalOpen = true;"
                                    class="inline-flex items-center {{ $tagName ? 'bg-sky-100 text-sky-700' : 'bg-white text-zinc-500' }} px-2.5 py-0.5 rounded-full font-medium text-xs hover:bg-sky-200 transition-colors">
                                    <svg class="mr-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                        </path>
                                    </svg>
                                    {{ $tagName ?? 'Add Tag' }}
                                </button>

                                @if (!$deck->is_public)
                                    <span
                                        class="inline-flex items-center bg-white px-2.5 py-0.5 rounded-full font-medium text-zinc-600 text-xs">
                                        <svg class="mr-1 w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Private
                                    </span>
                                @endif
                            </div>
                        </div>

                        <h3 class="mb-2 font-bold text-zinc-950 text-xl truncate">
                            {{ str($deck->name)->limit(40) }}
                        </h3>
                        <p class="mb-2 text-zinc-500 text-sm line-clamp-2 grow">
                            {{ str($deck->description ?? 'No description provided for this deck.')->limit(120) }}
                        </p>

                        <div class="flex justify-between items-center mt-auto pt-5 border-zinc-200 border-t">
                            <div class="flex items-center text-zinc-600">
                                <svg class="mr-1.5 w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <span class="font-semibold text-sm">{{ $deck->cards_count }} cards</span>
                            </div>
                            <div class="flex">
                                <form action="{{ route('folders.decks.remove', [$folder->slug, $deck->id]) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 text-zinc-400 hover:text-rose-500 transition-colors cursor-pointer"
                                        title="Remove from folder">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </form>
                                <a href="{{ route('decks.study', $deck->slug) }}"
                                    class="inline-flex justify-center items-center bg-zinc-950 ml-2 px-4 py-1.5 rounded-full font-bold text-white text-sm hover:scale-105 active:scale-100 transition-all">
                                    Practice
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $decks->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div
                class="flex flex-col justify-center items-center bg-zinc-50 px-6 py-20 border-2 border-zinc-200 border-dashed rounded-[2.5rem]">
                <div class="bg-white shadow-sm mb-6 p-5 rounded-full">
                    <svg class="w-12 h-12 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                </div>
                <h3 class="mb-2 font-bold text-zinc-900 text-xl">
                    {{ request('search') ? 'No decks found matching your search' : 'No decks in this folder yet' }}
                </h3>
                <p class="mb-8 max-w-xs text-zinc-500 text-center">
                    {{ request('search') ? 'Try searching with different keywords.' : 'Add your existing decks to organize them here.' }}
                </p>
                <button @click="addDeckModalOpen = true"
                    class="inline-flex justify-center items-center bg-sky-600 hover:bg-sky-500 px-8 py-3 rounded-full font-semibold text-white transition-all duration-200">
                    Add Deck
                </button>
            </div>
        @endif

        <!-- Add Deck Modal -->
        <div x-show="addDeckModalOpen" x-data="{ searchQuery: '' }"
            class="z-50 fixed inset-0 flex justify-center items-center" style="display: none;">
            <div x-show="addDeckModalOpen" x-transition.opacity class="fixed inset-0 bg-black/40 backdrop-blur-sm"
                @click="addDeckModalOpen = false"></div>

            <div x-show="addDeckModalOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative flex flex-col bg-white shadow-xl mx-4 rounded-3xl w-full max-w-2xl h-[80vh] overflow-hidden">

                <div class="flex justify-between items-center p-6 pb-4">
                    <h3 class="font-bold text-zinc-900 text-lg">Add Deck to Folder</h3>
                    <button @click="addDeckModalOpen = false"
                        class="bg-zinc-100 hover:bg-zinc-200 p-2 rounded-full text-zinc-400 hover:text-zinc-600 transition-colors cursor-pointer cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>

                @if($userDecks->isEmpty())
                    <div class="p-6">
                        <p class="py-4 text-zinc-500 text-center">You have no other decks available to add.</p>
                        <div class="flex justify-end gap-3 mt-6">
                            <button type="button" @click="addDeckModalOpen = false"
                                class="bg-zinc-100 hover:bg-zinc-200 px-5 py-2.5 rounded-full font-medium text-zinc-700 transition-colors">Close</button>
                        </div>
                    </div>
                @else
                    <div class="px-6 pt-4">
                        <div class="relative">
                            <div class="left-0 absolute inset-y-0 flex items-center pl-3 text-zinc-400 pointer-events-none">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input x-model="searchQuery" type="text" placeholder="Search decks..."
                                class="block bg-white p-2.5 pl-10 border border-zinc-200 focus:border-purple-600 rounded-full focus:outline-purple-600 w-full text-sm transition-colors"
                                autocomplete="off">
                        </div>
                    </div>

                    <form action="{{ route('folders.decks.add', $folder->slug) }}" method="POST"
                        class="flex flex-col flex-1 min-h-0 overflow-hidden">
                        @csrf
                        <div class="flex-1 p-6 min-h-0 overflow-y-auto custom-scrollbar">
                            <div class="space-y-2">
                                @foreach($userDecks as $deck)
                                    <label
                                        x-show="searchQuery === '' || '{{ strtolower(addslashes($deck->name)) }}'.includes(searchQuery.toLowerCase())"
                                        class="flex justify-between items-center bg-zinc-100 [&:has(:checked)]:bg-sky-50 hover:bg-sky-50 p-3 [&:has(:checked)]:border-sky-600 hover:border-sky-200 rounded-xl [&:has(:checked)]:ring-1 [&:has(:checked)]:ring-sky-600 transition-all cursor-pointer">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-zinc-900">{{ str($deck->name)->limit(40) }}</span>
                                            <span class="text-zinc-500 text-xs">{{ $deck->cards()->count() }} cards</span>
                                        </div>
                                        <input type="radio" name="deck_id" value="{{ $deck->id }}"
                                            class="border-zinc-300 focus:ring-sky-600 w-4 h-4 text-sky-600" required>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 bg-white mt-auto p-6">
                            <button type="button" @click="addDeckModalOpen = false"
                                class="bg-white hover:bg-zinc-50 px-5 py-2.5 border border-zinc-200 rounded-full font-medium text-zinc-700 transition-colors cursor-pointer">
                                Cancel
                            </button>
                            <button type="submit"
                                class="bg-zinc-900 hover:bg-zinc-800 shadow-sm px-5 py-2.5 rounded-full font-medium text-white transition-colors cursor-pointer">Add
                                to Folder
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>

        <!-- Tag Modal -->
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

    </div>

    <x-confirm-modal />
@endsection
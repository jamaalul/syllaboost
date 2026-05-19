@extends('layouts.dashboard')

@section('title')
    Your Decks \ Syllaboost
@endsection

@section('main')
    <div class="flex flex-col space-y-8" x-data="{ searching: false }">
        <!-- Search Bar -->
        <div class="group relative">
            <form action="{{ route('decks.index') }}" method="GET" @submit="searching = true">
                <div
                    class="left-0 absolute inset-y-0 flex items-center pl-4 text-zinc-400 group-focus-within:text-purple-600 transition-colors pointer-events-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search decks..."
                    class="block bg-white py-3.5 pr-24 pl-11 border border-zinc-200 rounded-full focus:outline-purple-600 w-full text-zinc-900 transition-all"
                    @keydown.escape="$el.value = ''; $el.form.submit()">

                <div class="right-0 absolute inset-y-0 flex items-center pr-2">
                    @if (request('search'))
                        <a href="{{ route('decks.index') }}" class="p-2 text-zinc-400 hover:text-zinc-600 transition-colors">
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

        <!-- Decks Grid -->
        @if ($decks->count() > 0)
            <div class="gap-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($decks as $deck)
                    @php
                        $colors = [
                            ['bg' => 'bg-sky-100', 'text' => 'text-sky-600', 'icon' => 'bg-sky-500'],
                            ['bg' => 'bg-purple-100', 'text' => 'text-purple-600', 'icon' => 'bg-purple-500'],
                            ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-600', 'icon' => 'bg-yellow-500'],
                            ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-600', 'icon' => 'bg-emerald-500'],
                            ['bg' => 'bg-rose-100', 'text' => 'text-rose-600', 'icon' => 'bg-rose-500'],
                            ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-600', 'icon' => 'bg-indigo-500'],
                        ];
                        $color = $colors[$deck->id % count($colors)];
                        
                        $progress = $deck->cards_count > 0 ? min(100, (int) round(($deck->studied_cards_count / $deck->cards_count) * 100)) : 0;
                    @endphp
                    <div class="group relative flex flex-col bg-zinc-100 p-4 rounded-3xl h-full overflow-hidden">

                        <div class="flex justify-between items-start mb-4">
                            <div class="{{ $color['text'] }}">
                                <svg class="size-8" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M16.5 6a3 3 0 0 0-3-3H6a3 3 0 0 0-3 3v7.5a3 3 0 0 0 3 3v-6A4.5 4.5 0 0 1 10.5 6h6Z" />
                                    <path d="M18 7.5a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-7.5a3 3 0 0 1-3-3v-7.5a3 3 0 0 1 3-3H18Z" />
                                </svg>
                            </div>
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
                            @else
                                <div x-data="{ copied: false }" class="relative">
                                    <button type="button"
                                        @click="navigator.clipboard.writeText('{{ route('decks.public.study', $deck->slug) }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                        class="inline-flex items-center bg-white hover:bg-zinc-50 px-2.5 py-0.5 rounded-full font-medium text-zinc-600 text-xs transition-colors cursor-pointer">
                                        <svg class="mr-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            x-show="!copied">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                        </svg>
                                        <svg class="mr-1 w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            x-cloak x-show="copied">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span x-text="copied ? 'Copied!' : 'Share'"></span>
                                    </button>
                                </div>
                            @endif
                        </div>

                        <h3 class="mb-2 font-bold text-zinc-950 text-xl truncate">
                            {{ str($deck->name)->limit(40) }}
                        </h3>
                        <p class="mb-4 text-zinc-500 text-sm line-clamp-2 grow">
                            {{ str($deck->description ?? 'No description provided for this deck.')->limit(120) }}
                        </p>

                        <div class="mb-4 w-full">
                            <div class="flex justify-between items-center mb-1.5 text-xs">
                                <span class="font-medium text-zinc-500">Progress</span>
                                <span class="font-medium text-zinc-900">{{ $progress }}%</span>
                            </div>
                            <div class="bg-zinc-200/80 rounded-full w-full h-1.5 overflow-hidden">
                                <div class="{{ $color['icon'] }} h-full rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-5 border-zinc-200/60 border-t">
                            <div class="flex items-center text-zinc-600">
                                <svg class="mr-1.5 size-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <span class="font-semibold text-sm">{{ $deck->cards_count }} cards</span>
                            </div>
                            <div class="flex">
                                <button type="button" @click="$dispatch('confirm-action', { 
                                                                        action: " {{ route('decks.destroy', $deck->slug) }}",
                                    method: 'DELETE' , title: 'Delete this deck?' ,
                                    : 'This action cannot be undone. The deck and all its cards will be permanently removed.' ,
                                    confirmText: 'Delete' })"
                                    class="p-2 text-zinc-400 hover:text-rose-500 transition-colors cursor-pointer"
                                    title="Delete Deck">
                                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                <a href="{{ route('decks.edit', $deck->slug) }}"
                                    class="mr-2 p-2 text-zinc-400 hover:text-zinc-600 transition-colors" title="Edit Deck">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </a>
                                <a href="{{ route('decks.study', $deck->slug) }}"
                                    class="inline-flex justify-center items-center bg-zinc-950 px-4 py-1.5 rounded-full w-22 font-bold text-white text-sm hover:scale-105 active:scale-100 transition-all">
                                    Practice
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
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
                    {{ request('search') ? 'No decks found matching your search' : 'No decks yet' }}
                </h3>
                <p class="mb-8 max-w-xs text-zinc-500 text-center">
                    {{ request('search') ? 'Try searching with different keywords or clear the filter.' : 'Create your first deck of flashcards to start studying effectively.' }}
                </p>
                @if (request('search'))
                    <a href="{{ route('decks.index') }}"
                        class="inline-flex justify-center items-center bg-zinc-900 hover:bg-zinc-800 px-8 py-3 rounded-full font-semibold text-white transition-all duration-200">
                        Clear Search
                    </a>
                @else
                    <a href="{{ route('decks.create') }}"
                        class="inline-flex justify-center items-center bg-sky-600 hover:bg-sky-500 px-8 py-3 rounded-full font-semibold text-white transition-all duration-200">
                        Create Your First Deck
                    </a>
                @endif
            </div>
        @endif
    </div>

    <x-confirm-modal />
@endsection
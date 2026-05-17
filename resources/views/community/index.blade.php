@extends('layouts.dashboard')

@section('title')
    Explore Public Decks \ Syllaboost
@endsection

@section('main')
    <div class="flex flex-col space-y-8" x-data="{ searching: false }">

        <!-- Page Header -->
        <div>
            <h1 class="font-bold text-zinc-950 text-2xl">Explore Public Decks</h1>
            <p class="mt-1 text-zinc-500 text-sm">Discover decks shared by the community and fork them to your collection.
            </p>
        </div>

        <!-- Search Bar -->
        <div class="group relative">
            <form action="{{ route('community.index') }}" method="GET" @submit="searching = true">
                <div
                    class="left-0 absolute inset-y-0 flex items-center pl-4 text-zinc-400 group-focus-within:text-purple-600 transition-colors pointer-events-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ $search }}" placeholder="Search public decks..."
                    class="block bg-white py-3.5 pr-24 pl-11 border border-zinc-200 rounded-full focus:outline-purple-600 w-full text-zinc-900 transition-all"
                    @keydown.escape="$el.value = ''; $el.form.submit()">

                <div class="right-0 absolute inset-y-0 flex items-center pr-2">
                    @if ($search)
                        <a href="{{ route('community.index') }}"
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

        @if (!$search)
            <!-- Most Copied Section -->
            @if ($mostForkedDecks->isNotEmpty())
                <div class="flex flex-col space-y-4">
                    <div class="flex items-center gap-2">
                        <h2 class="font-bold text-zinc-950 text-lg">Popular Decks</h2>
                    </div>

                    <div class="gap-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($mostForkedDecks as $deck)
                            @php
                                $colors = [
                                    ['bg' => 'bg-sky-100', 'text' => 'text-sky-600'],
                                    ['bg' => 'bg-purple-100', 'text' => 'text-purple-600'],
                                    ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-600'],
                                    ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-600'],
                                    ['bg' => 'bg-rose-100', 'text' => 'text-rose-600'],
                                    ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-600'],
                                ];
                                $color = $colors[$deck->id % count($colors)];
                            @endphp
                            <div class="group relative flex flex-col bg-zinc-100 p-4 rounded-3xl h-full overflow-hidden">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="{{ $color['text'] }}">
                                        <svg class="size-8" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M16.5 6a3 3 0 0 0-3-3H6a3 3 0 0 0-3 3v7.5a3 3 0 0 0 3 3v-6A4.5 4.5 0 0 1 10.5 6h6Z" />
                                            <path
                                                d="M18 7.5a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-7.5a3 3 0 0 1-3-3v-7.5a3 3 0 0 1 3-3H18Z" />
                                        </svg>
                                    </div>
                                    <span
                                        class="inline-flex items-center gap-1 bg-amber-100 px-2.5 py-0.5 rounded-full font-medium text-amber-700 text-xs">
                                        <svg class="size-3" viewBox="0 0 24 24" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $deck->fork_count }} {{ Str::plural('fork', $deck->fork_count) }}
                                    </span>
                                </div>

                                <h3 class="mb-1 font-bold text-zinc-950 text-xl truncate">
                                    {{ str($deck->name)->limit(40) }}
                                </h3>
                                <p class="mb-1 text-zinc-400 text-xs">by {{ $deck->user->name }}</p>
                                <p class="mb-2 text-zinc-500 text-sm line-clamp-2 grow">
                                    {{ str($deck->description ?? 'No description provided for this deck.')->limit(120) }}
                                </p>

                                <div class="flex justify-between items-center mt-auto pt-4 border-zinc-200 border-t">
                                    <div class="flex items-center text-zinc-600">
                                        <svg class="mr-1.5 size-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        <span class="font-semibold text-sm">{{ $deck->cards_count }} cards</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('decks.public.study', $deck->slug) }}"
                                            class="inline-flex justify-center items-center bg-white hover:bg-zinc-50 px-4 py-1.5 rounded-full font-medium text-zinc-700 text-sm transition-colors">
                                            Preview
                                        </a>
                                        <form action="{{ route('community.fork', $deck->slug) }}" method="POST"
                                            x-data="{ forking: false }" @submit="forking = true">
                                            @csrf
                                            <button type="submit" :disabled="forking"
                                                class="inline-flex justify-center items-center bg-zinc-950 disabled:opacity-60 px-4 py-1.5 rounded-full font-bold text-white text-sm hover:scale-105 active:scale-100 transition-all cursor-pointer">
                                                <svg x-show="!forking" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="mr-2 size-4">
                                                    <path
                                                        d="M7 3.5A1.5 1.5 0 0 1 8.5 2h3.879a1.5 1.5 0 0 1 1.06.44l3.122 3.12A1.5 1.5 0 0 1 17 6.622V12.5a1.5 1.5 0 0 1-1.5 1.5h-1v-3.379a3 3 0 0 0-.879-2.121L10.5 5.379A3 3 0 0 0 8.379 4.5H7v-1Z" />
                                                    <path
                                                        d="M4.5 6A1.5 1.5 0 0 0 3 7.5v9A1.5 1.5 0 0 0 4.5 18h7a1.5 1.5 0 0 0 1.5-1.5v-5.879a1.5 1.5 0 0 0-.44-1.06L9.44 6.439A1.5 1.5 0 0 0 8.378 6H4.5Z" />
                                                </svg>
                                                <svg x-cloak x-show="forking" class="mr-2 size-4 animate-spin" fill="none"
                                                    viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                        stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                                </svg>
                                                <span x-text="forking ? 'Forking...' : 'Fork'"></span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
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
                        No public decks yet
                    </h3>
                    <p class="mb-8 max-w-xs text-zinc-500 text-center">
                        Be the first to share a deck with the community!
                    </p>
                    <a href="{{ route('decks.index') }}"
                        class="inline-flex justify-center items-center bg-sky-600 hover:bg-sky-500 px-8 py-3 rounded-full font-semibold text-white transition-all duration-200">
                        Go to Your Decks
                    </a>
                </div>
            @endif
        @else
            <!-- Search Results -->
            <div class="flex flex-col space-y-4">
                <div class="flex justify-between items-center">
                    <h2 class="font-bold text-zinc-950 text-lg">
                        Search Results
                    </h2>
                    <span class="text-zinc-500 text-sm">{{ $decks->total() }} {{ Str::plural('result', $decks->total()) }} for
                        &ldquo;{{ $search }}&rdquo;</span>
                </div>

                @if ($decks->count() > 0)
                    <div class="gap-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($decks as $deck)
                            @php
                                $colors = [
                                    ['bg' => 'bg-sky-100', 'text' => 'text-sky-600'],
                                    ['bg' => 'bg-purple-100', 'text' => 'text-purple-600'],
                                    ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-600'],
                                    ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-600'],
                                    ['bg' => 'bg-rose-100', 'text' => 'text-rose-600'],
                                    ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-600'],
                                ];
                                $color = $colors[$deck->id % count($colors)];
                            @endphp
                            <div class="group relative flex flex-col bg-zinc-100 p-4 rounded-3xl h-full overflow-hidden">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="{{ $color['text'] }}">
                                        <svg class="size-8" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M16.5 6a3 3 0 0 0-3-3H6a3 3 0 0 0-3 3v7.5a3 3 0 0 0 3 3v-6A4.5 4.5 0 0 1 10.5 6h6Z" />
                                            <path
                                                d="M18 7.5a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-7.5a3 3 0 0 1-3-3v-7.5a3 3 0 0 1 3-3H18Z" />
                                        </svg>
                                    </div>
                                    @if ($deck->fork_count > 0)
                                        <span
                                            class="inline-flex items-center gap-1 bg-white px-2.5 py-0.5 rounded-full font-medium text-zinc-500 text-xs">
                                            <svg class="size-3 text-amber-400" viewBox="0 0 24 24" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $deck->fork_count }}
                                        </span>
                                    @endif
                                </div>

                                <h3 class="mb-1 font-bold text-zinc-950 text-xl truncate">
                                    {{ str($deck->name)->limit(40) }}
                                </h3>
                                <p class="mb-2 text-zinc-400 text-xs">by {{ $deck->user->name }}</p>
                                <p class="mb-2 text-zinc-500 text-sm line-clamp-2 grow">
                                    {{ str($deck->description ?? 'No description provided for this deck.')->limit(120) }}
                                </p>

                                <div class="flex justify-between items-center mt-auto pt-4 border-zinc-200 border-t">
                                    <div class="flex items-center text-zinc-600">
                                        <svg class="mr-1.5 size-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        <span class="font-semibold text-sm">{{ $deck->cards_count }} cards</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('decks.public.study', $deck->slug) }}"
                                            class="inline-flex justify-center items-center bg-white hover:bg-zinc-50 px-4 py-1.5 rounded-full font-medium text-zinc-700 text-sm transition-colors">
                                            Preview
                                        </a>
                                        <form action="{{ route('community.fork', $deck->slug) }}" method="POST"
                                            x-data="{ forking: false }" @submit="forking = true">
                                            @csrf
                                            <button type="submit" :disabled="forking"
                                                class="inline-flex justify-center items-center bg-zinc-950 disabled:opacity-60 px-4 py-1.5 rounded-full font-bold text-white text-sm hover:scale-105 active:scale-100 transition-all cursor-pointer">
                                                <svg x-show="!forking" class="mr-1.5 size-4" viewBox="0 0 24 24" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M6 3a3 3 0 0 1 3 3v1.5a3 3 0 0 1-3 3H4.5a3 3 0 0 1-3-3V6a3 3 0 0 1 3-3H6Zm7.5 0a3 3 0 0 1 3 3v1.5a3 3 0 0 1-3 3H12a3 3 0 0 1-3-3V6a3 3 0 0 1 3-3h1.5Zm-7.5 9a3 3 0 0 1 3 3V16.5a3 3 0 0 1-3 3H4.5a3 3 0 0 1-3-3V15a3 3 0 0 1 3-3H6Zm7.5 2.25a.75.75 0 0 1 .75.75v2.25H16.5a.75.75 0 0 1 0 1.5h-2.25V21a.75.75 0 0 1-1.5 0v-2.25H10.5a.75.75 0 0 1 0-1.5h2.25V15a.75.75 0 0 1 .75-.75Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <svg x-cloak x-show="forking" class="mr-1.5 size-4 animate-spin" fill="none"
                                                    viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                        stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                                </svg>
                                                <span x-text="forking ? 'Forking...' : 'Fork'"></span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
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
                            No public decks match your search
                        </h3>
                        <p class="mb-8 max-w-xs text-zinc-500 text-center">
                            Try searching with different keywords or clear the filter.
                        </p>
                        <a href="{{ route('community.index') }}"
                            class="inline-flex justify-center items-center bg-zinc-900 hover:bg-zinc-800 px-8 py-3 rounded-full font-semibold text-white transition-all duration-200">
                            Clear Search
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
@endsection
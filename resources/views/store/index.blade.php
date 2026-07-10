@extends('layouts.dashboard')

@section('title', 'Premium Store \ Syllaboost')

@section('main')
    <div class="flex flex-col space-y-8">
        {{-- Header --}}
        <div>
            <h1 class="text-2xl font-bold text-zinc-900">Premium Store</h1>
            <p class="text-zinc-500 mt-1">Supercharge your learning with community-curated premium decks.</p>
        </div>

        {{-- Decks Grid --}}
        @if ($decks->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
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
                    @endphp
                    <a href="{{ route('store.show', $deck->slug) }}"
                        class="group relative flex flex-col bg-zinc-100 p-4 rounded-3xl h-full overflow-hidden hover:-translate-y-1 hover:shadow-md transition-all duration-200">

                        <div class="flex justify-between items-start mb-4">
                            <div class="{{ $color['text'] }}">
                                <svg class="size-8" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M16.5 6a3 3 0 0 0-3-3H6a3 3 0 0 0-3 3v7.5a3 3 0 0 0 3 3v-6A4.5 4.5 0 0 1 10.5 6h6Z" />
                                    <path d="M18 7.5a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-7.5a3 3 0 0 1-3-3v-7.5a3 3 0 0 1 3-3H18Z" />
                                </svg>
                            </div>
                            <span class="inline-flex items-center bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-0.5 rounded-full font-semibold text-xs">
                                Rp {{ number_format($deck->price, 0, ',', '.') }}
                            </span>
                        </div>

                        <h3 class="mb-2 font-bold text-zinc-950 text-xl truncate">
                            {{ str($deck->name)->limit(40) }}
                        </h3>
                        <p class="mb-2 text-zinc-500 text-sm line-clamp-2 grow">
                            {{ str($deck->description ?? 'No description provided for this deck.')->limit(120) }}
                        </p>

                        <div class="flex justify-between items-center mt-auto pt-5 border-zinc-100 border-t">
                            <div class="flex items-center text-zinc-600">
                                <svg class="mr-1.5 size-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <span class="font-semibold text-sm">{{ $deck->cards_count }} cards</span>
                            </div>
                            <span class="text-xs text-zinc-400">By {{ $deck->user->name }}</span>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $decks->links() }}
            </div>
        @else
            {{-- Empty State --}}
            <div class="flex flex-col justify-center items-center bg-zinc-50 px-6 py-20 border-2 border-zinc-200 border-dashed rounded-[2.5rem]">
                <div class="bg-white shadow-sm mb-6 p-5 rounded-full">
                    <svg class="w-12 h-12 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                </div>
                <h3 class="mb-2 font-bold text-zinc-900 text-xl">No premium decks available yet</h3>
                <p class="mb-8 max-w-xs text-zinc-500 text-center">
                    Check back later — creators are always uploading new premium content.
                </p>
            </div>
        @endif
    </div>
@endsection

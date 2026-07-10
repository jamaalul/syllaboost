@extends('layouts.dashboard')

@section('title', $deck->name . ' \ Syllaboost')

@section('main')
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

    <div class="flex flex-col space-y-8">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-zinc-400">
            <a href="{{ route('store.index') }}" class="hover:text-zinc-700 transition-colors">Premium Store</a>
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-zinc-600 font-medium truncate">{{ $deck->name }}</span>
        </nav>

        {{-- Hero Section --}}
        <div class="bg-zinc-100 rounded-3xl p-8 md:p-10">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-8">

                {{-- Left: Info --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="{{ $color['text'] }}">
                            <svg class="size-10" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M16.5 6a3 3 0 0 0-3-3H6a3 3 0 0 0-3 3v7.5a3 3 0 0 0 3 3v-6A4.5 4.5 0 0 1 10.5 6h6Z" />
                                <path d="M18 7.5a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-7.5a3 3 0 0 1-3-3v-7.5a3 3 0 0 1 3-3H18Z" />
                            </svg>
                        </div>
                        <span class="inline-flex items-center {{ $color['bg'] }} {{ $color['text'] }} px-3 py-1 rounded-full text-xs font-semibold">
                            Premium Deck
                        </span>
                    </div>

                    <h1 class="text-3xl md:text-4xl font-bold text-zinc-900 mb-3">{{ $deck->name }}</h1>

                    <p class="text-zinc-500 mb-6 text-sm">
                        Created by <span class="font-semibold text-zinc-700">{{ $deck->user->name }}</span>
                    </p>

                    <p class="text-zinc-600 leading-relaxed mb-6">
                        {{ $deck->description ?? 'No description provided for this deck.' }}
                    </p>

                    {{-- Stats row --}}
                    <div class="flex flex-wrap gap-4">
                        <div class="flex items-center gap-1.5 text-zinc-600 text-sm">
                            <svg class="size-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <span class="font-semibold">{{ $deck->cards_count }}</span>
                            <span>cards</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-zinc-600 text-sm">
                            <svg class="size-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>By</span>
                            <span class="font-semibold">{{ $deck->user->name }}</span>
                        </div>
                    </div>
                </div>

                {{-- Right: Purchase Card --}}
                <div class="md:w-64 flex-shrink-0">
                    <div class="bg-white rounded-2xl p-6 border border-zinc-200 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400 mb-1">Price</p>
                        <p class="text-4xl font-bold text-emerald-600 mb-6">
                            Rp {{ number_format($deck->price, 0, ',', '.') }}
                        </p>

                        @auth
                            <form action="{{ route('cart.store', $deck) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full bg-zinc-900 text-white px-6 py-3 rounded-xl font-bold hover:bg-zinc-800 hover:scale-[1.02] active:scale-100 transition-all duration-150">
                                    Add to Cart
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}"
                                class="block w-full text-center bg-zinc-900 text-white px-6 py-3 rounded-xl font-bold hover:bg-zinc-800 hover:scale-[1.02] active:scale-100 transition-all duration-150">
                                Login to Purchase
                            </a>
                        @endauth

                        <p class="text-center text-zinc-400 text-xs mt-4">
                            Instant access after purchase
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card Preview --}}
        @if ($deck->cards->count() > 0)
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-zinc-900">
                        Preview
                        <span class="font-normal text-zinc-400 text-sm ml-1">({{ $deck->cards->count() }} of {{ $deck->cards_count }} shown)</span>
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach ($deck->cards as $card)
                        <div class="bg-zinc-100 rounded-2xl p-5 flex flex-col gap-3">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400 mb-1">Front</p>
                                <p class="text-zinc-900 font-medium text-sm leading-relaxed line-clamp-3">
                                    {{ $card->front_content }}
                                </p>
                            </div>
                            <div class="border-t border-zinc-200 pt-3">
                                <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400 mb-1">Back</p>
                                <p class="text-zinc-600 text-sm leading-relaxed line-clamp-3">
                                    {{ $card->back_content }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($deck->cards_count > 3)
                    <p class="text-center text-zinc-400 text-sm mt-4">
                        + {{ $deck->cards_count - 3 }} more cards unlocked after purchase
                    </p>
                @endif
            </div>
        @endif

    </div>
@endsection

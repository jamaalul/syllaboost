@extends('layouts.dashboard')

@section('title')
    Dashboard \ Syllaboost
@endsection

@section('main')
    <div class="flex flex-col space-y-8">

        <div>
            <h1 class="font-bold text-zinc-950 text-4xl">Hi, {{ Auth::user()->name }}</h1>
            <p class="mt-2 text-zinc-500 text-sm">Welcome back! Here's your study overview.</p>
        </div>

        @php
            $colors = [
                ['bg' => 'bg-sky-100', 'text' => 'text-sky-600', 'icon' => 'bg-sky-500'],
                ['bg' => 'bg-purple-100', 'text' => 'text-purple-600', 'icon' => 'bg-purple-500'],
                ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-600', 'icon' => 'bg-yellow-500'],
                ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-600', 'icon' => 'bg-emerald-500'],
                ['bg' => 'bg-rose-100', 'text' => 'text-rose-600', 'icon' => 'bg-rose-500'],
                ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-600', 'icon' => 'bg-indigo-500'],
            ];
            $todayColor = $colors[strtotime(date('Y-m-d')) % count($colors)];
        @endphp

        @php
            $totalDueCards = $dueDecks->sum('due_cards_count');
        @endphp

        <div
            class="{{ $todayColor['icon'] }} relative rounded-3xl w-full h-56 p-8 flex flex-col justify-center items-start overflow-hidden">
            <!-- decoration -->
            <svg class="-right-12 -bottom-12 absolute size-64 text-white/10" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M12 2.25a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-1.5 0V3a.75.75 0 0 1 .75-.75ZM7.5 12a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM18.894 6.166a.75.75 0 0 0-1.06-1.06l-1.591 1.59a.75.75 0 1 0 1.06 1.061l1.591-1.59ZM21.75 12a.75.75 0 0 1-.75.75h-2.25a.75.75 0 0 1 0-1.5H21a.75.75 0 0 1 .75.75ZM17.834 18.894a.75.75 0 0 0 1.06-1.06l-1.59-1.591a.75.75 0 1 0-1.061 1.06l1.59 1.591ZM12 18a.75.75 0 0 1 .75.75V21a.75.75 0 0 1-1.5 0v-2.25A.75.75 0 0 1 12 18ZM7.757 17.834a.75.75 0 0 0-1.06 1.06l1.591 1.59a.75.75 0 1 0 1.06-1.061l-1.59-1.59ZM6 12a.75.75 0 0 1-.75.75H3a.75.75 0 0 1 0-1.5h2.25A.75.75 0 0 1 6 12ZM6.697 7.757a.75.75 0 0 0 1.06-1.06l-1.59-1.591a.75.75 0 1 0-1.061 1.06l1.59 1.591Z" />
            </svg>

            <div class="z-10 text-white">
                <h2 class="mb-2 font-bold text-3xl">Mixed Review Pull</h2>
                @if($totalDueCards > 0)
                    <p class="mb-6 font-medium text-white/80">Review top 20 cards picked from cards of all decks due for review.
                    </p>
                    <a href="{{ route('decks.mixed-study') }}"
                        class="inline-flex justify-center items-center bg-white shadow-sm px-6 py-2.5 rounded-full font-bold text-zinc-950 text-sm hover:scale-105 active:scale-100 transition-all">
                        Review Now
                    </a>
                @else
                    <p class="mb-6 font-medium text-white/80">You are completely caught up! No cards due.</p>
                @endif
            </div>
        </div>

        @if($dueDecks->isNotEmpty())
            <div class="flex flex-col space-y-4">
                <h2 class="flex items-center gap-2 font-semibold text-zinc-800 text-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path
                            d="M9.195 18.44c1.25.714 2.805-.189 2.805-1.629v-2.34l6.945 3.968c1.25.715 2.805-.188 2.805-1.628V8.69c0-1.44-1.555-2.343-2.805-1.628L12 11.029v-2.34c0-1.44-1.555-2.343-2.805-1.628l-7.108 4.061c-1.26.72-1.26 2.536 0 3.256l7.108 4.061Z" />
                    </svg>
                    Past cards to review
                </h2>
                <div class="gap-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($dueDecks as $deck)
                        @php
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
                                    class="inline-flex items-center bg-white shadow-sm px-2.5 py-0.5 border border-zinc-200/50 rounded-full font-medium text-amber-600 text-xs">
                                    {{ $deck->due_cards_count }} cards due
                                </span>
                            </div>

                            <h3 class="mb-2 font-bold text-zinc-950 text-xl truncate">
                                {{ str($deck->name)->limit(40) }}
                            </h3>
                            <p class="mb-4 text-zinc-500 text-sm line-clamp-2 grow">
                                {{ str($deck->description ?? 'No description provided for this deck.')->limit(120) }}
                            </p>

                            <div class="flex justify-between items-center mt-auto pt-5 border-zinc-200/60 border-t">
                                <div class="flex items-center text-zinc-600">
                                    <svg class="mr-1.5 size-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    <span class="font-semibold text-sm">{{ $deck->due_cards_count }} cards</span>
                                </div>
                                <div class="flex">
                                    <a href="{{ route('decks.srs-study', $deck) }}"
                                        class="inline-flex justify-center items-center bg-zinc-950 px-4 py-1.5 rounded-full font-bold text-white text-sm hover:scale-105 active:scale-100 transition-all">
                                        Review Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div
                class="flex flex-col justify-center items-center bg-zinc-50 px-6 py-20 border-2 border-zinc-200 border-dashed rounded-[2.5rem]">
                <div class="bg-white shadow-sm mb-6 p-5 rounded-full">
                    <svg class="size-12 text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <h3 class="mb-2 font-bold text-zinc-900 text-xl">
                    You're all caught up!
                </h3>
                <p class="mb-8 max-w-xs text-zinc-500 text-center">
                    No cards due for review today. Great job staying on top of your studies.
                </p>
                <a href="{{ route('decks.index') }}"
                    class="inline-flex justify-center items-center bg-zinc-900 hover:bg-zinc-800 px-8 py-3 rounded-full font-semibold text-white transition-all duration-200">
                    Browse Decks
                </a>
            </div>
        @endif
    </div>
@endsection
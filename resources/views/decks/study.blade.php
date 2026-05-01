@extends('layouts.app')

@section('title', $deck->name . ' \ Syllaboost')

@section('content')
    <div class="relative flex justify-center items-center bg-zinc-100 w-screen h-screen" x-data="cardSlider()"
        @keydown.arrow-right.window="next()" @keydown.arrow-left.window="prev()" @keydown.space.window.prevent="reveal()"
        tabindex="0">

        {{-- stack decoration (ghost layers behind) --}}
        <div class="z-10 absolute bg-white border border-zinc-200 rounded-3xl w-[85vw] md:w-80 aspect-2/3 translate-y-4">
        </div>
        <div class="z-10 absolute bg-white border border-zinc-200 rounded-3xl w-[85vw] md:w-80 aspect-2/3 translate-y-3">
        </div>
        <div class="z-10 absolute bg-white border border-zinc-200 rounded-3xl w-[85vw] md:w-80 aspect-2/3 translate-y-2">
        </div>
        <div class="z-10 absolute bg-white border border-zinc-200 rounded-3xl w-[85vw] md:w-80 aspect-2/3 translate-y-1">
        </div>
        <div class="z-10 absolute bg-white border border-zinc-200 rounded-3xl w-[85vw] md:w-80 aspect-2/3"></div>

        @php
            $colors = [
                'bg-sky-600',
                'bg-purple-600',
                'bg-yellow-600',
                'bg-emerald-600',
                'bg-rose-600',
                'bg-indigo-600',
            ];
            $color = $colors[$deck->id % count($colors)];
        @endphp

        {{-- real cards --}}
        @foreach ($cards as $idx => $card)
            <div x-ref="card-{{ $idx }}" :style="{ zIndex: orderedCards.indexOf({{ $idx }}) + 20 }"
                class="absolute bg-white border-x border-zinc-200 rounded-3xl w-[85vw] md:w-80 aspect-2/3 card-item"
                style="perspective: 1000px;">

                {{-- inner flip container --}}
                <div x-ref="flip-{{ $idx }}" class="border border-zinc-200 w-full h-full card-flip-inner">

                    {{-- front face --}}
                    <div class="p-6 rounded-3xl card-face card-front">
                        <p class="font-bold text-zinc-950 text-xl">
                            {{ $card->front_content }}
                        </p>
                    </div>

                    {{-- back face --}}
                    <div class="{{ $color }} p-6 rounded-3xl card-face card-back">
                        <p class="font-bold text-white text-xl">
                            {{ $card->back_content }}
                        </p>
                    </div>

                </div>
            </div>
        @endforeach

        {{-- hint bar --}}
        <div class="bottom-8 absolute flex items-center gap-2 text-zinc-500 text-sm select-none">
            <kbd class="bg-white shadow-sm px-2 py-1 border border-zinc-300 rounded-md font-mono text-xs">←</kbd>
            <span>Prev</span>
            <span class="text-zinc-300">|</span>
            <kbd class="bg-white shadow-sm px-2 py-1 border border-zinc-300 rounded-md font-mono text-xs">→</kbd>
            <span>Next</span>
            <span class="text-zinc-300">|</span>
            <kbd class="bg-white shadow-sm px-2 py-1 border border-zinc-300 rounded-md font-mono text-xs">Space</kbd>
            <span>Reveal</span>
        </div>

        <div class="top-10 absolute w-full">
            <div class="flex justify-between mx-auto w-full max-w-5xl">
                <a href="{{ route('decks.index') }}" x-data="{ loading: false }" @click="loading = true"
                    class="flex justify-center items-center gap-2 w-24 font-medium text-zinc-500 hover:text-zinc-700 transition-colors">
                    <span class="flex justify-center items-center gap-2" x-show="!loading">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                        Back
                    </span>
                    <span x-show="loading">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="animate-spin lucide lucide-loader-circle-icon lucide-loader-circle">
                            <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                        </svg>
                    </span>
                </a>
                <span class="font-medium tabular-nums text-zinc-500 text-sm" x-text="`${topIndex + 1} / ${total}`"></span>
            </div>
        </div>

    </div>

    <style>
        .card-item {
            will-change: transform, opacity;
        }

        /* ── Flip structure ── */
        .card-flip-inner {
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.45s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 1.5rem;
        }

        .card-flip-inner.is-flipped {
            transform: rotateY(180deg);
        }

        .card-face {
            position: absolute;
            inset: 0;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }

        .card-front {
            background: white;
        }

        .card-back {
            transform: rotateY(180deg);
        }

        /* ── Slide animations (unchanged) ── */
        .card-item.slide-out-right {
            animation: slide-out-right 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .card-item.slide-in-left {
            animation: slide-in-left 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .card-item.rise-right {
            animation: rise-right 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .card-item.slide-in-right {
            animation: slide-in-right 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        @keyframes slide-out-right {
            0% {
                transform: translateX(0) rotate(0deg);
            }

            100% {
                transform: translateX(120%) rotate(5deg);
            }
        }

        @keyframes slide-in-left {
            0% {
                transform: translateX(120%) rotate(5deg);
            }

            100% {
                transform: translateX(0) rotate(0deg);
                opacity: 0;
                z-index: -10;
            }
        }

        @keyframes rise-right {
            0% {
                transform: translateX(0) rotate(0deg);
                opacity: 0;
            }

            20% {
                opacity: 0;
            }

            100% {
                transform: translateX(120%) rotate(5deg);
                opacity: 1;
            }
        }

        @keyframes slide-in-right {
            0% {
                transform: translateX(120%) rotate(5deg);
                opacity: 1;
            }

            100% {
                transform: translateX(0) rotate(0deg);
                opacity: 1;
            }
        }
    </style>

    <script>
        function cardSlider() {
            const DURATION = 300;

            return {
                cards: @json(collect($cards)->map(fn($c) => [
                    'front' => $c->front_content,
                    'back' => $c->back_content,
                ])),

                total: {{ count($cards) }},
                topIndex: 0,
                animating: false,
                revealed: false,

                get orderedCards() {
                    return Array.from({ length: this.total }, (_, i) =>
                        (this.topIndex + i) % this.total
                    ).reverse();
                },

                reveal() {
                    if (this.animating) return;
                    const flipEl = this.$refs['flip-' + this.topIndex];
                    this.revealed = !this.revealed;
                    flipEl.classList.toggle('is-flipped', this.revealed);
                },

                _resetFlip(index) {
                    const flipEl = this.$refs['flip-' + index];
                    if (flipEl) {
                        flipEl.style.transition = 'none';
                        flipEl.classList.remove('is-flipped');
                        // force reflow, then restore transition
                        flipEl.offsetHeight;
                        flipEl.style.transition = '';
                    }
                    this.revealed = false;
                },

                next() {
                    if (this.animating || this.total < 2) return;
                    this.animating = true;

                    const card = this.$refs['card-' + this.topIndex];
                    this._resetFlip(this.topIndex);

                    card.style.zIndex = '9999';
                    card.classList.add('slide-out-right');

                    setTimeout(() => {
                        card.classList.remove('slide-out-right');
                        card.classList.add('slide-in-left');

                        this.topIndex = (this.topIndex + 1) % this.total;

                        setTimeout(() => {
                            card.classList.remove('slide-in-left');
                            card.style.zIndex = '';
                            this.animating = false;
                        }, DURATION);
                    }, DURATION);
                },

                prev() {
                    if (this.animating || this.total < 2) return;
                    this.animating = true;

                    const prevIndex = (this.topIndex - 1 + this.total) % this.total;
                    const card = this.$refs['card-' + prevIndex];

                    this._resetFlip(this.topIndex);

                    card.style.opacity = '0';
                    card.style.transform = 'translateX(-120%)';
                    card.style.zIndex = '9999';

                    requestAnimationFrame(() => {
                        requestAnimationFrame(() => {
                            card.classList.add('rise-right');

                            setTimeout(() => {
                                card.classList.remove('rise-right');
                                card.classList.add('slide-in-right');

                                setTimeout(() => {
                                    card.classList.remove('slide-in-right');
                                    card.style.opacity = '';
                                    card.style.transform = '';
                                    card.style.zIndex = '';

                                    this.topIndex = prevIndex;
                                    this.animating = false;
                                }, DURATION);
                            }, DURATION);
                        });
                    });
                }
            };
        }
    </script>
@endsection
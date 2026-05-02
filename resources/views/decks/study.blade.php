@extends('layouts.app')

@section('title', $deck->name . ' \ Syllaboost')

@section('content')
    <div class="relative flex justify-center items-center bg-zinc-100 w-screen h-svh" x-data="cardSlider()"
        @keydown.arrow-right.window="next()" @keydown.arrow-left.window="prev()" @keydown.space.window.prevent="reveal()"
        tabindex="0">

        {{-- stack decoration (ghost layers behind) --}}
        <div
            class="z-10 absolute bg-white border border-zinc-200 rounded-3xl w-[80vw] md:w-[50vw] lg:w-80 aspect-2/3 translate-y-4">
        </div>
        <div
            class="z-10 absolute bg-white border border-zinc-200 rounded-3xl w-[80vw] md:w-[50vw] lg:w-80 aspect-2/3 translate-y-3">
        </div>
        <div
            class="z-10 absolute bg-white border border-zinc-200 rounded-3xl w-[80vw] md:w-[50vw] lg:w-80 aspect-2/3 translate-y-2">
        </div>
        <div
            class="z-10 absolute bg-white border border-zinc-200 rounded-3xl w-[80vw] md:w-[50vw] lg:w-80 aspect-2/3 translate-y-1">
        </div>
        <div class="z-10 absolute bg-white border border-zinc-200 rounded-3xl w-[80vw] md:w-[50vw] lg:w-80 aspect-2/3">
        </div>

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
                class="absolute bg-white border-x border-zinc-200 rounded-3xl w-[80vw] md:w-[50vw] lg:w-80 aspect-2/3 card-item"
                style="perspective: 1000px;">

                {{-- inner flip container --}}
                <div x-ref="flip-{{ $idx }}" class="border border-zinc-200 w-full h-full card-flip-inner">

                    {{-- front face --}}
                    <div class="relative p-6 rounded-3xl card-face card-front">
                        <p class="font-bold text-zinc-950 text-2xl">
                            {{ $card->front_content }}
                        </p>
                        <span class="right-6 bottom-6 absolute text-zinc-200">
                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg"
                                class="size-7">
                                <g clip-path="url(#clip0_29_199)">
                                    <path
                                        d="M7.2132 0.84923C15.4142 9.05024 28.7107 9.05024 36.9117 0.84923L43.2756 7.21319C35.0746 15.4142 35.0746 28.7107 43.2756 36.9117L36.9117 43.2756C29.2982 35.6622 26.6342 24.9751 28.916 15.2089C19.1498 17.4906 8.4627 14.8267 0.849236 7.21319L7.2132 0.84923ZM15.6985 22.0624L22.0624 28.4264L7.2132 43.2756L0.849236 36.9117L15.6985 22.0624Z"
                                        fill="currentColor" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_29_199">
                                        <rect width="44" height="44" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </span>
                    </div>

                    {{-- back face --}}
                    <div class="{{ $color }} p-6 relative rounded-3xl card-face card-back">
                        <p class="font-bold text-white text-2xl">
                            {{ $card->back_content }}
                        </p>
                        <span class="right-6 bottom-6 absolute text-white">
                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg"
                                class="size-7">
                                <g clip-path="url(#clip0_29_199)">
                                    <path
                                        d="M7.2132 0.84923C15.4142 9.05024 28.7107 9.05024 36.9117 0.84923L43.2756 7.21319C35.0746 15.4142 35.0746 28.7107 43.2756 36.9117L36.9117 43.2756C29.2982 35.6622 26.6342 24.9751 28.916 15.2089C19.1498 17.4906 8.4627 14.8267 0.849236 7.21319L7.2132 0.84923ZM15.6985 22.0624L22.0624 28.4264L7.2132 43.2756L0.849236 36.9117L15.6985 22.0624Z"
                                        fill="currentColor" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_29_199">
                                        <rect width="44" height="44" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </span>
                    </div>

                </div>
            </div>
        @endforeach

        {{-- hint bar: keyboard on desktop, swipe on mobile --}}
        <div class="bottom-8 absolute flex items-center gap-2 text-zinc-500 text-sm select-none">
            {{-- desktop hints --}}
            <div x-show="!isTouch" class="hidden md:flex items-center gap-2">
                <kbd class="bg-white shadow-sm px-2 py-1 border border-zinc-300 rounded-md font-mono text-xs">←</kbd>
                <span>Prev</span>
                <span class="text-zinc-300">|</span>
                <kbd class="bg-white shadow-sm px-2 py-1 border border-zinc-300 rounded-md font-mono text-xs">→</kbd>
                <span>Next</span>
                <span class="text-zinc-300">|</span>
                <kbd class="bg-white shadow-sm px-2 py-1 border border-zinc-300 rounded-md font-mono text-xs">Space</kbd>
                <span>Reveal</span>
            </div>
            {{-- mobile hints --}}
            <div x-show="isTouch" class="md:hidden flex items-center gap-2">
                <span class="flex items-center gap-1">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                            <path fill-rule="evenodd"
                                d="M10 2a.75.75 0 0 1 .75.75v12.59l1.95-2.1a.75.75 0 1 1 1.1 1.02l-3.25 3.5a.75.75 0 0 1-1.1 0l-3.25-3.5a.75.75 0 1 1 1.1-1.02l1.95 2.1V2.75A.75.75 0 0 1 10 2Z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                    Prev
                </span>
                <span class="text-zinc-300">|</span>
                <span class="flex items-center gap-1">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                            <path fill-rule="evenodd"
                                d="M10 18a.75.75 0 0 1-.75-.75V4.66L7.3 6.76a.75.75 0 0 1-1.1-1.02l3.25-3.5a.75.75 0 0 1 1.1 0l3.25 3.5a.75.75 0 1 1-1.1 1.02l-1.95-2.1v12.59A.75.75 0 0 1 10 18Z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                    Next
                </span>
                <span class="text-zinc-300">|</span>
                <span class="flex items-center gap-1">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                            <path
                                d="M10 1a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0v-1.5A.75.75 0 0 1 10 1ZM5.05 3.05a.75.75 0 0 1 1.06 0l1.062 1.06A.75.75 0 1 1 6.11 5.173L5.05 4.11a.75.75 0 0 1 0-1.06ZM14.95 3.05a.75.75 0 0 1 0 1.06l-1.06 1.062a.75.75 0 0 1-1.062-1.061l1.061-1.06a.75.75 0 0 1 1.06 0ZM3 8a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5h-1.5A.75.75 0 0 1 3 8ZM14 8a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5h-1.5A.75.75 0 0 1 14 8ZM7.172 10.828a.75.75 0 0 1 0 1.061L6.11 12.95a.75.75 0 0 1-1.06-1.06l1.06-1.06a.75.75 0 0 1 1.06 0ZM10.766 7.51a.75.75 0 0 0-1.37.365l-.492 6.861a.75.75 0 0 0 1.204.65l1.043-.799.985 3.678a.75.75 0 0 0 1.45-.388l-.978-3.646 1.292.204a.75.75 0 0 0 .74-1.16l-3.874-5.764Z" />
                        </svg>
                    </span>
                    /
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                            <path fill-rule="evenodd"
                                d="M13.2 2.24a.75.75 0 0 0 .04 1.06l2.1 1.95H6.75a.75.75 0 0 0 0 1.5h8.59l-2.1 1.95a.75.75 0 1 0 1.02 1.1l3.5-3.25a.75.75 0 0 0 0-1.1l-3.5-3.25a.75.75 0 0 0-1.06.04Zm-6.4 8a.75.75 0 0 0-1.06-.04l-3.5 3.25a.75.75 0 0 0 0 1.1l3.5 3.25a.75.75 0 1 0 1.02-1.1l-2.1-1.95h8.59a.75.75 0 0 0 0-1.5H4.66l2.1-1.95a.75.75 0 0 0 .04-1.06Z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                    Flip
                </span>
            </div>
        </div>

        <div class="top-4 md:top-10 absolute w-full">
            <div class="flex justify-between mx-auto p-4 w-full max-w-5xl">
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

        /* ── Slide animations: desktop (X axis) ── */
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

        /* ── Slide animations: mobile (Y axis, inverted direction) ── */
        .card-item.slide-out-up {
            animation: slide-out-up 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .card-item.slide-in-down {
            animation: slide-in-down 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .card-item.rise-up {
            animation: rise-up 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .card-item.slide-in-up {
            animation: slide-in-up 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        @keyframes slide-out-up {
            0% {
                transform: translateY(0) rotate(0deg);
            }

            100% {
                transform: translateY(-120%) rotate(-5deg);
            }
        }

        @keyframes slide-in-down {
            0% {
                transform: translateY(-120%) rotate(-5deg);
            }

            100% {
                transform: translateY(0) rotate(0deg);
                opacity: 0;
                z-index: -10;
            }
        }

        @keyframes rise-up {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 0;
            }

            20% {
                opacity: 0;
            }

            100% {
                transform: translateY(-120%) rotate(-5deg);
                opacity: 1;
            }
        }

        @keyframes slide-in-up {
            0% {
                transform: translateY(-120%) rotate(-5deg);
                opacity: 1;
            }

            100% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
            }
        }
    </style>

    <script>
        function cardSlider() {
            const DURATION = 300;
            const SWIPE_THRESHOLD = 50;
            const isMobile = () => window.matchMedia('(pointer: coarse)').matches;

            return {
                cards: @json(collect($cards)->map(fn($c) => [
                    'front' => $c->front_content,
                    'back' => $c->back_content,
                ])),

                total: {{ count($cards) }},
                topIndex: 0,
                animating: false,
                revealed: false,
                touchStartX: 0,
                touchStartY: 0,
                isTouch: window.matchMedia('(pointer: coarse)').matches,

                init() {
                    this._setupTouch();
                },

                _setupTouch() {
                    const el = this.$el;
                    let startX = 0;
                    let startY = 0;
                    let intentLocked = null; // 'vertical' | 'horizontal' | null

                    el.addEventListener('touchstart', (e) => {
                        startX = e.touches[0].clientX;
                        startY = e.touches[0].clientY;
                        intentLocked = null;
                        this.touchStartX = startX;
                        this.touchStartY = startY;
                    }, { passive: true });

                    // Non-passive so we can preventDefault on vertical swipes
                    el.addEventListener('touchmove', (e) => {
                        if (!isMobile()) return;

                        const dx = e.touches[0].clientX - startX;
                        const dy = e.touches[0].clientY - startY;

                        if (!intentLocked) {
                            if (Math.abs(dx) > 8 || Math.abs(dy) > 8) {
                                intentLocked = Math.abs(dy) > Math.abs(dx) ? 'vertical' : 'horizontal';
                            }
                        }

                        if (intentLocked === 'vertical') {
                            e.preventDefault(); // stops scroll + pull-to-refresh
                        }
                    }, { passive: false });

                    el.addEventListener('touchend', (e) => {
                        if (!isMobile()) return;

                        const dx = e.changedTouches[0].clientX - this.touchStartX;
                        const dy = e.changedTouches[0].clientY - this.touchStartY;
                        const absDx = Math.abs(dx);
                        const absDy = Math.abs(dy);

                        // Tap → reveal
                        if (absDx < SWIPE_THRESHOLD && absDy < SWIPE_THRESHOLD) {
                            this.reveal();
                            return;
                        }

                        if (intentLocked === 'horizontal') {
                            if (absDx > SWIPE_THRESHOLD) this.reveal();
                        } else if (intentLocked === 'vertical') {
                            if (dy < -SWIPE_THRESHOLD) this.next();
                            else if (dy > SWIPE_THRESHOLD) this.prev();
                        }
                    }, { passive: true });
                },

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
                    const mobile = isMobile();
                    this._resetFlip(this.topIndex);

                    card.style.zIndex = '9999';
                    card.classList.add(mobile ? 'slide-out-up' : 'slide-out-right');

                    setTimeout(() => {
                        card.classList.remove(mobile ? 'slide-out-up' : 'slide-out-right');
                        card.classList.add(mobile ? 'slide-in-down' : 'slide-in-left');

                        this.topIndex = (this.topIndex + 1) % this.total;

                        setTimeout(() => {
                            card.classList.remove(mobile ? 'slide-in-down' : 'slide-in-left');
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
                    const mobile = isMobile();

                    this._resetFlip(this.topIndex);

                    card.style.opacity = '0';
                    card.style.transform = mobile ? 'translateY(120%)' : 'translateX(-120%)';
                    card.style.zIndex = '9999';

                    requestAnimationFrame(() => {
                        requestAnimationFrame(() => {
                            card.classList.add(mobile ? 'rise-up' : 'rise-right');

                            setTimeout(() => {
                                card.classList.remove(mobile ? 'rise-up' : 'rise-right');
                                card.classList.add(mobile ? 'slide-in-up' : 'slide-in-right');

                                setTimeout(() => {
                                    card.classList.remove(mobile ? 'slide-in-up' : 'slide-in-right');
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
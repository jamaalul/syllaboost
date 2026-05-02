@extends('layouts.app')

@section('title', $deck->name . ' \ Syllaboost')

@section('content')
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
        $logo = 'M7.2132 0.84923C15.4142 9.05024 28.7107 9.05024 36.9117 0.84923L43.2756 7.21319C35.0746 15.4142 35.0746 28.7107 43.2756 36.9117L36.9117 43.2756C29.2982 35.6622 26.6342 24.9751 28.916 15.2089C19.1498 17.4906 8.4627 14.8267 0.849236 7.21319L7.2132 0.84923ZM15.6985 22.0624L22.0624 28.4264L7.2132 43.2756L0.849236 36.9117L15.6985 22.0624Z';
    @endphp

    <div id="card-slider" class="relative flex justify-center items-center bg-zinc-100 w-screen h-dvh" tabindex="0">

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

        {{--
        Three fixed, named DOM nodes — A, B, C — always present, never recreated.
        The JS layer decides which one is 'prev', 'current', and 'next' by rotating
        a roles pointer. Content is written imperatively via .textContent only while
        the target node is fully off-screen, so nothing visible ever flashes.
        --}}
        @foreach (['a', 'b', 'c'] as $node)
            <div id="card-node-{{ $node }}"
                class="absolute bg-white border-x border-zinc-200 rounded-3xl w-[80vw] md:w-[50vw] lg:w-80 aspect-2/3 card-item"
                style="perspective: 1000px; will-change: transform, opacity;">
                <div class="border border-zinc-200 w-full h-full card-flip-inner">
                    {{-- front --}}
                    <div class="relative p-6 rounded-3xl card-face card-front">
                        <p class="font-bold text-zinc-950 text-2xl card-front-text"></p>
                        <span class="right-6 bottom-6 absolute text-zinc-200">
                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg"
                                class="size-7">
                                <path d="{{ $logo }}" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                    {{-- back --}}
                    <div class="{{ $color }} p-6 relative rounded-3xl card-face card-back">
                        <p class="font-bold text-white text-2xl card-back-text"></p>
                        <span class="right-6 bottom-6 absolute text-white">
                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg"
                                class="size-7">
                                <path d="{{ $logo }}" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- top bar: back link + counter --}}
        <div class="top-4 md:top-10 absolute w-full">
            <div class="flex justify-between mx-auto p-4 w-full max-w-5xl">
                <a href="{{ route('decks.index') }}" id="back-link"
                    class="flex justify-center items-center gap-2 w-24 font-medium text-zinc-500 hover:text-zinc-700 transition-colors">
                    <span id="back-label" class="flex justify-center items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                        Back
                    </span>
                    <span id="back-spinner" class="hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="animate-spin">
                            <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                        </svg>
                    </span>
                </a>
                <span id="card-counter" class="font-medium tabular-nums text-zinc-500 text-sm"></span>
            </div>
        </div>

        {{-- hint bar --}}
        <div class="bottom-8 absolute flex items-center gap-2 text-zinc-500 text-sm select-none">
            <div id="hint-desktop" class="hidden md:flex items-center gap-2">
                <kbd class="bg-white shadow-sm px-2 py-1 border border-zinc-300 rounded-md font-mono text-xs">←</kbd>
                <span>Prev</span>
                <span class="text-zinc-300">|</span>
                <kbd class="bg-white shadow-sm px-2 py-1 border border-zinc-300 rounded-md font-mono text-xs">→</kbd>
                <span>Next</span>
                <span class="text-zinc-300">|</span>
                <kbd class="bg-white shadow-sm px-2 py-1 border border-zinc-300 rounded-md font-mono text-xs">Space</kbd>
                <span>Reveal</span>
            </div>
            <div id="hint-mobile" class="hidden items-center gap-2">
                <span class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path fill-rule="evenodd"
                            d="M10 2a.75.75 0 0 1 .75.75v12.59l1.95-2.1a.75.75 0 1 1 1.1 1.02l-3.25 3.5a.75.75 0 0 1-1.1 0l-3.25-3.5a.75.75 0 1 1 1.1-1.02l1.95 2.1V2.75A.75.75 0 0 1 10 2Z"
                            clip-rule="evenodd" />
                    </svg>
                    Prev
                </span>
                <span class="text-zinc-300">|</span>
                <span class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path fill-rule="evenodd"
                            d="M10 18a.75.75 0 0 1-.75-.75V4.66L7.3 6.76a.75.75 0 0 1-1.1-1.02l3.25-3.5a.75.75 0 0 1 1.1 0l3.25 3.5a.75.75 0 1 1-1.1 1.02l-1.95-2.1v12.59A.75.75 0 0 1 10 18Z"
                            clip-rule="evenodd" />
                    </svg>
                    Next
                </span>
                <span class="text-zinc-300">|</span>
                <span class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path
                            d="M10.766 7.51a.75.75 0 0 0-1.37.365l-.492 6.861a.75.75 0 0 0 1.204.65l1.043-.799.985 3.678a.75.75 0 0 0 1.45-.388l-.978-3.646 1.292.204a.75.75 0 0 0 .74-1.16l-3.874-5.764Z" />
                    </svg>
                    /
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path fill-rule="evenodd"
                            d="M13.2 2.24a.75.75 0 0 0 .04 1.06l2.1 1.95H6.75a.75.75 0 0 0 0 1.5h8.59l-2.1 1.95a.75.75 0 1 0 1.02 1.1l3.5-3.25a.75.75 0 0 0 0-1.1l-3.5-3.25a.75.75 0 0 0-1.06.04Zm-6.4 8a.75.75 0 0 0-1.06-.04l-3.5 3.25a.75.75 0 0 0 0 1.1l3.5 3.25a.75.75 0 1 0 1.02-1.1l-2.1-1.95h8.59a.75.75 0 0 0 0-1.5H4.66l2.1-1.95a.75.75 0 0 0 .04-1.06Z"
                            clip-rule="evenodd" />
                    </svg>
                    Flip
                </span>
            </div>
        </div>

    </div>

    <style>
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

        /* Desktop (X axis) */
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

        /* Mobile (Y axis) */
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
        (() => {
            const DURATION = 300;
            const SWIPE_THRESHOLD = 50;
            const isMobile = () => window.matchMedia('(pointer: coarse)').matches;

            // ── All card data — plain JS, never touches the DOM ──────────────────
            const ALL_CARDS = @json(collect($cards)->map(fn($c) => [
                'front' => $c->front_content,
                'back' => $c->back_content,
            ]));
            const TOTAL = ALL_CARDS.length;
            const wrap = i => ((i % TOTAL) + TOTAL) % TOTAL;

            // ── Three physical DOM nodes (fixed, never recreated) ─────────────────
            const nodes = ['a', 'b', 'c'].map(id => document.getElementById('card-node-' + id));

            // ── Role pointer ──────────────────────────────────────────────────────
            // roles is always a permutation of [0, 1, 2].
            // roles[0] → node index currently acting as 'prev'
            // roles[1] → node index currently acting as 'current'
            // roles[2] → node index currently acting as 'next'
            //
            // Advancing: rotate left  → [p,c,n] becomes [c,n,p]  (old prev recycles as next)
            // Going back: rotate right → [p,c,n] becomes [n,p,c]  (old next recycles as prev)
            let roles = [0, 1, 2];

            const nodeForRole = r => nodes[roles[r]]; // r: 0=prev, 1=current, 2=next
            const flipForRole = r => nodeForRole(r).querySelector('.card-flip-inner');

            // ── Write card content into a node (call only when node is off-screen) ─
            function writeCard(nodeIdx, cardIdx) {
                const node = nodes[nodeIdx];
                const card = ALL_CARDS[wrap(cardIdx)];
                node.querySelector('.card-front-text').textContent = card.front;
                node.querySelector('.card-back-text').textContent = card.back;
            }

            function applyZIndices() {
                nodeForRole(1).style.zIndex = '25'; // current — on top
                nodeForRole(2).style.zIndex = '22'; // next    — just below
                nodeForRole(0).style.zIndex = '20'; // prev    — hidden underneath
            }

            // ── State ─────────────────────────────────────────────────────────────
            let topIndex = 0;
            let animating = false;
            let revealed = false;

            // ── Bootstrap ─────────────────────────────────────────────────────────
            function boot() {
                writeCard(roles[0], topIndex - 1); // prev
                writeCard(roles[1], topIndex);     // current
                writeCard(roles[2], topIndex + 1); // next
                applyZIndices();
                updateCounter();
            }

            // ── Flip ──────────────────────────────────────────────────────────────
            function reveal() {
                if (animating) return;
                revealed = !revealed;
                flipForRole(1).classList.toggle('is-flipped', revealed);
            }

            function unflipCurrent() {
                const flip = flipForRole(1);
                flip.style.transition = 'none';
                flip.classList.remove('is-flipped');
                flip.offsetHeight; // force reflow
                flip.style.transition = '';
                revealed = false;
            }

            // ── next() ────────────────────────────────────────────────────────────
            // Mirrors prev() — two phases on CURRENT only.
            // Phase 1: current flies out (slide-out-right / slide-out-up).
            // Phase 2: current snaps back invisible via slide-in-left / slide-in-down
            //          (the keyframe ends at opacity:0 z-index:-10, so it's hidden).
            // The NEXT node is already underneath and is revealed as current leaves.
            // After phase 2: rotate roles, write new PREV into the recycled node.
            function next() {
                if (animating || TOTAL < 2) return;
                animating = true;
                unflipCurrent();

                const mobile = isMobile();
                const outCls = mobile ? 'slide-out-up' : 'slide-out-right';
                const inCls = mobile ? 'slide-in-down' : 'slide-in-left';

                const curEl = nodeForRole(1);
                curEl.style.zIndex = '9999';
                curEl.classList.add(outCls);

                setTimeout(() => {
                    curEl.classList.remove(outCls);
                    curEl.style.zIndex = '5';
                    curEl.classList.add(inCls);

                    setTimeout(() => {
                        curEl.classList.remove(inCls);
                        curEl.style.zIndex = '';

                        // Rotate left: [p,c,n] → [c,n,p]
                        roles = [roles[1], roles[2], roles[0]];
                        topIndex = wrap(topIndex + 1);

                        // Recycled node is now roles[2] — the new NEXT slot
                        writeCard(roles[2], topIndex + 1);

                        applyZIndices();
                        updateCounter();
                        animating = false;
                    }, DURATION);
                }, DURATION);
            }

            // ── prev() ────────────────────────────────────────────────────────────
            // The PREV node is already rendered but hidden behind CURRENT.
            // Rotate roles right first so the old PREV node becomes CURRENT,
            // then animate it sliding in.
            // Silently write new PREV content into the recycled node
            // now in the PREV role (the old NEXT, which is behind/under).
            function prev() {
                if (animating || TOTAL < 2) return;
                animating = true;
                unflipCurrent();

                const mobile = isMobile();
                const riseCls = mobile ? 'rise-up' : 'rise-right';
                const slideInCls = mobile ? 'slide-in-up' : 'slide-in-right';

                // Rotate right: [p,c,n] → [n,p,c]
                roles = [roles[2], roles[0], roles[1]];
                topIndex = wrap(topIndex - 1);

                // Recycled node is now roles[0] — the new PREV slot
                writeCard(roles[0], topIndex - 1);

                const inEl = nodeForRole(1);
                inEl.style.zIndex = '5';
                inEl.classList.add(riseCls);
                applyZIndices();

                setTimeout(() => {
                    inEl.classList.remove(riseCls);
                    inEl.style.zIndex = '9999';
                    inEl.classList.add(slideInCls);

                    setTimeout(() => {
                        inEl.classList.remove(slideInCls);
                        applyZIndices();
                        updateCounter();
                        animating = false;
                    }, DURATION);
                }, DURATION);
            }

            // ── Counter ───────────────────────────────────────────────────────────
            const counter = document.getElementById('card-counter');
            function updateCounter() {
                counter.textContent = `${topIndex + 1} / ${TOTAL}`;
            }

            // ── Keyboard ──────────────────────────────────────────────────────────
            document.addEventListener('keydown', e => {
                if (e.key === 'ArrowRight') { e.preventDefault(); next(); }
                else if (e.key === 'ArrowLeft') { e.preventDefault(); prev(); }
                else if (e.key === ' ') { e.preventDefault(); reveal(); }
            });

            // ── Touch ─────────────────────────────────────────────────────────────
            const slider = document.getElementById('card-slider');
            let touchStartX = 0, touchStartY = 0, intentLocked = null;

            slider.addEventListener('touchstart', e => {
                touchStartX = e.touches[0].clientX;
                touchStartY = e.touches[0].clientY;
                intentLocked = null;
            }, { passive: true });

            slider.addEventListener('touchmove', e => {
                if (!isMobile()) return;
                const dx = e.touches[0].clientX - touchStartX;
                const dy = e.touches[0].clientY - touchStartY;
                if (!intentLocked && (Math.abs(dx) > 8 || Math.abs(dy) > 8)) {
                    intentLocked = Math.abs(dy) > Math.abs(dx) ? 'vertical' : 'horizontal';
                }
                if (intentLocked === 'vertical') e.preventDefault();
            }, { passive: false });

            slider.addEventListener('touchend', e => {
                if (!isMobile()) return;
                const dx = e.changedTouches[0].clientX - touchStartX;
                const dy = e.changedTouches[0].clientY - touchStartY;
                if (Math.abs(dx) < SWIPE_THRESHOLD && Math.abs(dy) < SWIPE_THRESHOLD) {
                    reveal(); return;
                }
                if (intentLocked === 'horizontal' && Math.abs(dx) > SWIPE_THRESHOLD) {
                    reveal();
                } else if (intentLocked === 'vertical') {
                    if (dy < -SWIPE_THRESHOLD) next();
                    else if (dy > SWIPE_THRESHOLD) prev();
                }
            }, { passive: true });

            // ── Hint bar ──────────────────────────────────────────────────────────
            const isTouch = window.matchMedia('(pointer: coarse)').matches;
            document.getElementById('hint-desktop').classList.toggle('hidden', isTouch);
            const hintMobile = document.getElementById('hint-mobile');
            if (isTouch) hintMobile.classList.replace('hidden', 'flex');

            // ── Back button loading state ─────────────────────────────────────────
            document.getElementById('back-link').addEventListener('click', () => {
                document.getElementById('back-label').classList.add('hidden');
                document.getElementById('back-spinner').classList.remove('hidden');
            });

            // ── Go ────────────────────────────────────────────────────────────────
            boot();
        })();
    </script>
@endsection
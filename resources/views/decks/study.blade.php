@extends('layouts.feature')

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
        <div class="z-10 absolute bg-white border border-zinc-200 rounded-3xl h-[60vh] aspect-2/3 translate-y-4"></div>
        <div class="z-10 absolute bg-white border border-zinc-200 rounded-3xl h-[60vh] aspect-2/3 translate-y-3"></div>
        <div class="z-10 absolute bg-white border border-zinc-200 rounded-3xl h-[60vh] aspect-2/3 translate-y-2"></div>
        <div class="z-10 absolute bg-white border border-zinc-200 rounded-3xl h-[60vh] aspect-2/3 translate-y-1"></div>
        <div class="z-10 absolute bg-white border border-zinc-200 rounded-3xl h-[60vh] aspect-2/3"></div>

        {{--
        Three fixed, named DOM nodes — A, B, C — always present, never recreated.
        The JS layer decides which one is 'prev', 'current', and 'next' by rotating
        a roles pointer. Content is written imperatively via .textContent only while
        the target node is fully off-screen, so nothing visible ever flashes.
        --}}
        @foreach (['a', 'b', 'c'] as $node)
            <div id="card-node-{{ $node }}"
                class="absolute bg-white border-x border-zinc-200 rounded-3xl h-[60vh] aspect-2/3 card-item"
                style="perspective: 1000px; will-change: transform, opacity;">
                <div class="border border-zinc-200 w-full h-full card-flip-inner">
                    {{-- front --}}
                    <div class="relative p-6 rounded-3xl card-face card-front">
                        <p class="font-bold text-zinc-950 text-2xl card-front-text"></p>
                        <span class="right-6 bottom-6 absolute text-zinc-200">
                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-7">
                                <path d="{{ $logo }}" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                    {{-- back --}}
                    <div class="{{ $color }} p-6 relative rounded-3xl card-face card-back">
                        <p class="font-bold text-white text-2xl card-back-text"></p>
                        <span class="right-6 bottom-6 absolute text-white">
                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-7">
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
                <a href="{{ route('decks.index') }}"
                    class="flex justify-center items-center gap-2 w-24 font-medium text-zinc-500 hover:text-zinc-700 transition-colors">
                    <span id="back-label" class="flex justify-center items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                        Back
                    </span>
                </a>
                <span id="card-counter" class="font-medium tabular-nums text-zinc-500 text-sm"></span>
            </div>
        </div>

        {{-- hint bar --}}
        <div class="bottom-8 absolute flex items-center gap-2 text-zinc-500 text-sm select-none">
            <div id="hint-desktop" class="hidden md:flex items-center gap-2">
                <kbd class="bg-white shadow-sm px-2 py-1 border border-zinc-300 rounded-md font-mono text-xs">←</kbd>
                <span>Still Learning</span>
                <span class="text-zinc-300">|</span>
                <kbd class="bg-white shadow-sm px-2 py-1 border border-zinc-300 rounded-md font-mono text-xs">→</kbd>
                <span>Learned</span>
                <span class="text-zinc-300">|</span>
                <kbd class="bg-white shadow-sm px-2 py-1 border border-zinc-300 rounded-md font-mono text-xs">Space</kbd>
                <span>Reveal</span>
            </div>
            <div id="hint-mobile" class="hidden items-center gap-2">
                <span class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path fill-rule="evenodd" d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25A.75.75 0 0 1 17 10Z" clip-rule="evenodd" />
                    </svg>
                    Still Learning
                </span>
                <span class="text-zinc-300">|</span>
                <span class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.04-1.08l5.5 5.25a.75.75 0 0 1 0 1.08l-5.5 5.25a.75.75 0 1 1-1.04-1.08l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
                    </svg>
                    Learned
                </span>
                <span class="text-zinc-300">|</span>
                <span class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path d="M10 1a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0v-1.5A.75.75 0 0 1 10 1ZM5.05 3.05a.75.75 0 0 1 1.06 0l1.062 1.06A.75.75 0 1 1 6.11 5.173L5.05 4.11a.75.75 0 0 1 0-1.06ZM14.95 3.05a.75.75 0 0 1 0 1.06l-1.06 1.062a.75.75 0 0 1-1.062-1.061l1.061-1.06a.75.75 0 0 1 1.06 0ZM3 8a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5h-1.5A.75.75 0 0 1 3 8ZM14 8a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5h-1.5A.75.75 0 0 1 14 8ZM7.172 10.828a.75.75 0 0 1 0 1.061L6.11 12.95a.75.75 0 0 1-1.06-1.06l1.06-1.06a.75.75 0 0 1 1.06 0ZM10.766 7.51a.75.75 0 0 0-1.37.365l-.492 6.861a.75.75 0 0 0 1.204.65l1.043-.799.985 3.678a.75.75 0 0 0 1.45-.388l-.978-3.646 1.292.204a.75.75 0 0 0 .74-1.16l-3.874-5.764Z" />
                    </svg>
                    Reveal
                </span>
            </div>
        </div>

        {{-- Visual feedback pop-up --}}
        <div id="visual-feedback" class="top-1/9 z-[1000] absolute opacity-0 transition-opacity duration-200 pointer-events-none">
            <span id="visual-feedback-text"></span>
        </div>

        {{-- Session summary overlay --}}
        <div id="summary-overlay"
            class="hidden z-[100] absolute inset-0 flex justify-center items-center bg-white/20 backdrop-blur-xs">
            <div class="flex flex-col items-center gap-6 p-4 w-full max-w-sm">
                <div class="text-center">
                    <p class="mb-1 font-medium text-zinc-400 text-sm uppercase tracking-widest">Session Complete</p>
                    <h2 class="font-bold text-zinc-900 text-2xl">{{ $deck->name }}</h2>
                </div>
                <div class="flex flex-col gap-3 w-full">
                    <div class="flex justify-between items-center rounded-2xl">
                        <span class="flex items-center gap-2 font-semibold text-emerald-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            Learned
                        </span>
                        <span id="summary-learned" class="font-bold text-emerald-700 text-2xl">0</span>
                    </div>
                    <div class="flex justify-between items-center rounded-2xl">
                        <span class="flex items-center gap-2 font-semibold text-amber-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 0 0-3.7-3.7 48.678 48.678 0 0 0-7.324 0 4.006 4.006 0 0 0-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 0 0 3.7 3.7 48.656 48.656 0 0 0 7.324 0 4.006 4.006 0 0 0 3.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3-3 3" />
                            </svg>
                            Still Learning
                        </span>
                        <span id="summary-still" class="font-bold text-amber-700 text-2xl">0</span>
                    </div>
                </div>
                <div class="flex flex-col gap-3 w-full">
                    <button id="btn-study-again"
                        class="flex-1 {{ $color }} hover:opacity-90 py-3 rounded-2xl font-semibold text-white transition-colors cursor-pointer">
                        Review Again
                    </button>
                    <a href="{{ route('decks.index') }}"
                        class="flex flex-1 justify-center items-center bg-zinc-200 hover:bg-zinc-300 py-3 rounded-2xl font-semibold text-zinc-800 transition-colors cursor-pointer">
                        See Other Decks
                    </a>
                </div>
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

        .card-front { background: white; }
        .card-back  { transform: rotateY(180deg); }

        /* ── Right-exit (Learned) ─────────────────────────────── */
        .card-item.slide-out-right {
            animation: slide-out-right 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
        .card-item.slide-in-left {
            animation: slide-in-left 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        @keyframes slide-out-right {
            0%   { transform: translateX(0) rotate(0deg); }
            100% { transform: translateX(120%) rotate(5deg); }
        }
        @keyframes slide-in-left {
            0%   { transform: translateX(120%) rotate(5deg); }
            100% { transform: translateX(0) rotate(0deg); opacity: 0; z-index: -10; }
        }

        /* ── Left-exit (Still Learning) ──────────────────────── */
        .card-item.slide-out-left {
            animation: slide-out-left 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
        .card-item.snap-back-right {
            animation: snap-back-right 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        @keyframes slide-out-left {
            0%   { transform: translateX(0) rotate(0deg); }
            100% { transform: translateX(-120%) rotate(-5deg); }
        }
        @keyframes snap-back-right {
            0%   { transform: translateX(-120%) rotate(-5deg); }
            100% { transform: translateX(0) rotate(0deg); opacity: 0; z-index: -10; }
        }

        /* ── Unused legacy animations (kept for compatibility) ── */
        .card-item.rise-right  { animation: rise-right  0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
        .card-item.slide-in-right { animation: slide-in-right 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards; }

        @keyframes rise-right {
            0%   { transform: translateX(0) rotate(0deg); opacity: 0; }
            20%  { opacity: 0; }
            100% { transform: translateX(120%) rotate(5deg); opacity: 1; }
        }
        @keyframes slide-in-right {
            0%   { transform: translateX(120%) rotate(5deg); opacity: 1; }
            100% { transform: translateX(0) rotate(0deg); opacity: 1; }
        }
    </style>

    <script>
        (() => {
            const DURATION       = 300;
            const SWIPE_THRESHOLD = 50;
            const DECK_ID        = {{ $deck->id }};
            const RATINGS_URL    = '{{ route('ratings.store') }}';
            const CSRF_TOKEN     = '{{ csrf_token() }}';

            // ── Card data (includes id for rating submission) ─────────────────
            @php
                $allCardsData = collect($cards)->map(fn($c) => [
                    'id'    => $c->id,
                    'front' => $c->front_content,
                    'back'  => $c->back_content,
                ]);
            @endphp
            const ALL_CARDS = @json($allCardsData);
            const TOTAL = ALL_CARDS.length;
            const wrap  = i => ((i % TOTAL) + TOTAL) % TOTAL;

            // ── Session ratings tracker (cardId → rating) ─────────────────────
            const sessionRatings = @json($previousRatings);

            // ── DOM nodes ─────────────────────────────────────────────────────
            const nodes = ['a', 'b', 'c'].map(id => document.getElementById('card-node-' + id));

            // ── Role pointer ──────────────────────────────────────────────────
            let roles = [0, 1, 2];
            const nodeForRole = r => nodes[roles[r]];
            const flipForRole = r => nodeForRole(r).querySelector('.card-flip-inner');

            // ── Write card content (call only when node is off-screen) ────────
            function writeCard(nodeIdx, cardIdx) {
                const node = nodes[nodeIdx];
                const card = ALL_CARDS[wrap(cardIdx)];
                node.querySelector('.card-front-text').textContent = card.front;
                node.querySelector('.card-back-text').textContent  = card.back;
            }

            function applyZIndices() {
                nodeForRole(1).style.zIndex = '25';
                nodeForRole(2).style.zIndex = '22';
                nodeForRole(0).style.zIndex = '20';
            }

            // ── State ─────────────────────────────────────────────────────────
            let topIndex  = {{ $startIndex }};
            let animating = false;
            let revealed  = false;

            // ── Bootstrap ─────────────────────────────────────────────────────
            function boot() {
                animating = false;
                revealed  = false;
                roles     = [0, 1, 2];

                // Unflip all nodes instantly
                nodes.forEach(n => {
                    const fl = n.querySelector('.card-flip-inner');
                    fl.style.transition = 'none';
                    fl.classList.remove('is-flipped');
                    fl.offsetHeight;
                    fl.style.transition = '';
                });

                writeCard(roles[0], topIndex - 1);
                writeCard(roles[1], topIndex);
                writeCard(roles[2], topIndex + 1);
                applyZIndices();
                updateCounter();
            }

            // ── Flip ──────────────────────────────────────────────────────────
            function reveal() {
                if (animating) return;
                revealed = !revealed;
                flipForRole(1).classList.toggle('is-flipped', revealed);
            }

            function unflipCurrent() {
                const flip = flipForRole(1);
                flip.style.transition = 'none';
                flip.classList.remove('is-flipped');
                flip.offsetHeight;
                flip.style.transition = '';
                revealed = false;
            }

            // ── Rating submission (fire-and-forget) ───────────────────────────
            function submitRating(cardId, rating) {
                sessionRatings[cardId] = rating;
                fetch(RATINGS_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type':  'application/json',
                        'Accept':        'application/json',
                        'X-CSRF-TOKEN':  CSRF_TOKEN,
                    },
                    body: JSON.stringify({ card_id: cardId, deck_id: DECK_ID, rating }),
                }).catch(() => {});
            }

            // ── Summary screen ────────────────────────────────────────────────
            const summaryOverlay  = document.getElementById('summary-overlay');
            const summaryLearned  = document.getElementById('summary-learned');
            const summaryStill    = document.getElementById('summary-still');

            function computeSummaryCounts() {
                const entries = Object.values(sessionRatings);
                const learned       = entries.filter(r => r === 'learned').length;
                const stillLearning = entries.filter(r => r === 'still_learning').length;
                return { learned, stillLearning };
            }

            function showSummary() {
                const { learned, stillLearning } = computeSummaryCounts();
                summaryLearned.textContent = learned;
                summaryStill.textContent   = stillLearning;
                summaryOverlay.classList.remove('hidden');
            }

            document.getElementById('btn-study-again').addEventListener('click', () => {
                summaryOverlay.classList.add('hidden');
                // Clear session ratings so Study Again starts fresh
                Object.keys(sessionRatings).forEach(k => delete sessionRatings[k]);
                topIndex = 0;
                boot();
            });

            // ── rateAndNext() ─────────────────────────────────────────────────
            // direction: 'learned' (right-exit) | 'still_learning' (left-exit)
            function rateAndNext(direction) {
                if (animating || TOTAL === 0) return;
                animating = true;
                unflipCurrent();

                const feedbackEl = document.getElementById('visual-feedback');
                const feedbackTextEl = document.getElementById('visual-feedback-text');
                
                if (direction === 'learned') {
                    feedbackTextEl.textContent = 'Learned';
                    feedbackTextEl.className = 'text-emerald-600 font-bold text-4xl';
                } else {
                    feedbackTextEl.textContent = 'Still Learning';
                    feedbackTextEl.className = 'text-yellow-500 font-bold text-4xl';
                }
                
                feedbackEl.classList.remove('opacity-0');
                feedbackEl.classList.add('opacity-100');
                
                if (window.feedbackTimeout) clearTimeout(window.feedbackTimeout);
                window.feedbackTimeout = setTimeout(() => {
                    feedbackEl.classList.remove('opacity-100');
                    feedbackEl.classList.add('opacity-0');
                }, 500);

                const card     = ALL_CARDS[wrap(topIndex)];
                const outCls   = direction === 'learned' ? 'slide-out-right' : 'slide-out-left';
                const inCls    = direction === 'learned' ? 'slide-in-left'   : 'snap-back-right';

                // Fire-and-forget rating — does NOT block animation
                submitRating(card.id, direction);

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
                        roles    = [roles[1], roles[2], roles[0]];
                        topIndex = topIndex + 1;

                        if (topIndex >= TOTAL) {
                            animating = false;
                            showSummary();
                            return;
                        }

                        writeCard(roles[2], topIndex + 1);
                        applyZIndices();
                        updateCounter();
                        animating = false;
                    }, DURATION);
                }, DURATION);
            }

            // ── Counter ───────────────────────────────────────────────────────
            const counter = document.getElementById('card-counter');
            function updateCounter() {
                if (TOTAL === 0) { counter.textContent = ''; return; }
                counter.textContent = `${topIndex + 1} / ${TOTAL}`;
            }

            // ── Keyboard ──────────────────────────────────────────────────────
            document.addEventListener('keydown', e => {
                if (topIndex >= TOTAL) return;
                if (e.key === 'ArrowRight') { e.preventDefault(); rateAndNext('learned'); }
                else if (e.key === 'ArrowLeft') { e.preventDefault(); rateAndNext('still_learning'); }
                else if (e.key === ' ') { e.preventDefault(); reveal(); }
            });

            // ── Touch ─────────────────────────────────────────────────────────
            const slider = document.getElementById('card-slider');
            let touchStartX = 0, touchStartY = 0, intentLocked = null;

            slider.addEventListener('touchstart', e => {
                if (topIndex >= TOTAL) return;
                touchStartX  = e.touches[0].clientX;
                touchStartY  = e.touches[0].clientY;
                intentLocked = null;
            }, { passive: true });

            slider.addEventListener('touchmove', e => {
                if (topIndex >= TOTAL) return;
                const dx = e.touches[0].clientX - touchStartX;
                const dy = e.touches[0].clientY - touchStartY;
                if (!intentLocked && (Math.abs(dx) > 8 || Math.abs(dy) > 8)) {
                    intentLocked = Math.abs(dx) > Math.abs(dy) ? 'horizontal' : 'vertical';
                }
                if (intentLocked === 'horizontal') e.preventDefault();
            }, { passive: false });

            slider.addEventListener('touchend', e => {
                if (topIndex >= TOTAL) return;
                const dx = e.changedTouches[0].clientX - touchStartX;
                const dy = e.changedTouches[0].clientY - touchStartY;

                // Tap — no movement
                if (Math.abs(dx) < SWIPE_THRESHOLD && Math.abs(dy) < SWIPE_THRESHOLD) {
                    reveal(); return;
                }

                // Horizontal swipe only
                if (intentLocked === 'horizontal' && Math.abs(dx) >= SWIPE_THRESHOLD) {
                    if (dx > 0) { rateAndNext('learned'); }
                    else        { rateAndNext('still_learning'); }
                }
                // Vertical swipes are intentionally unbound
            }, { passive: true });

            // ── Hint bar ──────────────────────────────────────────────────────
            const isTouch = (
                ('ontouchstart' in window || navigator.maxTouchPoints > 0) &&
                window.matchMedia('(pointer: coarse)').matches
            );
            document.getElementById('hint-desktop').classList.toggle('hidden', isTouch);
            const hintMobile = document.getElementById('hint-mobile');
            hintMobile.classList.toggle('hidden', !isTouch);
            hintMobile.classList.toggle('flex', isTouch);

            // ── Go ────────────────────────────────────────────────────────────
            if (TOTAL === 0 || topIndex >= TOTAL) {
                showSummary();
            } else {
                boot();
            }
        })();
    </script>
@endsection
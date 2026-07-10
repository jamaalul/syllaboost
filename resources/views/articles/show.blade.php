@extends('layouts.frontend')
@section('title', $article->title . ' — Syllaboost')

@push('head')
<meta name="description" content="{{ Str::limit(strip_tags($article->content), 160) }}">
<meta property="og:title" content="{{ $article->title }}">
<meta property="og:description" content="{{ Str::limit(strip_tags($article->content), 160) }}">
@if($article->image_path)
<meta property="og:image" content="{{ $article->image_path }}">
@endif
@endpush

@section('content')
{{-- Reading Progress Bar (width set by JS, colours via Tailwind classes applied inline) --}}
<div id="progress-bar"
     class="fixed top-0 left-0 z-[9999] h-[3px] w-0 bg-gradient-to-r from-indigo-500 via-violet-500 to-purple-400 transition-[width] duration-100 ease-linear">
</div>

<div class="min-h-screen bg-white">

    @if($article->image_path)
    {{-- ── Hero: full-width image with overlaid title ── --}}
    <div class="relative w-full h-72 md:h-[480px] bg-zinc-900 overflow-hidden">
        <img src="{{ $article->image_path }}"
             alt="{{ $article->title }}"
             class="w-full h-full object-cover opacity-70">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>

        {{-- Back button --}}
        <div class="absolute top-6 left-6">
            <a href="{{ route('articles.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-black/20 backdrop-blur-sm text-white/80 hover:text-white hover:bg-black/30 text-sm font-medium transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m19 12H5"/><path d="m12 19-7-7 7-7"/></svg>
                Articles
            </a>
        </div>

        {{-- Title overlay --}}
        <div class="absolute bottom-0 left-0 right-0 p-8 md:p-12">
            <div class="mx-auto max-w-3xl">
                @if($article->category)
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-widest bg-indigo-500/80 text-white backdrop-blur-sm mb-4">
                        {{ $article->category }}
                    </span>
                @endif
                <h1 class="text-3xl md:text-5xl font-bold text-white leading-tight tracking-tight">
                    {{ $article->title }}
                </h1>
            </div>
        </div>
    </div>

    {{-- Meta row beneath the hero image --}}
    <div class="border-b border-zinc-100">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 py-6 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-400 to-violet-500 flex items-center justify-center text-white text-sm font-bold shrink-0">S</div>
                <div>
                    <p class="text-sm font-semibold text-zinc-800">Syllaboost Team</p>
                    <p class="text-xs text-zinc-400">
                        {{ $article->published_at ? $article->published_at->format('F d, Y') : $article->created_at->format('F d, Y') }}
                        &middot;
                        {{ max(1, (int) ceil(str_word_count(strip_tags($article->content)) / 200)) }} min read
                    </p>
                </div>
            </div>
            <button id="copy-btn"
                    onclick="copyLink()"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full border border-zinc-200 text-sm font-medium text-zinc-600 hover:bg-zinc-50 hover:-translate-y-px active:translate-y-0 transition-all duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                Copy link
            </button>
        </div>
    </div>

    @else
    {{-- ── No image: clean typographic header ── --}}
    <div class="border-b border-zinc-100">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 pt-10 pb-8">
            <a href="{{ route('articles.index') }}"
               class="inline-flex items-center gap-2 text-zinc-400 hover:text-zinc-700 text-sm font-medium mb-8 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m19 12H5"/><path d="m12 19-7-7 7-7"/></svg>
                Back to Articles
            </a>

            @if($article->category)
                <div class="mb-5">
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-widest bg-indigo-50 text-indigo-600">
                        {{ $article->category }}
                    </span>
                </div>
            @endif

            <h1 class="text-3xl md:text-5xl font-bold text-zinc-900 leading-tight tracking-tight mb-6">
                {{ $article->title }}
            </h1>

            <div class="flex flex-wrap items-center justify-between gap-4 pb-8 border-b border-zinc-200">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-400 to-violet-500 flex items-center justify-center text-white text-sm font-bold shrink-0">S</div>
                    <div>
                        <p class="text-sm font-semibold text-zinc-800">Syllaboost Team</p>
                        <p class="text-xs text-zinc-400">
                            {{ $article->published_at ? $article->published_at->format('F d, Y') : $article->created_at->format('F d, Y') }}
                            &middot;
                            {{ max(1, (int) ceil(str_word_count(strip_tags($article->content)) / 200)) }} min read
                        </p>
                    </div>
                </div>
                <button id="copy-btn"
                        onclick="copyLink()"
                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full border border-zinc-200 text-sm font-medium text-zinc-600 hover:bg-zinc-50 hover:-translate-y-px active:translate-y-0 transition-all duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                    Copy link
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- ── Article Body ── --}}
    <div class="mx-auto max-w-3xl px-4 sm:px-6 py-12">
        <div class="font-serif text-lg leading-[1.9] text-zinc-800
                    [&>p]:mb-6
                    first-letter:float-left first-letter:text-[4.5rem] first-letter:font-bold first-letter:leading-[0.8] first-letter:pr-2 first-letter:pt-2 first-letter:font-serif first-letter:text-zinc-900">
            {!! nl2br(e($article->content)) !!}
        </div>
    </div>

    {{-- ── Article Footer ── --}}
    <div class="mx-auto max-w-3xl px-4 sm:px-6 pb-16">
        <div class="border-t border-zinc-200 pt-10">

            @if($article->category)
            <div class="flex items-center gap-2 mb-8">
                <span class="text-xs text-zinc-400 font-medium">Filed under</span>
                <span class="px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-widest bg-zinc-100 text-zinc-600">
                    {{ $article->category }}
                </span>
            </div>
            @endif

            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                <div>
                    <p class="text-sm font-semibold text-zinc-700 mb-3">Share this article</p>
                    <button id="copy-btn-footer"
                            onclick="copyLink()"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-zinc-900 text-white text-sm font-medium hover:bg-zinc-700 hover:-translate-y-px active:translate-y-0 transition-all duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                        Copy link
                    </button>
                </div>
                <a href="{{ route('articles.index') }}"
                   class="inline-flex items-center gap-2 text-sm text-zinc-500 hover:text-zinc-900 font-medium transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m19 12H5"/><path d="m12 19-7-7 7-7"/></svg>
                    Back to all articles
                </a>
            </div>

        </div>
    </div>

</div>

<script>
    // Reading progress bar
    window.addEventListener('scroll', function () {
        const scrollTop = window.scrollY;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const pct = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
        document.getElementById('progress-bar').style.width = pct + '%';
    });

    // Copy link with feedback
    function copyLink() {
        navigator.clipboard.writeText(window.location.href).then(function () {
            ['copy-btn', 'copy-btn-footer'].forEach(function (id) {
                const btn = document.getElementById(id);
                if (!btn) return;
                const orig = btn.innerHTML;
                btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Copied!`;
                setTimeout(function () { btn.innerHTML = orig; }, 2000);
            });
        });
    }
</script>
@endsection

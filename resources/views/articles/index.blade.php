@extends('layouts.frontend')
@section('title', 'Articles — Syllaboost')

@push('head')
<meta name="description" content="Read the latest articles, study tips, and updates from Syllaboost.">
@endpush

@section('content')
<div class="min-h-screen bg-white">

    {{-- Page Header --}}
    <div class="border-b border-zinc-200 bg-white">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 py-14 md:py-20">
            <div class="max-w-2xl">
                <div class="flex items-center gap-2 mb-5">
                    <div class="h-[3px] w-8 rounded-full bg-gradient-to-r from-indigo-500 to-violet-500"></div>
                    <span class="text-xs font-semibold uppercase tracking-widest text-zinc-400">Syllaboost Journal</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-zinc-900 tracking-tight leading-tight mb-4">
                    Articles & Updates
                </h1>
                <p class="text-zinc-500 text-lg leading-relaxed">
                    Deep dives, study strategies, and the latest news from the Syllaboost team.
                </p>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-6xl px-4 sm:px-6 py-12">

        @if($articles->count() > 0)

        {{-- Featured Article (first one) --}}
        @php $featured = $articles->getCollection()->first(); @endphp
        <div class="mb-14">
            <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400 mb-5">Featured</p>
            <a href="{{ route('articles.show', $featured->slug) }}"
               class="group grid grid-cols-1 md:grid-cols-2 bg-white rounded-2xl border border-zinc-200 overflow-hidden hover:shadow-2xl hover:shadow-zinc-200/80 transition-shadow duration-300">

                @if($featured->image_path)
                    <div class="relative h-64 md:h-auto bg-zinc-100 overflow-hidden">
                        <img src="{{ $featured->image_path }}"
                             alt="{{ $featured->title }}"
                             class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                    </div>
                @else
                    <div class="relative h-64 md:h-auto bg-gradient-to-br from-indigo-50 via-violet-50 to-purple-100 flex items-center justify-center overflow-hidden">
                        <span class="text-8xl opacity-20 select-none">✦</span>
                    </div>
                @endif

                <div class="p-8 md:p-10 flex flex-col justify-between">
                    <div>
                        @if($featured->category)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[0.7rem] font-semibold uppercase tracking-widest bg-zinc-100 text-zinc-600 mb-4">
                                {{ $featured->category }}
                            </span>
                        @endif
                        <h2 class="text-2xl md:text-3xl font-bold text-zinc-900 leading-tight mb-4 group-hover:text-indigo-700 transition-colors duration-200">
                            {{ $featured->title }}
                        </h2>
                        <p class="text-zinc-500 leading-relaxed line-clamp-3">
                            {{ Str::limit(strip_tags($featured->content), 180) }}
                        </p>
                    </div>
                    <div class="flex items-center justify-between mt-8 pt-6 border-t border-zinc-100">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-400 to-violet-500 flex items-center justify-center text-white text-xs font-bold shrink-0">S</div>
                            <div>
                                <p class="text-xs font-semibold text-zinc-700">Syllaboost Team</p>
                                <p class="text-xs text-zinc-400">{{ $featured->published_at ? $featured->published_at->format('M d, Y') : $featured->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 text-sm font-medium text-indigo-600 group-hover:gap-3 transition-all duration-200">
                            Read article
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </span>
                    </div>
                </div>
            </a>
        </div>

        {{-- Article Grid --}}
        @if($articles->getCollection()->count() > 1)
        <div class="mb-10">
            <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400 mb-6">More Articles</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($articles->getCollection()->slice(1) as $article)
                <a href="{{ route('articles.show', $article->slug) }}"
                   class="group bg-white rounded-2xl border border-zinc-200 overflow-hidden flex flex-col hover:-translate-y-1 hover:shadow-xl hover:shadow-zinc-200/70 transition-all duration-300">

                    {{-- Thumbnail --}}
                    <div class="relative h-48 bg-zinc-100 overflow-hidden shrink-0">
                        @if($article->image_path)
                            <img src="{{ $article->image_path }}"
                                 alt="{{ $article->title }}"
                                 class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-zinc-100 to-zinc-200 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-zinc-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="m3 9 4-4 4 4 4-4 4 4"/><path d="M3 15h18"/></svg>
                            </div>
                        @endif
                        @if($article->category)
                            <div class="absolute top-3 left-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[0.65rem] font-semibold uppercase tracking-widest bg-white/90 backdrop-blur-sm text-zinc-600 shadow-sm">
                                    {{ $article->category }}
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="text-base font-bold text-zinc-800 leading-snug mb-2 line-clamp-2 group-hover:text-indigo-700 transition-colors duration-200">
                            {{ $article->title }}
                        </h3>
                        <p class="text-sm text-zinc-500 leading-relaxed line-clamp-3 flex-1 mb-4">
                            {{ Str::limit(strip_tags($article->content), 120) }}
                        </p>
                        <div class="flex items-center justify-between pt-4 border-t border-zinc-100">
                            <p class="text-xs text-zinc-400">
                                {{ $article->published_at ? $article->published_at->format('M d, Y') : $article->created_at->format('M d, Y') }}
                            </p>
                            <span class="text-xs font-medium text-indigo-500 flex items-center gap-1 group-hover:gap-2 transition-all duration-200">
                                Read
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        @else
        {{-- Empty State --}}
        <div class="flex flex-col items-center justify-center py-28 text-center">
            <div class="w-16 h-16 rounded-2xl bg-zinc-100 flex items-center justify-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-zinc-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2z"/><path d="M2 13h4"/><path d="M2 7h4"/><path d="M2 19h4"/></svg>
            </div>
            <h3 class="text-xl font-bold text-zinc-900 mb-2">No articles yet</h3>
            <p class="text-zinc-500 max-w-xs">We're working on some great content. Check back soon!</p>
        </div>
        @endif

        {{-- Pagination --}}
        @if($articles->hasPages())
        <div class="mt-12 flex justify-center border-t border-zinc-100 pt-8">
            {{ $articles->links() }}
        </div>
        @endif

    </div>
</div>
@endsection

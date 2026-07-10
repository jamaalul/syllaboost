@extends('layouts.dashboard')
@section('title', 'Edit Deck \ Syllaboost')
@section('main')
<div class="max-w-3xl flex flex-col gap-6">

    {{-- Page Header --}}
    <div class="flex items-center gap-4 mb-2">
        <a href="{{ route('admin.decks.index') }}" class="p-2 text-zinc-400 hover:text-zinc-900 hover:bg-zinc-100 rounded-xl transition-colors">
            <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
        </a>
        <h1 class="text-3xl font-bold text-zinc-900">Edit Deck: {{ $deck->name }}</h1>
    </div>
    
    <div class="bg-white rounded-2xl border border-zinc-200 overflow-hidden shadow-sm shadow-zinc-100">
        <div class="bg-zinc-50 border-b border-zinc-200 px-6 py-4">
            <p class="text-xs font-semibold uppercase tracking-widest text-zinc-500">Deck Details</p>
        </div>
        
        <form action="{{ route('admin.decks.update', $deck) }}" method="POST" class="p-6 flex flex-col gap-6">
            @csrf
            @method('PUT')
            
            <div class="flex flex-col gap-2">
                <label class="text-sm font-semibold text-zinc-700">Name</label>
                <input type="text" name="name" value="{{ $deck->name }}" required 
                    class="w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 placeholder:text-zinc-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all shadow-sm">
            </div>
            
            <div class="flex flex-col gap-2">
                <label class="text-sm font-semibold text-zinc-700">Description</label>
                <textarea name="description" rows="4" 
                    class="w-full rounded-xl border-zinc-300 bg-white px-4 py-3 text-zinc-900 placeholder:text-zinc-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all shadow-sm text-sm leading-relaxed">{{ $deck->description }}</textarea>
            </div>
            
            <div class="flex flex-col gap-2">
                <label class="text-sm font-semibold text-zinc-700">Price (Rp)</label>
                <input type="number" name="price" value="{{ $deck->price }}" required min="0" 
                    class="w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 placeholder:text-zinc-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all shadow-sm font-mono">
            </div>
            
            <div class="flex items-center gap-3 p-4 bg-zinc-50 rounded-xl border border-zinc-100">
                <div class="flex items-center h-5">
                    <input type="checkbox" name="is_public" id="is_public" value="1" {{ $deck->is_public ? 'checked' : '' }} 
                        class="size-4 rounded border-zinc-300 text-indigo-600 focus:ring-indigo-600 focus:ring-offset-0">
                </div>
                <div class="flex flex-col">
                    <label for="is_public" class="text-sm font-semibold text-zinc-900 cursor-pointer">Public (Visible in Store if price > 0)</label>
                    <p class="text-xs text-zinc-500">Allow users to discover and purchase this deck.</p>
                </div>
            </div>
            
            <div class="border-t border-zinc-200 pt-6 mt-2 flex items-center justify-end gap-3">
                <a href="{{ route('admin.decks.index') }}" 
                    class="px-5 py-2.5 rounded-xl font-medium text-sm text-zinc-600 hover:text-zinc-900 hover:bg-zinc-100 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                    class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl font-semibold text-sm hover:bg-indigo-700 hover:scale-[1.02] active:scale-100 transition-all duration-150 shadow-sm shadow-indigo-200">
                    Update Deck
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

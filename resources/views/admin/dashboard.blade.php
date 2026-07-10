@extends('layouts.dashboard')
@section('title', 'Admin Dashboard \ Syllaboost')
@section('main')
<div class="flex flex-col gap-6">

    {{-- Page Header --}}
    <div class="flex justify-between items-center mb-2">
        <h1 class="text-3xl font-bold text-zinc-900">Admin Overview</h1>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        {{-- Total Users Card --}}
        <div class="bg-white p-6 rounded-2xl border border-zinc-200 flex items-start justify-between group hover:border-indigo-200 transition-colors">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-zinc-500 mb-1">Total Users</p>
                <p class="text-3xl font-bold text-zinc-900">{{ number_format($stats['users']) }}</p>
            </div>
            <div class="bg-indigo-50 text-indigo-600 rounded-xl p-3 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
            </div>
        </div>

        {{-- Total Decks Card --}}
        <div class="bg-white p-6 rounded-2xl border border-zinc-200 flex items-start justify-between group hover:border-purple-200 transition-colors">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-zinc-500 mb-1">Total Decks</p>
                <p class="text-3xl font-bold text-zinc-900">{{ number_format($stats['decks']) }}</p>
            </div>
            <div class="bg-purple-50 text-purple-600 rounded-xl p-3 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.5 6a3 3 0 00-3-3H6a3 3 0 00-3 3v7.5a3 3 0 003 3v-6A4.5 4.5 0 0110.5 6h6z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 7.5a3 3 0 013 3V18a3 3 0 01-3 3h-7.5a3 3 0 01-3-3v-7.5a3 3 0 013-3H18z" />
                </svg>
            </div>
        </div>

        {{-- Total Articles Card --}}
        <div class="bg-white p-6 rounded-2xl border border-zinc-200 flex items-start justify-between group hover:border-emerald-200 transition-colors">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-zinc-500 mb-1">Total Articles</p>
                <p class="text-3xl font-bold text-zinc-900">{{ number_format($stats['articles']) }}</p>
            </div>
            <div class="bg-emerald-50 text-emerald-600 rounded-xl p-3 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
            </div>
        </div>

        {{-- Total Transactions Card --}}
        <div class="bg-white p-6 rounded-2xl border border-zinc-200 flex items-start justify-between group hover:border-sky-200 transition-colors">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-zinc-500 mb-1">Total Orders</p>
                <p class="text-3xl font-bold text-zinc-900">{{ number_format($stats['transactions']) }}</p>
            </div>
            <div class="bg-sky-50 text-sky-600 rounded-xl p-3 group-hover:bg-sky-600 group-hover:text-white transition-colors">
                <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                </svg>
            </div>
        </div>

    </div>
</div>
@endsection

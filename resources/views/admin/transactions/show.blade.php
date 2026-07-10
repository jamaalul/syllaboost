@extends('layouts.dashboard')
@section('title', 'Transaction Detail \ Syllaboost')
@section('main')
<div class="max-w-3xl flex flex-col gap-6">

    {{-- Page Header --}}
    <div class="flex justify-between items-center mb-2">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.transactions.index') }}" class="p-2 text-zinc-400 hover:text-zinc-900 hover:bg-zinc-100 rounded-xl transition-colors">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-zinc-900">Transaction Details</h1>
        </div>
        
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-semibold rounded-full border
            {{ $transaction->status === 'success' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : '' }}
            {{ $transaction->status === 'pending' ? 'bg-amber-50 text-amber-700 border-amber-200' : '' }}
            {{ $transaction->status === 'failed'  ? 'bg-red-50 text-red-700 border-red-200' : '' }}">
            <span class="size-1.5 rounded-full
                {{ $transaction->status === 'success' ? 'bg-emerald-500' : '' }}
                {{ $transaction->status === 'pending' ? 'bg-amber-500' : '' }}
                {{ $transaction->status === 'failed'  ? 'bg-red-500' : '' }}">
            </span>
            {{ ucfirst($transaction->status) }}
        </span>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        {{-- Customer Info Card --}}
        <div class="bg-white rounded-2xl border border-zinc-200 overflow-hidden shadow-sm shadow-zinc-100">
            <div class="bg-zinc-50 border-b border-zinc-200 px-6 py-4">
                <p class="text-xs font-semibold uppercase tracking-widest text-zinc-500">Customer Details</p>
            </div>
            <div class="p-6 flex flex-col gap-4">
                <div class="flex items-center gap-4 mb-2">
                    <div class="flex justify-center items-center bg-indigo-100 rounded-full w-12 h-12 font-bold text-indigo-700 shrink-0 text-lg">
                        {{ substr($transaction->user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold text-zinc-900">{{ $transaction->user->name }}</p>
                        <p class="text-sm text-zinc-500">{{ $transaction->user->email }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Order Info Card --}}
        <div class="bg-white rounded-2xl border border-zinc-200 overflow-hidden shadow-sm shadow-zinc-100">
            <div class="bg-zinc-50 border-b border-zinc-200 px-6 py-4">
                <p class="text-xs font-semibold uppercase tracking-widest text-zinc-500">Order Information</p>
            </div>
            <div class="p-6 flex flex-col gap-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-zinc-500">Order ID</span>
                    <span class="font-mono font-medium text-zinc-900 bg-zinc-100 px-2 py-1 rounded text-xs">{{ $transaction->order_id }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-zinc-500">Date</span>
                    <span class="font-medium text-zinc-900">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-zinc-500">Payment Method</span>
                    <span class="font-medium text-zinc-900">GoPay / QRIS</span>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Order Items Card --}}
    <div class="bg-white rounded-2xl border border-zinc-200 overflow-hidden shadow-sm shadow-zinc-100">
        <div class="bg-zinc-50 border-b border-zinc-200 px-6 py-4">
            <p class="text-xs font-semibold uppercase tracking-widest text-zinc-500">Order Items</p>
        </div>
        <div class="p-0">
            <ul class="divide-y divide-zinc-100">
                @foreach($transaction->items as $item)
                <li class="px-6 py-4 flex justify-between items-center hover:bg-zinc-50/50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="bg-zinc-100 p-2 rounded-lg text-zinc-500">
                            <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.5 6a3 3 0 00-3-3H6a3 3 0 00-3 3v7.5a3 3 0 003 3v-6A4.5 4.5 0 0110.5 6h6z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 7.5a3 3 0 013 3V18a3 3 0 01-3 3h-7.5a3 3 0 01-3-3v-7.5a3 3 0 013-3H18z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-zinc-900">{{ $item->deck_name }}</p>
                            <p class="text-xs text-zinc-500 mt-0.5">Quantity: {{ $item->quantity }}</p>
                        </div>
                    </div>
                    <span class="font-semibold text-zinc-700">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="bg-zinc-50 px-6 py-4 border-t border-zinc-200 flex justify-between items-center">
            <span class="font-bold text-zinc-900 uppercase tracking-wide text-sm">Total Amount</span>
            <span class="font-bold text-2xl text-emerald-600">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
        </div>
    </div>
</div>
@endsection

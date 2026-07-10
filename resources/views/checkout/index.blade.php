@extends('layouts.dashboard')
@section('title', 'Checkout \ Syllaboost')
@section('main')
<div class="flex flex-col gap-6">

    {{-- Page Header --}}
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-zinc-900">Checkout</h1>
        <a href="{{ route('cart.index') }}" class="text-sm text-zinc-500 hover:text-zinc-800 transition-colors font-medium flex items-center gap-1.5">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Cart
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        {{-- Order Items --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-zinc-200 overflow-hidden">
            <div class="bg-zinc-50 border-b border-zinc-200 px-6 py-3">
                <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400">Order Summary</p>
            </div>
            <ul class="divide-y divide-zinc-200">
                @foreach($cart->items as $item)
                <li class="flex items-center justify-between px-6 py-5 gap-4">
                    <div class="flex items-center gap-4 min-w-0">
                        <div class="bg-zinc-100 rounded-xl p-3 flex-shrink-0">
                            <svg class="size-6 text-zinc-500" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M16.5 6a3 3 0 0 0-3-3H6a3 3 0 0 0-3 3v7.5a3 3 0 0 0 3 3v-6A4.5 4.5 0 0 1 10.5 6h6Z" />
                                <path d="M18 7.5a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-7.5a3 3 0 0 1-3-3v-7.5a3 3 0 0 1 3-3H18Z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h3 class="font-semibold text-zinc-900 truncate">{{ $item->deck->name }}</h3>
                            <p class="text-sm text-zinc-400 mt-0.5">Qty: {{ $item->quantity }}</p>
                        </div>
                    </div>
                    <span class="font-bold text-zinc-900 text-base flex-shrink-0">
                        Rp {{ number_format($item->deck->price * $item->quantity, 0, ',', '.') }}
                    </span>
                </li>
                @endforeach
            </ul>
        </div>

        {{-- Payment Summary --}}
        <div class="bg-white rounded-2xl border border-zinc-200 overflow-hidden">
            <div class="bg-zinc-50 border-b border-zinc-200 px-6 py-3">
                <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400">Payment Details</p>
            </div>
            <div class="p-6 flex flex-col gap-4">
                <div class="flex justify-between items-center text-sm text-zinc-500">
                    <span>Subtotal</span>
                    <span class="font-medium text-zinc-700">
                        Rp {{ number_format($cart->items->sum(fn($i) => $i->deck->price * $i->quantity), 0, ',', '.') }}
                    </span>
                </div>
                <div class="flex justify-between items-center text-sm text-zinc-500">
                    <span>Tax</span>
                    <span class="font-medium text-zinc-700">—</span>
                </div>
                <div class="border-t border-zinc-200 pt-4 flex justify-between items-center">
                    <span class="font-bold text-zinc-900">Total to Pay</span>
                    <span class="font-bold text-2xl text-emerald-600">
                        Rp {{ number_format($cart->items->sum(fn($i) => $i->deck->price * $i->quantity), 0, ',', '.') }}
                    </span>
                </div>

                <form action="{{ route('checkout.process') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit"
                        class="w-full bg-zinc-900 text-white px-6 py-3 rounded-xl font-bold hover:bg-zinc-800 hover:scale-[1.02] active:scale-100 transition-all duration-150">
                        Pay Now
                    </button>
                </form>

                <div class="flex items-center justify-center gap-2 text-zinc-400 text-xs">
                    <svg class="size-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <span>Secure payment · Instant access after purchase</span>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@extends('layouts.dashboard')
@section('title', 'Cart \ Syllaboost')
@section('main')
<div class="flex flex-col gap-6">

    {{-- Page Header --}}
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-zinc-900">Your Cart</h1>
        <a href="{{ route('store.index') }}" class="text-sm text-zinc-500 hover:text-zinc-800 transition-colors font-medium flex items-center gap-1.5">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Store
        </a>
    </div>

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-600 px-5 py-4 rounded-2xl text-sm font-medium">
            {{ session('error') }}
        </div>
    @endif

    @if(!$cart || $cart->items->count() === 0)

        {{-- Empty State --}}
        <div class="bg-white rounded-2xl border border-zinc-200 overflow-hidden">
            <div class="flex flex-col items-center justify-center py-20 gap-4 text-center px-6">
                <div class="bg-zinc-100 rounded-full p-5">
                    <svg class="size-8 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 6h13M7 13L5.4 5M10 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-zinc-900 font-semibold text-lg">Your cart is empty</p>
                    <p class="text-zinc-400 text-sm mt-1">Browse the store to find premium decks to add.</p>
                </div>
                <a href="{{ route('store.index') }}"
                    class="mt-2 bg-zinc-900 text-white px-6 py-2.5 rounded-xl font-semibold text-sm hover:bg-zinc-800 hover:scale-[1.02] active:scale-100 transition-all duration-150">
                    Browse Store
                </a>
            </div>
        </div>

    @else

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            {{-- Cart Items --}}
            <div class="lg:col-span-2 bg-white rounded-2xl border border-zinc-200 overflow-hidden">
                <div class="bg-zinc-50 border-b border-zinc-200 px-6 py-3">
                    <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400">
                        {{ $cart->items->count() }} {{ Str::plural('item', $cart->items->count()) }} in cart
                    </p>
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
                        <div class="flex items-center gap-6 flex-shrink-0">
                            <span class="font-bold text-emerald-600 text-base">
                                Rp {{ number_format($item->deck->price * $item->quantity, 0, ',', '.') }}
                            </span>
                            <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-xs font-semibold text-red-500 hover:text-red-700 border border-red-200 hover:border-red-400 px-3 py-1.5 rounded-lg transition-colors">
                                    Remove
                                </button>
                            </form>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Order Summary --}}
            <div class="bg-white rounded-2xl border border-zinc-200 overflow-hidden">
                <div class="bg-zinc-50 border-b border-zinc-200 px-6 py-3">
                    <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400">Order Summary</p>
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
                        <span class="font-bold text-zinc-900">Total</span>
                        <span class="font-bold text-2xl text-emerald-600">
                            Rp {{ number_format($cart->items->sum(fn($i) => $i->deck->price * $i->quantity), 0, ',', '.') }}
                        </span>
                    </div>
                    <a href="{{ route('checkout.index') }}"
                        class="mt-2 w-full text-center bg-zinc-900 text-white px-6 py-3 rounded-xl font-bold hover:bg-zinc-800 hover:scale-[1.02] active:scale-100 transition-all duration-150">
                        Proceed to Checkout
                    </a>
                    <p class="text-center text-zinc-400 text-xs">Instant access after purchase</p>
                </div>
            </div>

        </div>

    @endif

</div>
@endsection

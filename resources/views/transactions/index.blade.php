@extends('layouts.dashboard')
@section('title', 'Transaction History \ Syllaboost')
@section('main')
<div class="flex flex-col gap-6">

    {{-- Page Header --}}
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-zinc-900">Transaction History</h1>
        <a href="{{ route('store.index') }}" class="text-sm text-zinc-500 hover:text-zinc-800 transition-colors font-medium flex items-center gap-1.5">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 6h13M7 13L5.4 5M10 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z" />
            </svg>
            Browse Store
        </a>
    </div>

    @if($transactions->isEmpty())

        {{-- Empty State --}}
        <div class="bg-white rounded-2xl border border-zinc-200 overflow-hidden">
            <div class="flex flex-col items-center justify-center py-20 gap-4 text-center px-6">
                <div class="bg-zinc-100 rounded-full p-5">
                    <svg class="size-8 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <p class="text-zinc-900 font-semibold text-lg">No transactions yet</p>
                    <p class="text-zinc-400 text-sm mt-1">Your purchase history will appear here once you buy a deck.</p>
                </div>
                <a href="{{ route('store.index') }}"
                    class="mt-2 bg-zinc-900 text-white px-6 py-2.5 rounded-xl font-semibold text-sm hover:bg-zinc-800 hover:scale-[1.02] active:scale-100 transition-all duration-150">
                    Browse Store
                </a>
            </div>
        </div>

    @else

        {{-- Transactions Table --}}
        <div class="bg-white rounded-2xl border border-zinc-200 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-zinc-50 border-b border-zinc-200 text-zinc-500">
                    <tr>
                        <th class="px-6 py-3 font-medium">Order ID</th>
                        <th class="px-6 py-3 font-medium">Items</th>
                        <th class="px-6 py-3 font-medium">Date</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200">
                    @foreach($transactions as $transaction)
                    <tr class="align-top">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-zinc-900 text-sm font-mono">{{ $transaction->order_id }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <ul class="space-y-1">
                                @foreach($transaction->items as $item)
                                <li class="text-sm text-zinc-600 flex items-center gap-1.5">
                                    <svg class="size-3.5 text-zinc-300 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M16.5 6a3 3 0 0 0-3-3H6a3 3 0 0 0-3 3v7.5a3 3 0 0 0 3 3v-6A4.5 4.5 0 0 1 10.5 6h6Z" />
                                        <path d="M18 7.5a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-7.5a3 3 0 0 1-3-3v-7.5a3 3 0 0 1 3-3H18Z" />
                                    </svg>
                                    <span class="font-medium text-zinc-700">{{ $item->deck_name }}</span>
                                    <span class="text-zinc-400">×{{ $item->quantity }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-6 py-4 text-sm text-zinc-500 whitespace-nowrap">
                            {{ $transaction->created_at->format('d M Y') }}
                            <br>
                            <span class="text-zinc-400 text-xs">{{ $transaction->created_at->format('H:i') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full
                                {{ $transaction->status === 'success' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                {{ $transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $transaction->status === 'failed'  ? 'bg-red-100 text-red-700'     : '' }}">
                                <span class="size-1.5 rounded-full
                                    {{ $transaction->status === 'success' ? 'bg-emerald-500' : '' }}
                                    {{ $transaction->status === 'pending' ? 'bg-yellow-500' : '' }}
                                    {{ $transaction->status === 'failed'  ? 'bg-red-500'    : '' }}">
                                </span>
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-emerald-600 whitespace-nowrap">
                            Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $transactions->links() }}

    @endif

</div>
@endsection

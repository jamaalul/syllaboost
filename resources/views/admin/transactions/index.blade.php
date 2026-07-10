@extends('layouts.dashboard')
@section('title', 'Manage Transactions \ Syllaboost')
@section('main')
<div class="flex flex-col gap-6">

    {{-- Page Header --}}
    <div class="flex justify-between items-center mb-2">
        <h1 class="text-3xl font-bold text-zinc-900">Manage Transactions</h1>
    </div>
    
    @if($transactions->isEmpty())
        {{-- Empty State --}}
        <div class="bg-white rounded-2xl border border-zinc-200 overflow-hidden">
            <div class="flex flex-col items-center justify-center py-20 gap-4 text-center px-6">
                <div class="bg-zinc-100 rounded-full p-5">
                    <svg class="size-8 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-zinc-900 font-semibold text-lg">No transactions yet</p>
                    <p class="text-zinc-500 text-sm mt-1">When users make purchases, they will appear here.</p>
                </div>
            </div>
        </div>
    @else
        {{-- Table --}}
        <div class="bg-white rounded-2xl border border-zinc-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-zinc-50 border-b border-zinc-200 text-zinc-500">
                        <tr>
                            <th class="px-6 py-3 font-medium">Order ID & Date</th>
                            <th class="px-6 py-3 font-medium">Customer</th>
                            <th class="px-6 py-3 font-medium">Amount</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                            <th class="px-6 py-3 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200">
                        @foreach($transactions as $transaction)
                        <tr class="align-top group">
                            <td class="px-6 py-4">
                                <p class="font-semibold text-zinc-900 text-sm font-mono">{{ $transaction->order_id }}</p>
                                <p class="text-xs text-zinc-500 mt-0.5">{{ $transaction->created_at->format('M d, Y H:i') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-zinc-900">{{ $transaction->user->name }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold text-emerald-600">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full border
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
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.transactions.show', $transaction) }}" class="p-2 text-zinc-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="View details">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-4">
            {{ $transactions->links() }}
        </div>
    @endif
</div>
@endsection

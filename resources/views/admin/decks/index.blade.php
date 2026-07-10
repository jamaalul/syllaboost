@extends('layouts.dashboard')
@section('title', 'Manage Decks \ Syllaboost')
@section('main')
<div class="flex flex-col gap-6">

    {{-- Page Header --}}
    <div class="flex justify-between items-center mb-2">
        <h1 class="text-3xl font-bold text-zinc-900">Manage Products (Decks)</h1>
    </div>
    
    @if($decks->isEmpty())
        {{-- Empty State --}}
        <div class="bg-white rounded-2xl border border-zinc-200 overflow-hidden">
            <div class="flex flex-col items-center justify-center py-20 gap-4 text-center px-6">
                <div class="bg-zinc-100 rounded-full p-5">
                    <svg class="size-8 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                </div>
                <div>
                    <p class="text-zinc-900 font-semibold text-lg">No decks found</p>
                    <p class="text-zinc-500 text-sm mt-1">Users haven't created any decks yet.</p>
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
                            <th class="px-6 py-3 font-medium w-1/3">Name</th>
                            <th class="px-6 py-3 font-medium">Author</th>
                            <th class="px-6 py-3 font-medium">Price</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                            <th class="px-6 py-3 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200">
                        @foreach($decks as $deck)
                        <tr class="align-top group">
                            <td class="px-6 py-4">
                                <p class="font-medium text-zinc-900">{{ $deck->name }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-zinc-600">{{ $deck->user->name }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold text-emerald-600">Rp {{ number_format($deck->price, 0, ',', '.') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full border
                                    {{ $deck->is_public ? 'bg-sky-50 text-sky-700 border-sky-200' : 'bg-zinc-100 text-zinc-700 border-zinc-200' }}">
                                    <span class="size-1.5 rounded-full {{ $deck->is_public ? 'bg-sky-500' : 'bg-zinc-400' }}"></span>
                                    {{ $deck->is_public ? 'Public' : 'Private' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.decks.edit', $deck) }}" class="p-2 text-zinc-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.decks.destroy', $deck) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="p-2 text-zinc-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" onclick="return confirm('Delete this deck?')" title="Delete">
                                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-4">
            {{ $decks->links() }}
        </div>
    @endif
</div>
@endsection

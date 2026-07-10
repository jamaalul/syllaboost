@extends('layouts.dashboard')
@section('title', 'Manage Users \ Syllaboost')
@section('main')
<div class="flex flex-col gap-6">

    {{-- Page Header --}}
    <div class="flex justify-between items-center mb-2">
        <h1 class="text-3xl font-bold text-zinc-900">Manage Users</h1>
    </div>
    
    @if($users->isEmpty())
        {{-- Empty State --}}
        <div class="bg-white rounded-2xl border border-zinc-200 overflow-hidden">
            <div class="flex flex-col items-center justify-center py-20 gap-4 text-center px-6">
                <div class="bg-zinc-100 rounded-full p-5">
                    <svg class="size-8 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
                <div>
                    <p class="text-zinc-900 font-semibold text-lg">No users found</p>
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
                            <th class="px-6 py-3 font-medium w-1/3">User</th>
                            <th class="px-6 py-3 font-medium">Role</th>
                            <th class="px-6 py-3 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200">
                        @foreach($users as $user)
                        <tr class="align-top group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex justify-center items-center bg-indigo-100 rounded-full w-10 h-10 font-bold text-indigo-700 shrink-0">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <p class="font-medium text-zinc-900">{{ $user->name }}</p>
                                        <p class="text-xs text-zinc-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full border
                                    {{ $user->role === 'admin' ? 'bg-indigo-50 text-indigo-700 border-indigo-200' : 'bg-zinc-100 text-zinc-700 border-zinc-200' }}">
                                    @if($user->role === 'admin')
                                        <svg class="size-3 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-zinc-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>
                                    </a>
                                    @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="p-2 text-zinc-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" onclick="return confirm('Delete this user?')" title="Delete">
                                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection

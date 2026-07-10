@extends('layouts.dashboard')
@section('title', 'Edit User \ Syllaboost')
@section('main')
<div class="max-w-3xl flex flex-col gap-6">

    {{-- Page Header --}}
    <div class="flex items-center gap-4 mb-2">
        <a href="{{ route('admin.users.index') }}" class="p-2 text-zinc-400 hover:text-zinc-900 hover:bg-zinc-100 rounded-xl transition-colors">
            <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
        </a>
        <h1 class="text-3xl font-bold text-zinc-900">Edit User: {{ $user->name }}</h1>
    </div>
    
    <div class="bg-white rounded-2xl border border-zinc-200 overflow-hidden shadow-sm shadow-zinc-100">
        <div class="bg-zinc-50 border-b border-zinc-200 px-6 py-4 flex items-center gap-3">
            <div class="flex justify-center items-center bg-indigo-100 rounded-full w-8 h-8 font-bold text-indigo-700 shrink-0 text-xs">
                {{ substr($user->name, 0, 1) }}
            </div>
            <p class="text-xs font-semibold uppercase tracking-widest text-zinc-500">User Profile</p>
        </div>
        
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-6 flex flex-col gap-6">
            @csrf
            @method('PUT')
            
            <div class="flex flex-col gap-2">
                <label class="text-sm font-semibold text-zinc-700">Name</label>
                <input type="text" name="name" value="{{ $user->name }}" required 
                    class="w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 placeholder:text-zinc-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all shadow-sm">
            </div>
            
            <div class="flex flex-col gap-2">
                <label class="text-sm font-semibold text-zinc-700">Email Address</label>
                <input type="email" name="email" value="{{ $user->email }}" required 
                    class="w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 placeholder:text-zinc-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all shadow-sm">
            </div>
            
            <div class="flex flex-col gap-2">
                <label class="text-sm font-semibold text-zinc-700">Role</label>
                <div class="relative">
                    <select name="role" required 
                        class="w-full appearance-none rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all shadow-sm pr-10">
                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-zinc-500">
                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-zinc-500 mt-1">Admins have full access to the management dashboard.</p>
            </div>
            
            <div class="border-t border-zinc-200 pt-6 mt-2 flex items-center justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" 
                    class="px-5 py-2.5 rounded-xl font-medium text-sm text-zinc-600 hover:text-zinc-900 hover:bg-zinc-100 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                    class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl font-semibold text-sm hover:bg-indigo-700 hover:scale-[1.02] active:scale-100 transition-all duration-150 shadow-sm shadow-indigo-200">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.dashboard')
@section('title', 'Manage Articles \ Syllaboost')
@section('main')
<div class="flex flex-col gap-6">

    {{-- Page Header --}}
    <div class="flex justify-between items-center mb-2">
        <h1 class="text-3xl font-bold text-zinc-900">Manage Articles</h1>
        <a href="{{ route('admin.articles.create') }}" class="flex items-center gap-2 bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-semibold text-sm hover:bg-indigo-700 hover:scale-[1.02] active:scale-100 transition-all duration-150 shadow-sm shadow-indigo-200">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Create New
        </a>
    </div>
    
    @if($articles->isEmpty())
        {{-- Empty State --}}
        <div class="bg-white rounded-2xl border border-zinc-200 overflow-hidden">
            <div class="flex flex-col items-center justify-center py-20 gap-4 text-center px-6">
                <div class="bg-zinc-100 rounded-full p-5">
                    <svg class="size-8 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
                <div>
                    <p class="text-zinc-900 font-semibold text-lg">No articles found</p>
                    <p class="text-zinc-500 text-sm mt-1">Get started by creating a new article.</p>
                </div>
                <a href="{{ route('admin.articles.create') }}" class="mt-2 bg-indigo-50 text-indigo-700 px-6 py-2.5 rounded-xl font-semibold text-sm hover:bg-indigo-100 transition-colors">
                    Create Article
                </a>
            </div>
        </div>
    @else
        {{-- Table --}}
        <div class="bg-white rounded-2xl border border-zinc-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-zinc-50 border-b border-zinc-200 text-zinc-500">
                        <tr>
                            <th class="px-6 py-3 font-medium">Title</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                            <th class="px-6 py-3 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200">
                        @foreach($articles as $article)
                        <tr class="align-top group">
                            <td class="px-6 py-4">
                                <p class="font-medium text-zinc-900">{{ $article->title }}</p>
                                <p class="text-xs text-zinc-400 mt-0.5">{{ $article->created_at->format('M d, Y') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full border
                                    {{ $article->is_published ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-zinc-100 text-zinc-700 border-zinc-200' }}">
                                    <span class="size-1.5 rounded-full {{ $article->is_published ? 'bg-emerald-500' : 'bg-zinc-400' }}"></span>
                                    {{ $article->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.articles.edit', $article) }}" class="p-2 text-zinc-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="p-2 text-zinc-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" onclick="return confirm('Delete this article?')" title="Delete">
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
            {{ $articles->links() }}
        </div>
    @endif
</div>
@endsection

@extends('layouts.app')

@section('title')
    Dashboard \ Syllaboost
@endsection

@section('content')
    <section class="w-full h-screen flex flex-col items-center justify-center gap-4">
        <h1 class="text-3xl font-bold text-zinc-900">Dashboard</h1>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition duration-150">
                Log Out
            </button>
        </form>
    </section>
@endsection
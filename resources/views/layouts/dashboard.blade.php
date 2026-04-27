@extends('layouts.app')

@section('title')
    @yield('title', 'Dashboard \ Syllaboost')
@endsection

@section('content')
    <section class="flex bg-zinc-100 w-screen h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
        <!-- Mobile sidebar overlay -->
        <div x-show="sidebarOpen" x-transition.opacity class="lg:hidden z-20 fixed inset-0 bg-black/50"
            @click="sidebarOpen = false" style="display: none;"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="left-0 z-30 lg:static fixed inset-y-0 lg:inset-0 flex flex-col bg-zinc-100 w-64 transition-transform lg:translate-x-0 duration-300">
            <!-- Sidebar Header -->
            <div class="flex justify-between items-center px-6 py-4 border-zinc-200 border-b h-16">
                <span class="text-black">
                    <svg class="size-6" width="44" height="44" viewBox="0 0 44 44" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_29_199)">
                            <path
                                d="M7.2132 0.84923C15.4142 9.05024 28.7107 9.05024 36.9117 0.84923L43.2756 7.21319C35.0746 15.4142 35.0746 28.7107 43.2756 36.9117L36.9117 43.2756C29.2982 35.6622 26.6342 24.9751 28.916 15.2089C19.1498 17.4906 8.4627 14.8267 0.849236 7.21319L7.2132 0.84923ZM15.6985 22.0624L22.0624 28.4264L7.2132 43.2756L0.849236 36.9117L15.6985 22.0624Z"
                                fill="currentColor" />
                        </g>
                        <defs>
                            <clipPath id="clip0_29_199">
                                <rect width="44" height="44" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                </span>
                <button @click="sidebarOpen = false" class="lg:hidden text-zinc-500 hover:text-zinc-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 space-y-2 px-4 py-4 overflow-y-auto">
                <a href="{{ route('dashboard') }}"
                    class="group flex items-center bg-white px-4 py-2.5 rounded-lg font-medium text-sky-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="mr-2 size-5">
                        <path
                            d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                        <path
                            d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                    </svg>
                    Dashboard
                </a>
                <!-- Add more links here later -->
            </nav>

            <!-- Sidebar Footer (User Info & Logout) -->
            <div class="p-4 border-zinc-200 border-t">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex justify-center items-center bg-sky-100 rounded-full w-10 h-10 font-bold text-sky-700">
                        {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-zinc-900 text-sm truncate">{{ auth()->user()->name ?? 'User' }}</p>
                        <p class="text-zinc-500 text-xs truncate">{{ auth()->user()->email ?? 'user@example.com' }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex justify-center items-center bg-red-50 hover:bg-red-100 px-4 py-2 rounded-lg w-full font-medium text-red-600 text-sm transition-colors">
                        Log out
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex flex-col flex-1 bg-white h-screen overflow-hidden">
            <!-- Mobile Header -->
            <header class="lg:hidden flex justify-between items-center bg-white px-6 py-4 border-zinc-200 border-b h-16">
                <button @click="sidebarOpen = true" class="text-zinc-500 hover:text-zinc-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                        </path>
                    </svg>
                </button>
                <span class="text-black">
                    <svg class="size-6" width="44" height="44" viewBox="0 0 44 44" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_29_199)">
                            <path
                                d="M7.2132 0.84923C15.4142 9.05024 28.7107 9.05024 36.9117 0.84923L43.2756 7.21319C35.0746 15.4142 35.0746 28.7107 43.2756 36.9117L36.9117 43.2756C29.2982 35.6622 26.6342 24.9751 28.916 15.2089C19.1498 17.4906 8.4627 14.8267 0.849236 7.21319L7.2132 0.84923ZM15.6985 22.0624L22.0624 28.4264L7.2132 43.2756L0.849236 36.9117L15.6985 22.0624Z"
                                fill="currentColor" />
                        </g>
                        <defs>
                            <clipPath id="clip0_29_199">
                                <rect width="44" height="44" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                </span>
            </header>

            <!-- Page Content -->
            <div
                class="flex flex-col flex-1 justify-center md:items-center mr-auto p-4 md:p-8 border w-full max-w-5xl h-fit min-h-screen">
                @yield('main')
            </div>
        </main>
    </section>
@endsection
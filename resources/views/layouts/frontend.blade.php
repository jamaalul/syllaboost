<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Syllaboost')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>

<body class="bg-zinc-50 overflow-x-hidden antialiased"
    style="background-image: url('{{ asset('assets/mesh.webp') }}'); background-size: cover; background-attachment: fixed;">
    <div class="top-0 left-0 z-50 sticky flex justify-center items-center md:px-4 w-full h-16 md:h-24">
        <nav class="flex bg-white shadow-sm md:mx-4 p-2 md:p-1 md:rounded-full w-full max-w-5xl h-16 md:h-12">
            <a href="/" class="h-full">
                <img src="{{ asset('assets/logo.webp') }}" alt="Syllaboost Logo" class="px-4 py-2 h-full">
            </a>
            <div class="hidden md:flex items-center gap-2 ml-auto px-2 h-full">
                <a href="{{ route('articles.index') }}"
                    class="px-3 font-medium text-zinc-600 hover:text-zinc-950 transition">Articles</a>

                @auth
                    <a href="{{ route('dashboard') }}"
                        class="flex justify-center items-center bg-zinc-900 hover:bg-zinc-800 px-5 rounded-full h-full font-medium text-white transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                        class="flex justify-center items-center hover:bg-zinc-100 px-5 rounded-full h-full font-medium text-zinc-950 transition">Log
                        in</a>
                    <a href="{{ route('register') }}"
                        class="flex justify-center items-center bg-zinc-900 hover:bg-zinc-800 px-5 rounded-full h-full font-medium text-white transition">Sign
                        up</a>
                @endauth
            </div>
            <!-- Mobile Menu Placeholder -->
            <div class="md:hidden flex items-center ml-auto px-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="font-medium text-zinc-900">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-medium text-zinc-900">Login</a>
                @endauth
            </div>
        </nav>
    </div>

    <main class="min-h-screen">
        @yield('content')
    </main>

    <footer class="flex flex-col bg-white mt-24 border-zinc-200 border-t w-full">
        <div class="mx-auto px-10 py-12 w-full max-w-5xl text-zinc-500 text-sm text-center">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Syllaboost') }}. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
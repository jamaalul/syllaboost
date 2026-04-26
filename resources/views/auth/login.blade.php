@extends('layouts.app')

@section('title')
    Login back to your Syllaboost account \ Syllaboost
@endsection

@section('content')
    <section
        class="w-screen h-screen bg-zinc-100 flex flex-row items-center justify-center relative overflow-hidden bg-cover"
        style="background-image: url('{{ asset('assets/mesh.webp') }}');">
        <span class=" text-sky-600 absolute left-8 top-8 cursor-pointer hover:scale-105 transition duration-100"
            onclick="window.location.href = '{{ route('welcome') }}'">
            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
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
        <div class="flex justify-center items-center mx-auto p-10 md:pt-0 w-full max-w-5xl h-screen">
            <div class="flex flex-col gap-2 w-lg">
                <h1 class="font-bold text-zinc-950 text-3xl md:text-4xl mb-10">Log in back<br>to your account</h1>
                <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-2"
                    x-data="{ email: '', password: '', loading: false }" @submit="loading = true">
                    @csrf
                    <button
                        class="flex mb-4 flex-row gap-4 justify-center items-center w-full text-lg font-medium p-2 rounded-lg bg-zinc-200 hover:bg-zinc-300 active:scale-98 transition duration-100 cursor-pointer">
                        <img src="{{ asset('assets/google.webp') }}" alt="Google logo" class="size-5">
                        <span>Log in with Google</span>
                    </button>
                    <div class="flex mb-4 flex-row gap-4 items-center">
                        <span class="w-full h-0.5 bg-zinc-300"></span>
                        <span class="font-medium text-zinc-500">or</span>
                        <span class="w-full h-0.5 bg-zinc-300"></span>
                    </div>
                    <div>
                        <p class="font-medium text-zinc-500">Email</p>
                        <input type="email" name="email" id="email" required x-model="email"
                            class="w-full rounded-lg bg-white border border-zinc-300 text-lg py-1 px-2 focus:outline-violet-600">
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <a class="underline text-sm text-zinc-600 hover:text-zinc-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500"
                            href="{{ route('register') }}">
                            Don't have an account?
                        </a>

                        <button type="submit" :disabled="!email || loading"
                            class="flex flex-row justify-center w-24 items-center bg-zinc-950 disabled:bg-zinc-700 py-2 rounded-full h-fit text-white active:scale-98 transition duration-100 cursor-pointer disabled:cursor-not-allowed">
                            <span x-show="!loading">Log in</span>
                            <span x-show="loading" style="display: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-loader-circle-icon lucide-loader-circle animate-spin">
                                    <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                                </svg>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@extends('layouts.app')

@section('title')
    Verify your login \ Syllaboost
@endsection

@section('content')
    <section
        class="w-screen h-screen bg-zinc-100 flex flex-row items-center justify-center relative overflow-hidden bg-cover"
        style="background-image: url('{{ asset('assets/mesh.webp') }}');">
        <span class="text-sky-600 absolute left-8 top-8">
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
                <h1 class="font-bold text-zinc-950 text-3xl md:text-4xl mb-2">Check your email</h1>
                <p class="text-zinc-500 mb-6">We sent a 6-digit code to <strong>{{ $email }}</strong></p>

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-2 rounded-lg text-center">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('otp.verify') }}" class="flex flex-col gap-4"
                    x-data="{ otp: '', loading: false }" @submit="loading = true">
                    @csrf

                    <div>
                        <label for="otp" class="font-medium text-zinc-500">6-Digit Code</label>
                        <input type="text" name="otp" id="otp" required autofocus autocomplete="one-time-code" x-model="otp"
                            maxlength="6" pattern="\d{6}"
                            class="w-full rounded-lg bg-white border border-zinc-300 text-3xl tracking-[1rem] text-center py-2 px-2 focus:outline-sky-600 @error('otp') border-red-500 @enderror">
                        @error('otp')
                            <p class="text-sm text-red-500 mt-2 text-center">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="remember">
                            <span class="ms-2 text-sm text-zinc-600">Remember me</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <a class="underline text-sm text-zinc-600 hover:text-zinc-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500"
                            href="{{ route('login') }}">
                            Cancel
                        </a>

                        <button type="submit" :disabled="otp.length < 6 || loading"
                            class="flex flex-row justify-center w-28 items-center bg-zinc-950 disabled:bg-zinc-700 py-2 rounded-full h-fit text-white active:scale-98 transition duration-100 cursor-pointer disabled:cursor-not-allowed">
                            <span x-show="!loading">Verify</span>
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

                <div class="mt-4 text-center">
                    <form method="POST" action="{{ route('otp.resend') }}">
                        @csrf
                        <button type="submit" class="text-sm text-sky-600 hover:text-sky-700 hover:underline">
                            Didn't receive the code? Resend
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection
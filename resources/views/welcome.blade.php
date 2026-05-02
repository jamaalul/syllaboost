<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learn better with Syllaboost</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="{ loading: true }"
    x-init="$nextTick(() => { window.addEventListener('load', () => { setTimeout(() => { loading = false }, 300) }) })"
    class="overflow-x-hidden antialiased">

    {{-- Loading Screen --}}
    <div x-show="loading" x-transition:leave="transition ease-in-out duration-700"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="z-[9999] fixed inset-0 flex flex-col justify-center items-center bg-white"
        aria-label="Loading Syllaboost" role="status">
        <div class="flex flex-col items-center gap-6">
            <img src="{{ asset('assets/logo.webp') }}" alt="Syllaboost" class="opacity-90 w-auto h-8">
            <span class="block bg-zinc-400 rounded-full w-1 h-1 animate-ping"></span>
        </div>
    </div>
    <div class="top-0 left-0 z-10 fixed flex justify-center items-center md:px-4 w-screen h-16 md:h-24">
        <nav class="flex bg-white shadow-sm md:mx-4 p-2 md:p-1 md:rounded-full w-full max-w-5xl h-16 md:h-12">
            <img src="{{ asset('assets/logo.webp') }}" alt="Syllaboost Logo" class="px-4 py-2 h-full">
            <div class="hidden md:flex ml-auto h-full">
                <button x-data="{ loading: false }"
                    @click="loading = true; window.location.href = '{{ route('login') }}'" :disabled="loading"
                    class="flex justify-center items-center bg-none px-5 rounded-full w-24 h-full font-medium text-zinc-950 active:scale-98 transition duration-100 cursor-pointer disabled:cursor-not-allowed">
                    <span x-show="!loading">Log in</span>
                    <span x-show="loading">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="animate-spin lucide lucide-loader-circle-icon lucide-loader-circle">
                            <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                        </svg>
                    </span>
                </button>
                <button x-data="{ loading: false }"
                    @click="loading = true; window.location.href = '{{ route('register') }}'" :disabled="loading"
                    class="flex justify-center items-center bg-zinc-900 disabled:bg-zinc-700 px-5 rounded-full w-40 h-full font-medium text-white active:scale-98 transition duration-100 cursor-pointer disabled:cursor-not-allowed">
                    <span x-show="!loading">Sign up for free</span>
                    <span x-show="loading">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="animate-spin lucide lucide-loader-circle-icon lucide-loader-circle">
                            <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                        </svg>
                    </span>
                </button>
            </div>
            <div x-data="{ open: false }"
                class="md:hidden relative flex flex-col justify-start items-end ml-auto px-1 h-full">
                <button @click="open = !open" class="flex justify-center items-center h-full">
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-menu-icon lucide-menu">
                            <path d="M4 5h16" />
                            <path d="M4 12h16" />
                            <path d="M4 19h16" />
                        </svg></span>
                </button>
                <div class="top-16 right-4 z-20 fixed flex flex-col gap-2 bg-white shadow-sm p-1 rounded-3xl w-fit h-fit"
                    x-show="open" @click.outside="open = false">
                    <button x-data="{ loading: false }"
                        @click="loading = true; window.location.href = '{{ route('login') }}'" :disabled="loading"
                        class="flex justify-center items-center bg-none px-4 py-2 rounded-full w-32 text-zinc-950 active:scale-98 transition duration-100 cursor-pointer disabled:cursor-not-allowed">
                        <span x-show="!loading">Log in</span>
                        <span x-show="loading">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="animate-spin lucide lucide-loader-circle-icon lucide-loader-circle">
                                <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                            </svg>
                        </span>
                    </button>
                    <button x-data="{ loading: false }"
                        @click="loading = true; window.location.href = '{{ route('register') }}'" :disabled="loading"
                        class="flex justify-center items-center bg-zinc-950 disabled:bg-zinc-700 px-4 py-2 rounded-full w-32 text-white active:scale-98 transition duration-100 cursor-pointer disabled:cursor-not-allowed">
                        <span x-show="!loading">Sign up</span>
                        <span x-show="loading">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="animate-spin lucide lucide-loader-circle-icon lucide-loader-circle">
                                <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
        </nav>
    </div>
    <section class="flex flex-col justify-center items-center bg-zinc-50 bg-cover pt-16 md:pt-0 w-screen md:h-screen"
        style="background-image: url('{{ asset('assets/mesh.webp') }}');">
        <div class="flex flex-col justify-center md:items-center mx-auto p-10 md:pt-0 w-full max-w-5xl md:h-screen">
            <div class="bg-sky-200 mb-4 px-3 py-1 rounded-full w-fit">
                <p class="font-semibold text-sky-700 text-sm">1000+ students</p>
            </div>
            <div class="flex flex-col max-w-3xl">
                <h1 class="font-display font-medium text-zinc-950 text-4xl md:text-6xl md:text-center leading-[1.6]">We
                    Help You Study<br>How You Should've Been</h1>
                <p class="mt-10 max-w-2xl text-zinc-500 text-lg md:text-center">Start learning in the most effective way
                    with flashcards, spaced repetitions, and custom quizzes to achieve your academic goals.</p>
            </div>
            <button x-data="{ loading: false }"
                @click="loading = true; window.location.href = '{{ route('register') }}'" :disabled="loading"
                class="flex justify-center items-center bg-zinc-900 disabled:bg-zinc-700 mt-8 px-4 py-2 rounded-full w-full md:w-32 font-medium text-white hover:scale-105 active:scale-100 transition duration-100 cursor-pointer disabled:cursor-not-allowed">
                <span x-show="!loading">Get Started</span>
                <span x-show="loading">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="animate-spin lucide lucide-loader-circle-icon lucide-loader-circle">
                        <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                    </svg>
                </span>
            </button>
            <div class="flex flex-wrap justify-center gap-6 md:gap-12 mt-12">
                <div class="flex justify-center items-center gap-2 text-yellow-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="size-6 md:size-9">
                        <path d="M16.5 6a3 3 0 0 0-3-3H6a3 3 0 0 0-3 3v7.5a3 3 0 0 0 3 3v-6A4.5 4.5 0 0 1 10.5 6h6Z" />
                        <path d="M18 7.5a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-7.5a3 3 0 0 1-3-3v-7.5a3 3 0 0 1 3-3H18Z" />
                    </svg>
                    <p class="font-semibold md:text-xl">Flashcards</p>
                </div>
                <div class="flex justify-center items-center gap-2 text-purple-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="size-6 md:size-9">
                        <path
                            d="M9.195 18.44c1.25.714 2.805-.189 2.805-1.629v-2.34l6.945 3.968c1.25.715 2.805-.188 2.805-1.628V8.69c0-1.44-1.555-2.343-2.805-1.628L12 11.029v-2.34c0-1.44-1.555-2.343-2.805-1.628l-7.108 4.061c-1.26.72-1.26 2.536 0 3.256l7.108 4.061Z" />
                    </svg>
                    <p class="font-semibold md:text-xl">Repetitions</p>
                </div>
                <div class="flex justify-center items-center gap-2 text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="size-6 md:size-9">
                        <path fill-rule="evenodd"
                            d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5Zm6.61 10.936a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                            clip-rule="evenodd" />
                        <path
                            d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                    </svg>
                    <p class="font-semibold md:text-xl">Quizzes</p>
                </div>
            </div>
        </div>
    </section>
    <section class="flex flex-col bg-white w-screen">
        <div class="flex flex-col items-center gap-24 mx-auto px-10 py-24 w-full max-w-5xl">
            <span class="text-pink-600">
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
            <div
                class="flex flex-col justify-center items-center gap-4 bg-zinc-100 p-8 md:p-16 rounded-3xl w-full h-64 md:h-80">
                <div class="flex gap-2 text-yellow-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd"
                            d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                            clip-rule="evenodd" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd"
                            d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                            clip-rule="evenodd" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd"
                            d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                            clip-rule="evenodd" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd"
                            d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                            clip-rule="evenodd" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd"
                            d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <p class="font-semibold text-zinc-950 text-lg md:text-4xl text-center text-balance">"Syllaboost help me
                    study so much. It prepares everything for me and all I need to do is just study."</p>
                <p class="font-cursive text-zinc-500 text-xl md:text-2xl text-center">Some Student, Content creator &
                    student</p>
            </div>
        </div>
    </section>
    <section class="flex flex-col bg-white w-screen">
        <div class="flex flex-col gap-24 mx-auto px-10 py-24 w-full max-w-5xl">
            <div class="flex flex-col gap-4">
                <p class="font-semibold text-sky-600 text-xl">Who is this for?</p>
                <h2 class="font-bold text-zinc-950 text-3xl md:text-4xl text-balance">Designed for students who has
                    enormous potential but haven't optimized their study methods.</h2>
            </div>
            <div class="gap-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                <div class="flex flex-col gap-1 bg-zinc-100 p-6 rounded-2xl w-full h-40">
                    <span class="mb-auto text-yellow-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-7">
                            <path
                                d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
                            <path
                                d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286.921.304 1.83.634 2.726.99v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.66a6.727 6.727 0 0 0 .551-1.607 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.667 2.25 2.25 0 0 0 2.12 0Z" />
                            <path
                                d="M4.462 19.462c.42-.419.753-.89 1-1.395.453.214.902.435 1.347.662a6.742 6.742 0 0 1-1.286 1.794.75.75 0 0 1-1.06-1.06Z" />
                        </svg>
                    </span>
                    <strong class="text-zinc-950 text-lg md:text-xl">
                        University Learners
                    </strong>
                    <p class="text-zinc-600 leading-tight">
                        Keep notes organized, review efficiently, and track progress.
                    </p>
                </div>
                <div class="flex flex-col gap-1 bg-zinc-100 p-6 rounded-2xl w-full h-40">
                    <span class="mb-auto text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd"
                                d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                    <strong class="text-zinc-950 text-lg md:text-xl">
                        High School Students
                    </strong>
                    <p class="text-zinc-600 leading-tight">
                        Better review habits and stay ahead of homework and projects.
                    </p>
                </div>
                <div class="flex flex-col gap-1 bg-zinc-100 p-6 rounded-2xl w-full h-40">
                    <span class="mb-auto text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd"
                                d="M7.5 5.25a3 3 0 0 1 3-3h3a3 3 0 0 1 3 3v.205c.933.085 1.857.197 2.774.334 1.454.218 2.476 1.483 2.476 2.917v3.033c0 1.211-.734 2.352-1.936 2.752A24.726 24.726 0 0 1 12 15.75c-2.73 0-5.357-.442-7.814-1.259-1.202-.4-1.936-1.541-1.936-2.752V8.706c0-1.434 1.022-2.7 2.476-2.917A48.814 48.814 0 0 1 7.5 5.455V5.25Zm7.5 0v.09a49.488 49.488 0 0 0-6 0v-.09a1.5 1.5 0 0 1 1.5-1.5h3a1.5 1.5 0 0 1 1.5 1.5Zm-3 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                                clip-rule="evenodd" />
                            <path
                                d="M3 18.4v-2.796a4.3 4.3 0 0 0 .713.31A26.226 26.226 0 0 0 12 17.25c2.892 0 5.68-.468 8.287-1.335.252-.084.49-.189.713-.311V18.4c0 1.452-1.047 2.728-2.523 2.923-2.12.282-4.282.427-6.477.427a49.19 49.19 0 0 1-6.477-.427C4.047 21.128 3 19.852 3 18.4Z" />
                        </svg>
                    </span>
                    <strong class="text-zinc-950 text-lg md:text-xl">
                        Adult Learners
                    </strong>
                    <p class="text-zinc-600 leading-tight">
                        Balance work, family, and coursework with flexible learning.
                    </p>
                </div>
                <div class="flex flex-col gap-1 bg-zinc-100 p-6 rounded-2xl w-full h-40">
                    <span class="mb-auto text-rose-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd"
                                d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z"
                                clip-rule="evenodd" />
                            <path fill-rule="evenodd"
                                d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375ZM6 12a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V12Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 15a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V15Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 18a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V18Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75Z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                    <strong class="text-zinc-950 text-lg md:text-xl">
                        Exam Prep Students
                    </strong>
                    <p class="text-zinc-600 leading-tight">
                        Use flashcards and practice quizzes to prepare for finals or exams.
                    </p>
                </div>
                <div class="flex flex-col gap-1 bg-zinc-100 p-6 rounded-2xl w-full h-40">
                    <span class="mb-auto text-purple-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd"
                                d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z"
                                clip-rule="evenodd" />
                            <path
                                d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
                        </svg>
                    </span>
                    <strong class="text-zinc-950 text-lg md:text-xl">
                        Group Study Leaders
                    </strong>
                    <p class="text-zinc-600 leading-tight">
                        Share study decks, assign review, and keep teammates aligned.
                    </p>
                </div>
                <div class="flex flex-col gap-1 bg-zinc-100 p-6 rounded-2xl w-full h-40">
                    <span class="mb-auto text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd"
                                d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                    <strong class="text-zinc-950 text-lg md:text-xl">
                        Busy Learners
                    </strong>
                    <p class="text-zinc-600 leading-tight">
                        Save time with quick review, bite-sized study, and priority-based.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="flex flex-col bg-white w-screen">
        <div class="flex flex-col justify-center items-center gap-24 mx-auto px-10 py-24 w-full max-w-5xl">
            <h2 class="max-w-2xl font-bold text-zinc-950 text-3xl md:text-4xl text-center text-balance">Discover how you
                should've been studying all this time</h2>
            <div class="gap-4 grid grid-cols-1 lg:grid-cols-3">
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-2">
                        <p class="font-bold text-yellow-500 text-lg">Flashcards</p>
                        <p class="font-medium text-zinc-500">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Laboriosam, nostrum.</p>
                    </div>
                    <div class="flex flex-col justify-center items-center bg-yellow-100 rounded-2xl w-full h-40">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-9 text-yellow-500">
                            <path
                                d="M16.5 6a3 3 0 0 0-3-3H6a3 3 0 0 0-3 3v7.5a3 3 0 0 0 3 3v-6A4.5 4.5 0 0 1 10.5 6h6Z" />
                            <path
                                d="M18 7.5a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-7.5a3 3 0 0 1-3-3v-7.5a3 3 0 0 1 3-3H18Z" />
                        </svg>
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-2">
                        <p class="font-bold text-purple-600 text-lg">Spaced Repetitions</p>
                        <p class="font-medium text-zinc-500">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Laboriosam, nostrum.</p>
                    </div>
                    <div class="flex flex-col justify-center items-center bg-purple-100 rounded-2xl w-full h-40">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-9 text-purple-600">
                            <path
                                d="M9.195 18.44c1.25.714 2.805-.189 2.805-1.629v-2.34l6.945 3.968c1.25.715 2.805-.188 2.805-1.628V8.69c0-1.44-1.555-2.343-2.805-1.628L12 11.029v-2.34c0-1.44-1.555-2.343-2.805-1.628l-7.108 4.061c-1.26.72-1.26 2.536 0 3.256l7.108 4.061Z" />
                        </svg>
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-2">
                        <p class="font-bold text-emerald-600 text-lg">Custom Quizzes</p>
                        <p class="font-medium text-zinc-500">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Laboriosam, nostrum.</p>
                    </div>
                    <div class="flex flex-col justify-center items-center bg-emerald-100 rounded-2xl w-full h-40">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-9 text-emerald-600">
                            <path fill-rule="evenodd"
                                d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5Zm6.61 10.936a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                clip-rule="evenodd" />
                            <path
                                d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="flex flex-col bg-white border-zinc-200 border-t w-screen">
        <div class="mx-auto px-10 py-12 w-full max-w-5xl">
            <div class="flex md:flex-row flex-col justify-between gap-8 md:gap-12">
                <div class="flex flex-col gap-4">
                    <img src="{{ asset('assets/logo.webp') }}" alt="Syllaboost Logo" class="w-fit h-8">
                    <p class="max-w-xs text-zinc-500 text-sm">
                        Start learning in the most effective way with flashcards, spaced repetitions, and custom
                        quizzes.
                    </p>
                </div>
                <div class="flex flex-wrap gap-12 md:gap-24">
                    <div class="flex flex-col gap-4">
                        <h3 class="font-semibold text-zinc-950">Features</h3>
                        <a href="#" class="text-zinc-500 hover:text-zinc-950 text-sm transition">Flashcards</a>
                        <a href="#" class="text-zinc-500 hover:text-zinc-950 text-sm transition">Spaced Repetitions</a>
                        <a href="#" class="text-zinc-500 hover:text-zinc-950 text-sm transition">Custom Quizzes</a>
                    </div>
                    <div class="flex flex-col gap-4">
                        <h3 class="font-semibold text-zinc-950">Company</h3>
                        <a href="#" class="text-zinc-500 hover:text-zinc-950 text-sm transition">About</a>
                        <a href="#" class="text-zinc-500 hover:text-zinc-950 text-sm transition">Blog</a>
                        <a href="#" class="text-zinc-500 hover:text-zinc-950 text-sm transition">Contact</a>
                    </div>
                    <div class="flex flex-col gap-4">
                        <h3 class="font-semibold text-zinc-950">Legal</h3>
                        <a href="#" class="text-zinc-500 hover:text-zinc-950 text-sm transition">Privacy Policy</a>
                        <a href="#" class="text-zinc-500 hover:text-zinc-950 text-sm transition">Terms of Service</a>
                    </div>
                </div>
            </div>
            <div
                class="flex md:flex-row flex-col justify-between items-center gap-4 mt-12 pt-8 border-zinc-200 border-t text-zinc-500 text-sm">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'Syllaboost') }}. All rights reserved.</p>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-zinc-950 transition">
                        <span class="sr-only">Twitter</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                        </svg>
                    </a>
                    <a href="#" class="hover:text-zinc-950 transition">
                        <span class="sr-only">GitHub</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
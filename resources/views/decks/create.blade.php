@extends('layouts.feature')

@section('title', 'Create New Deck \ Syllaboost')

@section('main')
    <div class="flex flex-col gap-12 p-1 lg:p-0 w-full h-full">
        <div class="p-1 lg:p-4 w-full">
            <div class="flex lg:flex-row flex-col lg:justify-between lg:items-center gap-2">
                <a href="{{ route('decks.create.json') }}"
                    class="flex justify-center items-center gap-2 w-fit font-medium text-zinc-500 hover:text-zinc-700 transition-colors">
                    <span class="flex justify-center items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="size-5 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                        Back
                    </span>
                </a>
                <div>
                    <h1 class="font-bold text-zinc-900 text-3xl lg:text-end">Create New Deck</h1>
                    <p class="mt-2 text-zinc-500 lg:text-end">Create your flashcards and store them in a new collection.</p>
                </div>
            </div>
        </div>
        <form action="{{ route('decks.store') }}" class="flex flex-col gap-12 w-full" method="POST"
            x-data="{ name: '', description: '', is_public: false, isSubmitting: false, cards: [{ front_content: '', back_content: '' }], addCard() { this.cards.unshift({ front_content: '', back_content: '' }); }, removeCard(index) { if (this.cards.length > 1) { this.cards.splice(index, 1); } }, get isValid() { return this.name.trim() !== '' && this.cards.every(c => c.front_content.trim() !== '' && c.back_content.trim() !== ''); } }"
            @submit="isSubmitting = true">
            @csrf
            <div class="flex flex-col gap-6 bg-zinc-100 p-6 rounded-3xl w-full">
                <div>
                    <h3 class="font-bold text-3xl">Deck Information</h3>
                    <p class="mt-2 text-zinc-500">Enter your deck details below</p>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="name" class="block font-semibold text-zinc-700 text-sm">Deck Name*</label>
                    <input type="text" name="name" id="name" x-model="name" required
                        class="bg-white px-2 py-1 border border-zinc-300 rounded-lg focus:outline-pink-600 w-full"
                        placeholder="e.g. Spanish Vocabulary, Biology 101...">
                </div>
                <div class="space-y-2">
                    <label for="description" class="block font-semibold text-zinc-700 text-sm">Description
                        (Optional)</label>
                    <textarea name="description" id="description" x-model="description" rows="3"
                        class="bg-white px-2 py-1 border border-zinc-300 rounded-lg focus:outline-yellow-600 w-full resize-y"
                        placeholder="What is this deck about?"></textarea>
                </div>
                <div class="flex items-center gap-3">
                    <label for="is_public" class="flex items-center gap-3 cursor-pointer">
                        <div class="inline-flex relative items-center">
                            <input type="checkbox" name="is_public" id="is_public" value="1" x-model="is_public"
                                class="sr-only peer">
                            <div
                                class="peer after:top-[2px] after:absolute after:inset-s-[2px] bg-zinc-200 after:bg-white peer-checked:bg-emerald-600 after:border after:border-zinc-300 peer-checked:after:border-white rounded-full after:rounded-full peer-focus:outline-none w-11 after:w-5 h-6 after:h-5 after:content-[''] after:transition-all rtl:peer-checked:after:-translate-x-full peer-checked:after:translate-x-full">
                            </div>
                        </div>
                        <span class="font-medium text-zinc-700 text-sm">Make this deck public</span>
                    </label>
                </div>
            </div>
            <div @click="addCard()"
                class="flex justify-center items-center p-6 border-3 border-zinc-200 hover:border-pink-600 border-dashed rounded-3xl w-full text-zinc-400 hover:text-pink-600 transition-colors cursor-pointer">
                <span class="flex gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span>
                        Add flashcard
                    </span>
                </span>
            </div>
            <div class="space-y-4">
                <template x-for="(card, index) in cards" :key="index">
                    <div class="group relative flex lg:flex-row flex-col gap-4 bg-sky-100 p-6 rounded-3xl">
                        <div class="flex flex-col gap-2 grow">
                            <p class="font-semibold text-sky-600 text-lg">Front side</p>
                            <textarea :name="'cards[' + index + '][front_content]'" :id="'front_' + index"
                                x-model="card.front_content" required rows="2"
                                class="bg-white p-2 border border-zinc-200 rounded-lg focus:outline-sky-600 w-full font-semibold text-xl"
                                placeholder="Mithocondria"></textarea>
                        </div>
                        <div class="flex flex-col gap-2 w-auto grow">
                            <p class="font-semibold text-sky-600 text-lg">Back side</p>
                            <textarea :name="'cards[' + index + '][back_content]'" :id="'back_' + index"
                                x-model="card.back_content" required rows="2"
                                class="bg-white p-2 border border-zinc-200 rounded-lg focus:outline-sky-600 w-full font-semibold text-xl"
                                placeholder="Powerhouse of cell"></textarea>
                        </div>
                        <button type="button" @click="removeCard(index)" x-show="cards.length > 1"
                            class="-top-3 -right-3 absolute bg-white opacity-0 group-hover:opacity-100 p-1.5 border border-zinc-100 rounded-full text-zinc-400 hover:text-red-500 transition-colors cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </template>
            </div>
            <div class="flex lg:flex-row flex-col lg:items-center gap-4 mt-8">
                <button type="submit" :disabled="isSubmitting || !isValid"
                    :class="(isSubmitting || !isValid) ? 'bg-zinc-700 cursor-not-allowed opacity-60' : 'bg-zinc-950 hover:scale-105 active:scale-98 cursor-pointer'"
                    class="flex justify-center bg-zinc-950 px-4 py-2 rounded-full w-full md:w-40 font-semibold text-white transition-all duration-100">
                    <span x-show="!isSubmitting">
                        Create Deck
                    </span>
                    <span x-show="isSubmitting" x-cloak>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="animate-spin lucide lucide-loader-circle-icon lucide-loader-circle">
                            <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                        </svg>
                    </span>
                </button>
                <a href="{{ route('decks.create.json') }}"
                    class="h-fit text-zinc-500 hover:text-sky-600 active:text-sky-600 text-center underline transition-all">
                    Create with AI instead
                </a>
            </div>
        </form>
    </div>
@endsection
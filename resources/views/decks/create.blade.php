@extends('layouts.feature')

@section('title', 'Create New Deck \ Syllaboost')

@section('main')
    <div x-data="{ name: '', description: '', is_public: false, isSubmitting: false, cards: [{ front_content: '', back_content: '' }], addCard() { this.cards.push({ front_content: '', back_content: '' }); }, removeCard(index) { if (this.cards.length > 1) { this.cards.splice(index, 1); } }, get isValid() { return this.name.trim() !== '' && this.cards.every(c => c.front_content.trim() !== '' && c.back_content.trim() !== ''); } }"
        class="space-y-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="font-bold text-zinc-900 text-3xl">Create New Deck</h1>
                <p class="mt-2 text-zinc-500">
                    Create your flashcards and store them in a new collection.
                    <a href="{{ route('decks.create.json') }}" class="text-sky-600 hover:underline">
                        Or create with AI
                    </a>
                </p>
            </div>
            <a href="{{ route('dashboard') }}"
                class="flex justify-center items-center gap-2 w-24 font-medium text-zinc-500 hover:text-zinc-700 transition-colors">
                <span class="flex justify-center items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Cancel
                </span>
            </a>
        </div>

        <form action="{{ route('decks.store') }}" method="POST" @submit="isSubmitting = true" class="space-y-12">
            @csrf

            <!-- Deck Info -->
            <div class="space-y-6 bg-zinc-100 p-4 rounded-3xl">
                <div class="space-y-2">
                    <label for="name" class="block font-semibold text-zinc-700 text-sm">Deck Name*</label>
                    <input type="text" name="name" id="name" x-model="name" required
                        class="bg-white px-2 py-1 border border-zinc-300 rounded-lg focus:outline-sky-600 w-full"
                        placeholder="e.g. Spanish Vocabulary, Biology 101...">
                </div>

                <div class="space-y-2">
                    <label for="description" class="block font-semibold text-zinc-700 text-sm">Description
                        (Optional)</label>
                    <textarea name="description" id="description" x-model="description" rows="3"
                        class="bg-white px-2 py-1 border border-zinc-300 rounded-lg focus:outline-pink-600 w-full resize-y"
                        placeholder="What is this deck about?"></textarea>
                </div>

                <div class="flex items-center gap-3">
                    <label for="is_public" class="flex items-center gap-3 cursor-pointer">
                        <div class="inline-flex relative items-center">
                            <input type="checkbox" name="is_public" id="is_public" value="1" x-model="is_public"
                                class="sr-only peer">
                            <div
                                class="peer after:top-[2px] after:absolute after:inset-s-[2px] bg-zinc-200 after:bg-white peer-checked:bg-sky-600 after:border after:border-zinc-300 peer-checked:after:border-white rounded-full after:rounded-full peer-focus:outline-none w-11 after:w-5 h-6 after:h-5 after:content-[''] after:transition-all rtl:peer-checked:after:-translate-x-full peer-checked:after:translate-x-full">
                            </div>
                        </div>
                        <span class="font-medium text-zinc-700 text-sm">Make this deck public</span>
                    </label>
                </div>
            </div>

            <!-- Flashcards -->
            <div class="space-y-6">
                <div class="flex justify-between items-center">
                    <h2 class="font-bold text-zinc-900 text-xl">Flashcards</h2>
                    <span class="text-zinc-500 text-sm"
                        x-text="`${cards.length} ${cards.length === 1 ? 'card' : 'cards'}`"></span>
                </div>

                <div class="space-y-4">
                    <template x-for="(card, index) in cards" :key="index">
                        <div class="group relative bg-zinc-100 p-6 rounded-3xl">
                            <div class="top-1/2 -left-3 absolute flex justify-center items-center bg-sky-600 border-2s border-white rounded-full w-6 h-6 font-bold text-white text-xs -translate-y-1/2"
                                x-text="index + 1"></div>

                            <div class="gap-6 grid grid-cols-1 md:grid-cols-2">
                                <div class="space-y-2">
                                    <label :for="'front_' + index" class="block font-bold text-zinc-400 text-xs">Front
                                        side*</label>
                                    <textarea :name="'cards[' + index + '][front_content]'" :id="'front_' + index"
                                        x-model="card.front_content" required
                                        class="bg-white px-2 py-1 border border-zinc-300 rounded-lg focus:outline-purple-600 w-full min-h-[100px] resize-none"
                                        placeholder="Enter term or question..."></textarea>
                                </div>
                                <div class="space-y-2">
                                    <label :for="'back_' + index" class="block font-bold text-zinc-400 text-xs">Back
                                        side*</label>
                                    <textarea :name="'cards[' + index + '][back_content]'" :id="'back_' + index"
                                        x-model="card.back_content" required
                                        class="bg-white px-2 py-1 border border-zinc-300 rounded-lg focus:outline-emerald-600 w-full min-h-[100px] resize-none"
                                        placeholder="Enter answer or definition..."></textarea>
                                </div>
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

                <button type="button" @click="addCard()"
                    class="group flex justify-center items-center gap-2 hover:bg-indigo-50/50 py-4 border-2 border-zinc-200 hover:border-indigo-300 border-dashed rounded-2xl w-full font-medium text-zinc-500 hover:text-indigo-600 transition-all cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-5 group-hover:scale-110 transition-transform">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Add Another Card
                </button>
            </div>

            <!-- Submit -->
            <div class="flex justify-between items-center pt-8 border-zinc-200 border-t">
                <p class="text-zinc-500 text-sm italic">All fields marked with * are required.</p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard') }}"
                        class="flex justify-center hover:bg-zinc-50 px-4 py-2 rounded-full w-30 font-semibold text-zinc-950 hover:scale-105 active:scale-100 transition-all duration-100 cursor-pointer">
                        Cancel
                    </a>
                    <button type="submit" :disabled="isSubmitting || !isValid"
                        :class="(isSubmitting || !isValid) ? 'bg-zinc-700 cursor-not-allowed opacity-60' : 'bg-zinc-950 hover:scale-105 active:scale-100 cursor-pointer'"
                        class="flex justify-center px-4 py-2 rounded-full w-38 font-semibold text-white transition-all duration-100">
                        <span x-show="!isSubmitting">
                            Create Deck
                        </span>
                        <span x-show="isSubmitting">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="animate-spin lucide lucide-loader-circle-icon lucide-loader-circle">
                                <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
@extends('layouts.feature')

@section('title', 'Edit Deck \ Syllaboost')

@section('main')
    <div x-data="{
                                        name: @js(old('name', $deck->name)),
                                        description: @js(old('description', $deck->description)),
                                        is_public: @js((bool) old('is_public', $deck->is_public)),
                                        isSubmitting: false,
                                        cards: @js(old('cards', $deck->cards->map(fn($c) => ['front_content' => $c->front_content, 'back_content' => $c->back_content])->toArray())),

                                        jsonInput: '',
                                        copyStatus: 'Copy AI Prompt',
                                        get currentJson() {
                                            return JSON.stringify({
                                                name: this.name,
                                                description: this.description,
                                                is_public: this.is_public,
                                                cards: this.cards.map(c => ({ front: c.front_content, back: c.back_content }))
                                            }, null, 2);
                                        },
                                        get prompt() {
                                            return `Update the following flashcard deck in valid JSON format based on the provided instructions or material. Maintain the exact same structure:\n\n${this.currentJson}\n\nRequirements:\n\n- Update the existing cards, add new ones, or remove unnecessary ones based on the prompt.\n- Keep the same JSON structure.\n- Each \'front\' should contain a single question or concept prompt.\n- Each \'back\' should contain a precise, self-contained answer.\n- Return only valid JSON (no extra text, comments, or formatting outside the JSON).`;
                                        },
                                        copyPrompt() {
                                            navigator.clipboard.writeText(this.prompt);
                                            this.copyStatus = 'Copied!';
                                            setTimeout(() => { this.copyStatus = 'Copy AI Prompt' }, 2000);
                                        },
                                        applyJson() {
                                            try {
                                                let parsed = JSON.parse(this.jsonInput);
                                                if (parsed.name !== undefined) this.name = parsed.name;
                                                if (parsed.description !== undefined) this.description = parsed.description;
                                                if (parsed.is_public !== undefined) this.is_public = parsed.is_public;
                                                if (parsed.cards && Array.isArray(parsed.cards)) {
                                                    this.cards = parsed.cards.map(c => ({
                                                        front_content: c.front_content || c.front || '',
                                                        back_content: c.back_content || c.back || ''
                                                    }));
                                                }
                                            } catch (e) {
                                                alert('Invalid JSON. Please check the format.');
                                            }
                                        },

                                        addCard() { this.cards.push({ front_content: '', back_content: '' }); },
                                        removeCard(index) { if (this.cards.length > 1) { this.cards.splice(index, 1); } },
                                        get isValid() { return this.name.trim() !== '' && this.cards.every(c => c.front_content.trim() !== '' && c.back_content.trim() !== ''); }
                                    }" class="space-y-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="font-bold text-zinc-900 text-3xl">Edit Deck</h1>
                <p class="mt-2 text-zinc-500">
                    Update your deck details and flashcards.
                </p>
            </div>
            <a href="{{ route('decks.index') }}"
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

        <form action="{{ route('decks.update', $deck) }}" method="POST" @submit="isSubmitting = true" class="space-y-12">
            @csrf
            @method('PUT')

            <!-- AI Assist Section -->
            <div class="space-y-6 bg-pink-50 p-4 border border-pink-100 rounded-3xl" x-data="{ expanded: false }">
                <div class="flex justify-between items-center cursor-pointer"
                    @click="expanded = !expanded; if(expanded && !jsonInput) jsonInput = currentJson;">
                    <h2 class="flex items-center gap-2 font-bold text-pink-900 text-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                        </svg>
                        Edit with AI & JSON
                    </h2>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-5 text-pink-700 transition-transform"
                        :class="expanded ? 'rotate-180' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>

                <div x-show="expanded" x-collapse class="space-y-6 pt-4 border-pink-200 border-t" style="display: none;">
                    <p class="text-pink-700 text-sm">Copy this prompt, paste it into your favorite AI, and paste the
                        resulting JSON back here to automatically update your deck. You can also edit the JSON directly.</p>

                    <div class="relative">
                        <pre class="bg-white p-4 border border-pink-200 rounded-lg max-h-64 overflow-x-auto text-zinc-600 text-sm"
                            x-text="prompt"></pre>
                        <button type="button" @click="copyPrompt"
                            class="top-3 right-3 absolute flex items-center gap-2 bg-pink-600 hover:bg-pink-700 px-4 py-1.5 rounded-lg font-semibold text-white text-sm transition-colors cursor-pointer">
                            <svg x-show="copyStatus === 'Copy AI Prompt'" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                            </svg>
                            <svg x-show="copyStatus === 'Copied!'" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4"
                                style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            <span x-text="copyStatus"></span>
                        </button>
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <label for="json_data" class="block font-semibold text-pink-900">AI Response / JSON
                                Editor</label>
                            <button type="button" @click="jsonInput = currentJson"
                                class="font-medium text-pink-600 hover:text-pink-800 text-sm transition-colors cursor-pointer">
                                Reset to Current Deck
                            </button>
                        </div>
                        <textarea id="json_data" x-model="jsonInput" rows="10"
                            class="bg-white p-4 border border-pink-200 rounded-lg focus:outline-pink-600 w-full font-mono text-sm resize-y"
                            placeholder='{ "name": "...", "cards": [...] }'></textarea>
                        <div class="flex justify-end pt-2">
                            <button type="button" @click="applyJson"
                                class="flex justify-center items-center gap-2 bg-pink-600 hover:bg-pink-700 px-6 py-2 rounded-lg font-semibold text-white transition-colors cursor-pointer">
                                Apply to Form
                            </button>
                        </div>
                    </div>
                </div>
            </div>

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
                    <a href="{{ route('decks.index') }}"
                        class="flex justify-center hover:bg-zinc-50 px-4 py-2 rounded-full w-30 font-semibold text-zinc-950 hover:scale-105 active:scale-100 transition-all duration-100 cursor-pointer">
                        Cancel
                    </a>
                    <button type="submit" :disabled="isSubmitting || !isValid"
                        :class="(isSubmitting || !isValid) ? 'bg-zinc-700 cursor-not-allowed opacity-60' : 'bg-zinc-950 hover:scale-105 active:scale-100 cursor-pointer'"
                        class="flex justify-center px-4 py-2 rounded-full w-38 font-semibold text-white transition-all duration-100">
                        <span x-show="!isSubmitting">
                            Update Deck
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
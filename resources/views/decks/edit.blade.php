@extends('layouts.feature')

@section('title', 'Edit Deck \ Syllaboost')

@section('main')
    <div class="flex flex-col gap-12 p-1 lg:p-0 w-full h-full"
        x-data="{name:@js(old('name', $deck->name)),description:@js(old('description', $deck->description)),is_public:@js((bool) old('is_public', $deck->is_public)),isSubmitting:false,cards:@js(old('cards', $deck->cards->map(fn($c) => ['front_content' => $c->front_content, 'back_content' => $c->back_content])->toArray())),jsonInput:'',copyStatus:'Copy AI Prompt',get currentJson(){return JSON.stringify({name:this.name,description:this.description,is_public:this.is_public,cards:this.cards.map(c=>({front:c.front_content,back:c.back_content}))},null,2);},get prompt(){return `Update the following flashcard deck in valid JSON format based on the provided instructions or material. Maintain the exact same structure:\n\n${this.currentJson}\n\nRequirements:\n\n- Update the existing cards, add new ones, or remove unnecessary ones based on the prompt.\n- Keep the same JSON structure.\n- Each 'front' should contain a single question or concept prompt.\n- Each 'back' should contain a precise, self-contained answer.\n- Return only valid JSON (no extra text, comments, or formatting outside the JSON).`;},copyPrompt(){navigator.clipboard.writeText(this.prompt);this.copyStatus='Copied!';setTimeout(()=>{this.copyStatus='Copy AI Prompt'},2000);},applyJson(){try{let parsed=JSON.parse(this.jsonInput);if(parsed.name!==undefined)this.name=parsed.name;if(parsed.description!==undefined)this.description=parsed.description;if(parsed.is_public!==undefined)this.is_public=parsed.is_public;if(parsed.cards&&Array.isArray(parsed.cards)){this.cards=parsed.cards.map(c=>({front_content:c.front_content||c.front||'',back_content:c.back_content||c.back||''}));}}catch(e){alert('Invalid JSON. Please check the format.');}},addCard(){this.cards.unshift({front_content:'',back_content:''});},removeCard(index){if(this.cards.length>1){this.cards.splice(index,1);}},get isValid(){return this.name.trim()!==''&&this.cards.every(c=>c.front_content.trim()!==''&&c.back_content.trim()!=='');}}">
        <div class="p-1 lg:p-4 w-full">
            <div class="flex lg:flex-row flex-col lg:justify-between lg:items-center gap-2">
                <a href="{{ route('decks.index') }}"
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
                    <h1 class="font-bold text-zinc-900 text-3xl lg:text-end">Edit Deck</h1>
                    <p class="mt-2 text-zinc-500 lg:text-end">Update your deck details and flashcards.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('decks.update', $deck) }}" method="POST" @submit="isSubmitting = true"
            class="flex flex-col gap-12 w-full">
            @csrf
            @method('PUT')

            <!-- AI Assist Section -->
            <div class="flex flex-col gap-6 bg-white p-6 border border-zinc-200 rounded-3xl w-full"
                x-data="{ expanded: false }">
                <div class="flex justify-between items-center cursor-pointer"
                    @click="expanded = !expanded; if(expanded && !jsonInput) jsonInput = currentJson;">
                    <div class="flex flex-col gap-1">
                        <h2 class="flex items-center gap-2 font-bold text-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-6 text-pink-600">
                                <path fill-rule="evenodd"
                                    d="M9 4.5a.75.75 0 0 1 .721.544l.813 2.846a3.75 3.75 0 0 0 2.576 2.576l2.846.813a.75.75 0 0 1 0 1.442l-2.846.813a3.75 3.75 0 0 0-2.576 2.576l-.813 2.846a.75.75 0 0 1-1.442 0l-.813-2.846a3.75 3.75 0 0 0-2.576-2.576l-2.846-.813a.75.75 0 0 1 0-1.442l2.846-.813A3.75 3.75 0 0 0 7.466 7.89l.813-2.846A.75.75 0 0 1 9 4.5ZM18 1.5a.75.75 0 0 1 .728.568l.258 1.036c.236.94.97 1.674 1.91 1.91l1.036.258a.75.75 0 0 1 0 1.456l-1.036.258c-.94.236-1.674.97-1.91 1.91l-.258 1.036a.75.75 0 0 1-1.456 0l-.258-1.036a2.625 2.625 0 0 0-1.91-1.91l-1.036-.258a.75.75 0 0 1 0-1.456l1.036-.258a2.625 2.625 0 0 0 1.91-1.91l.258-1.036A.75.75 0 0 1 18 1.5ZM16.5 15a.75.75 0 0 1 .712.513l.394 1.183c.15.447.5.799.948.948l1.183.395a.75.75 0 0 1 0 1.422l-1.183.395c-.447.15-.799.5-.948.948l-.395 1.183a.75.75 0 0 1-1.422 0l-.395-1.183a1.5 1.5 0 0 0-.948-.948l-1.183-.395a.75.75 0 0 1 0-1.422l1.183-.395c.447-.15.799-.5.948-.948l.395-1.183A.75.75 0 0 1 16.5 15Z"
                                    clip-rule="evenodd" />
                            </svg>
                            Edit with AI & JSON
                        </h2>
                        <p class="text-zinc-500 text-sm text-balance">
                            Update your deck automatically by pasting your current deck into AI.
                        </p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-6 text-zinc-400 transition-transform"
                        :class="expanded ? 'rotate-180' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>

                <div x-show="expanded" x-collapse class="flex flex-col pt-8" style="display: none;">
                    {{-- Step 1 --}}
                    <div class="flex gap-6 md:gap-12 h-50">
                        <div class="flex flex-col items-center shrink-0">
                            <span class="bg-zinc-200 rounded-full w-5 h-5 shrink-0"></span>
                            <div class="bg-zinc-200 my-2 w-0.5 grow"></div>
                        </div>
                        <div class="flex flex-col gap-6 pb-12 min-w-0">
                            <div class="flex flex-col gap-1">
                                <h3 class="font-bold text-2xl">Copy AI Prompt</h3>
                                <p class="text-zinc-500 text-sm">
                                    Copy the prompt below which contains your current deck.
                                </p>
                            </div>
                            <button type="button" @click="copyPrompt"
                                class="flex items-center gap-1 bg-pink-600 px-4 py-2 rounded-full w-fit font-medium text-white text-sm hover:scale-105 active:scale-98 transition-all cursor-pointer">
                                <svg x-show="copyStatus === 'Copy AI Prompt'" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor" class="size-5 shrink-0">
                                    <path
                                        d="M7 3.5A1.5 1.5 0 0 1 8.5 2h3.879a1.5 1.5 0 0 1 1.06.44l3.122 3.12A1.5 1.5 0 0 1 17 6.622V12.5a1.5 1.5 0 0 1-1.5 1.5h-1v-3.379a3 3 0 0 0-.879-2.121L10.5 5.379A3 3 0 0 0 8.379 4.5H7v-1Z" />
                                    <path
                                        d="M4.5 6A1.5 1.5 0 0 0 3 7.5v9A1.5 1.5 0 0 0 4.5 18h7a1.5 1.5 0 0 0 1.5-1.5v-5.879a1.5 1.5 0 0 0-.44-1.06L9.44 6.439A1.5 1.5 0 0 0 8.378 6H4.5Z" />
                                </svg>
                                <svg x-cloak x-show="copyStatus === 'Copied!'" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor" class="size-5" style="display: none;">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span x-text="copyStatus === 'Copy AI Prompt' ? 'Copy Prompt' : copyStatus"></span>
                            </button>
                        </div>
                    </div>

                    {{-- Step 2 --}}
                    <div class="flex gap-6 md:gap-12 h-50">
                        <div class="flex flex-col items-center shrink-0">
                            <span class="bg-zinc-200 rounded-full w-5 h-5 shrink-0"></span>
                            <div class="bg-zinc-200 my-2 w-0.5 grow"></div>
                        </div>
                        <div class="flex flex-col gap-6 pb-12 min-w-0">
                            <div class="flex flex-col gap-1">
                                <h3 class="font-bold text-2xl">Go to your favorite AI website</h3>
                                <p class="text-zinc-500 text-sm">
                                    Go to your favorite AI website (e.g., ChatGPT or Claude), paste the prompt you
                                    previously copied, and tell the AI to edit your deck the way you want it.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Step 3 --}}
                    <div class="flex gap-6 md:gap-12">
                        <div class="flex flex-col items-center shrink-0">
                            <span class="bg-zinc-200 rounded-full w-5 h-5 shrink-0"></span>
                        </div>
                        <div class="flex flex-col gap-6 pb-2 w-full min-w-0">
                            <div class="flex flex-col gap-1">
                                <div class="flex justify-between items-center">
                                    <h3 class="font-bold text-2xl">Paste your AI response</h3>
                                    <button type="button" @click="jsonInput = currentJson"
                                        class="font-medium text-pink-600 hover:text-pink-800 text-sm transition-colors cursor-pointer">
                                        Reset
                                    </button>
                                </div>
                                <p class="text-zinc-500 text-sm">
                                    Copy the response generated by the AI and paste it below.
                                </p>
                            </div>

                            <textarea id="json_data" x-model="jsonInput" rows="10"
                                class="bg-zinc-100 p-4 rounded-xl focus:outline-pink-600 w-full font-mono placeholder:text-zinc-400 resize-y"
                                placeholder='{ "name": "...", "cards": [...] }'></textarea>
                            <div class="flex justify-end pt-2">
                                <button type="button" @click="applyJson; expanded = false;"
                                    class="flex justify-center items-center gap-2 bg-pink-600 hover:bg-pink-700 px-6 py-2 rounded-full font-semibold text-white hover:scale-105 active:scale-98 transition-all cursor-pointer">
                                    Apply to Form
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deck Info -->
            <div class="flex flex-col gap-6 bg-zinc-100 p-6 rounded-3xl w-full">
                <div>
                    <h3 class="font-bold text-3xl">Deck Information</h3>
                    <p class="mt-2 text-zinc-500">Update your deck details below</p>
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

            <!-- Flashcards -->
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
                                placeholder="Enter term or question..."></textarea>
                        </div>
                        <div class="flex flex-col gap-2 w-auto grow">
                            <p class="font-semibold text-sky-600 text-lg">Back side</p>
                            <textarea :name="'cards[' + index + '][back_content]'" :id="'back_' + index"
                                x-model="card.back_content" required rows="2"
                                class="bg-white p-2 border border-zinc-200 rounded-lg focus:outline-sky-600 w-full font-semibold text-xl"
                                placeholder="Enter answer or definition..."></textarea>
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

            <!-- Submit -->
            <div class="flex lg:flex-row flex-col lg:items-center gap-4 mt-8">
                <button type="submit" :disabled="isSubmitting || !isValid"
                    :class="(isSubmitting || !isValid) ? 'bg-zinc-700 cursor-not-allowed opacity-60' : 'bg-zinc-950 hover:scale-105 active:scale-98 cursor-pointer'"
                    class="flex justify-center bg-zinc-950 px-4 py-2 rounded-full w-full md:w-40 font-semibold text-white transition-all duration-100">
                    <span x-show="!isSubmitting">
                        Update Deck
                    </span>
                    <span x-show="isSubmitting" x-cloak>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="animate-spin lucide lucide-loader-circle-icon lucide-loader-circle">
                            <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                        </svg>
                    </span>
                </button>
                <a href="{{ route('decks.index') }}"
                    class="h-fit text-zinc-500 hover:text-sky-600 active:text-sky-600 text-center underline transition-all">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
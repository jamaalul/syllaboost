@extends('layouts.feature')

@section('title', 'Create Deck with JSON \ Syllaboost')

@section('main')
    @php
        $aiPrompt = <<<'EOT'
                                        Generate a flashcard deck in valid JSON format based strictly on the uploaded study material. Follow this exact structure:

                                        {
                                          "name": "Deck Name",
                                          "description": "Short description of the material",
                                          "is_public": false,
                                          "cards": [
                                            { "front": "Prompt", "back": "Answer" }
                                          ]
                                        }

                                        Flashcard design rules (CRITICAL):

                                        - Use ONLY the uploaded material.
                                        - Each card must represent ONE atomic concept.
                                        - Keep content concise but clear:
                                          - Front: short prompt or cue (typically 2–6 words, not full sentences).
                                          - Back: short, precise answer (typically 3–10 words).
                                        - Do NOT write exam-style questions.
                                        - Prefer formats like:
                                          - Term → Definition
                                          - Concept → Key idea
                                          - Process → Key steps (compressed)
                                          - Formula → Meaning
                                        - If a concept is complex, split it into multiple cards instead of lengthening one.
                                        - Avoid:
                                          - Long explanations
                                          - Filler words
                                          - Redundant cards
                                        - Wording must be simple, specific, and easy to recall.
                                        - Cover all key concepts without skipping topics.

                                        Output rules:

                                        - Return ONLY valid JSON.
                                        - No extra text, no markdown, no comments.
                                        - Ensure correct JSON syntax.

                                        EOT;
    @endphp

    <div class="p-1 lg:p-4 w-full"
        x-data="{ jsonData: @js(old('json_data', '')), isSubmitting: false, prompt: @js($aiPrompt), copyStatus: 'Copy Prompt', copyPrompt() { navigator.clipboard.writeText(this.prompt); this.copyStatus = 'Copied!'; setTimeout(() => { this.copyStatus = 'Copy Prompt' }, 2000); } }">
        <div class="flex lg:flex-row flex-col lg:justify-between lg:items-center gap-2">
            <a href="{{ route('dashboard') }}"
                class="flex justify-center items-center gap-2 w-fit font-medium text-zinc-500 hover:text-zinc-700 transition-colors">
                <span class="flex justify-center items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-5 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Cancel
                </span>
            </a>
            <div>
                <h1 class="font-bold text-zinc-900 text-3xl lg:text-end">Create Deck with AI</h1>
                <p class="mt-2 text-zinc-500 lg:text-end">Paste your JSON data below to quickly create a new deck.</p>
            </div>
        </div>

        <div class="flex flex-col mt-24">

            {{-- Step 1 --}}
            <div class="flex gap-6 md:gap-12 h-50">
                {{-- Stepper column: circle + vertical line --}}
                <div class="flex flex-col items-center shrink-0">
                    <span class="bg-zinc-200 rounded-full w-5 h-5 shrink-0"></span>
                    <div class="bg-zinc-200 my-2 w-0.5 grow"></div>
                </div>
                {{-- Content --}}
                <div class="flex flex-col gap-6 pb-12 min-w-0">
                    <div class="flex flex-col gap-1">
                        <h3 class="font-bold text-2xl">Copy AI Prompt</h3>
                        <p class="text-zinc-500 text-sm">
                            Copy the prompt below and use it with your favorite AI (e.g., ChatGPT or Claude) to make you a
                            JSON deck.
                        </p>
                    </div>
                    <button @click="copyPrompt"
                        class="flex items-center gap-1 bg-pink-600 px-4 py-2 rounded-full w-fit font-medium text-white text-sm hover:scale-105 active:scale-98 transition-all cursor-pointer">
                        <svg x-show="copyStatus === 'Copy Prompt'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" class="size-5 shrink-0">
                            <path
                                d="M7 3.5A1.5 1.5 0 0 1 8.5 2h3.879a1.5 1.5 0 0 1 1.06.44l3.122 3.12A1.5 1.5 0 0 1 17 6.622V12.5a1.5 1.5 0 0 1-1.5 1.5h-1v-3.379a3 3 0 0 0-.879-2.121L10.5 5.379A3 3 0 0 0 8.379 4.5H7v-1Z" />
                            <path
                                d="M4.5 6A1.5 1.5 0 0 0 3 7.5v9A1.5 1.5 0 0 0 4.5 18h7a1.5 1.5 0 0 0 1.5-1.5v-5.879a1.5 1.5 0 0 0-.44-1.06L9.44 6.439A1.5 1.5 0 0 0 8.378 6H4.5Z" />
                        </svg>
                        <svg x-cloak x-show="copyStatus === 'Copied!'" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20" fill="currentColor" class="size-5">
                            <path fill-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span x-text="copyStatus"></span>
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
                            Go to your favorite AI website (e.g., ChatGPT or Claude), upload your module or material, paste
                            the prompt you previously copied.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Step 3 — last step, no line below --}}
            <div class="flex gap-6 md:gap-12">
                <div class="flex flex-col items-center shrink-0">
                    <span class="bg-zinc-200 rounded-full w-5 h-5 shrink-0"></span>
                </div>
                <div class="flex flex-col gap-6 pb-2 w-full min-w-0">
                    <div class="flex flex-col gap-1">
                        <h3 class="font-bold text-2xl">Paste your AI response</h3>
                        <p class="text-zinc-500 text-sm">
                            Copy the response generated by the AI and paste it below.
                        </p>
                    </div>
                    <form action="{{ route('decks.store.json') }}" method="POST" @submit="isSubmitting = true">
                        @csrf
                        <textarea name="json_data" id="json_data" rows="10" x-model="jsonData" required
                            placeholder='Paste your AI response here, e.g.&#10;{&#10;  "title": "My Deck",&#10;  "cards": [...]&#10;}'
                            class="bg-zinc-100 p-4 rounded-xl w-full font-mono placeholder:text-zinc-400 resize-y">{{ old('json_data') }}</textarea>
                        @error('json_data')
                            <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                        <button type="submit" :disabled="isSubmitting || jsonData.trim() === ''"
                            :class="(isSubmitting || jsonData.trim() === '') ? 'bg-zinc-700 cursor-not-allowed opacity-60' : 'bg-zinc-950 hover:scale-105 active:scale-98 cursor-pointer'"
                            class="flex justify-center bg-zinc-950 mt-8 px-4 py-2 rounded-full w-full md:w-40 font-semibold text-white transition-all duration-100">
                            <span x-show="!isSubmitting">
                                Create Deck
                            </span>
                            <span x-show="isSubmitting" x-cloak>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="animate-spin lucide lucide-loader-circle-icon lucide-loader-circle">
                                    <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                                </svg>
                            </span>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
@extends('layouts.feature')

@section('title', 'Create Deck with JSON \ Syllaboost')

@section('main')
    @php
        $aiPrompt = <<<'EOT'
                                                Generate a flashcard deck in valid JSON format based on the uploaded module or study material. Follow this exact structure:

                                                {
                                                  "name": "Deck Name",
                                                  "description": "Description",
                                                  "is_public": false,
                                                  "cards": [
                                                    { "front": "Question", "back": "Answer" }
                                                  ]
                                                }

                                                Requirements:

                                                Use the uploaded module as the only source of content.
                                                Create clear, concise, and study-focused flashcards.
                                                Each "front" should contain a single question or concept prompt.
                                                Each "back" should contain a precise, self-contained answer.
                                                Cover the most important concepts from the material (do not skip key topics).
                                                Avoid duplicates, filler text, or overly long explanations.
                                                Keep wording simple and unambiguous.
                                                Return only valid JSON (no extra text, comments, or formatting outside the JSON).
                                                EOT;
    @endphp

    <div x-data="{ jsonData: @js(old('json_data', '')), isSubmitting: false, prompt: @js($aiPrompt), copyStatus: 'Copy AI Prompt', copyPrompt() { navigator.clipboard.writeText(this.prompt); this.copyStatus = 'Copied!'; setTimeout(() => { this.copyStatus = 'Copy AI Prompt' }, 2000); } }"
        class="space-y-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="font-bold text-zinc-900 text-3xl">Create Deck with AI</h1>
                <p class="mt-2 text-zinc-500">Paste your JSON data below to quickly create a new deck.</p>
            </div>
            <a href="{{ route('decks.create') }}"
                class="flex justify-center items-center gap-2 w-40 font-medium text-zinc-500 hover:text-zinc-700 transition-colors">
                <span class="flex justify-center items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Back to Manual
                </span>
            </a>
        </div>

        <div class="space-y-6">
            <!-- AI Prompt Section -->
            <div class="bg-pink-50 p-4 border border-pink-100 rounded-3xl">
                <h2 class="flex items-center gap-2 font-bold text-pink-900 text-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                    </svg>
                    AI Prompt
                </h2>
                <p class="mt-2 text-pink-700 text-sm">Copy this prompt, paste it into your favorite AI (e.g., ChatGPT or
                    Claude), upload your module, and generate your flashcards in the correct format.</p>

                <div class="relative mt-4">
                    <pre class="bg-white p-4 border border-pink-200 rounded-lg overflow-x-auto text-zinc-600 text-sm"
                        x-text="prompt"></pre>
                    <button @click="copyPrompt"
                        class="top-3 right-3 absolute flex items-center gap-2 bg-pink-600 hover:bg-pink-700 px-4 py-1.5 rounded-lg font-semibold text-white text-sm transition-colors cursor-pointer">
                        <svg x-show="copyStatus === 'Copy AI Prompt'" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                        </svg>
                        <svg x-show="copyStatus === 'Copied!'" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                        <span x-text="copyStatus"></span>
                    </button>
                </div>
            </div>

            <form action="{{ route('decks.store.json') }}" method="POST" @submit="isSubmitting = true" class="space-y-8">
                @csrf

                <div class="space-y-6 bg-zinc-100 p-4 rounded-3xl">
                    <div class="space-y-2">
                        <label for="json_data" class="block font-semibold text-zinc-700">AI response*</label>
                        <p class="mt-1 text-zinc-500 text-sm">Paste the JSON data generated by the AI below.</p>
                        @error('json_data')
                            <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                        <textarea name="json_data" id="json_data" x-model="jsonData" rows="15" required
                            class="bg-white p-4 border border-zinc-300 rounded-lg focus:outline-sky-600 w-full font-mono text-sm resize-y"
                            placeholder='{ "name": "...", "cards": [...] }'>{{ old('json_data') }}</textarea>
                    </div>
                </div>

                <div class="flex justify-between items-center pt-8 border-zinc-200 border-t">
                    <p class="text-zinc-500 text-sm italic">Ensure your JSON follows the required format.</p>
                    <div class="flex items-center gap-4">
                        <a href="{{ route('decks.create') }}"
                            class="flex justify-center hover:bg-zinc-50 px-4 py-2 rounded-full w-30 font-semibold text-zinc-950 hover:scale-105 active:scale-100 transition-all duration-100 cursor-pointer">
                            Cancel
                        </a>
                        <button type="submit" :disabled="isSubmitting || jsonData.trim() === ''"
                            :class="(isSubmitting || jsonData.trim() === '') ? 'bg-zinc-700 cursor-not-allowed opacity-60' : 'bg-zinc-950 hover:scale-105 active:scale-100 cursor-pointer'"
                            class="flex justify-center px-4 py-2 rounded-full w-56 font-semibold text-white transition-all duration-100">
                            <span x-show="!isSubmitting">
                                Create Deck
                            </span>
                            <span x-show="isSubmitting">
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
            </form>
        </div>
    </div>
@endsection
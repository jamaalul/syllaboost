@props(['userDecks', 'folder'])

<div x-show="addDeckModalOpen" x-data="{ searchQuery: '' }" class="z-50 fixed inset-0 flex justify-center items-center"
    style="display: none;">
    <div x-show="addDeckModalOpen" x-transition.opacity class="fixed inset-0 bg-black/40 backdrop-blur-sm"
        @click="addDeckModalOpen = false"></div>

    <div x-show="addDeckModalOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative flex flex-col bg-white shadow-xl mx-4 rounded-3xl w-full max-w-2xl h-[80vh] overflow-hidden">

        <div class="flex justify-between items-center p-6 pb-4">
            <h3 class="font-bold text-zinc-900 text-lg">Add Deck to Folder</h3>
            <button @click="addDeckModalOpen = false"
                class="bg-zinc-100 hover:bg-zinc-200 p-2 rounded-full text-zinc-400 hover:text-zinc-600 transition-colors cursor-pointer cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        @if($userDecks->isEmpty())
            <div class="p-6">
                <p class="py-4 text-zinc-500 text-center">You have no other decks available to add.</p>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" @click="addDeckModalOpen = false"
                        class="bg-zinc-100 hover:bg-zinc-200 px-5 py-2.5 rounded-full font-medium text-zinc-700 transition-colors">Close</button>
                </div>
            </div>
        @else
            <div class="px-6 pt-4">
                <div class="relative">
                    <div class="left-0 absolute inset-y-0 flex items-center pl-3 text-zinc-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input x-model="searchQuery" type="text" placeholder="Search decks..."
                        class="block bg-white p-2.5 pl-10 border border-zinc-200 focus:border-purple-600 rounded-full focus:outline-purple-600 w-full text-sm transition-colors"
                        autocomplete="off">
                </div>
            </div>

            <form action="{{ route('folders.decks.add', $folder->slug) }}" method="POST"
                class="flex flex-col flex-1 min-h-0 overflow-hidden" x-data="{ isSubmitting: false }"
                @submit="isSubmitting = true">
                @csrf
                <div class="flex-1 p-6 min-h-0 overflow-y-auto custom-scrollbar">
                    @error('deck_ids')
                        <div class="mb-4 text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                    <div class="space-y-2">
                        @foreach($userDecks as $deck)
                            <label
                                x-show="searchQuery === '' || '{{ strtolower(addslashes($deck->name)) }}'.includes(searchQuery.toLowerCase())"
                                class="flex justify-between items-center bg-zinc-100 [&:has(:checked)]:bg-sky-50 hover:bg-sky-50 p-3 [&:has(:checked)]:border-sky-600 hover:border-sky-200 rounded-xl [&:has(:checked)]:ring-1 [&:has(:checked)]:ring-sky-600 transition-all cursor-pointer">

                                <div class="flex flex-col">
                                    <span class="font-medium text-zinc-900">{{ str($deck->name)->limit(40) }}</span>
                                    <span class="text-zinc-500 text-xs">{{ $deck->cards()->count() }} cards</span>
                                </div>

                                <div class="relative flex justify-center items-center mr-1 size-5">
                                    {{-- Hidden native checkbox (still handles form submission) --}}
                                    <input type="checkbox" name="deck_ids[]" value="{{ $deck->id }}"
                                        class="peer absolute inset-0 opacity-0 cursor-pointer">

                                    {{-- Custom visual checkbox --}}
                                    <div
                                        class="flex justify-center items-center bg-white peer-checked:bg-sky-600 border-2 border-zinc-300 peer-checked:border-sky-600 rounded-full size-5 transition-colors duration-200">
                                        {{-- Checkmark --}}
                                        <svg class="opacity-0 peer-checked:opacity-100 size-3 text-white transition-opacity"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    <div class="mt-6">
                        {{ $userDecks->links() }}
                    </div>
                </div>

                <div class="flex justify-end gap-3 bg-white mt-auto p-6">
                    <button type="button" @click="addDeckModalOpen = false"
                        class="bg-white hover:bg-zinc-100 px-5 py-2.5 rounded-full font-medium text-zinc-700 transition-colors cursor-pointer">
                        Cancel
                    </button>
                    <button type="submit" :disabled="isSubmitting || !isValid"
                        :class="(isSubmitting || !isValid) ? 'bg-zinc-700 cursor-not-allowed opacity-60' : 'bg-zinc-950 hover:scale-105 active:scale-100 cursor-pointer'"
                        class="flex justify-center items-center bg-zinc-900 hover:bg-zinc-800 shadow-sm px-5 py-2.5 rounded-full w-36 font-medium text-white transition-colors cursor-pointer">
                        <span x-show="!isSubmitting">
                            Add to Folder
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
            </form>
        @endif
    </div>
</div>
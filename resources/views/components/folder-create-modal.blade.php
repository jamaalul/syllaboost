<!-- Create Folder Modal -->
<div x-show="createFolderModalOpen" class="z-50 fixed inset-0 flex justify-center items-center" style="display: none;">
    <div x-show="createFolderModalOpen" x-transition.opacity class="fixed inset-0 bg-black/40 backdrop-blur-sm"
        @click="createFolderModalOpen = false"></div>

    <div x-show="createFolderModalOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative bg-white shadow-xl mx-4 p-6 rounded-3xl w-full max-w-md overflow-hidden">
        <div class="flex justify-between items-center mb-5">
            <h3 class="font-bold text-zinc-900 text-lg">Create New Folder</h3>
            <button @click="createFolderModalOpen = false" class="text-zinc-400 hover:text-zinc-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <form action="{{ route('folders.store') }}" method="POST" x-data="{ isSubmitting: false, folderName: @js(old('name', '')) }" @submit="isSubmitting = true">
            @csrf
            <div class="mb-5">
                <label for="name" class="block mb-1 font-medium text-zinc-700 text-sm">Folder Name</label>
                <input type="text" name="name" id="name" required x-model="folderName"
                    class="bg-white px-2 py-1 border border-zinc-300 rounded-lg focus:outline-violet-600 w-full text-lg"
                    placeholder="e.g. Science Notes" autofocus>
                @error('name')
                    <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" x-data="{ loading: false }" @click="createFolderModalOpen = false; loading = true"
                    class="flex justify-center hover:bg-zinc-50 px-4 py-2 rounded-full w-24 font-semibold text-zinc-950 hover:scale-105 active:scale-100 transition-all duration-100 cursor-pointer">
                    <span x-show="!loading">
                        Cancel
                    </span>
                    <span x-show="loading">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="animate-spin lucide lucide-loader-circle-icon lucide-loader-circle">
                            <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                        </svg>
                    </span>
                </button>
                <button type="submit" :disabled="isSubmitting || folderName.trim() === ''"
                    :class="(isSubmitting || folderName.trim() === '') ? 'bg-zinc-700 cursor-not-allowed opacity-60' : 'bg-zinc-950 hover:scale-105 active:scale-100 cursor-pointer'"
                    class="flex justify-center px-4 py-2 rounded-full w-38 font-semibold text-white transition-all duration-100">
                    <span x-show="!isSubmitting">
                        Create Folder
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
    </div>
</div>
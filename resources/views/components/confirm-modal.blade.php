<div
    x-data="{
        open: false,
        formAction: '',
        formMethod: 'DELETE',
        title: 'Are you sure?',
        description: 'This action cannot be undone.',
        confirmText: 'Confirm',
        showModal(action, method = 'DELETE', title = 'Are you sure?', description = 'This action cannot be undone.', confirmText = 'Confirm') {
            this.formAction = action;
            this.formMethod = method;
            this.title = title;
            this.description = description;
            this.confirmText = confirmText;
            this.open = true;
        }
    }"
    @confirm-action.window="showModal($event.detail.action, $event.detail.method ?? 'DELETE', $event.detail.title, $event.detail.description, $event.detail.confirmText)"
    x-show="open"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    style="display: none;"
    @keydown.escape.window="open = false"
>
    {{-- Backdrop --}}
    <div
        class="absolute inset-0 bg-black/40 backdrop-blur-sm"
        @click="open = false"
    ></div>

    {{-- Modal Panel --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm p-6 flex flex-col items-center gap-4"
    >
        {{-- Icon --}}
        <div class="flex items-center justify-center bg-rose-50 rounded-full w-14 h-14">
            <svg class="w-7 h-7 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </div>

        {{-- Text --}}
        <div class="text-center">
            <h3 class="text-lg font-bold text-zinc-900 mb-1" x-text="title"></h3>
            <p class="text-sm text-zinc-500" x-text="description"></p>
        </div>

        {{-- Actions --}}
        <div class="flex gap-3 w-full mt-1">
            <button
                type="button"
                @click="open = false"
                class="flex-1 px-4 py-2.5 rounded-full border border-zinc-200 bg-white text-zinc-700 font-semibold text-sm hover:bg-zinc-50 transition-colors cursor-pointer"
            >
                Cancel
            </button>
            <form :action="formAction" method="POST" class="flex-1">
                @csrf
                <input type="hidden" name="_method" :value="formMethod">
                <button
                    type="submit"
                    class="w-full px-4 py-2.5 rounded-full bg-rose-500 hover:bg-rose-600 text-white font-semibold text-sm transition-colors cursor-pointer"
                    x-text="confirmText"
                >
                </button>
            </form>
        </div>
    </div>
</div>

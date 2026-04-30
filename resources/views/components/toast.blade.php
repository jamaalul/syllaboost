<div x-data="{ 
    show: false, 
    message: '', 
    type: 'info',
    init() {
        @if (session('success'))
            this.showToast('{{ session('success') }}', 'success');
        @endif
        @if (session('error'))
            this.showToast('{{ session('error') }}', 'error');
        @endif
        @if (session('info'))
            this.showToast('{{ session('info') }}', 'info');
        @endif
        @if ($errors->any())
            this.showToast('{{ $errors->first() }}', 'error');
        @endif
    },
    showToast(message, type) {
        this.message = message;
        this.type = type;
        this.show = true;
        setTimeout(() => { this.show = false }, 5000);
    }
}" 
x-show="show" 
x-transition:enter="transition ease-out duration-300"
x-transition:enter-start="opacity-0 transform translate-y-2"
x-transition:enter-end="opacity-100 transform translate-y-0"
x-transition:leave="transition ease-in duration-200"
x-transition:leave-start="opacity-100 transform translate-y-0"
x-transition:leave-end="opacity-0 transform translate-y-2"
class="fixed bottom-5 right-5 z-50 px-6 py-3 rounded-2xl shadow-xl border flex items-center gap-3 min-w-[320px] max-w-md"
:class="{
    'bg-emerald-50 border-emerald-100 text-emerald-800': type === 'success',
    'bg-red-50 border-red-100 text-red-800': type === 'error',
    'bg-sky-50 border-sky-100 text-sky-800': type === 'info'
}"
style="display: none;">
    <!-- Icons -->
    <div class="flex-shrink-0">
        <template x-if="type === 'success'">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 text-emerald-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </template>
        <template x-if="type === 'error'">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 text-red-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </template>
        <template x-if="type === 'info'">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 text-sky-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
            </svg>
        </template>
    </div>
    
    <div class="flex-1">
        <p x-text="message" class="text-sm font-semibold leading-tight"></p>
    </div>
    
    <button @click="show = false" class="flex-shrink-0 text-zinc-400 hover:text-zinc-600 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    </button>
</div>

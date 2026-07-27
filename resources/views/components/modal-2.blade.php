@props(['name', 'title' => '', 'maxWidth' => 'lg', 'focusable' => false])

@php
    $maxWidthClass =
        [
            'sm' => 'max-w-sm',
            'md' => 'max-w-md',
            'lg' => 'max-w-[600px]',
            'xl' => 'max-w-xl',
            '2xl' => 'max-w-2xl',
            '3xl' => 'max-w-3xl',
        ][$maxWidth] ?? 'max-w-[600px]';
@endphp

<div x-data="{
    show: false,
    focusable: @js($focusable),
    focusables() {
        let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
        return [...$el.querySelectorAll(selector)].filter(el => !el.hasAttribute('disabled'))
    },
    firstFocusable() { return this.focusables()[0] },
    lastFocusable() { return this.focusables().slice(-1)[0] },
    nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
    prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
    nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
    prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) - 1 },
}" x-init="$watch('show', value => {
    if (value) {
        document.body.classList.add('overflow-hidden');
        if (focusable) setTimeout(() => firstFocusable()?.focus(), 100);
    } else {
        document.body.classList.remove('overflow-hidden');
    }
})"
    x-on:open-modal.window="$event.detail === '{{ $name }}' ? show = true : null"
    x-on:close-modal.window="$event.detail === '{{ $name }}' ? show = false : null" x-on:close.stop="show = false"
    x-on:keydown.escape.window="show ? show = false : null"
    x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
    x-on:keydown.shift.tab.prevent="prevFocusable().focus()" x-show="show" x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center " style="display: none;">
    {{-- Backdrop --}}
    <div x-show="show" class="absolute inset-0 bg-black/50 backdrop-blur-sm" x-on:click="show = false"
        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

    {{-- Modal Panel --}}
    <div x-show="show"
        class="relative w-full {{ $maxWidthClass }} max-h-[90dvh] bg-white rounded-2xl shadow-2xl flex flex-col mx-4 "
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
        {{-- Modal Header --}}
        @if ($title)
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 flex-shrink-0">
                <h3 class="font-poppins font-bold text-lg">{{ $title }}</h3>
                <button x-on:click="show = false" type="button"
                    class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-200 hover:text-gray-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        {{-- Modal Body --}}
        <div class="flex-1 overflow-y-auto p-6">
            {{ $slot }}
        </div>

        {{-- Modal Footer (optional slot) --}}
        @if (isset($footer))
            <div class="flex-shrink-0 px-6 py-4 border-t border-gray-100">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>

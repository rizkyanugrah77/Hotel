@props(['item', 'confirmDelete'])


<button type="button" wire:click="{{ $confirmDelete }}({{ $item->id }})"
    class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-red-600 transition-colors hover:bg-red-50"
    aria-label="Hapus {{ $item->name }}" title="Hapus"> <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12M9 7V4h6v3m-8 0l1 13h8l1-13M10 11v6m4-6v6" />
    </svg></button>

@props(['item', 'action'])

{{-- @php($itemId = is_array($item) ? $item['id'] : (is_object($item) ? $item->id : $item)) --}}

<button type="button" wire:click="{{ $action }}({{ $item->id }})"
    class="w-8 h-8 rounded-lg bg-primary text-white flex items-center justify-center hover:bg-primary/80 transition-colors"
    title="Show Detail">
    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2 12s3-4 10-4 10 4 10 4-3 4-10 4-10-4-10-4z" />
        <circle cx="12" cy="12" r="3" />
    </svg>
</button>

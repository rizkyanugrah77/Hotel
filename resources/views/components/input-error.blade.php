@props(['message'])

@php
    $resolvedMessage = is_array($message) 
        ? ($message[0] ?? null) 
        : ($message instanceof \Illuminate\Support\Collection ? $message->first() : $message);
@endphp

@if ($resolvedMessage)
    <span {{ $attributes->merge(['class' => 'text-sm text-red-500 mt-1']) }}>{{ $resolvedMessage }}</span>
@endif

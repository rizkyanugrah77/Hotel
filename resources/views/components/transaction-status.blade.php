@props(['status'])

@php
    $statusKey = strtoupper((string) $status);
    $label = match ($statusKey) {
        'SUCCESS' => 'Berhasil',
        'PENDING', 'CHALLENGE' => 'Pending',
        'FAILED', 'EXPIRED', 'CANCEL' => 'Gagal',
        'REFUND' => 'Dikembalikan',
        default => $status ?: 'N/A',
    };
@endphp

<span @class([
    'inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold',
    'bg-emerald-50 text-emerald-700' => $statusKey === 'SUCCESS',
    'bg-amber-50 text-amber-700' => in_array($statusKey, ['PENDING', 'CHALLENGE']),
    'bg-red-50 text-red-600' => in_array($statusKey, ['FAILED', 'EXPIRED', 'CANCEL']),
    'bg-gray-100 text-gray-600' => !in_array($statusKey, ['SUCCESS', 'PENDING', 'CHALLENGE', 'FAILED', 'EXPIRED', 'CANCEL', 'REFUND']),
])>
    {{ $label }}
</span>

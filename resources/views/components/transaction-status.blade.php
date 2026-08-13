@props(['status'])

@php
    $statusKey = strtolower((string) $status);
    $label = match ($statusKey) {
        'success', 'capture', 'settlement', 'paid', 'completed' => 'Berhasil',
        'pending', 'challenge' => 'Pending',
        'deny', 'cancelled', 'cancel', 'failed', 'expired', 'expire' => 'Gagal',
        default => $status ?: 'N/A',
    };
@endphp

<span @class([
    'inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold',
    'bg-emerald-50 text-emerald-700' => in_array($statusKey, [
        'success',
        'capture',
        'settlement',
        'paid',
        'completed',
    ]),
    'bg-amber-50 text-amber-700' => in_array($statusKey, ['pending', 'challenge']),
    'bg-red-50 text-red-600' => in_array($statusKey, [
        'deny',
        'cancelled',
        'cancel',
        'failed',
        'expired',
        'expire',
    ]),
    'bg-gray-100 text-gray-600' => !in_array($statusKey, [
        'success',
        'capture',
        'settlement',
        'paid',
        'completed',
        'pending',
        'challenge',
        'deny',
        'cancelled',
        'cancel',
        'failed',
        'expired',
        'expire',
    ]),
])>
    {{ $label }}
</span>
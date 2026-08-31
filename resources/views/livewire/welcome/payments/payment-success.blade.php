@php
    $paymentStatus = strtoupper((string) $payment->transaction_status);
    $isPaid =
        $paymentStatus === 'SUCCESS' && in_array($payment->booking->status, ['paid', 'checked_in', 'checked_out']);
    $isPending = in_array($paymentStatus, ['PENDING', 'CHALLENGE'], true) || $payment->booking->status === 'pending';

    [$title, $description, $badge, $badgeClass] = $isPaid
        ? [
            'Booking Confirmed!',
            'Pembayaran Anda telah diterima. Konfirmasi booking dan receipt dikirim ke',
            'Paid In Full',
            'badge-success',
        ]
        : ($isPending
            ? [
                'Payment Pending',
                'Pembayaran Anda masih menunggu konfirmasi. Kami akan memperbarui status booking melalui email ke',
                'Awaiting Payment',
                'badge-warning',
            ]
            : [
                'Payment Not Completed',
                'Pembayaran tidak dapat diselesaikan. Status booking terbaru telah dikirim ke',
                'Payment ' . ucfirst(strtolower($paymentStatus ?: 'failed')),
                'badge-accent',
            ]);
@endphp

<div class="py-32 px-4 flex justify-center min-h-[calc(100vh-80px)] items-center">
    <div class="max-w-2xl w-full text-center">

        <!-- Success Icon -->
        <div class="relative w-24 h-24 mx-auto mb-8">
            <div @class([
                'absolute inset-0 rounded-full animate-ping opacity-75',
                'bg-green-100' => $isPaid,
                'bg-amber-100' => $isPending,
                'bg-red-100' => !$isPaid && !$isPending,
            ])></div>
            <div @class([
                'relative flex h-full w-full items-center justify-center rounded-full text-white animate-scale-up',
                'bg-green-500 shadow-lg shadow-green-500/30' => $isPaid,
                'bg-amber-500 shadow-lg shadow-amber-500/30' => $isPending,
                'bg-red-500 shadow-lg shadow-red-500/30' => !$isPaid && !$isPending,
            ])>
                <svg class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                    @if ($isPaid)
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    @elseif ($isPending)
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75v5.25l3.75 2.25" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    @else
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.25 9-4.5 4.5m0-4.5 4.5 4.5" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    @endif
                </svg>
            </div>
        </div>

        <h1 class="text-3xl md:text-4xl font-poppins font-bold text-foreground mb-4 animate-fade-in-up"
            style="animation-delay: 0.2s">{{ $title }}</h1>
        <p class="text-gray-500 mb-8 max-w-md mx-auto animate-fade-in-up" style="animation-delay: 0.3s">
            {{ $description }} <span class="text-foreground font-medium">{{ $payment->booking->user->email }}</span>.
        </p>

        <!-- Booking Card -->
        <div class="card p-6 md:p-8 text-left mb-8 border border-gray-100 animate-fade-in-up"
            style="animation-delay: 0.4s">
            <div class="flex justify-between items-center pb-6 border-b border-gray-100 mb-6">
                <div>
                    <p class="text-sm text-gray-500">Booking Reference</p>
                    <p class="text-xl font-mono font-bold text-primary mt-1">
                        {{ $payment->booking->booking_code }}
                    </p>
                </div>
                <div class="text-right">
                    <span class="{{ $badgeClass }} mb-1">{{ $badge }}</span>
                    <p class="font-poppins font-bold text-lg">
                        {{ 'Rp ' . number_format($payment->booking->total_price, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Check-in</p>
                    <p class="font-medium text-sm">{{ $payment->booking->check_in->format('d M Y') }}</p>
                    <p class="text-xs text-gray-400">After 2:00 PM</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Check-out</p>
                    <p class="font-medium text-sm">{{ $payment->booking->check_out->format('d M Y') }}</p>
                    <p class="text-xs text-gray-400">Before 12:00 PM</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Room</p>
                    <p class="font-medium text-sm">{{ $payment->booking->room->name }}</p>
                    <p class="text-xs text-gray-400">{{ $payment->booking->total_guests }} Guests</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Guest</p>
                    <p class="font-medium text-sm">{{ $payment->booking->user->name }}</p>
                    <p class="text-xs text-gray-400">{{ $payment->booking->user->phone }}</p>

                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Tipe Pembayaran</p>
                    <p class="font-medium text-sm capitalize">{{ $payment->payment_type }}</p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row justify-center gap-4 animate-fade-in-up" style="animation-delay: 0.5s">
            <a href="{{ route('user.dashboard') }}" class="btn-primary" wire:navigate>
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
                Go to My Dashboard
            </a>
            @if ($isPaid)
                <button type="button" wire:click="downloadReceipt" wire:loading.attr="disabled" class="btn-outline">
                    <svg wire:loading.remove class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>

                    <svg wire:loading class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>

                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>

                    <span wire:loading.remove>
                        Download Receipt
                    </span>

                    <span wire:loading>
                        Generating PDF...
                    </span>
                </button>
            @endif
        </div>

        <p class="text-sm text-gray-400 mt-12 animate-fade-in-up" style="animation-delay: 0.6s">
            <a href="{{ route('index') }}" class="hover:text-primary transition-colors" wire:navigate>Return to
                Homepage</a>
        </p>
    </div>
</div>

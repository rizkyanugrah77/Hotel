<div class="py-32 px-4 flex justify-center min-h-[calc(100vh-80px)] items-center">
    <div class="max-w-2xl w-full text-center">

        <!-- Success Icon -->
        <div class="relative w-24 h-24 mx-auto mb-8">
            <div class="absolute inset-0 bg-green-100 rounded-full animate-ping opacity-75"></div>
            <div
                class="relative w-full h-full bg-green-500 rounded-full flex items-center justify-center shadow-lg shadow-green-500/30 animate-scale-up">
                <svg class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
            </div>
        </div>

        <h1 class="text-3xl md:text-4xl font-poppins font-bold text-foreground mb-4 animate-fade-in-up"
            style="animation-delay: 0.2s">Booking Confirmed!</h1>
        <p class="text-gray-500 mb-8 max-w-md mx-auto animate-fade-in-up" style="animation-delay: 0.3s">Thank you
            for choosing Sitio Tio Resort. We have sent your booking confirmation and receipt to <span
                class="text-foreground font-medium">{{ $payment->booking->user->email }}</span>.</p>

        <!-- Booking Card -->
        <div class="card p-6 md:p-8 text-left mb-8 border border-gray-100 animate-fade-in-up"
            style="animation-delay: 0.4s">
            <div class="flex justify-between items-center pb-6 border-b border-gray-100 mb-6">
                <div>
                    <p class="text-sm text-gray-500">Booking Reference</p>
                    <p class="text-xl font-mono font-bold text-primary mt-1">
                    </p>
                </div>
                <div class="text-right">
                    <span class="badge-success mb-1">Paid In Full</span>
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
                    <p class="text-xs text-gray-500 mb-1">Payment Method</p>
                    <p class="font-medium text-sm capitalize">{{ $payment->payment_method }}</p>
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
        </div>

        <p class="text-sm text-gray-400 mt-12 animate-fade-in-up" style="animation-delay: 0.6s">
            <a href="{{ route('index') }}" class="hover:text-primary transition-colors" wire:navigate>Return to
                Homepage</a>
        </p>
    </div>
</div>

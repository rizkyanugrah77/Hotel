<x-guest-layout>
    <div class="py-32 px-4 flex justify-center min-h-[calc(100vh-80px)] items-center">
        <div class="max-w-2xl w-full text-center">

            <!-- Loading Icon -->
            <div class="relative w-24 h-24 mx-auto mb-8">
                <div class="relative w-full h-full bg-primary/10 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-primary animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </div>
            </div>

            <h1 class="text-2xl md:text-3xl font-poppins font-bold text-foreground mb-4">
                Processing Your Payment...
            </h1>
            <p class="text-gray-500 mb-8 max-w-md mx-auto">
                Please wait while we verify your payment status. You will be redirected shortly.
            </p>

            <noscript>
                <p class="text-red-500">JavaScript is required for automatic redirect.</p>
            </noscript>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const params = new URLSearchParams(window.location.search);
            const orderId = params.get('order_id');

            if (orderId) {
                // Redirect to the payment status page
                window.location.href = "{{ url('/payment-success') }}/" + encodeURIComponent(orderId);
            } else {
                // No order_id found, redirect to homepage
                window.location.href = "{{ route('index') }}";
            }
        });
    </script>
</x-guest-layout>

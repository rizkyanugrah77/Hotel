<div>
    <main class="px-4 py-32">
        <div class="max-w-5xl mx-auto">

            <!-- Stepper -->
            <div class="mb-12">
                <div class="flex items-center justify-between max-w-2xl mx-auto relative">
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1 bg-gray-200 rounded-full -z-10">
                    </div>
                    <div
                        class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1 bg-primary rounded-full -z-10 transition-all duration-500">
                    </div>

                    <div class="flex flex-col items-center gap-2">
                        <div
                            class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shadow-red">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-primary">Select Room</span>
                    </div>
                    <div class="flex flex-col items-center gap-2">
                        <div
                            class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shadow-red">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-primary">Guest Details</span>
                    </div>
                    <div class="flex flex-col items-center gap-2">
                        <div
                            class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shadow-red ring-4 ring-primary/20">
                            3</div>
                        <span class="text-xs font-semibold text-primary">Payment</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Left: Payment Form -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="card p-6 md:p-8 border border-gray-100" data-tabs>
                        <h2 class="text-xl font-poppins font-bold text-foreground mb-6">Payment Method</h2>

                        <!-- Midtrans Secure Payment Info -->
                        <div class="bg-blue-50/50 border border-blue-100 rounded-2xl p-6 text-center mb-8">
                            <div
                                class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm border border-gray-100">
                                <svg class="w-8 h-8 text-primary" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </div>
                            <h3 class="font-poppins font-semibold text-lg text-foreground mb-2">Secure Payment via
                                Midtrans</h3>
                            <p class="text-gray-600 text-sm max-w-md mx-auto">
                                You will be directed to Midtrans' secure payment gateway where you can choose your
                                preferred payment method (Credit Card, Virtual Account, e-Wallet, etc).
                            </p>
                        </div>

                        <form wire:submit="pay">
                            <div class="flex justify-center">
                                <button type="submit"
                                    class="btn-primary !px-8 text-lg w-full md:w-auto flex items-center justify-center gap-2 shadow-lg shadow-primary/30">
                                    Proceed to Payment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right: Summary -->
                <div>
                    <div class="card p-6 border border-gray-100 sticky top-6">
                        <h3 class="font-poppins font-bold text-lg mb-4">Order Summary</h3>
                        <div class="flex gap-4 items-center mb-6 pb-6 border-b border-gray-100">
                            <img src="{{ asset('assets/img/rooms/' . $bookings->room->image) }}"
                                class="w-20 h-20 rounded-xl object-cover" alt="" />
                            <div>
                                <p class="font-medium text-sm">{{ $bookings->room->name }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ \Carbon\Carbon::parse($bookings->check_in)->format('d F Y') }} -
                                    {{ \Carbon\Carbon::parse($bookings->check_out)->format('d F Y') }}
                                </p>
                                <p class="text-xs text-gray-500">{{ $bookings->total_guests }} Guests</p>
                            </div>
                        </div>

                        <div class="space-y-3 pb-6 border-b border-gray-100 text-sm">
                            @php
                                $subtotal = $bookings->total_price / 1.11;
                                $taxAmount = $bookings->total_price - $subtotal;
                            @endphp
                            <div class="flex justify-between">
                                <span class="text-gray-500">Subtotal</span>
                                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Taxes (11%)</span>
                                <span>Rp {{ number_format($taxAmount, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="pt-4 flex justify-between items-center mb-6">
                            <span class="font-bold text-foreground">Total</span>
                            <span class="text-2xl font-poppins font-bold text-primary">
                                Rp {{ number_format($bookings->total_price, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="bg-blue-50 text-blue-800 text-xs p-4 rounded-xl flex items-start gap-2">
                            <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                            </svg>
                            <p>Free cancellation until 10 Oct 2026. After that, a 1-night penalty applies.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">
    <div class="p-5 sm:p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
        <h2 class="font-poppins font-bold text-lg text-foreground">Riwayat Booking</h2>
        <p class="text-xs text-gray-400">{{ $totalBookings }} total booking</p>
    </div>

    @if ($allBookings->count() > 0)
        <!-- Mobile: Card view -->
        <div class="divide-y divide-gray-50 sm:hidden">
            @foreach ($allBookings as $booking)
                <div class="p-4">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <h3 class="text-sm font-semibold text-foreground">
                                {{ $booking->room->name ?? 'Room' }}
                            </h3>
                            <p class="text-[11px] text-gray-400 mt-0.5">{{ $booking->booking_code }}</p>

                            <div class="mt-2">
                                @php
                                    $payment = $payments->where('booking_id', $booking->id)->first();
                                @endphp
                                @if ($payment)
                                    @if ($booking->status === 'paid')
                                        <a href="{{ route('payment-success', $payment->order_id) }}" wire:navigate
                                            class="btn-primary text-xs !px-2 !py-1.5 inline-flex">Cetak</a>
                                    @else
                                        <a href="{{ route('payment-check', $payment->order_id) }}" wire:navigate
                                            class="btn-secondary text-xs !px-2 !py-1.5 inline-flex">Cek</a>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div>
                            @if ($booking->status === 'paid')
                                <span class="badge-success text-[10px]">Paid</span>
                            @elseif($booking->status === 'pending')
                                <span class="badge-warning text-[10px]">Pending</span>
                            @elseif($booking->status === 'cancelled')
                                <span class="badge bg-red-50 text-red-600 text-[10px]">Cancelled</span>
                            @elseif($booking->status === 'checked_in')
                                <span class="badge bg-gray-100 text-gray-600 text-[10px]">Selesai</span>
                            @else
                                <span
                                    class="badge bg-gray-100 text-gray-600 text-[10px]">{{ ucfirst($booking->status) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center justify-between text-xs text-gray-500 mt-3">
                        <span>{{ $booking->check_in->format('d M') }} —
                            {{ $booking->check_out->format('d M Y') }}</span>
                        <span class="font-semibold text-foreground">Rp
                            {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Desktop: Table view -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50/80 text-gray-500">
                    <tr>
                        <th class="py-3 px-6 font-medium">Kode Booking</th>
                        <th class="py-3 px-6 font-medium">Lihat</th>
                        <th class="py-3 px-6 font-medium">Kamar</th>
                        <th class="py-3 px-6 font-medium">Tanggal</th>
                        <th class="py-3 px-6 font-medium">Tamu</th>
                        <th class="py-3 px-6 font-medium">Status</th>
                        <th class="py-3 px-6 font-medium text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach ($allBookings as $booking)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-3.5 px-6">
                                <span
                                    class="font-mono text-xs font-medium text-primary bg-primary/5 px-2 py-1 rounded-lg">{{ $booking->booking_code }}</span>
                            </td>
                            <td class="py-3.5 px-6">
                                @php
                                    $payment = $payments->where('booking_id', $booking->id)->first();
                                @endphp
                                @if ($payment)
                                    @if ($booking->status === 'paid' || $booking->status === 'checked_in' || $booking->status === 'checked_out')
                                        <a href="{{ route('payment-success', $payment->order_id) }}" wire:navigate
                                            class="btn-ghost text-xs !px-2 !py-1.5 inline-flex">Cek Bukti</a>
                                    @elseif($booking->status === 'pending' || $booking->status === 'cancelled')
                                        <a href="{{ route('payment-success', $payment->order_id) }}" wire:navigate
                                            class="btn-primary text-xs !px-2 !py-1.5 inline-flex">Cek Pembayaran</a>
                                    @endif
                                @else
                                    <span class="badge-primary text-[10px]">Belum ada pembayaran</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-6 font-medium text-foreground">
                                {{ $booking->room->name ?? '-' }}</td>
                            <td class="py-3.5 px-6 text-gray-500">
                                {{ $booking->check_in->format('d M') }} —
                                {{ $booking->check_out->format('d M Y') }}</td>
                            <td class="py-3.5 px-6 text-gray-500">{{ $booking->total_guests }} orang</td>
                            <td class="py-3.5 px-6">
                                <span
                                    class="badge-{{ $booking->status === 'paid' ? 'success' : ($booking->status === 'pending' ? 'warning' : ($booking->status === 'cancelled' ? 'primary' : ($booking->status === 'checked_in' ? 'success' : ''))) }}">{{ ucfirst($booking->status) }}</span>
                            </td>
                            <td class="py-3.5 px-6 font-semibold text-foreground text-right">Rp
                                {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="p-8 sm:p-12 text-center">
            <div class="w-16 h-16 mx-auto bg-gray-50 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <p class="text-sm text-gray-500 font-medium">Belum ada riwayat booking</p>
            <p class="text-xs text-gray-400 mt-1">Booking pertama Anda akan muncul di sini.</p>
        </div>
    @endif
</div>

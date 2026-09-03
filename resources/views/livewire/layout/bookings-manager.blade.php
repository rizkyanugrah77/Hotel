<div x-data="{
    toast: { show: false, message: '', type: 'success' },
    showToast(message, type) {
        this.toast.message = message;
        this.toast.show = true;
        this.toast.type = type;
        window.setTimeout(() => this.toast.show = false, 5000);
    }
}"
    x-on:booking-saved.window="$dispatch('close-modal', 'manage-booking'); showToast($event.detail.message, $event.detail.type)"
    x-on:booking-deleted.window="$dispatch('close-modal', 'delete-booking'); showToast($event.detail.message, $event.detail.type)"
    x-on:booking-error.window="showToast($event.detail.message, $event.detail.type); $dispatch('close-modal', 'manage-booking')"
    x-on:booking-editing.window="$dispatch('open-modal', 'manage-booking')"
    x-on:booking-detail.window="$dispatch('open-modal', 'booking-detail')"
    x-on:booking-delete-confirmation.window="$dispatch('open-modal', 'delete-booking')"
    class="min-w-0 flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">

    <!-- Content -->

    <x-toast />
    <!-- KPI Cards -->
    <div class="mb-6 grid grid-cols-2 gap-3 lg:mb-8 lg:grid-cols-4 lg:gap-6">
        <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-5 lg:p-6">
            <div class="mb-2 flex items-start justify-between sm:mb-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Bookings</p>
                    <h3 class="text-2xl font-poppins font-bold text-foreground" id="kpiTotal">
                        {{ $bookingStats['total'] }}</h3>
                </div>
                <div
                    class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary sm:h-10 sm:w-10">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                    </svg>
                </div>
            </div>
            <p class="hidden text-xs font-medium text-gray-500 sm:block" id="kpiTotalSub">Semua booking</p>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-5 lg:p-6">
            <div class="mb-2 flex items-start justify-between sm:mb-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Confirmed</p>
                    <h3 class="text-2xl font-poppins font-bold text-emerald-600" id="kpiConfirmed">
                        {{ $bookingStats['paid'] }}</h3>
                </div>
                <div
                    class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 sm:h-10 sm:w-10">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <p class="hidden text-xs font-medium text-emerald-600 sm:block" id="kpiConfirmedSub">Booking aktif</p>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-5 lg:p-6">
            <div class="mb-2 flex items-start justify-between sm:mb-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Pending</p>
                    <h3 class="text-2xl font-poppins font-bold text-amber-600" id="kpiPending">
                        {{ $bookingStats['pending'] }}</h3>
                </div>
                <div
                    class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-50 text-amber-600 sm:h-10 sm:w-10">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <p class="hidden text-xs font-medium text-amber-600 sm:block" id="kpiPendingSub">Menunggu konfirmasi</p>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-5 lg:p-6">
            <div class="mb-2 flex items-start justify-between sm:mb-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Revenue</p>
                    <h3 class="text-2xl font-poppins font-bold text-accent-700" id="kpiRevenue">
                        {{ 'Rp ' . number_format($bookingStats['total_price'] ?? 0, 0, ',', '.') }}</h3>
                </div>
                <div
                    class="flex h-9 w-9 items-center justify-center rounded-xl bg-accent/10 text-accent-700 sm:h-10 sm:w-10">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                    </svg>
                </div>
            </div>
            <p class="hidden text-xs font-medium text-accent-600 sm:block" id="kpiRevenueSub">Dari confirmed booking</p>
        </div>
    </div>

    <!-- Action Bar & Table -->
    <div class="mb-8 overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
        <div class="grid grid-cols-1">
            <div
                class="flex flex-col items-start justify-between gap-3 border-b border-gray-100 p-4 sm:p-5 lg:flex-row lg:items-center">
                <h2 class="font-poppins text-lg font-bold">Daftar Booking</h2>
                <div class="grid w-full grid-cols-2 gap-2 lg:flex lg:w-auto lg:items-center lg:gap-3">
                    <div class="relative">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        <input wire:model.live="search" type="text" id="searchInput"
                            placeholder="Cari booking atau tamu..."
                            class="input w-full py-2 pl-10 pr-4 text-sm lg:w-56" />
                    </div>
                    <select wire:model.live="filterStatus" id="filterStatus" class="input min-w-0 py-2 text-sm lg:w-36">
                        <option value="">Semua Status</option>
                        <option value="paid">Paid</option>
                        <option value="pending">Pending</option>
                        <option value="checked_in">Checked In</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="checked_out">Checked Out</option>
                    </select>
                    <select wire:model.live="filterRoom" id="filterRoom" class="input min-w-0 py-2 text-sm lg:w-40">
                        <option value="">Semua Room</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}">{{ $room->name }}</option>
                        @endforeach
                    </select>
                    <button type="button" @click="$dispatch('open-modal', 'manage-booking'); $wire.resetForm()"
                        class="btn-primary col-span-2 justify-center px-4 py-2 text-sm lg:col-auto">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Booking
                    </button>
                </div>
            </div>

            <div class="divide-y divide-gray-100 md:hidden">
                @forelse ($bookings as $booking)
                    @php
                        $statusClasses = match ($booking->status) {
                            'paid' => 'badge-info',
                            'checked_in' => 'badge-success',
                            'pending' => 'badge-warning',
                            'cancelled' => 'badge-danger',
                            'checked_out' => 'badge-accent',
                            default => 'badge-primary',
                        };
                    @endphp
                    <article wire:key="booking-mobile-{{ $booking->id }}" class="p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="truncate font-semibold text-gray-900">{{ $booking->booking_code }}</p>
                                <p class="mt-0.5 truncate text-sm text-gray-600">{{ $booking->user->name }}</p>
                            </div>
                            <span
                                class="shrink-0 rounded-full px-2 py-1 text-xs font-medium {{ $statusClasses }}">{{ ucwords(str_replace('_', ' ', $booking->status)) }}</span>
                        </div>
                        <div class="mt-3 rounded-lg bg-gray-50 p-3 text-sm">
                            <p class="font-medium text-gray-800">{{ $booking->room->name }} No
                                {{ $booking->roomUnit->room_number[2] }}</p>
                            <p class="mt-1 text-xs text-gray-500">{{ $booking->check_in->format('d M Y') }} -
                                {{ $booking->check_out->format('d M Y') }}</p>
                        </div>
                        <div class="mt-3 flex items-center justify-between text-sm">
                            <span class="text-gray-500">{{ $booking->total_guests }} tamu</span>
                            <span
                                class="font-semibold text-emerald-700">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="mt-3 flex justify-end border-t border-gray-100 pt-3">
                            <x-edit-button :item="$booking" action="edit" />
                            <x-show-button :item="$booking" action="show" />
                        </div>
                    </article>
                @empty
                    <p class="px-4 py-12 text-center text-sm text-gray-500">Tidak ada booking ditemukan.</p>
                @endforelse
            </div>

            <div class="hidden overflow-x-auto md:block">
                <table class="w-full min-w-[850px] text-left text-sm" id="bookingsTable">
                    <thead class="bg-gray-50 text-gray-500">
                        <tr>
                            <th class="px-4 py-3 font-medium">No</th>
                            <th class="px-4 py-3 font-medium">Booking & Tamu</th>
                            <th class="px-4 py-3 font-medium">Kamar</th>
                            <th class="px-4 py-3 font-medium">Menginap</th>
                            <th class="px-4 py-3 font-medium">Tamu</th>
                            <th class="px-4 py-3 font-medium">Status</th>
                            <th class="px-4 py-3 text-center font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($bookings as $index => $booking)
                            <tr wire:key="booking-{{ $booking->id }}" class="hover:bg-gray-50">
                                @php
                                    $statusClasses = match ($booking->status) {
                                        'paid' => 'badge-info',
                                        'checked_in' => 'badge-success',
                                        'pending' => 'badge-warning',
                                        'cancelled' => 'badge-primary',
                                        'checked_out' => 'badge-accent',
                                        default => 'badge-primary',
                                    };
                                @endphp
                                <td class="px-4 py-3 font-medium text-gray-500">{{ $index + 1 }}
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-medium text-gray-800">{{ $booking->booking_code }}</p>
                                    <p class="mt-0.5 text-xs text-gray-500">{{ $booking->user->name }}</p>
                                </td>
                                <td class="px-4 py-3 text-gray-700"> {{ $booking->room->name }} No.
                                    {{ $booking->roomUnit->room_number }}</td>
                                <td class="px-4 py-3 text-xs text-gray-600">
                                    <p>{{ $booking->check_in->format('d M Y') }}</p>
                                    <p class="mt-1">{{ $booking->check_out->format('d M Y') }}</p>
                                </td>
                                <td class="px-4 py-3 text-gray-700">{{ $booking->total_guests }}</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-flex rounded-full px-2 py-1 text-xs font-medium {{ $statusClasses }}">{{ ucwords(str_replace('_', ' ', $booking->status)) }}</span>
                                </td>
                                <td class="px-4 py-3 flex items-center space-x-2  text-center text-gray-700">
                                    <x-edit-button :item="$booking" action="edit" />

                                    <x-show-button :item="$booking" action="show" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-12 text-center text-gray-500">Tidak ada booking
                                    ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="bg-gray-50 p-4">{{ $bookings->links() }}</div>
        </div>
    </div>


    <x-modal-2 name="booking-detail" title="Detail Booking" maxWidth="5xl">
        @if ($payments)
            @php
                $status = $payments->transaction_status ?? 'N/A';
                $booking = $payments->booking;
                $guest = $booking?->user;
                $room = $booking?->room;
                $guestName = $guest?->name ?? 'Guest tidak diketahui';
                $guestInitials = collect(explode(' ', trim($guestName)))
                    ->filter()
                    ->map(fn($name) => mb_strtoupper(mb_substr($name, 0, 1)))
                    ->take(2)
                    ->implode('');
                $statusClasses = match ($status) {
                    'settlement', 'capture', 'success', 'paid', 'completed' => 'bg-emerald-100 text-emerald-700',
                    'pending', 'challenge' => 'bg-amber-100 text-amber-700',
                    'cancel', 'cancelled', 'deny', 'failure', 'expire' => 'bg-red-100 text-red-700',
                    default => 'bg-slate-100 text-slate-600',
                };

            @endphp

            <div class="grid gap-5 lg:grid-cols-12">
                <aside class="lg:col-span-3">
                    <div class="h-full rounded-xl border border-gray-100 bg-gray-50 p-5">
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Profil Tamu</p>

                        <div class="mt-5 flex items-center gap-3">
                            <img class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-primary text-sm font-bold text-white"
                                src="{{ $guest?->photo ?? 'https://ui-avatars.com/api/?name=' . $guestName }}"
                                alt="{{ $guestName }}">
                            <div class="min-w-0">
                                <p class="truncate font-poppins text-lg font-bold text-gray-900">{{ $guestName }}
                                </p>
                                <p class="mt-0.5 text-sm text-gray-500">Tamu booking</p>
                            </div>
                        </div>

                        <dl class="mt-6 space-y-4 text-sm">
                            <div>
                                <dt class="text-gray-500">Email</dt>
                                <dd class="mt-1 break-all font-medium text-gray-800">{{ $guest?->email ?? 'N/A' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Nomor telepon</dt>
                                <dd class="mt-1 font-medium text-gray-800">{{ $guest?->phone ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                        <div class="w-full border-2 border-slate-600  my-3"></div>
                        <dl class="space-y-2 text-sm">
                            <h4 class="text-xs font-semibold uppercase tracking-wide text-gray-500">Identitas Tamu</h4>
                            <div>
                                <dt class="text-gray-500">Kewarganegaraan</dt>
                                <dd class="mt-1 font-medium text-gray-800">{{ $guest?->nationality ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Jenis Kelamin</dt>
                                <dd class="mt-1 font-medium text-gray-800">{{ $guest?->gender ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Alamat</dt>
                                <dd class="mt-1 font-medium text-gray-800">{{ $guest?->address ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                    </div>
                </aside>

                <section class="space-y-4 lg:col-span-5">
                    <div class="rounded-xl bg-gradient-to-br from-primary to-primary/80 p-4 text-white shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-xs font-medium text-white/70">Total Pembayaran</p>
                                <p class="mt-1 text-2xl font-bold">Rp
                                    {{ number_format($payments->gross_amount, 0, ',', '.') }}</p>
                            </div>
                            <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClasses }}">
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </span>
                        </div>
                    </div>

                    <dl class="divide-y divide-gray-100 overflow-hidden rounded-xl border border-gray-100 text-sm">
                        <div class="grid grid-cols-3 gap-3 px-4 py-3">
                            <dt class="text-gray-500">Kode booking</dt>
                            <dd class="col-span-2 text-right font-medium text-gray-800">
                                {{ $booking?->booking_code ?? 'N/A' }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-3 bg-gray-50/60 px-4 py-3">
                            <dt class="text-gray-500">Kamar</dt>
                            <dd class="col-span-2 text-right font-medium text-gray-800">
                                {{ $booking?->room?->name ?? 'N/A' }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-3 px-4 py-3">
                            <dt class="text-gray-500">Masa inap</dt>
                            <dd class="col-span-2 text-right font-medium text-gray-800">
                                {{ $booking?->check_in?->format('d M Y') ?? 'N/A' }} -
                                {{ $booking?->check_out?->format('d M Y') ?? 'N/A' }}
                            </dd>
                        </div>
                        <div class="grid grid-cols-3 gap-3 bg-gray-50/60 px-4 py-3">
                            <dt class="text-gray-500">Jumlah tamu</dt>
                            <dd class="col-span-2 text-right font-medium text-gray-800">
                                {{ $booking?->total_guests ?? 'N/A' }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-3 px-4 py-3">
                            <dt class="text-gray-500">Payment ID</dt>
                            <dd class="col-span-2 break-all text-right font-medium text-gray-800">
                                {{ $payments->order_id }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-3 bg-gray-50/60 px-4 py-3">
                            <dt class="text-gray-500">Metode</dt>
                            <dd class="col-span-2 text-right font-medium text-gray-800">
                                {{ $payments->payment_method ?? 'N/A' }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-3 px-4 bg-gray-50/60 py-3">
                            <dt class="text-gray-500">Tanggal transaksi</dt>
                            <dd class="col-span-2 text-right font-medium text-gray-800">
                                {{ $payments->created_at?->format('d M Y, H:i') ?? 'N/A' }}
                            </dd>
                        </div>
                        <div class="grid grid-cols-3 gap-3 px-4 py-3">
                            <dt class="text-gray-500">Status</dt>
                            <dd class="col-span-2 text-right font-medium text-gray-800">
                                {{ $booking->status ?? 'N/A' }}
                            </dd>
                        </div>
                    </dl>
                </section>

                <section class="overflow-hidden rounded-xl border border-gray-100 bg-white lg:col-span-4">
                    @if ($room?->image)
                        <img src="{{ asset('storage/assets/img/rooms/' . $room->image) }}" alt="{{ $room->name }}"
                            class="h-48 w-full object-cover sm:h-56 lg:h-48">
                    @else
                        <div
                            class="flex h-48 items-center justify-center bg-gray-100 text-sm text-gray-500 sm:h-56 lg:h-48">
                            Gambar kamar belum tersedia
                        </div>
                    @endif

                    <div class="p-5">
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Detail Kamar</p>
                        <h4 class="mt-1 font-poppins text-xl font-bold text-gray-900">
                            {{ $room?->name ?? 'Kamar tidak diketahui' }}</h4>
                        <p class="mt-1 text-base font-bold text-primary">Rp
                            {{ number_format($room?->price ?? 0, 0, ',', '.') }} <span
                                class="text-sm font-normal text-gray-500">/ malam</span></p>

                        <dl class="mt-5 grid grid-cols-2 gap-x-4 gap-y-4 text-sm">
                            <div>
                                <dt class="text-gray-500">Kapasitas</dt>
                                <dd class="mt-1 font-medium text-gray-800">
                                    {{ $room?->capacity ? $room->capacity . ' orang' : 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Tempat tidur</dt>
                                <dd class="mt-1 font-medium text-gray-800">{{ $room?->bed_type ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Ukuran</dt>
                                <dd class="mt-1 font-medium text-gray-800">
                                    {{ $room?->size ? $room->size . ' m²' : 'N/A' }}</dd>
                            </div>
                        </dl>

                        {{-- @if ($room?->description)
                            <p class="mt-5 border-t border-gray-100 pt-4 text-sm leading-6 text-gray-600">{{ $room->description }}</p>
                        @endif --}}

                        <div class="mt-5 border-t border-gray-100 pt-4">
                            <p class="text-sm font-semibold text-gray-900">Fasilitas</p>
                            <div class="mt-2 flex flex-wrap gap-2">
                                @forelse ($room?->facilities ?? [] as $facility)
                                    <span
                                        class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-medium text-emerald-700">{{ $facility->name }}</span>
                                @empty
                                    <p class="text-sm text-gray-500">Belum ada fasilitas untuk kamar ini.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        @else
            <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-4 py-8 text-center">
                <p class="text-sm font-medium text-gray-700">Belum ada pembayaran</p>
                <p class="mt-1 text-xs text-gray-500">Data pembayaran akan tampil setelah transaksi dibuat.</p>
            </div>
        @endif
    </x-modal-2>

    <x-modal-2 name="manage-booking" :title="$bookingEditId ? 'Edit Booking' : 'Tambah Booking'">
        <form wire:submit="save">
            {{-- <input type="hidden" id="bookingId" wire:model="bookingId" /> --}}

            <!-- Row: Booking Code & User ID -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                @if ($bookingEditId)
                    <div>
                        <label class="input-label">Booking Code <span class="text-red-500">*</span></label>
                        <input type="text" id="bookingCode" class="input" disabled wire:model="booking_code"
                            placeholder="e.g. STR-847291" />
                    </div>
                @endif
                <div>
                    <label for="bookingUserId" class="input-label">User <span class="text-red-500">*</span></label>
                    <select id="bookingUserId" wire:model="user_id" class="input" required>
                        <option value="">Pilih Guest</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :message="$errors->get('user_id')" />
                </div>
            </div>

            <!-- Room -->
            {{-- <div class="mb-4">
                <p class="input-label mb-3">
                    Room <span class="text-red-500">*</span>
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-3 max-h-[65vh] overflow-y-auto pr-1">
                    @foreach ($rooms as $room)
                        <label for="room{{ $room->id }}" class="block cursor-pointer">
                            <input type="radio" id="room{{ $room->id }}" wire:model.live="room_id"
                                value="{{ $room->id }}" class="peer sr-only">

                            <div
                                class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition-all duration-200
                hover:border-blue-500 hover:shadow-md
                peer-checked:border-blue-600 peer-checked:ring-2 peer-checked:ring-blue-200 peer-checked:border-2 ">

                                <img src="{{ asset('storage/assets/img/rooms/' . $room->image) }}"
                                    alt="{{ $room->name }}" class="w-full h-32 sm:h-36 object-cover">

                                <div class="p-3">
                                    <div class="flex items-start justify-between gap-2">
                                        <div class="min-w-0">
                                            <h3 class="font-semibold text-sm sm:text-base text-gray-800 truncate">
                                                {{ $room->name }}
                                            </h3>

                                            <p class="text-xs text-gray-500">
                                                {{ $room->type }}
                                            </p>

                                            <p class="text-xs text-gray-500">
                                                👥 {{ $room->capacity }} Tamu
                                            </p>
                                        </div>

                                        <span
                                            class="hidden sm:inline-flex px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-600
                            peer-checked:bg-blue-600 peer-checked:text-white">
                                            Pilih
                                        </span>
                                    </div>

                                    <div class="mt-3 flex items-center justify-between">
                                        <span class="text-base sm:text-lg font-bold text-blue-600">
                                            Rp {{ number_format($room->price, 0, ',', '.') }}
                                        </span>

                                        <span
                                            class="sm:hidden text-xs font-medium px-2 py-1 rounded-md bg-gray-100 text-gray-600
                            peer-checked:bg-blue-600 peer-checked:text-white">
                                            Pilih
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>

                <x-input-error :message="$errors->get('room_id')" />
            </div> --}}

            <!-- Row: RoomUnit -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="input-label">Room<span class="text-red-500">*</span></label>
                    <select wire:model.live="room_id" name="room_id" id="room_id" class="input">
                        <option value="">Select Room</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}">{{ $room->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :message="$errors->get('room_id')" />
                </div>

                <div>
                    <label class="input-label">RoomUnit <span class="text-red-500">*</span></label>
                    <select wire:model="room_unit_id" name="room_unit_id" id="room_unit_id" class="input">
                        <option value="">Select RoomUnit</option>
                        @if ($room_id)
                            @foreach ($rooms->find($room_id)->units as $room_unit)
                                @if ($room_unit->status == 'available' || $room_unit->id == $room_unit_id)
                                    <option value="{{ $room_unit->id }}"
                                        {{ $room_unit->id == $room_unit_id ? 'selected' : '' }}
                                        @disabled($room_unit->status === 'occupied')>
                                        {{ $room_unit->room_number }}{{ $room_unit->status === 'occupied' ? ' (Occupied)' : '' }}
                                    </option>
                                @else
                                    <option value="{{ $room_unit->id }}" disabled>
                                        {{ $room_unit->room_number }} ({{ ucfirst($room_unit->status) }})
                                    </option>
                                @endif
                            @endforeach
                        @endif
                    </select>

                    <x-input-error :message="$errors->get('room_unit_id')" />
                </div>
            </div>

            <!-- Row: Check In & Check Out -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="input-label">Check In <span class="text-red-500">*</span></label>
                    <input type="date" id="bookingCheckIn" wire:model.live="check_in" class="input"
                        min="{{ now()->toDateString() }}" disabled />
                    <x-input-error :message="$errors->get('check_in')" />
                </div>
                <div>
                    <label class="input-label">Check Out <span class="text-red-500">*</span></label>
                    <input type="date" id="bookingCheckOut" wire:model.live="check_out" class="input"
                        min="{{ $check_in ?: now()->toDateString() }}" disabled />

                    <x-input-error :message="$errors->get('check_out')" />
                </div>
            </div>

            <!-- Row: Total Guest & Total Price -->
            {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="input-label">Total Guest <span class="text-red-500">*</span></label>
                    <select id="bookingTotalGuest" wire:model="total_guests" class="input">
                        <option value="">Pilih Jumlah Tamu</option>
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    @error('total_guests')
                        <p class="text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="input-label">Total Price (Rp) <span class="text-red-500">*</span></label>
                    <input type="text" id="bookingTotalPrice" readonly disabled value="" class="input"
                        required>
                    @error('total_price')
                        <p class="text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>
            </div> --}}
            <!-- Status -->
            @if ($bookingEditId)
                <div class="mb-4">
                    <label class="input-label">Status <span class="text-red-500">*</span></label>
                    <select id="bookingStatus" wire:model="status" class="input"
                        @if ($this->status === 'checked_out' || $this->status === 'cancelled') disabled @endif>
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="checked_in">Checked In</option>
                        <option value="checked_out">Checked Out</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <x-input-error :message="$errors->get('status')" />
                </div>
            @endif

            <div class="mb-4">
                <label class="input-label">Deposit Status <span class="text-red-500">*</span></label>
                <select wire:model="deposit_status" class="input">
                    <option value="none">None</option>
                    <option value="ktp">KTP</option>
                    <option value="cash">Cash (Rp. 100.000)</option>
                    <option value="passport">Passport</option>
                </select>
                <x-input-error :message="$errors->get('deposit_status')" />
            </div>
            <!-- Duration Info -->
            <div id="durationInfo" class="mb-4 hidden">
                <div class="p-4 bg-blue-50 rounded-xl border border-blue-100">
                    <div class="flex items-center gap-2 text-blue-700 text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                        <span id="durationText">-</span>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <button type="button" @click="$dispatch('close-modal', 'manage-booking')"
                    class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
                <x-primary-button type="submit" wire:target="save" wire:loading.attr="disabled"
                    wire:loading.class="opacity-50 cursor-not-allowed">Simpan
                    Booking</x-primary-button>
            </div>
        </form>
    </x-modal-2>

    <x-modal-2 name="delete-booking" title="Hapus Booking">
        <p>Apakah Anda yakin ingin menghapus booking ini?</p>
        <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
            <button type="button" @click="$dispatch('close-modal', 'delete-booking')"
                class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
            <x-danger-button type="button" wire:click="delete" wire:target="delete" wire:loading.attr="disabled"
                wire:loading.class="opacity-50 cursor-not-allowed">Hapus</x-danger-button>
        </div>
    </x-modal-2>
</div>

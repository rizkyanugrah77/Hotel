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
    x-on:booking-delete-confirmation.window="$dispatch('open-modal', 'delete-booking')"
    class="min-w-0 flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">

    <!-- Content -->

    <x-toast />
    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Bookings</p>
                    <h3 class="text-2xl font-poppins font-bold text-foreground" id="kpiTotal">0</h3>
                </div>
                <div class="w-10 h-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 font-medium" id="kpiTotalSub">Semua booking</p>
        </div>

        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Confirmed</p>
                    <h3 class="text-2xl font-poppins font-bold text-emerald-600" id="kpiConfirmed">0</h3>
                </div>
                <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-emerald-600 font-medium" id="kpiConfirmedSub">Booking aktif</p>
        </div>

        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Pending</p>
                    <h3 class="text-2xl font-poppins font-bold text-amber-600" id="kpiPending">0</h3>
                </div>
                <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-amber-600 font-medium" id="kpiPendingSub">Menunggu konfirmasi</p>
        </div>

        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Revenue</p>
                    <h3 class="text-2xl font-poppins font-bold text-accent-700" id="kpiRevenue">Rp 0</h3>
                </div>
                <div class="w-10 h-10 bg-accent/10 text-accent-700 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-accent-600 font-medium" id="kpiRevenueSub">Dari confirmed booking</p>
        </div>
    </div>

    <!-- Action Bar & Table -->
    <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden mb-8 ">
        <div class="grid grid-cols-1">
            <div
                class="p-3 lg:p-6 border-b border-gray-100 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <h2 class="font-poppins font-bold text-lg">Daftar Booking</h2>
                <div class="flex flex-col lg:flex-row w-full lg:w-auto items-stretch lg:items-center gap-3">
                    <div class="relative">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        <input type="text" id="searchInput" placeholder="Cari booking code, user..."
                            class="input pl-10 pr-4 py-2 text-sm w-64" oninput="filterBookings()" />
                    </div>
                    <select id="filterStatus" class="input py-2 text-sm w-40" onchange="filterBookings()">
                        <option value="">Semua Status</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="pending">Pending</option>
                        <option value="checked_in">Checked In</option>
                        <option value="checked_out">Checked Out</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <select id="filterRoom" class="input py-2 text-sm w-44" onchange="filterBookings()">
                        <option value="">Semua Room</option>
                    </select>
                    <button @click="$dispatch('open-modal', 'manage-booking'); $wire.resetForm()"
                        class="btn-primary text-sm px-4 py-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Booking
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap" id="bookingsTable">
                    <thead class="bg-gray-50 text-gray-500">
                        <tr>
                            <th class="py-3 px-6 font-medium">No</th>
                            <th class="py-3 px-6 font-medium">Booking Code</th>
                            <th class="py-3 px-6 font-medium">Room</th>
                            <th class="py-3 px-6 font-medium">User ID</th>
                            <th class="py-3 px-6 font-medium">Check In</th>
                            <th class="py-3 px-6 font-medium">Check Out</th>
                            <th class="py-3 px-6 font-medium">Guests</th>
                            <th class="py-3 px-6 font-medium">Total Price</th>
                            <th class="py-3 px-6 font-medium">Status</th>
                            <th class="py-3 px-6 font-medium text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($bookings as $index => $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-6 text-gray-700 font-medium">{{ $index + 1 }}</td>
                                <td class="py-3 px-6 text-gray-700">{{ $booking->booking_code }}</td>
                                <td class="py-3 px-6 text-gray-700">{{ $booking->room->name }}</td>
                                <td class="py-3 px-6 text-gray-700">{{ $booking->user->name }}</td>
                                <td class="py-3 px-6 text-gray-700">
                                    {{ $booking->check_in->format('D-m-Y, H:i:s') }}
                                </td>
                                <td class="py-3 px-6 text-gray-700">
                                    {{ $booking->check_out->format('D-m-Y, H:i:s') }}
                                </td>
                                <td class="py-3 px-6 text-gray-700">{{ $booking->total_guests }}</td>
                                <td class="py-3 px-6 text-gray-700">
                                    {{ 'Rp ' . number_format($booking->total_price, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-6 text-gray-700">
                                    <span @class([
                                        'px-3 py-1 rounded-full text-xs font-medium text-white',
                                        'bg-emerald-600' => $booking->status === 'completed',
                                        'bg-amber-600' => $booking->status === 'pending',
                                        'bg-red-600' => $booking->status === 'cancelled',
                                        'bg-blue-600' => $booking->status === 'paid',
                                        'bg-gray-600' => !in_array($booking->status, [
                                            'completed',
                                            'pending',
                                            'cancelled',
                                            'paid',
                                        ]),
                                    ])>
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 inline-flex text-gray-700">
                                    <x-edit-button :item="$booking" action="edit" />
                                    <x-delete-button :item="$booking" confirmDelete="confirmDelete" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Reports Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Booking per Room -->
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6 lg:col-span-1">
            <h2 class="font-poppins font-bold text-lg mb-6">Booking per Room</h2>
            <div class="space-y-4" id="reportByRoom">
            </div>
        </div>

        <!-- Revenue Statistics -->
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
            <h2 class="font-poppins font-bold text-lg mb-6">Statistik Revenue</h2>
            <div class="space-y-4">
                <div class="p-4 bg-gray-50 rounded-xl">
                    <p class="text-sm text-gray-500 mb-1">Total Revenue (Confirmed)</p>
                    <p class="text-xl font-poppins font-bold text-accent-700" id="statRevenue">Rp 0</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-xl">
                    <p class="text-sm text-gray-500 mb-1">Rata-rata per Booking</p>
                    <p class="text-xl font-poppins font-bold text-foreground" id="statAvgPrice">Rp 0</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-xl">
                    <p class="text-sm text-gray-500 mb-1">Booking Tertinggi</p>
                    <p class="text-xl font-poppins font-bold text-primary" id="statHighest">Rp 0</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-xl">
                    <p class="text-sm text-gray-500 mb-1">Total Tamu</p>
                    <p class="text-xl font-poppins font-bold text-blue-600" id="statTotalGuests">0</p>
                </div>
            </div>
        </div>

        <!-- Status Summary & Quick Actions -->
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
            <h2 class="font-poppins font-bold text-lg mb-6">Status Booking</h2>
            <div class="space-y-4" id="statusReport">
            </div>
            <div class="mt-6 pt-6 border-t border-gray-100">
                <h3 class="text-sm font-medium text-gray-600 mb-3">Aksi Cepat</h3>
                <div class="grid grid-cols-2 gap-3">
                    <button onclick="openModal()"
                        class="p-3 border border-gray-200 rounded-xl text-sm font-medium hover:bg-gray-50 transition-colors flex flex-col items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Booking
                    </button>
                    <button onclick="exportReport()"
                        class="p-3 border border-gray-200 rounded-xl text-sm font-medium hover:bg-gray-50 transition-colors flex flex-col items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        Export Laporan
                    </button>
                </div>
            </div>
        </div>
    </div>


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
                        <option value="">Pilih User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error name="user_id" />
                </div>
            </div>

            <!-- Room -->
            <div class="mb-4">
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

                <x-input-error name="room_id" />
            </div>

            <!-- Row: Check In & Check Out -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="input-label">Check In <span class="text-red-500">*</span></label>
                    <input type="date" id="bookingCheckIn" wire:model.live="check_in" class="input"
                        min="{{ now()->toDateString() }}" />
                    <x-input-error name="check_in" />
                </div>
                <div>
                    <label class="input-label">Check Out <span class="text-red-500">*</span></label>
                    <input type="date" id="bookingCheckOut" wire:model.live="check_out" class="input"
                        min="{{ $check_in ?: now()->toDateString() }}" required />

                    <x-input-error name="check_out" />
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
                    <select id="bookingStatus" wire:model="status" class="input" disabled>
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            @endif
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

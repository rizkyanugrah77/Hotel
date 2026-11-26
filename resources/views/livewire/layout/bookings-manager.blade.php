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

    <x-slot name="header">
        <div class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8 flex-shrink-0">
            <h1 class="text-xl font-poppins font-bold text-foreground">Bookings Management</h1>
        </div>
    </x-slot>

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

    <!-- Action Bar & Calendar / Table -->
    <div class="mb-8 overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
        <div class="grid grid-cols-1">
            <div
                class="flex flex-col items-start justify-between gap-3 border-b border-gray-100 p-4 sm:p-5 lg:flex-row lg:items-center">
                <div class="flex flex-wrap items-center gap-3">
                    <h2 class="font-poppins text-lg font-bold text-foreground">Daftar Booking</h2>
                    <div class="inline-flex rounded-xl border border-gray-200 bg-gray-50 p-1">
                        <button type="button" wire:click="setViewMode('calendar')"
                            class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-semibold transition-all {{ $viewMode === 'calendar' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                            Kalender 7 Hari
                        </button>
                        <button type="button" wire:click="setViewMode('table')"
                            class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-semibold transition-all {{ $viewMode === 'table' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                            </svg>
                            Tabel
                        </button>
                    </div>
                </div>
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
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="checked_in">Checked In</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="checked_out">Checked Out</option>
                        <option value="refunded">Refunded</option>
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

            @if ($viewMode === 'calendar')
                <div class="p-4 sm:p-5" x-data="{
                    slideCalendar(amount) {
                        if (this.$refs.calendarTrack) {
                            this.$refs.calendarTrack.scrollBy({ left: amount, behavior: 'smooth' });
                        }
                    }
                }">
                    <!-- Calendar Navigation & Legend -->
                    <div class="mb-4 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex flex-wrap items-center gap-2">
                            <div class="inline-flex items-center rounded-xl border border-gray-200 bg-gray-50 p-1">
                                <button type="button" wire:click="shiftCalendar(-7)"
                                    class="rounded-lg px-2.5 py-1.5 text-xs font-medium text-gray-600 transition hover:bg-white hover:text-gray-900"
                                    title="7 hari sebelumnya">
                                    &laquo; 7H
                                </button>
                                <button type="button" wire:click="shiftCalendar(-1)"
                                    class="rounded-lg px-2.5 py-1.5 text-xs font-medium text-gray-600 transition hover:bg-white hover:text-gray-900"
                                    title="Hari sebelumnya">
                                    &lsaquo; Prev
                                </button>
                                <button type="button" wire:click="resetCalendarToday"
                                    class="rounded-lg bg-white px-3 py-1.5 text-xs font-semibold text-primary shadow-sm transition hover:bg-primary hover:text-white">
                                    Hari Ini
                                </button>
                                <button type="button" wire:click="shiftCalendar(1)"
                                    class="rounded-lg px-2.5 py-1.5 text-xs font-medium text-gray-600 transition hover:bg-white hover:text-gray-900"
                                    title="Hari berikutnya">
                                    Next &rsaquo;
                                </button>
                                <button type="button" wire:click="shiftCalendar(7)"
                                    class="rounded-lg px-2.5 py-1.5 text-xs font-medium text-gray-600 transition hover:bg-white hover:text-gray-900"
                                    title="7 hari berikutnya">
                                    7H &raquo;
                                </button>
                            </div>

                            <span class="rounded-xl bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-700">
                                {{ $calendarStart->format('d M') }} &ndash; {{ $calendarEnd->format('d M Y') }}
                            </span>

                            @if ($upcomingOutsideCount > 0)
                                <button type="button" wire:click="shiftCalendar(7)"
                                    class="inline-flex items-center gap-1 rounded-xl border border-primary/20 bg-primary/5 px-3 py-1.5 text-xs font-semibold text-primary transition hover:bg-primary/10">
                                    <span>{{ $upcomingOutsideCount }} booking di tanggal berikutnya</span>
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                    </svg>
                                </button>
                            @endif
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <!-- Status Legend -->
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1.5 text-xs text-gray-600">
                                <span class="inline-flex items-center gap-1.5 font-medium text-emerald-700">
                                    <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                                    Checked-in
                                </span>
                                <span class="inline-flex items-center gap-1.5">
                                    <span class="h-2.5 w-2.5 rounded-full bg-sky-500"></span>
                                    Paid
                                </span>
                                <span class="inline-flex items-center gap-1.5">
                                    <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>
                                    Pending
                                </span>
                                <span class="inline-flex items-center gap-1.5">
                                    <span class="h-2.5 w-2.5 rounded-full bg-slate-400"></span>
                                    Checked-out
                                </span>
                                <span class="inline-flex items-center gap-1.5">
                                    <span class="h-2.5 w-2.5 rounded-full bg-rose-500"></span>
                                    Cancelled
                                </span>
                            </div>

                            <!-- Horizontal Track Slider Controls -->
                            <div class="inline-flex items-center gap-1">
                                <button type="button" @click="slideCalendar(-300)"
                                    class="rounded-lg border border-gray-200 bg-white p-1.5 text-gray-600 shadow-sm transition hover:bg-gray-50 hover:text-primary"
                                    aria-label="Geser kalender ke kiri">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 19.5 8.25 12l7.5-7.5" />
                                    </svg>
                                </button>
                                <button type="button" @click="slideCalendar(300)"
                                    class="rounded-lg border border-gray-200 bg-white p-1.5 text-gray-600 shadow-sm transition hover:bg-gray-50 hover:text-primary"
                                    aria-label="Geser kalender ke kanan">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 7-Day Horizontal Calendar Matrix (Card per Room) -->
                    <div x-ref="calendarTrack" class="overflow-x-auto pb-3 scroll-smooth">
                        <div class="min-w-[1480px] space-y-3">
                            <!-- 7-Day Header Row -->
                            <div
                                class="flex overflow-hidden rounded-2xl border border-gray-200/90 bg-gray-50/90 shadow-sm">
                                <div
                                    class="sticky left-0 z-20 flex w-48 shrink-0 flex-col justify-center border-r border-gray-200 bg-gray-100/95 px-4 py-3 backdrop-blur-sm">
                                    <p class="font-poppins text-xs font-bold uppercase tracking-wider text-gray-500">
                                        Kamar / Room
                                    </p>
                                    <p class="mt-0.5 text-xs font-medium text-gray-700">
                                        {{ $calendarRooms->count() }} Tipe Room
                                    </p>
                                </div>

                                <div class="flex flex-1">
                                    @foreach ($calendarDays as $day)
                                        <div wire:key="calendar-header-{{ $day['dateKey'] }}"
                                            class="flex-1 min-w-[185px] border-r last:border-r-0 border-gray-200/80 px-3 py-3 {{ $day['isToday'] ? 'bg-primary/10' : 'bg-white' }}">
                                            <div class="flex items-center justify-between gap-1.5">
                                                <div>
                                                    <p
                                                        class="text-[11px] font-semibold uppercase tracking-wider {{ $day['isToday'] ? 'text-primary' : 'text-gray-500' }}">
                                                        {{ $day['date']->locale('id')->translatedFormat('D') }},
                                                        {{ $day['date']->format('d M') }}
                                                    </p>
                                                </div>
                                                @if ($day['isToday'])
                                                    <span
                                                        class="rounded-full bg-primary px-2 py-0.5 text-[10px] font-semibold text-white">
                                                        Hari Ini
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="mt-2 flex items-center gap-1.5 text-[11px]">
                                                <span
                                                    class="rounded-lg bg-gray-100 px-2 py-0.5 font-semibold text-gray-800">
                                                    {{ $day['totalRooms'] }} Kamar
                                                </span>
                                                <span
                                                    class="rounded-lg bg-primary/10 px-2 py-0.5 font-semibold text-primary">
                                                    {{ $day['bookingCount'] }} Booking
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Card Per Room -->
                            @forelse ($calendarRooms as $room)
                                @php
                                    $roomBookingsByDate = $calendarBookingsByRoomAndDate->get($room->id, collect());
                                    $roomBookingCount = $roomBookingsByDate->flatten(1)->count();
                                    $roomCheckedInCount = $roomBookingsByDate
                                        ->flatten(1)
                                        ->where('status', 'checked_in')
                                        ->count();
                                @endphp

                                <section wire:key="calendar-room-{{ $room->id }}"
                                    class="flex overflow-hidden rounded-2xl border border-gray-200/90 bg-white shadow-sm transition hover:border-gray-300">
                                    <!-- Room Info Column (Sticky on horizontal scroll) -->
                                    <div
                                        class="sticky left-0 z-10 flex w-48 shrink-0 flex-col justify-between border-r border-gray-200 bg-gray-50/95 p-4 backdrop-blur-sm">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span
                                                    class="h-2.5 w-2.5 shrink-0 rounded-full bg-primary"></span>
                                                <h3 class="font-poppins text-sm font-bold text-gray-900 leading-snug">
                                                    {{ $room->name }}
                                                </h3>
                                            </div>
                                            <p class="mt-1 text-xs text-gray-500">
                                                {{ $room->units->count() }} Unit Tersedia
                                            </p>
                                        </div>

                                        <div class="mt-4 space-y-1.5 border-t border-gray-200/80 pt-3">
                                            <div class="flex items-center justify-between text-xs">
                                                <span class="text-gray-500">Total Booking</span>
                                                <span class="font-semibold text-gray-900">{{ $roomBookingCount }}</span>
                                            </div>
                                            <div class="flex items-center justify-between text-xs">
                                                <span class="text-emerald-700">Checked-in</span>
                                                <span
                                                    class="rounded-full bg-emerald-100 px-2 py-0.5 text-[11px] font-semibold text-emerald-800">
                                                    {{ $roomCheckedInCount }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 7-Day Cells for This Room -->
                                    <div class="flex flex-1">
                                        @foreach ($calendarDays as $day)
                                            @php
                                                $cellBookings = $roomBookingsByDate->get($day['dateKey'], collect());
                                            @endphp
                                            <div wire:key="calendar-cell-{{ $room->id }}-{{ $day['dateKey'] }}"
                                                class="flex-1 min-w-[185px] border-r last:border-r-0 border-gray-100 p-2.5 {{ $day['isToday'] ? 'bg-primary/[0.02]' : '' }}">
                                                <div class="space-y-2">
                                                    @forelse ($cellBookings as $booking)
                                                        @php
                                                            $cardTheme = match ($booking->status) {
                                                                'checked_in' => [
                                                                    'wrapper' => 'border-emerald-300 bg-emerald-50/95 ring-1 ring-emerald-200',
                                                                    'accent' => 'bg-emerald-500',
                                                                    'badge' => 'bg-emerald-600 text-white',
                                                                ],
                                                                'paid' => [
                                                                    'wrapper' => 'border-sky-200 bg-sky-50/90',
                                                                    'accent' => 'bg-sky-500',
                                                                    'badge' => 'bg-sky-100 text-sky-800',
                                                                ],
                                                                'pending' => [
                                                                    'wrapper' => 'border-amber-200 bg-amber-50/90',
                                                                    'accent' => 'bg-amber-500',
                                                                    'badge' => 'bg-amber-100 text-amber-800',
                                                                ],
                                                                'checked_out' => [
                                                                    'wrapper' => 'border-slate-200 bg-slate-50',
                                                                    'accent' => 'bg-slate-400',
                                                                    'badge' => 'bg-slate-200 text-slate-700',
                                                                ],
                                                                default => [
                                                                    'wrapper' => 'border-rose-200 bg-rose-50/90',
                                                                    'accent' => 'bg-rose-500',
                                                                    'badge' => 'bg-rose-100 text-rose-800',
                                                                ],
                                                            };
                                                        @endphp

                                                        <article wire:key="calendar-booking-{{ $booking->id }}"
                                                            class="relative overflow-hidden rounded-xl border p-2.5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md {{ $cardTheme['wrapper'] }}">
                                                            <div
                                                                class="absolute inset-y-0 left-0 w-1 {{ $cardTheme['accent'] }}">
                                                            </div>

                                                            <div class="pl-1.5">
                                                                <div class="flex items-start justify-between gap-1.5">
                                                                    <p
                                                                        class="truncate font-poppins text-xs font-bold text-gray-900">
                                                                        {{ $booking->user?->name ?? 'Tamu' }}
                                                                    </p>
                                                                    <span
                                                                        class="shrink-0 rounded-full px-1.5 py-0.5 text-[9px] font-semibold uppercase {{ $cardTheme['badge'] }}">
                                                                        {{ ucwords(str_replace('_', ' ', $booking->status)) }}
                                                                    </span>
                                                                </div>

                                                                <p class="mt-0.5 truncate text-[11px] font-medium text-gray-500">
                                                                    {{ $booking->booking_code }} &bull; Unit
                                                                    {{ $booking->roomUnit?->room_number ?? '-' }}
                                                                </p>

                                                                <p class="mt-1.5 text-[10px] text-gray-600">
                                                                    In:
                                                                    <span
                                                                        class="font-semibold">{{ $booking->check_in->format('d M') }}</span>
                                                                    &rarr; Out:
                                                                    {{ $booking->check_out->format('d M') }}
                                                                </p>

                                                                <div
                                                                    class="mt-2 flex items-center justify-between border-t border-black/5 pt-1.5">
                                                                    <span class="text-[11px] font-semibold text-gray-800">
                                                                        Rp{{ number_format($booking->total_price, 0, ',', '.') }}
                                                                    </span>
                                                                    <div class="flex items-center gap-0.5">
                                                                        <x-edit-button :item="$booking" action="edit" />
                                                                        <x-show-button :item="$booking" action="show" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </article>
                                                    @empty
                                                        <div
                                                            class="flex h-20 items-center justify-center rounded-xl border border-dashed border-gray-200/90 bg-gray-50/40 text-[11px] text-gray-400">
                                                            &mdash;
                                                        </div>
                                                    @endforelse
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </section>
                            @empty
                                <div
                                    class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-10 text-center text-sm text-gray-500">
                                    Tidak ada room ditemukan.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @else
                <div class="divide-y divide-gray-100 md:hidden">
                    @forelse ($bookings as $booking)
                        @php
                            $statusClasses = match ($booking->status) {
                                'paid' => 'badge-info',
                                'checked_in' => 'badge-success',
                                'pending' => 'badge-warning',
                                'cancelled' => 'badge-danger',
                                'checked_out' => 'badge-accent',
                                'refunded' => 'badge-secondary',
                                default => 'badge-primary',
                            };
                        @endphp
                        <article wire:key="booking-mobile-{{ $booking->id }}" class="p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="truncate font-semibold text-gray-900">{{ $booking->booking_code }}</p>
                                    <p class="mt-0.5 truncate text-sm text-gray-600">{{ $booking->user->name }}</p>
                                </div>
                                <span class="shrink-0 rounded-full px-2 py-1 text-xs font-medium  {{ $statusClasses }}">
                                    {{ ucwords(str_replace('_', ' ', $booking->status)) }}</span>
                            </div>
                            <div class="mt-3 rounded-lg bg-gray-50 p-3 text-sm">
                                <p class="font-medium text-gray-800">{{ $booking->room->name }} No
                                    {{ $booking->roomUnit?->room_number ?? '-' }}</p>
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
                                            'refunded' => 'badge-secondary',
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
                                        {{ $booking->roomUnit?->room_number ?? '-' }}</td>
                                    <td class="px-4 py-3 text-xs text-gray-600">
                                        <p>{{ $booking->check_in->format('d M Y') }}</p>
                                        <p class="mt-1">{{ $booking->check_out->format('d M Y') }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-gray-700">{{ $booking->total_guests }}</td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="inline-flex rounded-full px-2 py-1 text-xs font-medium  {{ $statusClasses }}">{{ ucwords(str_replace('_', ' ', $booking->status)) }}</span>
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
            @endif
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
                $statusClasses = match ($status) {
                    'settlement', 'capture', 'success', 'paid', 'completed' => 'bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200',
                    'pending', 'challenge' => 'bg-amber-100 text-amber-800 ring-1 ring-amber-200',
                    'cancel', 'cancelled', 'deny', 'failure', 'expire' => 'bg-rose-100 text-rose-700 ring-1 ring-rose-200',
                    'refunded' => 'bg-sky-100 text-sky-700 ring-1 ring-sky-200',
                    default => 'bg-slate-100 text-slate-600 ring-1 ring-slate-200',
                };
                $bookingStatusClasses = match ($booking?->status) {
                    'checked_in' => 'bg-emerald-100 text-emerald-800',
                    'paid' => 'bg-sky-100 text-sky-800',
                    'pending' => 'bg-amber-100 text-amber-800',
                    'checked_out' => 'bg-slate-200 text-slate-700',
                    default => 'bg-rose-100 text-rose-800',
                };
            @endphp

            <div class="grid gap-5 lg:grid-cols-12">
                <!-- Left: Profil Tamu -->
                <aside class="lg:col-span-4">
                    <div class="h-full rounded-2xl border border-gray-200/80 bg-gray-50/70 p-5">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400">Profil Tamu</p>

                        <div class="mt-4 flex items-center gap-3.5">
                            <img class="h-12 w-12 shrink-0 rounded-2xl bg-primary object-cover shadow-sm ring-2 ring-white"
                                src="{{ $guest?->photo ?? 'https://ui-avatars.com/api/?name=' . urlencode($guestName) . '&background=A61B1B&color=fff' }}"
                                alt="{{ $guestName }}">
                            <div class="min-w-0">
                                <p class="font-poppins text-base font-bold text-gray-900 leading-snug break-words">
                                    {{ $guestName }}
                                </p>
                                <p class="mt-0.5 text-xs font-medium text-gray-500">Tamu Booking</p>
                            </div>
                        </div>

                        <dl class="mt-5 space-y-3 border-t border-gray-200/80 pt-4 text-sm">
                            <div class="flex flex-col">
                                <dt class="text-xs text-gray-500">Email</dt>
                                <dd class="mt-0.5 break-all font-medium text-gray-800">{{ $guest?->email ?? 'N/A' }}</dd>
                            </div>
                            <div class="flex flex-col">
                                <dt class="text-xs text-gray-500">Nomor Telepon</dt>
                                <dd class="mt-0.5 font-medium text-gray-800">{{ $guest?->phone ?? 'N/A' }}</dd>
                            </div>
                        </dl>

                        <div class="my-4 border-t border-gray-200/80"></div>

                        <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400">Identitas Tamu</p>
                        <dl class="mt-3 grid grid-cols-2 gap-3 text-sm">
                            <div class="rounded-xl bg-white p-2.5 border border-gray-100">
                                <dt class="text-[11px] text-gray-500">Kewarganegaraan</dt>
                                <dd class="mt-0.5 font-semibold text-gray-800">{{ $guest?->nationality ?? 'N/A' }}</dd>
                            </div>
                            <div class="rounded-xl bg-white p-2.5 border border-gray-100">
                                <dt class="text-[11px] text-gray-500">Jenis Kelamin</dt>
                                <dd class="mt-0.5 font-semibold text-gray-800">{{ $guest?->gender ?? 'N/A' }}</dd>
                            </div>
                            <div class="col-span-2 rounded-xl bg-white p-2.5 border border-gray-100">
                                <dt class="text-[11px] text-gray-500">Alamat</dt>
                                <dd class="mt-0.5 font-medium text-gray-800 leading-relaxed">{{ $guest?->address ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                    </div>
                </aside>

                <!-- Middle: Ringkasan Pembayaran & Booking -->
                <section class="space-y-4 lg:col-span-4">
                    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-primary to-red-700 p-5 text-white shadow-md">
                        <div class="pointer-events-none absolute -right-6 -top-6 h-24 w-24 rounded-full bg-white/10"></div>
                        <div class="relative flex items-start justify-between gap-3">
                            <div>
                                <p class="text-xs font-medium text-white/80">Total Pembayaran</p>
                                <p class="mt-1 font-poppins text-2xl font-bold tracking-tight">
                                    Rp {{ number_format($payments->gross_amount, 0, ',', '.') }}
                                </p>
                            </div>
                            <span class="rounded-full px-2.5 py-1 text-[11px] font-bold uppercase tracking-wide {{ $statusClasses }}">
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </span>
                        </div>
                    </div>

                    <dl class="divide-y divide-gray-100 overflow-hidden rounded-2xl border border-gray-200/80 bg-white text-sm">
                        <div class="flex items-center justify-between gap-3 px-4 py-3">
                            <dt class="text-xs text-gray-500">Kode Booking</dt>
                            <dd class="font-poppins font-semibold text-gray-900">{{ $booking?->booking_code ?? 'N/A' }}</dd>
                        </div>
                        <div class="flex items-center justify-between gap-3 bg-gray-50/70 px-4 py-3">
                            <dt class="text-xs text-gray-500">Kamar</dt>
                            <dd class="text-right font-medium text-gray-800">
                                {{ $booking?->room?->name ?? 'N/A' }}
                                @if ($booking?->roomUnit?->room_number)
                                    <span class="text-gray-500">&bull; No. {{ $booking->roomUnit->room_number }}</span>
                                @endif
                            </dd>
                        </div>
                        <div class="flex items-center justify-between gap-3 px-4 py-3">
                            <dt class="text-xs text-gray-500">Masa Inap</dt>
                            <dd class="text-right font-medium text-gray-800">
                                {{ $booking?->check_in?->format('d M Y') ?? 'N/A' }} &ndash;
                                {{ $booking?->check_out?->format('d M Y') ?? 'N/A' }}
                            </dd>
                        </div>
                        <div class="flex items-center justify-between gap-3 bg-gray-50/70 px-4 py-3">
                            <dt class="text-xs text-gray-500">Jumlah Tamu</dt>
                            <dd class="font-medium text-gray-800">{{ $booking?->total_guests ? $booking->total_guests . ' orang' : 'N/A' }}</dd>
                        </div>
                        <div class="flex flex-col gap-1 px-4 py-3">
                            <dt class="text-xs text-gray-500">Payment ID</dt>
                            <dd class="break-all font-mono text-xs font-medium text-gray-700">{{ $payments->order_id }}</dd>
                        </div>
                        <div class="flex items-center justify-between gap-3 bg-gray-50/70 px-4 py-3">
                            <dt class="text-xs text-gray-500">Metode</dt>
                            <dd class="font-medium uppercase text-gray-800">{{ $payments->payment_method ?? 'N/A' }}</dd>
                        </div>
                        <div class="flex items-center justify-between gap-3 px-4 py-3">
                            <dt class="text-xs text-gray-500">Tanggal Transaksi</dt>
                            <dd class="font-medium text-gray-800">{{ $payments->created_at?->format('d M Y, H:i') ?? 'N/A' }}</dd>
                        </div>
                        <div class="flex items-center justify-between gap-3 bg-gray-50/70 px-4 py-3">
                            <dt class="text-xs text-gray-500">Status Booking</dt>
                            <dd>
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $bookingStatusClasses }}">
                                    {{ $booking?->status ? ucwords(str_replace('_', ' ', $booking->status)) : 'N/A' }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </section>

                <!-- Right: Detail Kamar -->
                <section class="flex flex-col overflow-hidden rounded-2xl border border-gray-200/80 bg-white lg:col-span-4">
                    @if ($room?->image)
                        <div class="relative">
                            <img src="{{ asset('storage/assets/img/rooms/' . $room->image) }}" alt="{{ $room->name }}"
                                class="h-44 w-full object-cover">
                            <div class="absolute inset-x-0 bottom-0 h-12 bg-gradient-to-t from-black/40 to-transparent"></div>
                        </div>
                    @else
                        <div class="flex h-44 items-center justify-center bg-gray-100 text-sm text-gray-500">
                            Gambar kamar belum tersedia
                        </div>
                    @endif

                    <div class="flex flex-1 flex-col p-5">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400">Detail Kamar</p>
                        <h4 class="mt-1 font-poppins text-lg font-bold text-gray-900">
                            {{ $room?->name ?? 'Kamar tidak diketahui' }}
                        </h4>
                        <p class="mt-0.5 text-base font-bold text-primary">
                            Rp {{ number_format($room?->price ?? 0, 0, ',', '.') }}
                            <span class="text-xs font-normal text-gray-500">/ malam</span>
                        </p>

                        <dl class="mt-4 grid grid-cols-2 gap-2.5 text-sm">
                            <div class="rounded-xl border border-gray-100 bg-gray-50/80 p-2.5">
                                <dt class="text-[11px] text-gray-500">Kapasitas</dt>
                                <dd class="mt-0.5 font-semibold text-gray-800">
                                    {{ $room?->capacity ? $room->capacity . ' orang' : 'N/A' }}
                                </dd>
                            </div>
                            <div class="rounded-xl border border-gray-100 bg-gray-50/80 p-2.5">
                                <dt class="text-[11px] text-gray-500">Tempat Tidur</dt>
                                <dd class="mt-0.5 font-semibold text-gray-800">{{ $room?->bed_type ?? 'N/A' }}</dd>
                            </div>
                            <div class="rounded-xl border border-gray-100 bg-gray-50/80 p-2.5">
                                <dt class="text-[11px] text-gray-500">Ukuran</dt>
                                <dd class="mt-0.5 font-semibold text-gray-800">
                                    {{ $room?->size ? $room->size . ' m²' : 'N/A' }}
                                </dd>
                            </div>
                            <div class="rounded-xl border border-gray-100 bg-gray-50/80 p-2.5">
                                <dt class="text-[11px] text-gray-500">Nomor Unit</dt>
                                <dd class="mt-0.5 font-semibold text-gray-800">
                                    {{ $booking?->roomUnit?->room_number ? 'No. ' . $booking->roomUnit->room_number : 'N/A' }}
                                </dd>
                            </div>
                        </dl>

                        <div class="mt-4 border-t border-gray-100 pt-4">
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Fasilitas</p>
                            <div class="mt-2.5 flex flex-wrap gap-1.5">
                                @forelse ($room?->facilities ?? [] as $facility)
                                    <span
                                        class="rounded-full bg-emerald-50 border border-emerald-200/80 px-2.5 py-1 text-xs font-medium text-emerald-700">
                                        {{ $facility->name }}
                                    </span>
                                @empty
                                    <p class="text-xs text-gray-500">Belum ada fasilitas untuk kamar ini.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-6 py-12 text-center">
                <p class="font-poppins text-sm font-semibold text-gray-700">Belum ada pembayaran</p>
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
                                @php
                                    $unitBooked = in_array($room_unit->id, $unavailableUnitIds, true);
                                    $unitUnavailable = $room_unit->status !== 'available' || $unitBooked;
                                    $unitLabel = $room_unit->status !== 'available'
                                        ? ucfirst($room_unit->status)
                                        : ($unitBooked ? 'Terisi' : '');
                                @endphp
                                <option value="{{ $room_unit->id }}"
                                    {{ $room_unit->id == $room_unit_id ? 'selected' : '' }}
                                    @disabled($unitUnavailable && $room_unit->id != $room_unit_id)>
                                    {{ $room_unit->room_number }}{{ $unitLabel ? ' (' . $unitLabel . ')' : '' }}
                                </option>
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
                @php($statusTransitions = \App\Enums\BookingStatus::adminTransitionsFor($status))
                <div class="mb-4">
                    <label class="input-label">Status <span class="text-red-500">*</span></label>
                    <select id="bookingStatus" wire:model="status" class="input"
                        @disabled(empty($statusTransitions))>
                        <option value="{{ $status }}" selected>
                            {{ ucwords(str_replace('_', ' ', $status)) }} (saat ini)
                        </option>
                        @foreach ($statusTransitions as $transitionValue => $transitionLabel)
                            <option value="{{ $transitionValue }}">{{ $transitionLabel }}</option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Status pembayaran hanya dapat berubah melalui alur pembayaran.</p>
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

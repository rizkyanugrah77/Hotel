<div>
    {{-- wire:poll.10s="refreshCharts" --}}

    <!-- Main Content Area -->
    <!-- Topbar -->
    <x-slot name="header">
        <div class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8 flex-shrink-0">
            <h1 class="text-xl font-poppins font-bold text-foreground">Dashboard Overview</h1>
        </div>
    </x-slot>



    <!-- Content -->
    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">

        <!-- KPI Cards -->
        <div class="mb-5 grid grid-cols-2 gap-3 sm:mb-6 sm:gap-4 lg:grid-cols-4 lg:gap-6">
            <div class="card rounded-xl border border-gray-100 bg-white p-4 shadow-sm sm:rounded-2xl sm:p-5 lg:p-6">
                <div class="mb-3 flex items-start justify-between sm:mb-4">
                    <div>
                        <p class="mb-1 text-xs text-gray-500 sm:text-sm">Pendapatan</p>
                        <h3 class="font-poppins text-lg font-bold text-foreground sm:text-2xl">Rp.
                            {{ number_format($revenue, 0, ',', '.') }}</h3>
                    </div>
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-lg bg-green-50 text-green-600 sm:h-10 sm:w-10 sm:rounded-xl">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                        </svg>
                    </div>
                </div>
                <p class="text-[11px] font-medium text-green-600 sm:text-xs">+15% from yesterday</p>
            </div>

            <div class="card rounded-xl border border-gray-100 bg-white p-4 shadow-sm sm:rounded-2xl sm:p-5 lg:p-6">
                <div class="mb-3 flex items-start justify-between sm:mb-4">
                    <div>
                        <p class="mb-1 text-xs text-gray-500 sm:text-sm">Total Bookings</p>
                        <h3 class="font-poppins text-lg font-bold text-foreground sm:text-2xl">{{ $totalBookings }}</h3>
                    </div>
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary/10 text-primary sm:h-10 sm:w-10 sm:rounded-xl">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                        </svg>
                    </div>
                </div>
                <p class="text-[11px] font-medium text-gray-500 sm:text-xs">8 new today</p>
            </div>

            <div class="card rounded-xl border border-gray-100 bg-white p-4 shadow-sm sm:rounded-2xl sm:p-5 lg:p-6">
                <div class="mb-3 flex items-start justify-between sm:mb-4">
                    <div>
                        <p class="mb-1 text-xs text-gray-500 sm:text-sm">Occupancy Rate</p>
                        <h3 class="font-poppins text-lg font-bold text-foreground sm:text-2xl">{{ $totalRoomUnits }}
                        </h3>
                    </div>
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600 sm:h-10 sm:w-10 sm:rounded-xl">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2 h-1.5 w-full rounded-full bg-gray-200">
                    <div class="h-1.5 rounded-full bg-blue-600" style="width: 78%"></div>
                </div>
            </div>

            <div class="card rounded-xl border border-gray-100 bg-white p-4 shadow-sm sm:rounded-2xl sm:p-5 lg:p-6">
                <div class="mb-3 flex items-start justify-between sm:mb-4">
                    <div>
                        <p class="mb-1 text-xs text-gray-500 sm:text-sm">Check-ins Today</p>
                        <h3 class="font-poppins text-lg font-bold text-foreground sm:text-2xl">{{ $activeBookings }}
                        </h3>
                    </div>
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-lg bg-accent/10 text-accent-700 sm:h-10 sm:w-10 sm:rounded-xl">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>
                    </div>
                </div>
                <p class="text-[11px] font-medium text-gray-500 sm:text-xs">{{ $pendingArrivals }} arrivals</p>
            </div>
        </div>

        <!-- Filter Laporan -->
        <div class="bg-white  shadow-md rounded-2xl p-4 sm:p-6 mb-6">
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4">

                <!-- Judul -->
                <div>
                    <h2 class="font-poppins font-bold text-lg text-gray-800">
                        Laporan Transaksi
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Filter laporan berdasarkan periode
                    </p>
                </div>

                <!-- Filter -->
                <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">

                    <!-- Jenis Periode -->
                    <div class="w-full sm:w-40">
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">
                            Periode
                        </label>

                        <select wire:model.live="reportPeriod" class="input py-2.5 text-sm w-full">
                            <option value="weekly">Mingguan</option>
                            <option value="monthly">Bulanan</option>
                            <option value="yearly">Tahunan</option>
                        </select>
                    </div>

                    <!-- Mingguan -->
                    @if ($reportPeriod === 'weekly')
                        <div class="w-full sm:w-44">
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">
                                Tanggal
                            </label>

                            <input type="date" wire:model.live="reportDate" class="input py-2.5 text-sm w-full">
                        </div>
                    @endif

                    <!-- Bulanan -->
                    @if ($reportPeriod === 'monthly')
                        <div class="w-full sm:w-44">
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">
                                Bulan
                            </label>

                            <input type="month" wire:model.live="reportMonth" class="input py-2.5 text-sm w-full">
                        </div>
                    @endif

                    <!-- Tahunan -->
                    @if ($reportPeriod === 'yearly')
                        <div class="w-full sm:w-32">
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">
                                Tahun
                            </label>

                            <select wire:model.live="reportYear" class="input py-2.5 text-sm w-full">

                                @for ($year = now()->year; $year >= now()->year - 5; $year--)
                                    <option value="{{ $year }}">
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        {{-- Chart --}}
        <div class="mb-5 w-full max-w-full sm:mb-6  rounded-xl">
            <div
                class="grid min-w-0 grid-cols-1 gap-4 rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:gap-5 sm:rounded-2xl sm:p-5 lg:grid-cols-12 lg:p-6">
                <h2 class="font-poppins text-base font-bold text-gray-800 sm:text-lg lg:col-span-12 lg:text-xl">Grafik
                    Transaksi</h2>

                <div class="h-52 min-w-0 w-full sm:h-60 lg:col-span-8 lg:h-64 border border-gray-300 rounded-xl p-2">
                    <canvas
                        wire:key="transaction-chart-{{ $chartVersion }}-{{ $reportPeriod }}-{{ $reportDate }}-{{ $reportMonth }}-{{ $reportYear }}"
                        wire:ignore x-data x-init="$nextTick(() => {
                            new window.Chart($el, {
                                type: 'bar',
                                data: {{ Js::from($chartData) }},
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        tooltip: {
                                            callbacks: {
                                                label: (context) => {
                                                    const value = context.parsed.y;
                                                    const percentage = {{ $totalRoomUnits }} ?
                                                        ((value / {{ $totalRoomUnits }}) * 100).toFixed(1) :
                                                        0;
                        
                                                    return `${context.dataset.label}: ${value} unit (${percentage}%)`;
                                                }
                                            }
                                        }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            max: {{ $chartCapacity }},
                                            ticks: {
                                                precision: 0,
                                                callback: (value) => {
                                                    const percentage = {{ $totalRoomUnits }} ?
                                                        Math.round((value / {{ $totalRoomUnits }}) * 100) :
                                                        0;
                        
                                                    return `${value} unit (${percentage}%)`;
                                                }
                                            }
                                        }
                                    }
                                }
                            })
                        })"></canvas>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:col-span-4 lg:grid-cols-1 lg:gap-5 ">
                    <div class="h-36 min-w-0 w-full sm:h-40 lg:h-28 border border-slate-400 rounded-xl">
                        <canvas
                            wire:key="transaction-status-chart-{{ $chartVersion }}-{{ $reportPeriod }}-{{ $reportDate }}-{{ $reportMonth }}-{{ $reportYear }}"
                            wire:ignore x-data x-init="$nextTick(() => {
                                new window.Chart($el, {
                                    type: 'bar',
                                    data: {
                                        labels: {{ Js::from($statusChartData['labels']) }},
                                        datasets: [{
                                            label: 'Jumlah transaksi',
                                            data: {{ Js::from($statusChartData['data']) }},
                                            backgroundColor: ['#059669', '#d97706', '#dc2626', '#64748b'],
                                            borderRadius: 6
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        plugins: { legend: { display: false } },
                                        scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
                                    }
                                })
                            })"></canvas>
                    </div>

                    <div class="h-40 min-w-0 w-full sm:h-40 lg:h-32rounded-xl">
                        <h3 class="mb-1 text-center text-xs font-semibold text-gray-700 sm:mb-2 sm:text-sm">Metode
                            Pembayaran</h3>
                        <canvas
                            wire:key="payment-method-chart-{{ $chartVersion }}-{{ $reportPeriod }}-{{ $reportDate }}-{{ $reportMonth }}-{{ $reportYear }}"
                            wire:ignore x-data x-init="$nextTick(() => {
                                new window.Chart($el, {
                                    type: 'doughnut',
                                    data: {
                                        labels: {{ Js::from($paymentMethods->pluck('payment_type')->values()) }},
                                        datasets: [{
                                            data: {{ Js::from($paymentMethods->pluck('total')->values()) }},
                                            backgroundColor: ['#2563eb', '#7c3aed', '#0891b2', '#ea580c', '#16a34a', '#db2777'],
                                            borderWidth: 2,
                                            borderColor: '#ffffff'
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        plugins: { legend: { position: 'bottom' } }
                                    }
                                })
                            })"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{--  --}}
        <div class="grid grid-cols-1 gap-5 lg:grid-cols-3 lg:gap-8">
            <!-- Recent Bookings Table -->
            <div class="lg:col-span-2">
                <div class="card overflow-auto rounded-xl border border-slate-200 bg-white shadow-sm sm:rounded-2xl">
                    <div class="flex items-center justify-between border-b border-slate-200 p-4 sm:p-5 lg:p-6 ">
                        <h2 class="font-poppins text-base font-bold sm:text-lg">Recent Bookings</h2>
                        <button class="text-xs font-medium text-primary hover:underline sm:text-sm">View All</button>
                    </div>
                    <div class="divide-y divide-slate-200 md:hidden ">
                        @forelse ($recentBookings as $booking)
                            <article class="space-y-2 p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold text-foreground">
                                            {{ $booking->booking_code }}</p>
                                        <p class="truncate text-xs text-gray-500">{{ $booking->user->name }}</p>
                                    </div>
                                    <span @class([
                                        'shrink-0 badge text-[11px]',
                                        'badge-primary' => $booking->status === 'pending',
                                        'badge-info' => $booking->status === 'paid',
                                        'badge-success' => $booking->status === 'checked_in',
                                        'badge-warning' => $booking->status === 'checked_out',
                                        'badge-accent' => $booking->status === 'cancelled',
                                    ])>{{ ucfirst($booking->status) }}</span>
                                </div>
                                <div class="flex items-end justify-between gap-3 text-xs">
                                    <div class="min-w-0 text-gray-500">
                                        <p class="truncate font-medium text-gray-700">{{ $booking->room->name }}</p>
                                        <p>
                                            {{ Carbon\Carbon::parse($booking->check_in)->format('d M Y H:i') }} -
                                            {{ Carbon\Carbon::parse($booking->check_out)->format('d M Y H:i') }}
                                        </p>
                                    </div>
                                    <div class="shrink-0 font-semibold text-foreground">Rp
                                        {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                                </div>
                            </article>
                        @empty
                            <p class="p-6 text-center text-sm text-gray-500">Belum ada data</p>
                        @endforelse
                    </div>
                    <div class="hidden overflow-x-auto md:block">
                        <table class="w-full whitespace-nowrap text-left text-sm">
                            <thead class="bg-gray-50 text-gray-500">
                                <tr>
                                    <th class="px-4 py-3 font-medium lg:px-6">Guest</th>
                                    <th class="px-4 py-3 font-medium lg:px-6">Room</th>
                                    <th class="px-4 py-3 font-medium lg:px-6">Dates</th>
                                    <th class="px-4 py-3 font-medium lg:px-6">Status</th>
                                    <th class="px-4 py-3 font-medium lg:px-6">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($recentBookings as $booking)
                                    <tr class="hover:bg-gray-50 cursor-pointer">

                                        <td class="px-4 py-3 lg:px-6">
                                            <div class="font-medium text-foreground">
                                                {{ $booking->booking_code }}</div>
                                            <div class="text-xs text-gray-500">{{ $booking->user->name }}</div>
                                        </td>
                                        <td class="px-4 py-3 lg:px-6">
                                            <div class="font-medium text-foreground">
                                                {{ $booking->room->name }}</div>
                                            <div class="text-xs text-gray-500">
                                                {{ $booking->roomUnit->room_number }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 lg:px-6">
                                            <div class="text-xs">
                                                {{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y H:i') }}
                                            </div>
                                            <div class="text-xs">
                                                {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y H:i') }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 lg:px-6">
                                            <span @class([
                                                'badge',
                                                'badge-primary' => $booking->status === 'pending',
                                                'badge-info' => $booking->status === 'paid',
                                                'badge-success' => $booking->status === 'checked_in',
                                                'badge-warning' => $booking->status === 'checked_out',
                                                'badge-accent' => $booking->status === 'cancelled',
                                            ])>
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 font-medium lg:px-6">
                                            {{ $booking->total_price ? 'Rp ' . number_format($booking->total_price, 0, ',', '.') : 'Belum ada data' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-6 text-center">Belum ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="border-t border-slate-200 px-4 py-3 sm:px-5 lg:px-6">
                        {{ $recentBookings->links() }}
                    </div>

                </div>
            </div>

            <!-- Room Status Summary -->
            <div>
                <div
                    class="card rounded-xl border border-gray-100 bg-white p-4 shadow-sm sm:rounded-2xl sm:p-5 lg:p-6">
                    <h2 class="mb-4 font-poppins text-base font-bold sm:mb-5 sm:text-lg lg:mb-6">Room Availability</h2>

                    <div class="space-y-3 sm:space-y-4">
                        @forelse ($rooms as $room)
                            <div>
                                <div class="mb-1 flex justify-between text-xs sm:text-sm">
                                    <span class="truncate pr-3 text-gray-600">{{ $room->name }}</span>
                                    <span
                                        class="font-medium badge-success">{{ $room->units->where('status', 'available')->count() }}
                                        / {{ $room->units->count() }}</span>
                                </div>
                                <div class="h-1.5 w-full rounded-full bg-gray-100 sm:h-2">
                                    <div class="h-1.5 rounded-full bg-emerald-500 sm:h-2"
                                        style="width: {{ $room->units->count() ? ($room->units->where('status', 'available')->count() / $room->units->count()) * 100 : 0 }}%">
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6">Belum ada data</div>
                        @endforelse

                    </div>

                    <div class="mt-5 border-t border-gray-100 pt-4 sm:mt-6 sm:pt-5 lg:mt-8 lg:pt-6">
                        <h3 class="mb-3 text-xs font-medium text-gray-600 sm:mb-4 sm:text-sm">Quick Actions</h3>
                        <div class="grid grid-cols-2 gap-2 sm:gap-3">
                            <button
                                class="flex flex-col items-center gap-1.5 rounded-lg border border-gray-200 p-2.5 text-xs font-medium transition-colors hover:bg-gray-50 sm:gap-2 sm:rounded-xl sm:p-3 sm:text-sm">
                                <svg class="h-4 w-4 text-gray-500 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                New Booking
                            </button>
                            <button type="button" wire:click="exportExcel" wire:loading.attr="disabled"
                                class="flex flex-col items-center gap-1.5 rounded-lg border border-gray-200 p-2.5 text-xs font-medium transition-colors hover:bg-gray-50 sm:gap-2 sm:rounded-xl sm:p-3 sm:text-sm">

                                <!-- Excel Icon -->
                                <svg class="h-4 w-4 text-gray-500 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>

                                <!-- Loading -->
                                <svg wire:loading class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4">
                                    </circle>

                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                                    </path>
                                </svg>

                                <span wire:loading.remove>
                                    Export Excel
                                </span>

                                <span wire:loading>
                                    Mengekspor...
                                </span>
                            </button>
                            {{-- <button
                                class="flex flex-col items-center gap-1.5 rounded-lg border border-gray-200 p-2.5 text-xs font-medium transition-colors hover:bg-gray-50 sm:gap-2 sm:rounded-xl sm:p-3 sm:text-sm">
                                <svg class="h-4 w-4 text-gray-500 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                                Generate Report
                            </button> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


</div>

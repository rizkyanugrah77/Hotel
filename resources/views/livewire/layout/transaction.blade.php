<div x-data="{
    toast: { show: false, message: '', type: 'success' },
    showToast(message, type) {
        this.toast.message = message;
        this.toast.show = true;
        this.toast.type = type;
        window.setTimeout(() => this.toast.show = false, 5000);
    }
}"
    class="relative min-w-0 w-full max-w-full flex-1 overflow-x-hidden overflow-y-auto p-3 sm:p-5 lg:p-6">

    <x-toast />

    <!-- KPI Cards -->
    <div class="mb-5 grid grid-cols-2 gap-3 sm:mb-6 lg:grid-cols-4 lg:gap-4">
        <div class="min-w-0 rounded-xl border border-slate-200 bg-slate-50 p-3 shadow-sm sm:p-4">
            <div class="mb-2 flex items-start justify-between gap-2 sm:mb-3">
                <div class="min-w-0">
                    <p class="mb-1 text-xs text-gray-500">Pendapatan Periode Terpilih</p>
                    <h3 class="break-words text-lg font-poppins font-bold leading-tight text-foreground sm:text-xl">
                        {{ 'Rp ' . number_format($transactionStats['total'] ?? 0, 0, ',', '.') }}</h3>
                    @if ($transactionStats['total_change'] !== null)
                        <p @class([
                            'text-[10px] sm:text-xs font-medium mt-1 text-emerald-600',
                            'text-emerald-600' => $transactionStats['total_change'] >= 0,
                            'text-rose-600' => $transactionStats['total_change'] < 0,
                        ])>
                            {{ $transactionStats['total_change'] >= 0 ? '+' : '' }}{{ number_format($transactionStats['total_change'], 1, ',', '.') }}%

                        </p>
                    @else
                        <p class="text-[10px] sm:text-xs text-gray-500 font-medium mt-1">-</p>
                    @endif
                </div>
                <div
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary sm:h-9 sm:w-9">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.118a7.5 7.5 0 0 1 15 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.5-1.632Z" />
                    </svg>
                </div>
            </div>
            <p class="hidden text-xs font-medium text-gray-500 sm:block">Semua transaksi</p>
        </div>

        <div class="min-w-0 rounded-xl border border-emerald-200 bg-emerald-50 p-3 shadow-sm sm:p-4">
            <div class="mb-2 flex items-start justify-between gap-2 sm:mb-3">
                <div class="min-w-0">
                    <p class="mb-1 text-xs text-gray-500">Berhasil</p>
                    <h3 class="text-lg font-poppins font-bold leading-tight text-emerald-600 sm:text-xl">
                        {{ $transactionStats['success'] ?? 0 }}</h3>
                </div>
                <div
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 sm:h-9 sm:w-9">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <p class="hidden text-xs font-medium text-emerald-700 sm:block">Pembayaran sukses</p>
        </div>

        <div class="min-w-0 rounded-xl border border-amber-200 bg-amber-50 p-3 shadow-sm sm:p-4">
            <div class="mb-2 flex items-start justify-between gap-2 sm:mb-3">
                <div class="min-w-0">
                    <p class="mb-1 text-xs text-gray-500">Pending</p>
                    <h3 class="text-lg font-poppins font-bold leading-tight text-amber-700 sm:text-xl">
                        {{ $transactionStats['pending'] ?? 0 }}</h3>
                </div>
                <div
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-amber-100 text-amber-700 sm:h-9 sm:w-9">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <p class="hidden text-xs font-medium text-amber-700 sm:block">Menunggu pembayaran</p>
        </div>

        <div class="min-w-0 rounded-xl border border-violet-200 bg-violet-50 p-3 shadow-sm sm:p-4">
            <div class="mb-2 flex items-start justify-between gap-2 sm:mb-3">
                <div class="min-w-0 flex flex-col">
                    <p class="mb-1 text-xs text-gray-500">Laba Bersih Estimasi</p>
                    <h3 class="break-words text-lg font-poppins font-bold leading-tight text-accent sm:text-xl">
                        {{ 'Rp ' . number_format($transactionStats['revenue'] ?? 0, 0, ',', '.') }}</h3>
                    <h3 class="text-xs font-poppins font-medium text-primary sm:text-sm">
                        {{ 'Rp ' . number_format($transactionStats['total_tax'] ?? 0, 0, ',', '.') }} <span
                            class="text-xs text-gray-500">Tax</span></h3>
                </div>
                <div
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-accent/10 text-accent-700 sm:h-9 sm:w-9">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                    </svg>
                </div>
            </div>
            <p class="hidden text-xs font-medium text-accent-700 sm:block">Dari transaksi sukses</p>
        </div>
    </div>

    <!-- Filter Laporan -->
    <div class="mb-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:mb-6 sm:p-5">
        <div class="flex flex-col justify-between gap-4 xl:flex-row xl:items-end">

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
            <div class="grid w-full grid-cols-1 gap-3 sm:grid-cols-2 xl:w-auto xl:grid-cols-[10rem_11rem_auto]">

                <!-- Jenis Periode -->
                <div class="w-full sm:w-40">
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">
                        Periode
                    </label>

                    <select wire:model.live="reportPeriod" class="input py-2.5 text-sm w-full">
                        <option value="daily">Harian</option>
                        <option value="monthly">Bulanan</option>
                        <option value="yearly">Tahunan</option>
                    </select>
                </div>

                <!-- Harian -->
                @if ($reportPeriod === 'daily')
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

                <!-- Export -->
                <div class="flex items-end">
                    <button type="button" wire:click="exportExcel" wire:loading.attr="disabled"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5
                           bg-emerald-600 hover:bg-emerald-700
                           text-white text-sm font-semibold
                           min-h-11 rounded-lg transition-colors shadow-sm
                           w-full
                           disabled:opacity-50 disabled:cursor-not-allowed">

                        <!-- Excel Icon -->
                        <svg wire:loading.remove class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3v12m0 0 4-4m-4 4-4-4M5 21h14a2 2 0 0 0 2-2v-4M3 15v4a2 2 0 0 0 2 2" />
                        </svg>

                        <!-- Loading -->
                        <svg wire:loading class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4">
                            </circle>

                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                            </path>
                        </svg>

                        <span wire:loading.remove>
                            Export Excel
                        </span>

                        <span wire:loading>
                            Mengekspor...
                        </span>
                    </button>
                </div>

            </div>
        </div>
    </div>


    <!-- Search & Filter + Transaction List -->
    <div class="mb-6 w-full min-w-0 overflow-scroll rounded-xl border border-slate-200 bg-white shadow-sm">

        {{-- daftar --}}
        <div
            class="flex flex-col items-start justify-between gap-3 border-b border-gray-100 p-4 sm:p-5 lg:flex-row lg:items-center">
            <h2 class="font-poppins font-bold text-lg">Daftar Transaksi</h2>
            <div class="grid w-full grid-cols-1 gap-2 sm:grid-cols-[minmax(0,1fr)_10rem] lg:w-auto">
                <div class="relative min-w-0">
                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <input wire:model.live="search" type="text" placeholder="Cari kode transaksi, user, room..."
                        class="input w-full py-2 pl-10 pr-4 text-sm lg:w-64" />
                </div>

                <select id="filterStatus" wire:model.live="filterStatus"
                    class="input min-w-0 w-full py-2 text-sm lg:w-40">
                    <option value="">Semua Status</option>
                    <option value="success">Berhasil</option>
                    <option value="pending">Pending</option>
                    <option value="failed">Gagal</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
            </div>
        </div>

        <!-- Table: desktop only -->
        <div class="hidden min-w-0 xl:block">
            <table class="w-full table-fixed text-left text-xs 2xl:text-sm">
                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="w-10 px-3 py-3 font-medium">No</th>
                        <th class="w-[10%] px-3 py-3 font-medium">Order ID</th>
                        <th class="w-[10%] px-3 py-3 font-medium">Date</th>
                        <th class="w-[8%] px-3 py-3 font-medium">Booking Code</th>
                        <th class="w-[10%] px-3 py-3 font-medium">User</th>
                        <th class="w-[10%] px-3 py-3 font-medium">Room</th>
                        <th class="w-[8%] px-3 py-3 font-medium">Metode</th>
                        <th class="hidden w-[8%] px-3 py-3 font-medium 2xl:table-cell">Tax</th>
                        <th class="hidden w-[8%] px-3 py-3 font-medium 2xl:table-cell">Promo</th>
                        <th class="hidden w-[10%] px-3 py-3 font-medium 2xl:table-cell">Subtotal</th>
                        <th class="w-[9%] px-3 py-3 font-medium">Total</th>
                        <th class="w-[9%] px-3 py-3 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($transactions as $index => $tx)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-3 font-medium text-gray-700">{{ $index + 1 }}</td>
                            <td class="truncate px-3 py-3 font-mono text-gray-700">{{ $tx->order_id }}</td>
                            <td class="truncate px-3 py-3 text-gray-700">
                                {{ Carbon\Carbon::parse($tx->created_at)->setTimezone('Asia/Jakarta')->format('d M Y H:i') }}
                            </td>
                            <td class="truncate px-3 py-3 text-gray-700">{{ $tx->booking?->booking_code ?? '-' }}</td>
                            <td class="truncate px-3 py-3 text-gray-700">{{ $tx->user?->name ?? '-' }}</td>
                            <td class="truncate px-3 py-3 text-gray-700">{{ $tx->booking?->room?->name ?? '-' }}</td>
                            <td class="truncate px-3 py-3 text-gray-700">
                                {{ $tx->payment_type ?? ($tx->payment_method ?? '-') }}
                            </td>
                            <td class="hidden truncate px-3 py-3 text-gray-700 2xl:table-cell">
                                Rp. {{ number_format($tx->tax_amount, 0, ',', '.') }}
                            </td>


                            <td class="hidden truncate px-3 py-3 text-gray-700 2xl:table-cell">
                                @if ($tx->promo)
                                    @if ($tx->promo->discount_type === 'percentage')
                                        {{ $tx->promo->discount_value }}%
                                    @else
                                        Rp. {{ number_format($tx->promo->discount_value, 0, ',', '.') }}
                                    @endif
                                @else
                                    No Promo
                                @endif
                            </td>
                            <td class="hidden truncate px-3 py-3 text-gray-700 2xl:table-cell">
                                {{ 'Rp ' . number_format($tx->sub_total_amount, 0, ',', '.') }}
                            </td>
                            <td class="truncate px-3 py-3 text-gray-700">
                                {{ 'Rp ' . number_format($tx->gross_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-3 py-3">
                                <x-transaction-status :status="$tx->transaction_status" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="px-3 py-6 text-center text-gray-500">Tidak ada transaksi
                                ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Cards: mobile first -->
        <div class="divide-y divide-gray-100 xl:hidden">
            @forelse ($transactions as $tx)
                <article class="space-y-3 p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="font-mono text-sm font-semibold text-gray-800 truncate">{{ $tx->order_id }}</p>
                            <p class="mt-0.5 truncate text-xs text-gray-500">{{ $tx->user?->name ?? '-' }}</p>
                        </div>
                        <x-transaction-status :status="$tx->transaction_status" />
                    </div>
                    <div class="rounded-lg bg-gray-50 p-3 text-sm">
                        <p class="truncate font-medium text-gray-800">{{ $tx->booking?->room?->name ?? '-' }}</p>
                        <div class="mt-1 flex items-center justify-between gap-3 text-xs text-gray-500">
                            <span class="min-w-0 truncate">{{ $tx->booking?->booking_code ?? '-' }}</span>
                            <span
                                class="shrink-0">{{ Carbon\Carbon::parse($tx->created_at)->setTimezone('Asia/Jakarta')->format('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                        <span
                            class="min-w-0 truncate pr-3 text-xs text-gray-400">{{ $tx->payment_type ?? ($tx->payment_method ?? '-') }}</span>
                        <span class="shrink-0 font-poppins font-bold text-accent-700">
                            {{ 'Rp ' . number_format($tx->gross_amount, 0, ',', '.') }}
                        </span>
                    </div>
                </article>
            @empty
                <div class="p-6 text-center text-gray-500 text-sm">Tidak ada transaksi ditemukan.</div>
            @endforelse
        </div>

        <div class="p-4">
            {{ $transactions->links() }}
        </div>

    </div>

    <!-- Recent Transactions Summary -->
    <div class="grid min-w-0 grid-cols-1 gap-4 lg:grid-cols-3">
        <div class="min-w-0 rounded-xl border border-sky-200 bg-sky-50 p-4 shadow-sm sm:p-5 lg:col-span-1">
            <h2 class="mb-3 font-poppins text-lg font-bold">Metode Pembayaran</h2>
            <div class="space-y-2">
                @forelse ($paymentMethods as $method)
                    <div class="flex items-center justify-between gap-3 rounded-lg bg-white/70 p-3">
                        <span
                            class="text-sm font-medium text-gray-700 capitalize">{{ $method->payment_type ?: 'Lainnya' }}</span>
                        <span class="text-sm font-poppins font-bold text-primary">{{ $method->total }}</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Belum ada data.</p>
                @endforelse
            </div>
        </div>

        <div class="min-w-0 rounded-xl border border-violet-200 bg-violet-50 p-4 shadow-sm sm:p-5">
            <h2 class="mb-3 font-poppins text-lg font-bold">Statistik Transaksi</h2>
            <div class="grid gap-2 sm:grid-cols-3 lg:grid-cols-1">
                <div class="rounded-lg bg-white/70 p-3">
                    <p class="text-sm text-gray-500 mb-1">Total Revenue (Berhasil)</p>
                    <p class="text-lg sm:text-xl font-poppins font-bold text-accent-700">
                        {{ 'Rp ' . number_format($transactionStats['revenue'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="rounded-lg bg-white/70 p-3">
                    <p class="text-sm text-gray-500 mb-1">Rata-rata per Transaksi</p>
                    <p class="text-lg sm:text-xl font-poppins font-bold text-foreground">
                        {{ 'Rp ' . number_format($transactionStats['average'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="rounded-lg bg-white/70 p-3">
                    <p class="text-sm text-gray-500 mb-1">Transaksi Tertinggi</p>
                    <p class="text-lg sm:text-xl font-poppins font-bold text-primary">
                        {{ 'Rp ' . number_format($transactionStats['highest'] ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="min-w-0 rounded-xl border border-indigo-200 bg-indigo-50 p-4 shadow-sm sm:p-5">
            <h2 class="mb-3 font-poppins text-lg font-bold">Ringkasan Booking</h2>
            <div class="grid gap-2 sm:grid-cols-3 lg:grid-cols-1">
                <div class="rounded-lg bg-white/70 p-3">
                    <p class="text-sm text-gray-500 mb-1">Total Pesanan</p>
                    <p class="text-lg sm:text-xl font-poppins font-bold text-foreground">
                        {{ $transactionStats['total'] ?? 0 }}</p>
                </div>
                <div class="rounded-lg bg-white/70 p-3">
                    <p class="text-sm text-gray-500 mb-1">Dibayar</p>
                    <p class="text-lg sm:text-xl font-poppins font-bold text-emerald-600">
                        {{ $transactionStats['paid'] ?? 0 }}</p>
                </div>
                <div class="rounded-lg bg-white/70 p-3">
                    <p class="text-sm text-gray-500 mb-1">Menunggu</p>
                    <p class="text-lg sm:text-xl font-poppins font-bold text-amber-600">
                        {{ $transactionStats['pending'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

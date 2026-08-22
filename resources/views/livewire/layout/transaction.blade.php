<div x-data="{
    toast: { show: false, message: '', type: 'success' },
    showToast(message, type) {
        this.toast.message = message;
        this.toast.show = true;
        this.toast.type = type;
        window.setTimeout(() => this.toast.show = false, 5000);
    }
}"
    class="relative min-w-0 w-full max-w-full flex-1 overflow-x-hidden overflow-y-auto p-4 sm:p-6 lg:p-8">

    <x-toast />

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-6 sm:mb-8">
        <div class="bg-slate-50 border border-slate-200 shadow-md rounded-2xl p-4 sm:p-6">
            <div class="flex justify-between items-start mb-3 sm:mb-4">
                <div>
                    <p class="text-xs sm:text-sm text-gray-500 mb-1">Total Transaksi</p>
                    <h3 class="text-xl sm:text-2xl font-poppins font-bold text-foreground">
                        {{ $transactionStats['total'] ?? 0 }}</h3>
                </div>
                <div
                    class="w-8 h-8 sm:w-10 sm:h-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.118a7.5 7.5 0 0 1 15 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.5-1.632Z" />
                    </svg>
                </div>
            </div>
            <p class="text-[10px] sm:text-xs text-gray-500 font-medium">Semua transaksi</p>
        </div>

        <div class="bg-emerald-50 border border-emerald-200 shadow-md rounded-2xl p-4 sm:p-6">
            <div class="flex justify-between items-start mb-3 sm:mb-4">
                <div>
                    <p class="text-xs sm:text-sm text-gray-500 mb-1">Berhasil</p>
                    <h3 class="text-xl sm:text-2xl font-poppins font-bold text-emerald-600">
                        {{ $transactionStats['success'] ?? 0 }}</h3>
                </div>
                <div
                    class="w-8 h-8 sm:w-10 sm:h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <p class="text-[10px] sm:text-xs text-emerald-600 font-medium">Pembayaran sukses</p>
        </div>

        <div class="bg-amber-50 border border-amber-200 shadow-md rounded-2xl p-4 sm:p-6">
            <div class="flex justify-between items-start mb-3 sm:mb-4">
                <div>
                    <p class="text-xs sm:text-sm text-gray-500 mb-1">Pending</p>
                    <h3 class="text-xl sm:text-2xl font-poppins font-bold text-amber-600">
                        {{ $transactionStats['pending'] ?? 0 }}</h3>
                </div>
                <div
                    class="w-8 h-8 sm:w-10 sm:h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <p class="text-[10px] sm:text-xs text-amber-600 font-medium">Menunggu pembayaran</p>
        </div>

        <div class="bg-violet-50 border border-violet-200 shadow-md rounded-2xl p-4 sm:p-6">
            <div class="flex justify-between items-start mb-3 sm:mb-4">
                <div>
                    <p class="text-xs sm:text-sm text-gray-500 mb-1">Total Revenue</p>
                    <h3 class="text-xl sm:text-2xl font-poppins font-bold text-accent-700">
                        {{ 'Rp ' . number_format($transactionStats['revenue'] ?? 0, 0, ',', '.') }}</h3>
                </div>
                <div
                    class="w-8 h-8 sm:w-10 sm:h-10 bg-accent/10 text-accent-700 rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                    </svg>
                </div>
            </div>
            <p class="text-[10px] sm:text-xs text-accent-600 font-medium">Dari transaksi sukses</p>
        </div>
    </div>

    <!-- Filter Laporan -->
    <div class="bg-white border border-slate-200 shadow-md rounded-2xl p-4 sm:p-6 mb-6">
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
                <div class="flex items-end w-full sm:w-auto">
                    <button type="button" wire:click="exportExcel" wire:loading.attr="disabled"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5
                           bg-emerald-600 hover:bg-emerald-700
                           text-white text-sm font-semibold
                           rounded-xl transition-all shadow-sm
                           w-full sm:w-auto
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
    <div class="w-full min-w-0 overflow-hidden bg-white border border-slate-200 shadow-md rounded-2xl mb-8">

        {{-- daftar --}}
        <div
            class="p-3 sm:p-6 border-b border-gray-100 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <h2 class="font-poppins font-bold text-lg">Daftar Transaksi</h2>
            <div class="flex flex-col sm:flex-row w-full lg:w-auto items-stretch gap-3">
                <div class="relative flex-1 sm:flex-none">
                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <input wire:model.live="search" type="text" placeholder="Cari kode transaksi, user, room..."
                        class="input pl-10 pr-4 py-2 text-sm lg:w-full sm:w-64" />
                </div>

                <select id="filterStatus" wire:model.live="filterStatus"
                    class="mt-2 block w-full rounded-md bg-white py-2 pl-3 pr-10 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:w-40">
                    <option value="">Semua Status</option>
                    <option value="success">Berhasil</option>
                    <option value="pending">Pending</option>
                    <option value="failed">Gagal</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
            </div>
        </div>

        <!-- Table: desktop only -->
        <div class="overflow-x-auto hidden md:block">
            <table class="w-full text-left text-sm overflow-x-scroll">
                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="py-3 px-6 font-medium">No</th>
                        <th class="py-3 px-6 font-medium">Order ID</th>
                        <th class="py-3 px-6 font-medium">Date</th>
                        <th class="py-3 px-6 font-medium">Booking Code</th>
                        <th class="py-3 px-6 font-medium">User</th>
                        <th class="py-3 px-6 font-medium">Room</th>
                        <th class="py-3 px-6 font-medium">Metode</th>
                        <th class="py-3 px-6 font-medium">Total</th>
                        <th class="py-3 px-6 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($transactions as $index => $tx)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-6 text-gray-700 font-medium">{{ $index + 1 }}</td>
                            <td class="py-3 px-6 text-gray-700 font-mono">{{ $tx->order_id }}</td>
                            <td class="py-3 px-6 text-gray-700">{{ $tx->created_at->format('d M Y H:i') }}</td>
                            <td class="py-3 px-6 text-gray-700">{{ $tx->booking?->booking_code ?? '-' }}</td>
                            <td class="py-3 px-6 text-gray-700">{{ $tx->user?->name ?? '-' }}</td>
                            <td class="py-3 px-6 text-gray-700">{{ $tx->booking?->room?->name ?? '-' }}</td>
                            <td class="py-3 px-6 text-gray-700">
                                {{ $tx->payment_type ?? ($tx->payment_method ?? '-') }}
                            </td>
                            <td class="py-3 px-6 text-gray-700">
                                {{ 'Rp ' . number_format($tx->gross_amount, 0, ',', '.') }}</td>
                            <td class="py-3 px-6">
                                <x-transaction-status :status="$tx->transaction_status" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-6 px-6 text-center text-gray-500">Tidak ada transaksi
                                ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Cards: mobile first -->
        <div class="md:hidden grid grid-cols-1 gap-4">
            @forelse ($transactions as $tx)
                <div class="p-4 space-y-3">
                    <div class="flex items-start justify-between">
                        <div class="min-w-0">
                            <p class="font-mono text-sm font-semibold text-gray-800 truncate">{{ $tx->order_id }}</p>
                            <p class="text-xs text-gray-500">{{ $tx->user?->name ?? '-' }}</p>
                        </div>
                        <x-transaction-status :status="$tx->transaction_status" />
                    </div>
                    <div class="flex items-center justify-between gap-3 text-sm">
                        <span class="min-w-0 truncate text-gray-500">{{ $tx->booking?->room?->name ?? '-' }}</span>
                        <span
                            class="min-w-0 truncate text-right text-gray-500">{{ $tx->booking?->booking_code ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                        <span
                            class="min-w-0 truncate pr-3 text-xs text-gray-400">{{ $tx->payment_type ?? ($tx->payment_method ?? '-') }}</span>
                        <span class="shrink-0 font-poppins font-bold text-accent-700">
                            {{ 'Rp ' . number_format($tx->gross_amount, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500 text-sm">Tidak ada transaksi ditemukan.</div>
            @endforelse
        </div>

        <div class="p-4">
            {{ $transactions->links() }}
        </div>
    </div>

    <!-- Recent Transactions Summary -->
    <div class="grid min-w-0 grid-cols-1 gap-6 lg:grid-cols-3 lg:gap-8">
        <div class="min-w-0 bg-sky-50 border border-sky-200 shadow-md rounded-2xl p-4 sm:p-6 lg:col-span-1">
            <h2 class="font-poppins font-bold text-lg mb-4">Metode Pembayaran</h2>
            <div class="space-y-4">
                @forelse ($paymentMethods as $method)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                        <span
                            class="text-sm font-medium text-gray-700 capitalize">{{ $method->payment_type ?: 'Lainnya' }}</span>
                        <span class="text-sm font-poppins font-bold text-primary">{{ $method->total }}</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Belum ada data.</p>
                @endforelse
            </div>
        </div>

        <div class="min-w-0 bg-violet-50 border border-violet-200 shadow-md rounded-2xl p-4 sm:p-6">
            <h2 class="font-poppins font-bold text-lg mb-4">Statistik Transaksi</h2>
            <div class="space-y-4">
                <div class="p-4 bg-gray-50 rounded-xl">
                    <p class="text-sm text-gray-500 mb-1">Total Revenue (Berhasil)</p>
                    <p class="text-lg sm:text-xl font-poppins font-bold text-accent-700">
                        {{ 'Rp ' . number_format($transactionStats['revenue'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-xl">
                    <p class="text-sm text-gray-500 mb-1">Rata-rata per Transaksi</p>
                    <p class="text-lg sm:text-xl font-poppins font-bold text-foreground">
                        {{ 'Rp ' . number_format($transactionStats['average'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-xl">
                    <p class="text-sm text-gray-500 mb-1">Transaksi Tertinggi</p>
                    <p class="text-lg sm:text-xl font-poppins font-bold text-primary">
                        {{ 'Rp ' . number_format($transactionStats['highest'] ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="min-w-0 bg-indigo-50 border border-indigo-200 shadow-md rounded-2xl p-4 sm:p-6">
            <h2 class="font-poppins font-bold text-lg mb-4">Ringkasan Booking</h2>
            <div class="space-y-4">
                <div class="p-4 bg-gray-50 rounded-xl">
                    <p class="text-sm text-gray-500 mb-1">Total Pesanan</p>
                    <p class="text-lg sm:text-xl font-poppins font-bold text-foreground">
                        {{ $transactionStats['total'] ?? 0 }}</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-xl">
                    <p class="text-sm text-gray-500 mb-1">Dibayar</p>
                    <p class="text-lg sm:text-xl font-poppins font-bold text-emerald-600">
                        {{ $transactionStats['paid'] ?? 0 }}</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-xl">
                    <p class="text-sm text-gray-500 mb-1">Menunggu</p>
                    <p class="text-lg sm:text-xl font-poppins font-bold text-amber-600">
                        {{ $transactionStats['pending'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

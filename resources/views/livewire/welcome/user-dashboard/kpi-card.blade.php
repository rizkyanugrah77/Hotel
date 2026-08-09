    <div class="flex gap-4 overflow-x-auto no-scrollbar pb-1 sm:grid sm:grid-cols-2 lg:grid-cols-4 sm:overflow-visible">

        <!-- Total Bookings -->
        <div
            class="min-w-[160px] sm:min-w-0 flex-shrink-0 sm:flex-shrink bg-white border border-gray-100 shadow-sm rounded-2xl p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <p class="text-xs text-gray-500 mb-1 font-medium">Total Booking</p>
                    <h3 class="text-2xl font-poppins font-bold text-foreground">{{ $totalBookings }}</h3>
                </div>
                <div class="w-10 h-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 font-medium">Semua booking Anda</p>
        </div>

        <!-- Total Spent -->
        <div
            class="min-w-[160px] sm:min-w-0 flex-shrink-0 sm:flex-shrink bg-white border border-gray-100 shadow-sm rounded-2xl p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <p class="text-xs text-gray-500 mb-1 font-medium">Total Pengeluaran</p>
                    <h3 class="text-xl font-poppins font-bold text-foreground">Rp
                        {{ number_format($totalSpent / 1000000, 1) }}M</h3>
                </div>
                <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.46 1.453-1.226V5.117c0-.528-.278-1.013-.727-1.28A60.064 60.064 0 0 0 2.25 3v15.75ZM21.75 18V5.25" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-emerald-600 font-medium">Rp {{ number_format($totalSpent, 0, ',', '.') }}</p>
        </div>

        <!-- Active Bookings -->
        <div
            class="min-w-[160px] sm:min-w-0 flex-shrink-0 sm:flex-shrink bg-white border border-gray-100 shadow-sm rounded-2xl p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <p class="text-xs text-gray-500 mb-1 font-medium">Booking Aktif</p>
                    <h3 class="text-2xl font-poppins font-bold text-foreground">{{ $activeCount }}</h3>
                </div>
                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-blue-600 font-medium">Sedang berjalan</p>
        </div>

        <!-- Upcoming Check-in -->
        <div
            class="min-w-[160px] sm:min-w-0 flex-shrink-0 sm:flex-shrink bg-white border border-gray-100 shadow-sm rounded-2xl p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <p class="text-xs text-gray-500 mb-1 font-medium">Check-in Dekat</p>
                    <h3 class="text-2xl font-poppins font-bold text-foreground">{{ $upcomingCount }}</h3>
                </div>
                <div class="w-10 h-10 bg-accent/10 text-accent-700 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-accent-700 font-medium">Dalam 3 hari</p>
        </div>
    </div>

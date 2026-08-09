<div class="space-y-6 sm:space-y-8">

    <!-- ===================================
       SECTION 1: Welcome Header
       =================================== -->
    <section class="animate-fade-in-up delay-1" id="welcome-header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-poppins font-bold text-foreground">
                    Selamat Datang, <span class="text-gradient-primary">{{ $user->name }}</span> 👋
                </h1>
                <p class="text-sm sm:text-base text-gray-500 mt-1 font-inter">
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </p>
            </div>
            <a href="{{ route('index') }}#rooms" wire:navigate class="btn-primary text-sm !px-5 !py-2.5 w-fit">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Book Kamar
            </a>
        </div>
    </section>


    <!-- ===================================
       SECTION 2: Notifikasi Check-in
       =================================== -->
    @if ($upcomingCheckins->count() > 0)
        <section class="animate-fade-in-up delay-2" id="checkin-alerts">
            @foreach ($upcomingCheckins as $checkin)
                <div
                    class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200/60 rounded-2xl p-4 sm:p-5 flex items-start gap-3 mb-3 last:mb-0 shadow-sm">
                    <div
                        class="w-10 h-10 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-amber-800">
                            🔔 Check-in {{ $checkin->check_in->diffForHumans() }}
                        </p>
                        <p class="text-xs text-amber-600 mt-0.5">
                            <span class="font-medium">{{ $checkin->room->name ?? 'Room' }}</span> —
                            {{ $checkin->check_in->format('d M Y') }} s/d {{ $checkin->check_out->format('d M Y') }}
                        </p>
                        <p class="text-xs text-amber-500 mt-0.5">Kode: {{ $checkin->booking_code }}</p>
                    </div>
                </div>
            @endforeach
        </section>
    @endif


    <!-- ===================================
       SECTION 3: KPI Cards
       =================================== -->
    <section class="animate-fade-in-up delay-3" id="kpi-cards">
        <!-- Horizontal scroll on mobile, grid on larger screens -->
        <div
            class="flex gap-4 overflow-x-auto no-scrollbar pb-1 sm:grid sm:grid-cols-2 lg:grid-cols-4 sm:overflow-visible">

            <!-- Total Bookings -->
            <div
                class="min-w-[160px] sm:min-w-0 flex-shrink-0 sm:flex-shrink bg-white border border-gray-100 shadow-sm rounded-2xl p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <p class="text-xs text-gray-500 mb-1 font-medium">Total Booking</p>
                        <h3 class="text-2xl font-poppins font-bold text-foreground">{{ $totalBookings }}</h3>
                    </div>
                    <div class="w-10 h-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
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
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
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
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
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
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-accent-700 font-medium">Dalam 3 hari</p>
            </div>
        </div>
    </section>


    <!-- ===================================
       SECTION 4: Active Bookings + Quick Actions
       =================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">

        <!-- Active Bookings (2/3 width on desktop) -->
        <section class="lg:col-span-2 animate-fade-in-up delay-4" id="active-bookings">
            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">
                <div class="p-5 sm:p-6 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="font-poppins font-bold text-lg text-foreground">Booking Aktif</h2>
                    <span class="badge-primary">{{ $activeCount }} aktif</span>
                </div>

                <div class="divide-y divide-gray-50">
                    @forelse($activeBookings as $booking)
                        <div class="p-4 sm:p-5 hover:bg-gray-50/50 transition-colors">
                            <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
                                <!-- Room image placeholder -->
                                <div
                                    class="w-full sm:w-20 h-28 sm:h-16 bg-gradient-to-br from-gray-100 to-gray-50 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden">
                                    @if ($booking->room && $booking->room->image)
                                        <img src="{{ asset('storage/assets/img/rooms/' . $booking->room->image) }}"
                                            alt="{{ $booking->room->name }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 21h19.5M3.75 21V9.75 6.75m0 3h16.5m-16.5 0 2.07-5.175A1.5 1.5 0 0 1 7.214 3.75h9.572a1.5 1.5 0 0 1 1.394.925l2.07 5.175m0 0V21" />
                                        </svg>
                                    @endif
                                </div>

                                <!-- Booking info -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2">
                                        <div>
                                            <h3 class="text-sm font-semibold text-foreground">
                                                {{ $booking->room->name ?? 'Room' }}</h3>
                                            <p class="text-xs text-gray-400 mt-0.5">{{ $booking->booking_code }}</p>
                                        </div>
                                        @if ($booking->status === 'confirmed')
                                            <span class="badge-success flex-shrink-0">Confirmed</span>
                                        @elseif($booking->status === 'pending')
                                            <span class="badge-warning flex-shrink-0">Pending</span>
                                        @else
                                            <span
                                                class="badge bg-gray-100 text-gray-600 flex-shrink-0">{{ ucfirst($booking->status) }}</span>
                                        @endif
                                    </div>

                                    <div
                                        class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-2 text-xs text-gray-500">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                            </svg>
                                            {{ $booking->check_in->format('d M') }} —
                                            {{ $booking->check_out->format('d M Y') }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                            </svg>
                                            {{ $booking->total_guests }} tamu
                                        </span>
                                        <span class="font-semibold text-foreground">
                                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 sm:p-12 text-center">
                            <div
                                class="w-16 h-16 mx-auto bg-gray-50 rounded-2xl flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                            </div>
                            <p class="text-sm text-gray-500 font-medium">Belum ada booking aktif</p>
                            <p class="text-xs text-gray-400 mt-1">Yuk jelajahi kamar kami dan booking sekarang!</p>
                            <a href="{{ route('index') }}#rooms" wire:navigate
                                class="btn-primary text-sm !px-5 !py-2.5 mt-4 inline-flex">
                                Jelajahi Kamar
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Quick Actions + Profile (1/3 width on desktop) -->
        <section class="space-y-6 animate-fade-in-up delay-5" id="sidebar-widgets">

            <!-- Quick Actions -->
            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5 sm:p-6">
                <h2 class="font-poppins font-bold text-lg text-foreground mb-4">Aksi Cepat</h2>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('index') }}#rooms" wire:navigate
                        class="group p-4 border border-gray-100 rounded-xl text-center hover:bg-primary hover:border-primary hover:shadow-red transition-all duration-300">
                        <div
                            class="w-10 h-10 mx-auto bg-primary/10 group-hover:bg-white/20 text-primary group-hover:text-white rounded-xl flex items-center justify-center mb-2 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </div>
                        <span
                            class="text-xs font-semibold text-gray-700 group-hover:text-white transition-colors">Lihat
                            Room</span>
                    </a>

                    <a href="{{ route('index') }}#rooms" wire:navigate
                        class="group p-4 border border-gray-100 rounded-xl text-center hover:bg-accent hover:border-accent hover:shadow-gold transition-all duration-300">
                        <div
                            class="w-10 h-10 mx-auto bg-accent/10 group-hover:bg-white/20 text-accent-700 group-hover:text-white rounded-xl flex items-center justify-center mb-2 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-700 group-hover:text-white transition-colors">Book
                            Kamar</span>
                    </a>

                    <a href="{{ route('profile') }}" wire:navigate
                        class="group p-4 border border-gray-100 rounded-xl text-center hover:bg-blue-500 hover:border-blue-500 transition-all duration-300">
                        <div
                            class="w-10 h-10 mx-auto bg-blue-50 group-hover:bg-white/20 text-blue-600 group-hover:text-white rounded-xl flex items-center justify-center mb-2 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.5-1.632Z" />
                            </svg>
                        </div>
                        <span
                            class="text-xs font-semibold text-gray-700 group-hover:text-white transition-colors">Profil</span>
                    </a>

                    <a href="#booking-history"
                        class="group p-4 border border-gray-100 rounded-xl text-center hover:bg-emerald-500 hover:border-emerald-500 transition-all duration-300">
                        <div
                            class="w-10 h-10 mx-auto bg-emerald-50 group-hover:bg-white/20 text-emerald-600 group-hover:text-white rounded-xl flex items-center justify-center mb-2 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                        <span
                            class="text-xs font-semibold text-gray-700 group-hover:text-white transition-colors">Riwayat</span>
                    </a>
                </div>
            </div>

            <!-- Profile Card -->
            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5 sm:p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-primary text-white flex items-center justify-center text-lg font-bold shadow-red">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-sm font-semibold text-foreground truncate">{{ $user->name }}</h3>
                        <p class="text-xs text-gray-400">Member sejak {{ $user->created_at->format('M Y') }}</p>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center gap-2.5 text-sm">
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                        <span class="text-gray-600 truncate">{{ $user->email }}</span>
                    </div>

                    @if ($user->phone)
                        <div class="flex items-center gap-2.5 text-sm">
                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                            </svg>
                            <span class="text-gray-600">{{ $user->phone }}</span>
                        </div>
                    @endif

                    @if ($user->address)
                        <div class="flex items-start gap-2.5 text-sm">
                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                            <span class="text-gray-600 line-clamp-2">{{ $user->address }}</span>
                        </div>
                    @endif
                </div>

                <a href="{{ route('profile') }}" wire:navigate
                    class="mt-4 w-full inline-flex items-center justify-center gap-1.5 px-4 py-2.5 text-sm font-medium text-primary border border-primary/20 rounded-xl hover:bg-primary/5 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                    Edit Profil
                </a>
            </div>
        </section>
    </div>


    <!-- ===================================
       SECTION 5: Booking History
       =================================== -->
    <section class="animate-fade-in-up delay-6" id="booking-history">
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">
            <div
                class="p-5 sm:p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
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
                                        {{ $booking->room->name ?? 'Room' }}</h3>
                                    <p class="text-[11px] text-gray-400 mt-0.5">{{ $booking->booking_code }}</p>
                                </div>
                                @if ($booking->status === 'confirmed')
                                    <span class="badge-success text-[10px]">Confirmed</span>
                                @elseif($booking->status === 'pending')
                                    <span class="badge-warning text-[10px]">Pending</span>
                                @elseif($booking->status === 'cancelled')
                                    <span class="badge bg-red-50 text-red-600 text-[10px]">Cancelled</span>
                                @elseif($booking->status === 'completed')
                                    <span class="badge bg-gray-100 text-gray-600 text-[10px]">Selesai</span>
                                @else
                                    <span
                                        class="badge bg-gray-100 text-gray-600 text-[10px]">{{ ucfirst($booking->status) }}</span>
                                @endif
                            </div>
                            <div class="flex items-center justify-between text-xs text-gray-500">
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
                                    <td class="py-3.5 px-6 font-medium text-foreground">
                                        {{ $booking->room->name ?? '-' }}</td>
                                    <td class="py-3.5 px-6 text-gray-500">{{ $booking->check_in->format('d M') }} —
                                        {{ $booking->check_out->format('d M Y') }}</td>
                                    <td class="py-3.5 px-6 text-gray-500">{{ $booking->total_guests }} orang</td>
                                    <td class="py-3.5 px-6">
                                        @if ($booking->status === 'confirmed')
                                            <span class="badge-success">Confirmed</span>
                                        @elseif($booking->status === 'pending')
                                            <span class="badge-warning">Pending</span>
                                        @elseif($booking->status === 'cancelled')
                                            <span class="badge bg-red-50 text-red-600">Cancelled</span>
                                        @elseif($booking->status === 'completed')
                                            <span class="badge bg-gray-100 text-gray-600">Selesai</span>
                                        @else
                                            <span
                                                class="badge bg-gray-100 text-gray-600">{{ ucfirst($booking->status) }}</span>
                                        @endif
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
    </section>

</div>

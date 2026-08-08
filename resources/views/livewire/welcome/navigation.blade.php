{{-- <nav class="-mx-3 flex flex-1 justify-end">
    @auth
        <a href="{{ url('/dashboard') }}" wire:navigate
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
            Dashboard
        </a>
    @else
        <a href="{{ route('login') }}" wire:navigate
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
            Log in
        </a>

        @if (Route::has('register'))
            <a href="{{ route('register') }}" wire:navigate
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                Register
            </a>
        @endif
    @endauth
</nav> --}}

<nav id="navbar" x-data="{ scrolled: false }" @scroll.window="scrolled = window.scrollY > 80"
    :class="scrolled ? 'shadow-lg  backdrop-blur-md bg-red-600/90 ' : 'bg-transparent backdrop-blur-md  backdrop-brightness-50'"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 ">
    <div class=" max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 ">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <a href="/" class="flex items-center gap-3 group" aria-label="Sitio Tio Resort Home">
                <div
                    class="w-10 h-10 bg-gradient-primary rounded-2xl flex items-center justify-center shadow-red group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5M10.5 21V8.121c0-.312.11-.611.308-.848l4.692-5.58a.75.75 0 0 1 1.149.024l4.469 5.404c.18.217.282.5.282.79V21m-14.4 0H3.75c-.621 0-1.125-.504-1.125-1.125v-6.75c0-.621.504-1.125 1.125-1.125h3.375" />
                    </svg>
                </div>
                <div>
                    <span
                        class="text-xl font-poppins font-bold text-white group-hover:text-accent transition-colors">Sitio
                        Tio</span>
                    <span class="block text-[10px] font-inter uppercase tracking-[3px] text-white/70">Resort &
                        Spa</span>
                </div>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center gap-1">
                <a href="/" wire:navigate
                    class="px-4 py-2 text-sm font-medium text-white hover:text-red-600 transition-colors rounded-xl hover:bg-white"
                    aria-current="page">Home</a>
                <a href="/pages/rooms.html" wire:navigate
                    class="px-4 py-2 text-sm font-medium text-white/80 hover:text-red-600 transition-colors rounded-xl hover:bg-white">Rooms</a>
                <a href="/pages/booking.html" wire:navigate
                    class="px-4 py-2 text-sm font-medium text-white/80 hover:text-red-600 transition-colors rounded-xl hover:bg-white">Booking</a>
                <a href="/pages/dashboard.html" wire:navigate
                    class="px-4 py-2 text-sm font-medium text-white/80 hover:text-red-600 transition-colors rounded-xl hover:bg-white">My
                    Bookings</a>
                <div class="w-px h-6 bg-white/20 mx-2"></div>
                @auth
                    <a href="{{ route('dashboard') }}" wire:navigate class="btn-accent text-sm !px-5 !py-2.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                        My Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" wire:navigate class="btn-accent text-sm !px-5 !py-2.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                        Book Now
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Toggle -->
            <button id="mobile-menu-toggle"
                class="lg:hidden p-2 text-white hover:bg-white/10 rounded-xl transition-colors"
                aria-label="Open navigation menu">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu-overlay"
        class="fixed h-screen top-0 right-0 w-full inset-0 bg-black/50 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden">
    </div>

    <!-- Mobile Menu Drawer -->
    <div id="mobile-menu"
        class="fixed h-screen top-0 right-0 w-80 max-w-[85vw] bg-white shadow-2xl  translate-x-full transition-transform duration-300 ease-out lg:hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gradient-primary rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5M10.5 21V8.121c0-.312.11-.611.308-.848l4.692-5.58a.75.75 0 0 1 1.149.024l4.469 5.404c.18.217.282.5.282.79V21m-14.4 0H3.75c-.621 0-1.125-.504-1.125-1.125v-6.75c0-.621.504-1.125 1.125-1.125h3.375" />
                        </svg>
                    </div>
                    <span class="font-poppins font-bold text-foreground">Sitio Tio</span>
                </div>
                <button id="mobile-menu-close" class="p-2 hover:bg-gray-100 rounded-xl transition-colors"
                    aria-label="Close navigation menu">
                    <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="space-y-1" aria-label="Mobile navigation">
                <a href="/"
                    class="flex items-center gap-3 px-4 py-3 text-primary bg-primary/5 rounded-2xl font-medium"
                    aria-current="page">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m2.25 12 8.954-8.955a1.126 1.126 0 0 1 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Home
                </a>
                <a href="/pages/rooms.html"
                    class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:text-primary hover:bg-primary/5 rounded-2xl transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                    Rooms
                </a>
                <a href="/pages/booking.html"
                    class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:text-primary hover:bg-primary/5 rounded-2xl transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                    Booking
                </a>
                <a href="/pages/dashboard.html"
                    class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:text-primary hover:bg-primary/5 rounded-2xl transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    My Bookings
                </a>
            </nav>

            <div class="mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('login') }}" wire:navigate class="btn-primary w-full text-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                    Book Now
                </a>
            </div>
        </div>
    </div>
</nav>

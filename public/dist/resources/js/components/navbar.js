export function renderNavbar(activePage = 'home') {
  return `
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md shadow-soft transition-all duration-500">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
          <a href="/" class="flex items-center gap-3 group">
            <div class="w-10 h-10 bg-gradient-primary rounded-2xl flex items-center justify-center shadow-red group-hover:scale-110 transition-transform duration-300">
              <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5M10.5 21V8.121c0-.312.11-.611.308-.848l4.692-5.58a.75.75 0 0 1 1.149.024l4.469 5.404c.18.217.282.5.282.79V21m-14.4 0H3.75c-.621 0-1.125-.504-1.125-1.125v-6.75c0-.621.504-1.125 1.125-1.125h3.375" /></svg>
            </div>
            <div>
              <span class="text-xl font-poppins font-bold text-foreground group-hover:text-primary transition-colors">Sitio Tio</span>
              <span class="block text-[10px] font-inter uppercase tracking-[3px] text-gray-400">Resort & Spa</span>
            </div>
          </a>
          <div class="hidden lg:flex items-center gap-1">
            <a href="/" class="px-4 py-2 text-sm font-medium ${activePage === 'home' ? 'text-primary bg-primary/5' : 'text-gray-600 hover:text-primary hover:bg-primary/5'} transition-colors rounded-xl" ${activePage === 'home' ? 'aria-current="page"' : ''}>Home</a>
            <a href="/pages/rooms.html" class="px-4 py-2 text-sm font-medium ${activePage === 'rooms' ? 'text-primary bg-primary/5' : 'text-gray-600 hover:text-primary hover:bg-primary/5'} transition-colors rounded-xl" ${activePage === 'rooms' ? 'aria-current="page"' : ''}>Rooms</a>
            <a href="/pages/booking.html" class="px-4 py-2 text-sm font-medium ${activePage === 'booking' ? 'text-primary bg-primary/5' : 'text-gray-600 hover:text-primary hover:bg-primary/5'} transition-colors rounded-xl" ${activePage === 'booking' ? 'aria-current="page"' : ''}>Booking</a>
            <a href="/pages/dashboard.html" class="px-4 py-2 text-sm font-medium ${activePage === 'dashboard' ? 'text-primary bg-primary/5' : 'text-gray-600 hover:text-primary hover:bg-primary/5'} transition-colors rounded-xl" ${activePage === 'dashboard' ? 'aria-current="page"' : ''}>My Bookings</a>
            <div class="w-px h-6 bg-gray-200 mx-2"></div>
            <a href="/pages/booking.html" class="btn-accent text-sm !px-5 !py-2.5">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
              Book Now
            </a>
          </div>
          <button id="mobile-menu-toggle" class="lg:hidden p-2 text-gray-600 hover:bg-gray-100 rounded-xl transition-colors" aria-label="Open menu">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
          </button>
        </div>
      </div>
      <div id="mobile-menu-overlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden"></div>
      <div id="mobile-menu" class="fixed top-0 right-0 h-full w-80 max-w-[85vw] bg-white shadow-2xl translate-x-full transition-transform duration-300 ease-out lg:hidden">
        <div class="p-6">
          <div class="flex items-center justify-between mb-8">
            <span class="font-poppins font-bold text-foreground">Menu</span>
            <button id="mobile-menu-close" class="p-2 hover:bg-gray-100 rounded-xl" aria-label="Close menu">
              <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
            </button>
          </div>
          <nav class="space-y-1">
            <a href="/" class="flex items-center gap-3 px-4 py-3 ${activePage === 'home' ? 'text-primary bg-primary/5 font-medium' : 'text-gray-600 hover:text-primary hover:bg-primary/5'} rounded-2xl transition-colors" ${activePage === 'home' ? 'aria-current="page"' : ''}>Home</a>
            <a href="/pages/rooms.html" class="flex items-center gap-3 px-4 py-3 ${activePage === 'rooms' ? 'text-primary bg-primary/5 font-medium' : 'text-gray-600 hover:text-primary hover:bg-primary/5'} rounded-2xl transition-colors" ${activePage === 'rooms' ? 'aria-current="page"' : ''}>Rooms</a>
            <a href="/pages/booking.html" class="flex items-center gap-3 px-4 py-3 ${activePage === 'booking' ? 'text-primary bg-primary/5 font-medium' : 'text-gray-600 hover:text-primary hover:bg-primary/5'} rounded-2xl transition-colors" ${activePage === 'booking' ? 'aria-current="page"' : ''}>Booking</a>
            <a href="/pages/dashboard.html" class="flex items-center gap-3 px-4 py-3 ${activePage === 'dashboard' ? 'text-primary bg-primary/5 font-medium' : 'text-gray-600 hover:text-primary hover:bg-primary/5'} rounded-2xl transition-colors" ${activePage === 'dashboard' ? 'aria-current="page"' : ''}>My Bookings</a>
          </nav>
          <div class="mt-8 pt-6 border-t border-gray-100">
            <a href="/pages/booking.html" class="btn-primary w-full text-center">Book Now</a>
          </div>
        </div>
      </div>
    </nav>
  `;
}

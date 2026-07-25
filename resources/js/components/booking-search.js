export function renderBookingSearch() {
  return `
    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-24 z-20 animate-fade-in-up" style="animation-delay: 0.6s;">
      <div class="glass rounded-3xl p-6 shadow-soft-xl border border-white/50 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-white/40 to-white/10"></div>
        <form action="/pages/rooms.html" class="relative flex flex-col md:flex-row items-center gap-4">
          
          <div class="flex-1 w-full flex flex-col md:border-r border-gray-200/50 pr-4">
            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 flex items-center gap-1">
              <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
              Check-in
            </label>
            <input type="date" class="w-full bg-transparent text-foreground font-poppins font-medium focus:outline-none placeholder:text-gray-400" required />
          </div>

          <div class="flex-1 w-full flex flex-col md:border-r border-gray-200/50 px-4">
            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 flex items-center gap-1">
              <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
              Check-out
            </label>
            <input type="date" class="w-full bg-transparent text-foreground font-poppins font-medium focus:outline-none placeholder:text-gray-400" required />
          </div>

          <div class="flex-1 w-full flex flex-col px-4">
            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 flex items-center gap-1">
              <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
              Guests & Rooms
            </label>
            <select class="w-full bg-transparent text-foreground font-poppins font-medium focus:outline-none appearance-none cursor-pointer">
              <option>1 Room, 2 Guests</option>
              <option>1 Room, 3 Guests</option>
              <option>2 Rooms, 4 Guests</option>
              <option>2 Rooms, 5+ Guests</option>
            </select>
          </div>

          <div class="w-full md:w-auto mt-4 md:mt-0 pl-0 md:pl-4">
            <button type="submit" class="btn-primary w-full md:w-auto !py-4 shadow-red hover:-translate-y-1">
              Check Availability
            </button>
          </div>
        </form>
      </div>
    </div>
  `;
}

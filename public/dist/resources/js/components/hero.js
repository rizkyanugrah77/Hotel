export function renderHero() {
  return `
    <header class="relative min-h-screen flex items-center pt-20 overflow-hidden">
      <!-- Background elements -->
      <div class="absolute inset-0 z-0">
        <img src="/resources/assets/images/hero.png" alt="Sitio Tio Resort Lake Toba" class="w-full h-full object-cover animate-scale-up" />
        <!-- Overlay gradients -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-background via-transparent to-black/30"></div>
        <!-- Batak pattern overlay -->
        <div class="absolute inset-0 batak-pattern opacity-10"></div>
      </div>

      <!-- Content -->
      <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="max-w-3xl">
          <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-sm font-medium mb-6 animate-fade-in-up" style="animation-delay: 0.1s;">
            <span class="w-2 h-2 rounded-full bg-accent animate-pulse"></span>
            Discover Samosir's Crown Jewel
          </div>
          
          <h1 class="text-5xl md:text-7xl font-poppins font-bold text-white leading-tight mb-6 animate-fade-in-up" style="animation-delay: 0.2s;">
            Where <span class="text-gradient-accent">Heritage</span> Meets <br>Modern Luxury
          </h1>
          
          <p class="text-lg md:text-xl text-gray-200 mb-10 max-w-2xl animate-fade-in-up leading-relaxed" style="animation-delay: 0.3s;">
            Experience the majestic beauty of Lake Toba in an exclusive sanctuary inspired by traditional Batak architecture, designed for the modern traveler.
          </p>

          <div class="flex flex-wrap items-center gap-4 animate-fade-in-up" style="animation-delay: 0.4s;">
            <a href="/pages/rooms.html" class="btn-primary !px-8 !py-4 text-lg shadow-red hover:shadow-xl hover:shadow-primary/40">
              Explore Our Rooms
            </a>
            <a href="#video-tour" class="btn-outline text-white border-white/30 hover:bg-white/10 hover:border-white flex items-center gap-2 !px-6 !py-4">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
              Watch Video
            </a>
          </div>
        </div>
      </div>

      <!-- Scroll Indicator -->
      <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-10 flex flex-col items-center gap-2 animate-fade-in-up" style="animation-delay: 0.8s;">
        <span class="text-white/60 text-xs tracking-[0.2em] uppercase font-medium">Scroll to discover</span>
        <div class="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center p-1">
          <div class="w-1 h-2 bg-white rounded-full animate-float"></div>
        </div>
      </div>
    </header>
  `;
}

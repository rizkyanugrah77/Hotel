export function renderFooter() {
  return `
    <footer class="bg-gradient-dark text-white">
      <div class="batak-ornament w-full"></div>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8">
          <div class="lg:col-span-1 space-y-6">
            <a href="/" class="flex items-center gap-3">
              <div class="w-10 h-10 bg-gradient-primary rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5M10.5 21V8.121c0-.312.11-.611.308-.848l4.692-5.58a.75.75 0 0 1 1.149.024l4.469 5.404c.18.217.282.5.282.79V21m-14.4 0H3.75c-.621 0-1.125-.504-1.125-1.125v-6.75c0-.621.504-1.125 1.125-1.125h3.375" /></svg>
              </div>
              <div>
                <span class="text-xl font-poppins font-bold text-white">Sitio Tio</span>
                <span class="block text-[10px] font-inter uppercase tracking-[3px] text-white/50">Resort & Spa</span>
              </div>
            </a>
            <p class="text-white/60 text-sm leading-relaxed">
              Experience the pinnacle of luxury infused with the rich cultural heritage of Batak Samosir, set against the breathtaking backdrop of Lake Toba.
            </p>
          </div>

          <div>
            <h3 class="text-lg font-poppins font-bold mb-6 flex items-center gap-2">
              <span class="w-2 h-2 rounded-full bg-accent"></span>
              Quick Links
            </h3>
            <ul class="space-y-4">
              <li><a href="/" class="text-white/60 hover:text-accent transition-colors text-sm flex items-center gap-2 group"><svg class="w-3 h-3 opacity-0 -ml-5 group-hover:opacity-100 group-hover:ml-0 transition-all" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>Home</a></li>
              <li><a href="/pages/rooms.html" class="text-white/60 hover:text-accent transition-colors text-sm flex items-center gap-2 group"><svg class="w-3 h-3 opacity-0 -ml-5 group-hover:opacity-100 group-hover:ml-0 transition-all" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>Our Rooms</a></li>
              <li><a href="#facilities" class="text-white/60 hover:text-accent transition-colors text-sm flex items-center gap-2 group"><svg class="w-3 h-3 opacity-0 -ml-5 group-hover:opacity-100 group-hover:ml-0 transition-all" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>Facilities</a></li>
              <li><a href="#gallery" class="text-white/60 hover:text-accent transition-colors text-sm flex items-center gap-2 group"><svg class="w-3 h-3 opacity-0 -ml-5 group-hover:opacity-100 group-hover:ml-0 transition-all" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>Gallery</a></li>
            </ul>
          </div>

          <div>
            <h3 class="text-lg font-poppins font-bold mb-6 flex items-center gap-2">
              <span class="w-2 h-2 rounded-full bg-accent"></span>
              Support
            </h3>
            <ul class="space-y-4">
              <li><a href="#" class="text-white/60 hover:text-accent transition-colors text-sm">Contact Us</a></li>
              <li><a href="#" class="text-white/60 hover:text-accent transition-colors text-sm">FAQ</a></li>
              <li><a href="#" class="text-white/60 hover:text-accent transition-colors text-sm">Privacy Policy</a></li>
              <li><a href="#" class="text-white/60 hover:text-accent transition-colors text-sm">Terms of Service</a></li>
            </ul>
          </div>

          <div>
            <h3 class="text-lg font-poppins font-bold mb-6 flex items-center gap-2">
              <span class="w-2 h-2 rounded-full bg-accent"></span>
              Contact Info
            </h3>
            <ul class="space-y-4">
              <li class="flex items-start gap-3 text-white/60 text-sm">
                <svg class="w-5 h-5 text-accent shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
                <span>Jl. Lingkar Tuk-Tuk, Samosir Island,<br>North Sumatra, Indonesia</span>
              </li>
              <li class="flex items-center gap-3 text-white/60 text-sm">
                <svg class="w-5 h-5 text-accent shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.73-1.379-5.039-3.688-6.418-6.418l1.293-.97c.362-.271.527-.733.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" /></svg>
                <span>+62 811-2233-4455</span>
              </li>
              <li class="flex items-center gap-3 text-white/60 text-sm">
                <svg class="w-5 h-5 text-accent shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /></svg>
                <span>hello@sitiotio.com</span>
              </li>
            </ul>
          </div>
        </div>

        <div class="mt-16 pt-8 border-t border-white/10 flex flex-col md:flex-row items-center justify-between gap-4">
          <p class="text-white/40 text-sm">© 2026 Sitio Tio Resort. All rights reserved.</p>
          <div class="flex gap-4">
            <!-- Social Icons (Placeholders) -->
            <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-white/60 hover:bg-primary hover:text-white transition-all"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
            <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-white/60 hover:bg-primary hover:text-white transition-all"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>
            <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-white/60 hover:bg-primary hover:text-white transition-all"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/></svg></a>
          </div>
        </div>
      </div>
    </footer>
  `;
}

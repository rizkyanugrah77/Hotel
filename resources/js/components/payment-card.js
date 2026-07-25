export function renderPaymentCard() {
  return `
    <div class="w-full max-w-sm mx-auto h-48 bg-gradient-dark rounded-2xl p-6 text-white shadow-xl relative overflow-hidden mb-8 group">
      <div class="absolute -right-4 -top-4 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition-colors duration-500"></div>
      <div class="absolute -left-4 -bottom-4 w-24 h-24 bg-accent/20 rounded-full blur-xl group-hover:bg-accent/40 transition-colors duration-500"></div>
      
      <div class="relative z-10 h-full flex flex-col justify-between">
        <div class="flex justify-between items-center">
          <svg class="w-8 h-8 opacity-70" viewBox="0 0 24 24" fill="currentColor"><path d="M21 4H3C1.895 4 1 4.895 1 6V18C1 19.105 1.895 20 3 20H21C22.105 20 23 19.105 23 18V6C23 4.895 22.105 4 21 4ZM21 18H3V12H21V18ZM21 8H3V6H21V8Z"/></svg>
          <div class="flex gap-2">
            <div class="w-6 h-6 rounded-full bg-red-500/80"></div>
            <div class="w-6 h-6 rounded-full bg-yellow-500/80 -ml-4 mix-blend-multiply"></div>
          </div>
        </div>
        <div>
          <p class="font-mono text-lg tracking-widest opacity-90 mb-2">•••• •••• •••• 4242</p>
          <div class="flex justify-between items-end text-xs opacity-70">
            <p class="uppercase tracking-wider font-medium">John Doe</p>
            <p class="font-mono">12/28</p>
          </div>
        </div>
      </div>
    </div>
  `;
}

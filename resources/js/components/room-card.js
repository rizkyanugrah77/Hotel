export function renderRoomCard(room) {
  return `
    <div class="card group animate-on-scroll">
      <div class="relative img-zoom rounded-t-3xl">
        <img src="${room.image}" alt="${room.name}" class="w-full h-64 object-cover" loading="lazy" />
        ${room.badge ? `<div class="absolute top-4 left-4"><span class="${room.badgeClass}">${room.badge}</span></div>` : ''}
        <div class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-sm rounded-2xl px-4 py-2 shadow-soft">
          <span class="text-xs text-gray-500">From</span>
          <span class="text-lg font-poppins font-bold text-primary ml-1">${room.price}</span>
          <span class="text-xs text-gray-500">/night</span>
        </div>
      </div>
      <div class="p-6">
        <h3 class="text-xl font-poppins font-bold text-foreground group-hover:text-primary transition-colors">${room.name}</h3>
        <p class="text-sm text-gray-500 mt-2 line-clamp-2">${room.description}</p>
        <div class="flex flex-wrap items-center gap-4 mt-4 text-xs text-gray-500 font-medium">
          <span class="flex items-center gap-1">
            <svg class="w-4 h-4 text-primary/70" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
            ${room.guests}
          </span>
          <span class="flex items-center gap-1">
            <svg class="w-4 h-4 text-primary/70" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" /></svg>
            ${room.size}
          </span>
          <span class="flex items-center gap-1">
            <svg class="w-4 h-4 text-primary/70" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 0 1 7.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 0 1 1.06 0Z" /></svg>
            ${room.view}
          </span>
        </div>
        <div class="mt-6 flex gap-3">
          <a href="/pages/room-detail.html" class="btn-outline flex-1 text-sm !py-2.5 text-center">View Details</a>
          <a href="/pages/booking.html" class="btn-primary flex-1 text-sm !py-2.5 text-center">Book Now</a>
        </div>
      </div>
    </div>
  `;
}

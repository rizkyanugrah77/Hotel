export function renderGalleryItem(imageSrc, altText, size = 'small') {
  const spanClass = size === 'large' ? 'md:col-span-2 md:row-span-2' : '';
  
  return `
    <div class="relative group rounded-3xl overflow-hidden cursor-pointer ${spanClass} h-64 md:h-auto min-h-[250px]" data-gallery-item>
      <img src="${imageSrc}" alt="${altText}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy" />
      <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
      <div class="absolute inset-0 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-500 translate-y-4 group-hover:translate-y-0">
        <div class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white border border-white/40 mb-3 shadow-lg">
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" /></svg>
        </div>
        <p class="text-white font-poppins font-medium tracking-wide">${altText}</p>
      </div>
    </div>
  `;
}

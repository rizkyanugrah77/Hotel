export function renderFacilityCard(facility) {
  return `
    <div class="card p-6 md:p-8 group hover:-translate-y-2 transition-transform duration-500 animate-on-scroll">
      <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mb-6 group-hover:bg-primary group-hover:text-white group-hover:scale-110 transition-all duration-300 shadow-soft">
        ${facility.svgIcon}
      </div>
      <h3 class="text-xl font-poppins font-bold text-foreground mb-3">${facility.title}</h3>
      <p class="text-gray-500 text-sm leading-relaxed">${facility.description}</p>
    </div>
  `;
}

export function renderTestimonial(testimonial) {
  return `
    <div class="card p-8 md:p-10 relative animate-on-scroll shrink-0 w-[350px] md:w-[450px] snap-center">
      <div class="absolute top-8 right-8 text-primary/10">
        <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" /></svg>
      </div>
      <div class="flex text-accent mb-6">
        ${Array(5).fill('<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" /></svg>').join('')}
      </div>
      <p class="text-gray-600 text-lg italic mb-8 relative z-10 leading-relaxed">
        "${testimonial.content}"
      </p>
      <div class="flex items-center gap-4">
        <div class="w-14 h-14 rounded-full bg-gradient-accent text-white flex items-center justify-center font-bold text-xl shadow-soft">
          ${testimonial.initials}
        </div>
        <div>
          <h4 class="font-poppins font-bold text-foreground">${testimonial.name}</h4>
          <p class="text-sm text-gray-500">${testimonial.location}</p>
        </div>
      </div>
    </div>
  `;
}

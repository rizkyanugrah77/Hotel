      <div class="max-w-7xl mx-auto">
          <!-- Header -->
          <div class="text-center mb-10 sm:mb-14 animate-on-scroll">
              <div class="gold-line-center mb-4"></div>
              <h2 class="section-title">Resort <span class="text-gradient-accent">Gallery</span></h2>
              <p class="section-subtitle mx-auto mt-4">Take a visual journey through our stunning resort and its
                  breathtaking surroundings.</p>
          </div>

          <!-- Gallery Grid (Masonry-style) -->
          <div class="grid grid-cols-2 gap-3 sm:gap-4 md:grid-cols-4 md:auto-rows-[12rem]">
            @if ($featuredGalleries->count() > 0)
                   <div class="col-span-2 overflow-hidden rounded-2xl shadow-soft cursor-pointer group animate-on-scroll-scale md:col-span-2 md:row-span-2 md:rounded-3xl"
                       data-gallery-item>
                       @php $firstGallery = $featuredGalleries->first(); @endphp
                       <div class="relative aspect-[4/3] md:h-full md:aspect-auto">
                          <img src="{{ asset('assets/img/gallery/' . $firstGallery->image) }}"
                              alt="{{ $firstGallery->caption }} - Sitio Tio Resort"
                              class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                              loading="lazy" />
                          <div
                               class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent opacity-100 transition-opacity duration-300 md:opacity-0 md:group-hover:opacity-100">
                           </div>
                           <div
                               class="absolute bottom-3 left-3 right-3 text-white opacity-100 transition-opacity duration-300 md:bottom-4 md:left-4 md:right-4 md:opacity-0 md:group-hover:opacity-100">
                               <p class="font-poppins font-semibold">{{ $firstGallery->room->name ?? 'Resort' }}</p>
                               <p class="mt-0.5 text-xs text-white/80 line-clamp-2 sm:text-sm">{{ $firstGallery->caption }}</p>
                          </div>
                      </div>
                  </div>

                  @foreach ($featuredGalleries->skip(1)->take(4) as $index => $gallery)
                       <div class="overflow-hidden rounded-2xl shadow-soft cursor-pointer group animate-on-scroll-scale stagger-{{ $index + 1 }} md:rounded-3xl"
                           data-gallery-item>
                           <div class="relative aspect-square md:h-full md:aspect-auto">
                              <img src="{{ asset('assets/img/gallery/' . $gallery->image) }}"
                                  alt="{{ $gallery->caption }} - Sitio Tio Resort"
                                  class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                  loading="lazy" />
                              <div
                                  class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                              </div>
                          </div>
                      </div>
                  @endforeach

              @endif
          </div>
      </div>

      <div class="max-w-7xl mx-auto">
          <!-- Header -->
          <div class="text-center mb-14 animate-on-scroll">
              <div class="gold-line-center mb-4"></div>
              <h2 class="section-title">Resort <span class="text-gradient-accent">Gallery</span></h2>
              <p class="section-subtitle mx-auto mt-4">Take a visual journey through our stunning resort and its
                  breathtaking surroundings.</p>
          </div>

          <!-- Gallery Grid (Masonry-style) -->
          <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
              @if ($featuredGalleries->count() > 0)
                  <div class="md:col-span-2 md:row-span-2 rounded-3xl overflow-hidden shadow-soft cursor-pointer group animate-on-scroll-scale"
                      data-gallery-item>
                      @php $firstGallery = $featuredGalleries->first(); @endphp
                      <div class="relative h-full min-h-[300px] md:min-h-[400px]">
                          <img src="{{ asset('assets/img/gallery/' . $firstGallery->image) }}"
                              alt="{{ $firstGallery->caption }} - Sitio Tio Resort"
                              class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                              loading="lazy" />
                          <div
                              class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                          </div>
                          <div
                              class="absolute bottom-4 left-4 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                              <p class="font-poppins font-semibold">{{ $firstGallery->room->name ?? 'Resort' }}</p>
                              <p class="text-sm text-white/80">{{ $firstGallery->caption }}</p>
                          </div>
                      </div>
                  </div>

                  @foreach ($featuredGalleries->skip(1)->take(4) as $index => $gallery)
                      <div class="rounded-3xl overflow-hidden shadow-soft cursor-pointer group animate-on-scroll-scale stagger-{{ $index + 1 }}"
                          data-gallery-item>
                          <div class="relative h-48 md:h-full">
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

  <div class="max-w-7xl mx-auto">
      <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
          <!-- Image -->
          <div class="animate-on-scroll-left relative">
              <div class="rounded-3xl overflow-hidden shadow-soft-xl">
                  <img src="{{ asset('dist/resources/assets/images/restaurant.png') }}"
                      alt="Open-air dining at Sitio Tio Resort" class="w-full h-[400px] lg:h-[500px] object-cover"
                      loading="lazy" />
              </div>
              <!-- Floating accent card -->
              {{-- <div
                  class="absolute -bottom-6 -right-6 bg-white rounded-3xl p-5 shadow-soft-lg hidden md:block animate-float">
                  <div class="flex items-center gap-3">
                      <div class="w-12 h-12 bg-accent/10 rounded-2xl flex items-center justify-center">
                          <svg class="w-6 h-6 text-accent" fill="currentColor" viewBox="0 0 24 24">
                              <path
                                  d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                          </svg>
                      </div>
                      <div>
                          <div class="text-xl font-poppins font-bold text-foreground">4.9</div>
                          <div class="text-xs text-gray-500">Guest Rating</div>
                      </div>
                  </div>
              </div> --}}
          </div>

          <!-- Content -->
          <div class="animate-on-scroll-right">
              <div class="gold-line mb-4"></div>
              <h2 class="section-title">A Paradise Rooted in <span class="text-gradient-primary">Lake Toba</span>
              </h2>
              {{-- <p class="section-subtitle mt-4">
                  Sitio Tio Resort is more than a hotel — it's a cultural journey, offering an experience that
                  nourishes both body and soul.
              </p> --}}
              <div class="grid grid-cols-2 gap-4 mt-8">
                  <div class="flex items-start gap-3">
                      <div
                          class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                          <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                              stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                              <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                          </svg>
                      </div>
                      <div>
                          <h3 class="font-poppins font-semibold text-foreground text-sm">Lakeside Location</h3>
                          <p class="text-xs text-gray-500 mt-1">Direct access to Lake Toba shores</p>
                      </div>
                  </div>
                  <div class="flex items-start gap-3">
                      <div
                          class="w-10 h-10 bg-accent/10 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                          <svg class="w-5 h-5 text-accent-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                              stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-1.5.75a3.354 3.354 0 0 1-3 0 3.354 3.354 0 0 0-3 0 3.354 3.354 0 0 1-3 0 3.354 3.354 0 0 0-3 0 3.354 3.354 0 0 1-3 0L3 16.5m15-3.379a48.474 48.474 0 0 0-6-.371c-2.032 0-4.034.126-6 .371m12 0c.39.049.777.102 1.163.16 1.07.16 1.837 1.094 1.837 2.175v5.169c0 .621-.504 1.125-1.125 1.125H4.125A1.125 1.125 0 0 1 3 20.625v-5.17c0-1.08.768-2.014 1.837-2.174A47.78 47.78 0 0 1 6 13.12" />
                          </svg>
                      </div>
                      <div>
                          <h3 class="font-poppins font-semibold text-foreground text-sm">Cultural Cuisine</h3>
                          <p class="text-xs text-gray-500 mt-1">Authentic local & international dishes</p>
                      </div>
                  </div>
                  <div class="flex items-start gap-3">
                      <div
                          class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                          <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                              stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                          </svg>
                      </div>
                      <div>
                          <h3 class="font-poppins font-semibold text-foreground text-sm">Premium Spa</h3>
                          <p class="text-xs text-gray-500 mt-1">Traditional healing treatments</p>
                      </div>
                  </div>
                  <div class="flex items-start gap-3">
                      <div
                          class="w-10 h-10 bg-accent/10 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                          <svg class="w-5 h-5 text-accent-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                              stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                          </svg>
                      </div>
                      <div>
                          <h3 class="font-poppins font-semibold text-foreground text-sm">Warm Hospitality</h3>
                          <p class="text-xs text-gray-500 mt-1">Heartfelt Samosir hospitality</p>
                      </div>
                  </div>
              </div>
              {{-- <a href="#rooms" class="btn-outline mt-3 inline-flex" wire:navigate>
                  Discover Our Rooms
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                  </svg>
              </a> --}}

              <div class="mt-4 w-full rounded-2xl overflow-hidden shadow-lg border border-gray-200 bg-white">
                  <iframe width="100%" height="160" frameborder="0" style="border:0; display:block;"
                      referrerpolicy="strict-origin-when-cross-origin" loading="lazy"
                      allow="fullscreen; accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d996.4115508159018!2d98.67438096487352!3d2.620457773852175!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3031c571e97ed373%3A0x6196bdd6b96c43e0!2sJl.%20Aek%20Rangat%20No.71%2C%20Siogung-Ogung%2C%20Kec.%20Pangururan%2C%20Kabupaten%20Samosir%2C%20Sumatera%20Utara!5e0!3m2!1sid!2sid!4v1788164260169!5m2!1sid!2sid"
                      width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                      referrerpolicy="strict-origin-when-cross-origin">
                  </iframe>
                  <a href="https://maps.app.goo.gl/KU8sb6zXcH3iyadc8" target="_blank" rel="noopener noreferrer"
                      class="flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-poppins font-semibold text-primary hover:bg-gray-50 transition-colors">
                      <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                          <path stroke-linecap="round" stroke-linejoin="round"
                              d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                      </svg>
                      Lihat Lokasi
                      <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                          stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round"
                              d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                      </svg>
                  </a>
              </div>
          </div>
      </div>
  </div>

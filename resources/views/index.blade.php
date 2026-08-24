<div>

    <!-- ===================================
       HERO SECTION
       =================================== -->
    <section id="hero" class="relative min-h-screen flex items-center overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="{{ asset('dist/resources/assets/images/hero.png') }}" alt="Sitio Tio Resort overlooking Lake Toba"
                class="w-full h-full object-cover" loading="eager" />
            <div class="absolute inset-0 bg-gradient-hero"></div>
        </div>

        <!-- Floating Batak Pattern -->
        <div class="absolute inset-0 batak-pattern opacity-20"></div>

        <!-- Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 lg:py-0 w-full">
            <div class="max-w-3xl pt-32 lg:-translate-y-20">
                <!-- Badge -->
                {{-- <div
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 mb-8 animate-fade-in">
                    <span class="w-2 h-2 bg-accent rounded-full animate-pulse-soft"></span>
                    <span class="text-sm text-white/90 font-inter">Samosir Island's Premier Retreat</span>
                </div> --}}

                <!-- Headline -->
                <h1 class="text-4xl sm:text-4xl md:text-6xl lg:text-7xl font-poppins font-bold text-white pt-5 leading-[1.1] mb-6 animate-fade-in"
                    style="animation-delay: 0.15s;">
                    Experience The
                    <span class="text-gradient-accent block mt-2">Magic of Lake Toba</span>
                    Like Never Before
                </h1>

                <!-- Subtitle -->
                <p class="text-md sm:text-lg text-white/80 font-inter leading-relaxed max-w-xl mb-8 animate-fade-in"
                    style="animation-delay: 0.3s;">
                    Nestled on the shores of Lake Toba, Sitio Tio Resort offers an unforgettable blend of traditional
                    Batak Samosir hospitality and modern luxury.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 animate-fade-in" style="animation-delay: 0.45s;">
                    <a href="/pages/rooms.html" class="btn-accent text-base !px-8 !py-4">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        Explore Rooms
                    </a>
                    <a href="#about"
                        class="inline-flex items-center justify-center gap-2 px-8 py-4 border-2 border-white/30 text-white font-poppins font-semibold rounded-2xl transition-all duration-300 hover:bg-white/10 hover:border-white/50 backdrop-blur-sm">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                        Learn More
                    </a>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-6 mt-10 max-w-md animate-fade-in" style="animation-delay: 0.6s;">
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl font-poppins font-bold text-white" data-counter="150">0</div>
                        <div class="text-xs sm:text-sm text-white/60 mt-1">Luxury Rooms</div>
                    </div>
                    <div class="text-center border-x border-white/20">
                        <div class="text-2xl sm:text-3xl font-poppins font-bold text-accent" data-counter="4800">0</div>
                        <div class="text-xs sm:text-sm text-white/60 mt-1">Happy Guests</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl font-poppins font-bold text-white" data-counter="15">0</div>
                        <div class="text-xs sm:text-sm text-white/60 mt-1">Awards Won</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Down Indicator -->
        <a href="#booking-search"
            class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-white/60 hover:text-white transition-colors animate-bounce-soft"
            aria-label="Scroll to booking search">
            <span class="text-xs font-inter uppercase tracking-widest">Scroll</span>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
            </svg>
        </a>
    </section>

    <!-- ===================================
       BOOKING SEARCH SECTION
       =================================== -->
    <section id="booking-search" class="relative -mt-20 z-20 px-4">
        @include('welcome.index.booking-form')
    </section>


    <!-- ===================================
       ABOUT SECTION
       =================================== -->
    <section id="about" class="section">
        @include('welcome.index.about')
    </section>


    <!-- ===================================
       FEATURED ROOMS
       =================================== -->
    <section id="rooms" class="section bg-gray-50/80">
        @include('welcome.index.rooms')
    </section>


    <!-- ===================================
       FACILITIES
       =================================== -->
    <section id="facilities" class="section">
        @include('welcome.index.facilities')
    </section>

    <!-- ===================================
       GALLERY
       =================================== -->
    <section id="gallery" class="section bg-gray-50/80">
        @include('welcome.index.galleries')
        <!-- Lightbox -->
        <div id="gallery-lightbox"
            class="fixed inset-0 z-50 bg-black/90 backdrop-blur-sm flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
            <button id="lightbox-close" class="absolute top-6 right-6 text-white hover:text-accent transition-colors"
                aria-label="Close lightbox">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
            <img id="lightbox-img" src="" alt="Gallery image expanded"
                class="max-w-[90vw] max-h-[85vh] object-contain rounded-2xl shadow-2xl" />
        </div>
    </section>


    <!-- ===================================
       TESTIMONIALS
       =================================== -->
    {{-- <section id="testimonials" class="section overflow-hidden">
        <livewire:welcome.testimonial />
    </section> --}}


    <!-- ===================================
       CTA SECTION
       =================================== -->
    <section class="relative py-24 md:py-32 overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ asset('dist/resources/assets/images/pool.png') }}" alt=""
                class="w-full h-full object-cover" loading="lazy" aria-hidden="true" />
            <div class="absolute inset-0 bg-gradient-hero"></div>
        </div>
        <div class="absolute inset-0 batak-pattern opacity-10"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 text-center animate-on-scroll">
            <div
                class="inline-flex items-center gap-2 px-4 py-2 bg-accent/15 backdrop-blur-md rounded-full border border-accent/40 mb-6 shadow-lg shadow-black/10">
                <span class="relative flex h-2 w-2">
                    <span
                        class="absolute inline-flex h-full w-full rounded-full bg-accent opacity-75 animate-ping"></span>
                    <span class="relative inline-flex h-2 w-2 rounded-full bg-accent"></span>
                </span>
                <svg class="w-4 h-4 text-accent" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path
                        d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                </svg>
                <span class="text-xs font-poppins font-semibold tracking-[0.18em] text-white uppercase">Penawaran
                    Spesial</span>
            </div>
            @if ($promos->count() > 0)
                <p class="text-sm md:text-base font-medium tracking-wide text-white/80 mb-3">Liburan impian di Samosir
                    kini lebih hemat</p>
                <h2
                    class="text-4xl md:text-6xl lg:text-7xl font-poppins font-bold text-white leading-[1.05] tracking-tight">
                    {{ $promos->first()->name }}
                    <span class="block mt-2 text-gradient-accent">{{ $promos->first()->description }}</span>
                </h2>
            @else
                <p class="text-sm md:text-base font-medium tracking-wide text-white/80 mb-3">Waktunya berhenti
                    membayangkan dan mulai berlibur</p>
                <h2
                    class="text-4xl md:text-6xl lg:text-7xl font-poppins font-bold text-white leading-[1.05] tracking-tight">
                    Your Dream Lakeside
                    <span class="block mt-2 text-gradient-accent">Escape Awaits</span>
                </h2>
            @endif
            @if ($promos->count() > 0)
                <div
                    class="inline-flex items-center gap-3 mt-7 px-5 py-3 rounded-2xl bg-black/20 border border-dashed border-white/50 backdrop-blur-sm">
                    <span class="text-sm text-white/75">Gunakan kode</span>
                    <span
                        class="font-poppins font-bold tracking-[0.16em] text-accent">{{ $promos->first()->code }}</span>
                </div>
            @else
                <p class="text-lg text-white/80 mt-6 max-w-2xl mx-auto leading-relaxed">
                    Book your stay today and enjoy 20% off for early reservations. Experience the magic of Samosir
                    Island
                    with world-class luxury.
                </p>
            @endif
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mt-9">
                @if ($promos->count() > 0)
                    <a href="{{ route('view-rooms') }}" wire:navigate
                        class="btn-accent text-base !px-8 !py-4 shadow-xl shadow-black/25 hover:scale-[1.03]">
                        Pesan Sekarang, Hemat
                        <span
                            class="font-bold">{{ $promos->first()->discount_type == 'percentage' ? $promos->first()->discount_value . '%' : 'Rp' . number_format($promos->first()->discount_value, '0', ',', '.') }}</span>
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                @else
                    <a href="{{ route('view-rooms') }}" wire:navigate
                        class="inline-flex items-center justify-center gap-2 px-10 py-4 border-2 border-white/30 text-white font-poppins font-semibold rounded-2xl transition-all duration-300 hover:bg-white/10 hover:-translate-y-0.5 backdrop-blur-sm">
                        Lihat Ketersediaan Kamar
                    </a>
                @endif
            </div>
            {{-- <p class="mt-6 text-sm text-white/65">Pemandangan dan kenyamanan terbaik menanti Anda di tepi Danau Toba.</p> --}}
        </div>
    </section>


    <!-- ===================================
       FOOTER
       =================================== -->
    <footer class="bg-gradient-dark ">
        <!-- Batak Ornament Border -->
        <div class="batak-ornament w-full"></div>

        @include('welcome.footer')
    </footer>


    <!-- ===================================
       BACK TO TOP
       =================================== -->
    <button id="back-to-top"
        class="fixed bottom-6 right-6 z-40 w-12 h-12 bg-primary text-white rounded-2xl shadow-red flex items-center justify-center opacity-0 pointer-events-none translate-y-4 transition-all duration-300 hover:bg-secondary hover:-translate-y-1"
        aria-label="Back to top">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
        </svg>
    </button>


</div>

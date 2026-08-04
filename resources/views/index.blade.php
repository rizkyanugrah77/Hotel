<x-guest-layout>

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
            <div class="max-w-3xl pt-10">
                <!-- Badge -->
                {{-- <div
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 mb-8 animate-fade-in">
                    <span class="w-2 h-2 bg-accent rounded-full animate-pulse-soft"></span>
                    <span class="text-sm text-white/90 font-inter">Samosir Island's Premier Retreat</span>
                </div> --}}

                <!-- Headline -->
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-poppins font-bold text-white leading-[1.1] mb-6 animate-fade-in"
                    style="animation-delay: 0.15s;">
                    Experience The
                    <span class="text-gradient-accent block mt-2">Magic of Lake Toba</span>
                    Like Never Before
                </h1>

                {{-- <!-- Subtitle -->
                <p class="text-lg sm:text-xl text-white/80 font-inter leading-relaxed max-w-xl mb-10 animate-fade-in"
                    style="animation-delay: 0.3s;">
                    Nestled on the shores of Lake Toba, Sitio Tio Resort offers an unforgettable blend of traditional
                    Batak Samosir hospitality and modern luxury.
                </p> --}}

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
                <div class="grid grid-cols-3 gap-6 mt-16 max-w-md animate-fade-in" style="animation-delay: 0.6s;">
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
        <livewire:welcome.booking-form />
    </section>


    <!-- ===================================
       ABOUT SECTION
       =================================== -->
    <section id="about" class="section">
        <livewire:welcome.about />
    </section>


    <!-- ===================================
       FEATURED ROOMS
       =================================== -->
    <section id="rooms" class="section bg-gray-50/80">
        <livewire:welcome.rooms />
    </section>


    <!-- ===================================
       FACILITIES
       =================================== -->
    <section id="facilities" class="section">
        <livewire:welcome.facilities />
    </section>

    <!-- ===================================
       GALLERY
       =================================== -->
    <section id="gallery" class="section bg-gray-50/80">
        <livewire:welcome.galleries />

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
    <section id="testimonials" class="section overflow-hidden">
        <livewire:welcome.testimonial />
    </section>


    <!-- ===================================
       CTA SECTION
       =================================== -->
    <section class="relative py-24 md:py-32 overflow-hidden">
        <div class="absolute inset-0">
            <img src="/resources/assets/images/pool.png" alt="" class="w-full h-full object-cover"
                loading="lazy" aria-hidden="true" />
            <div class="absolute inset-0 bg-gradient-hero"></div>
        </div>
        <div class="absolute inset-0 batak-pattern opacity-10"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 text-center animate-on-scroll">
            <div
                class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 mb-6">
                <svg class="w-4 h-4 text-accent" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                </svg>
                <span class="text-sm text-white/90">Limited Time Offer</span>
            </div>
            <h2 class="text-3xl md:text-5xl lg:text-6xl font-poppins font-bold text-white leading-tight">
                Your Dream Lakeside <br class="hidden sm:block" />
                <span class="text-gradient-accent">Escape Awaits</span>
            </h2>
            <p class="text-lg text-white/80 mt-6 max-w-2xl mx-auto">
                Book your stay today and enjoy 20% off for early reservations. Experience the magic of Samosir Island
                with world-class luxury.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 mt-10">
                <a href="/pages/booking.html" class="btn-accent text-base !px-10 !py-4">
                    Book Now — Save 20%
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>
                <a href="/pages/rooms.html"
                    class="inline-flex items-center justify-center gap-2 px-10 py-4 border-2 border-white/30 text-white font-poppins font-semibold rounded-2xl transition-all duration-300 hover:bg-white/10 backdrop-blur-sm">
                    View Rooms
                </a>
            </div>
        </div>
    </section>


    <!-- ===================================
       FOOTER
       =================================== -->
    <footer class="bg-gradient-dark text-white">
        <!-- Batak Ornament Border -->
        <div class="batak-ornament w-full"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <!-- About -->
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-gradient-primary rounded-2xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5M10.5 21V8.121c0-.312.11-.611.308-.848l4.692-5.58a.75.75 0 0 1 1.149.024l4.469 5.404c.18.217.282.5.282.79V21m-14.4 0H3.75c-.621 0-1.125-.504-1.125-1.125v-6.75c0-.621.504-1.125 1.125-1.125h3.375" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-xl font-poppins font-bold">Sitio Tio</span>
                            <span class="block text-[10px] uppercase tracking-[3px] text-white/50">Resort & Spa</span>
                        </div>
                    </div>
                    <p class="text-white/60 text-sm leading-relaxed">
                        A luxury lakeside resort on Samosir Island, blending Batak cultural heritage with modern comfort
                        and world-class hospitality.
                    </p>
                    <div class="flex gap-3 mt-6">
                        <a href="#"
                            class="w-9 h-9 bg-white/10 rounded-xl flex items-center justify-center hover:bg-accent transition-colors"
                            aria-label="Facebook">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-9 h-9 bg-white/10 rounded-xl flex items-center justify-center hover:bg-accent transition-colors"
                            aria-label="Instagram">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-9 h-9 bg-white/10 rounded-xl flex items-center justify-center hover:bg-accent transition-colors"
                            aria-label="Twitter">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="font-poppins font-semibold text-lg mb-6">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="/"
                                class="text-white/60 hover:text-accent transition-colors text-sm">Home</a></li>
                        <li><a href="/pages/rooms.html"
                                class="text-white/60 hover:text-accent transition-colors text-sm">Our Rooms</a></li>
                        <li><a href="/pages/booking.html"
                                class="text-white/60 hover:text-accent transition-colors text-sm">Book a Stay</a></li>
                        <li><a href="#facilities"
                                class="text-white/60 hover:text-accent transition-colors text-sm">Facilities</a></li>
                        <li><a href="#gallery"
                                class="text-white/60 hover:text-accent transition-colors text-sm">Gallery</a></li>
                        <li><a href="#testimonials"
                                class="text-white/60 hover:text-accent transition-colors text-sm">Reviews</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="font-poppins font-semibold text-lg mb-6">Contact Us</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3 text-sm text-white/60">
                            <svg class="w-5 h-5 text-accent flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                            Jl. Samosir No. 88, Tuktuk Siadong, Samosir, Sumatera Utara 22395
                        </li>
                        <li class="flex items-center gap-3 text-sm text-white/60">
                            <svg class="w-5 h-5 text-accent flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                            </svg>
                            +62 632 123 4567
                        </li>
                        <li class="flex items-center gap-3 text-sm text-white/60">
                            <svg class="w-5 h-5 text-accent flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                            hello@sitiotio.com
                        </li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h3 class="font-poppins font-semibold text-lg mb-6">Stay Updated</h3>
                    <p class="text-white/60 text-sm mb-4">Subscribe for exclusive offers and Samosir travel tips.</p>
                    <form class="space-y-3" aria-label="Newsletter subscription">
                        <input type="email" placeholder="Your email address"
                            class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-2xl text-white placeholder:text-white/40 focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent transition-all text-sm" />
                        <button type="submit" class="btn-accent w-full text-sm !py-2.5">
                            Subscribe
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Bottom bar -->
            <div
                class="border-t border-white/10 mt-12 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-white/40 text-sm">© 2026 Sitio Tio Resort. All rights reserved.</p>
                <div class="flex gap-6 text-sm text-white/40">
                    <a href="#" class="hover:text-accent transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-accent transition-colors">Terms of Service</a>
                    <a href="#" class="hover:text-accent transition-colors">Sitemap</a>
                </div>
            </div>
        </div>
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


</x-guest-layout>

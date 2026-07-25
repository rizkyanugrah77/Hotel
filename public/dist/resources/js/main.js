// ===================================
// Sitio Tio Resort — Main JS
// ===================================

import '../css/style.css';

// ===================================
// Scroll-Triggered Animations
// ===================================
export function initScrollAnimations() {
  const observerOptions = {
    root: null,
    rootMargin: '0px 0px -80px 0px',
    threshold: 0.1,
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  const animatedElements = document.querySelectorAll(
    '.animate-on-scroll, .animate-on-scroll-left, .animate-on-scroll-right, .animate-on-scroll-scale'
  );

  animatedElements.forEach((el) => observer.observe(el));
}

// ===================================
// Mobile Navigation
// ===================================
export function initMobileNav() {
  const toggle = document.getElementById('mobile-menu-toggle');
  const menu = document.getElementById('mobile-menu');
  const overlay = document.getElementById('mobile-menu-overlay');
  const closeBtn = document.getElementById('mobile-menu-close');

  if (!toggle || !menu) return;

  const openMenu = () => {
    menu.classList.remove('translate-x-full');
    menu.classList.add('translate-x-0');
    if (overlay) {
      overlay.classList.remove('opacity-0', 'pointer-events-none');
      overlay.classList.add('opacity-100');
    }
    document.body.style.overflow = 'hidden';
  };

  const closeMenu = () => {
    menu.classList.remove('translate-x-0');
    menu.classList.add('translate-x-full');
    if (overlay) {
      overlay.classList.remove('opacity-100');
      overlay.classList.add('opacity-0', 'pointer-events-none');
    }
    document.body.style.overflow = '';
  };

  toggle.addEventListener('click', openMenu);
  if (closeBtn) closeBtn.addEventListener('click', closeMenu);
  if (overlay) overlay.addEventListener('click', closeMenu);

  // Close on escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeMenu();
  });
}

// ===================================
// Navbar Scroll Effect
// ===================================
export function initNavbarScroll() {
  const navbar = document.getElementById('navbar');
  if (!navbar) return;

  let lastScroll = 0;

  window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset;

    if (currentScroll > 50) {
      navbar.classList.add('bg-white/95', 'backdrop-blur-md', 'shadow-soft');
      navbar.classList.remove('bg-transparent');
    } else {
      navbar.classList.remove('bg-white/95', 'backdrop-blur-md', 'shadow-soft');
      navbar.classList.add('bg-transparent');
    }

    lastScroll = currentScroll;
  });
}

// ===================================
// Smooth Scroll for Anchor Links
// ===================================
export function initSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });
}

// ===================================
// Back to Top Button
// ===================================
export function initBackToTop() {
  const btn = document.getElementById('back-to-top');
  if (!btn) return;

  window.addEventListener('scroll', () => {
    if (window.pageYOffset > 400) {
      btn.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-4');
      btn.classList.add('opacity-100', 'translate-y-0');
    } else {
      btn.classList.remove('opacity-100', 'translate-y-0');
      btn.classList.add('opacity-0', 'pointer-events-none', 'translate-y-4');
    }
  });

  btn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
}

// ===================================
// Testimonial Carousel
// ===================================
export function initTestimonialCarousel() {
  const track = document.getElementById('testimonial-track');
  const dots = document.querySelectorAll('[data-testimonial-dot]');
  const prevBtn = document.getElementById('testimonial-prev');
  const nextBtn = document.getElementById('testimonial-next');

  if (!track) return;

  const slides = track.children;
  let currentIndex = 0;
  const totalSlides = slides.length;

  const goToSlide = (index) => {
    currentIndex = ((index % totalSlides) + totalSlides) % totalSlides;
    track.style.transform = `translateX(-${currentIndex * 100}%)`;

    dots.forEach((dot, i) => {
      dot.classList.toggle('bg-primary', i === currentIndex);
      dot.classList.toggle('bg-gray-300', i !== currentIndex);
      dot.classList.toggle('w-8', i === currentIndex);
      dot.classList.toggle('w-3', i !== currentIndex);
    });
  };

  if (prevBtn) prevBtn.addEventListener('click', () => goToSlide(currentIndex - 1));
  if (nextBtn) nextBtn.addEventListener('click', () => goToSlide(currentIndex + 1));
  dots.forEach((dot, i) => dot.addEventListener('click', () => goToSlide(i)));

  // Auto-play
  let autoPlay = setInterval(() => goToSlide(currentIndex + 1), 5000);

  track.parentElement.addEventListener('mouseenter', () => clearInterval(autoPlay));
  track.parentElement.addEventListener('mouseleave', () => {
    autoPlay = setInterval(() => goToSlide(currentIndex + 1), 5000);
  });
}

// ===================================
// Gallery Lightbox
// ===================================
export function initGalleryLightbox() {
  const lightbox = document.getElementById('gallery-lightbox');
  const lightboxImg = document.getElementById('lightbox-img');
  const lightboxClose = document.getElementById('lightbox-close');
  const galleryItems = document.querySelectorAll('[data-gallery-item]');

  if (!lightbox || !lightboxImg) return;

  galleryItems.forEach((item) => {
    item.addEventListener('click', () => {
      const src = item.querySelector('img')?.src || item.dataset.src;
      if (src) {
        lightboxImg.src = src;
        lightbox.classList.remove('opacity-0', 'pointer-events-none');
        lightbox.classList.add('opacity-100');
        document.body.style.overflow = 'hidden';
      }
    });
  });

  const closeLightbox = () => {
    lightbox.classList.remove('opacity-100');
    lightbox.classList.add('opacity-0', 'pointer-events-none');
    document.body.style.overflow = '';
  };

  if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
  lightbox.addEventListener('click', (e) => {
    if (e.target === lightbox) closeLightbox();
  });
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeLightbox();
  });
}

// ===================================
// Counter Animation
// ===================================
export function initCounterAnimation() {
  const counters = document.querySelectorAll('[data-counter]');

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const target = parseInt(entry.target.dataset.counter, 10);
        const duration = 2000;
        const start = performance.now();

        const animate = (now) => {
          const elapsed = now - start;
          const progress = Math.min(elapsed / duration, 1);
          const eased = 1 - Math.pow(1 - progress, 3);
          entry.target.textContent = Math.round(target * eased).toLocaleString();

          if (progress < 1) requestAnimationFrame(animate);
        };

        requestAnimationFrame(animate);
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.5 });

  counters.forEach((c) => observer.observe(c));
}

// ===================================
// Tab Switching
// ===================================
export function initTabs() {
  const tabGroups = document.querySelectorAll('[data-tabs]');

  tabGroups.forEach((group) => {
    const tabs = group.querySelectorAll('[data-tab]');
    const panels = group.querySelectorAll('[data-tab-panel]');

    tabs.forEach((tab) => {
      tab.addEventListener('click', () => {
        const target = tab.dataset.tab;

        tabs.forEach((t) => {
          t.classList.toggle('text-primary', t.dataset.tab === target);
          t.classList.toggle('border-primary', t.dataset.tab === target);
          t.classList.toggle('text-gray-500', t.dataset.tab !== target);
          t.classList.toggle('border-transparent', t.dataset.tab !== target);
        });

        panels.forEach((panel) => {
          panel.classList.toggle('hidden', panel.dataset.tabPanel !== target);
        });
      });
    });
  });
}

// ===================================
// Initialize All
// ===================================
export function initAll() {
  initScrollAnimations();
  initMobileNav();
  initNavbarScroll();
  initSmoothScroll();
  initBackToTop();
  initTestimonialCarousel();
  initGalleryLightbox();
  initCounterAnimation();
  initTabs();
}

// Auto-init on DOM ready
document.addEventListener('DOMContentLoaded', initAll);

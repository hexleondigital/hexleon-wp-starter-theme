import './style.css';
import '@fontsource/inter/300.css';
import '@fontsource/inter/400.css';
import '@fontsource/inter/500.css';
import '@fontsource/inter/600.css';
import '@fontsource/inter/700.css';
import '@fontsource/inter/800.css';
import '@fontsource/inter/900.css';
import '@fontsource/jetbrains-mono/400.css';
import '@fontsource/jetbrains-mono/500.css';
import '@fontsource/jetbrains-mono/700.css';
import '@fontsource/outfit/300.css';
import '@fontsource/outfit/400.css';
import '@fontsource/outfit/500.css';
import '@fontsource/outfit/600.css';
import '@fontsource/outfit/700.css';
import '@fontsource/outfit/800.css';
import '@fontsource/outfit/900.css';
import 'material-symbols/outlined.css';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import pcBudgetCalc from './js/pc-budget-calculator.js';

// NProgress
import NProgress from 'nprogress';
import 'nprogress/nprogress.css';
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay, Thumbs } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/thumbs';

// Alpine Setup
Alpine.plugin(collapse);

// PC Budget Calculator page component
Alpine.data('pcBudgetCalc', pcBudgetCalc);

// Alpine Global Store for Mini-Cart Drawer
Alpine.store('cart', {
 isOpen: false,
 open() { this.isOpen = true; document.body.classList.add('overflow-hidden'); },
 close() { this.isOpen = false; document.body.classList.remove('overflow-hidden'); },
 toggle() { if (this.isOpen) { this.close(); } else { this.open(); } }
});

// Alpine Global Store for Live Search
Alpine.store('search', {
 isOpen: false,
 query: '',
 category: 0,
 results: [],
 loading: false,
 open() { this.isOpen = true; },
 close() { this.isOpen = false; },
 performSearch() {
 if (this.query.trim().length < 2) {
 this.results = [];
 this.loading = false;
 return;
 }
 this.loading = true;
 
 const ajaxData = new FormData();
 ajaxData.append('action', 'hexleon_live_search');
 ajaxData.append('security', window.hexleonData ? window.hexleonData.nonce : '');
 ajaxData.append('search', this.query);
 ajaxData.append('category', this.category);

 fetch(window.hexleonData ? window.hexleonData.ajaxUrl : '/wp-admin/admin-ajax.php', {
 method: 'POST',
 body: ajaxData
 })
 .then(res => res.json())
 .then(data => {
 this.loading = false;
 if (data.success) {
 this.results = data.data.results;
 } else {
 this.results = [];
 }
 })
 .catch(() => {
 this.loading = false;
 this.results = [];
 });
 }
});

// Alpine Global Store for Quick View Modal
Alpine.store('quickView', {
 isOpen: false,
 productId: null,
 loading: false,
 open(id) {
 this.productId = id;
 this.isOpen = true;
 document.body.classList.add('overflow-hidden');
 },
 close() {
 this.isOpen = false;
 this.productId = null;
 document.body.classList.remove('overflow-hidden');
 }
});

window.Alpine = Alpine;
Alpine.start();

// Listen for WooCommerce AJAX Cart Events to update Mini-Cart Drawer
if (window.jQuery) {
 window.jQuery(document.body).on('added_to_cart', function() {
 Alpine.store('cart').open();
 });
}

// Swiper Carousel Initializers
window.initHeroSwiper = function() {
 const heroEl = document.querySelector('.heroSwiper');
 if (heroEl && !heroEl.swiper) {
 new Swiper(heroEl, {
 modules: [Navigation, Pagination, Autoplay],
 loop: true,
 speed: 800,
 autoplay: {
 delay: 5000,
 disableOnInteraction: false,
 pauseOnMouseEnter: true
 },
 pagination: {
 el: '.hero-pagination',
 clickable: true,
 },
 navigation: {
 nextEl: '.hero-btn-next',
 prevEl: '.hero-btn-prev',
 },
 });
 }
};

window.initDealsSwiper = function() {
 const dealsEl = document.querySelector('.dealsSwiper');
 if (dealsEl && !dealsEl.swiper) {
 new Swiper(dealsEl, {
 modules: [Navigation, Autoplay],
 slidesPerView: 1.2,
 spaceBetween: 16,
 grabCursor: true,
 autoplay: {
 delay: 4000,
 disableOnInteraction: false,
 pauseOnMouseEnter: true
 },
 navigation: {
 nextEl: '.deals-btn-next',
 prevEl: '.deals-btn-prev',
 },
 breakpoints: {
 640: { slidesPerView: 2.2, spaceBetween: 16 },
 1024: { slidesPerView: 3.2, spaceBetween: 20 },
 1280: { slidesPerView: 4, spaceBetween: 24 }
 }
 });
 }
};

window.initBrandSwiper = function() {
 const brandEl = document.querySelector('.brandSwiper');
 if (brandEl && !brandEl.swiper) {
 new Swiper(brandEl, {
 modules: [Autoplay],
 slidesPerView: 3,
 spaceBetween: 24,
 loop: true,
 speed: 3000,
 autoplay: {
 delay: 0,
 disableOnInteraction: false,
 },
 breakpoints: {
 640: { slidesPerView: 4, spaceBetween: 32 },
 768: { slidesPerView: 6, spaceBetween: 40 },
 1024: { slidesPerView: 8, spaceBetween: 48 }
 }
 });
 }
};

window.initProductGallerySwiper = function() {
 const thumbEl = document.querySelector('.productThumbSwiper');
 const mainEl = document.querySelector('.productMainSwiper');
 
 if (mainEl && !mainEl.swiper) {
 let thumbsSwiper = null;
 if (thumbEl) {
 thumbsSwiper = new Swiper(thumbEl, {
 spaceBetween: 12,
 slidesPerView: 4,
 freeMode: true,
 watchSlidesProgress: true,
 });
 }

 new Swiper(mainEl, {
 modules: [Navigation, Thumbs],
 spaceBetween: 16,
 navigation: {
 nextEl: '.gallery-btn-next',
 prevEl: '.gallery-btn-prev',
 },
 thumbs: {
 swiper: thumbsSwiper,
 },
 });
 }
};

document.addEventListener('DOMContentLoaded', () => {
 window.initHeroSwiper();
 window.initDealsSwiper();
 window.initBrandSwiper();
 window.initProductGallerySwiper();
 
 // Initialize NProgress
 NProgress.configure({ showSpinner: false, minimum: 0.1 });
 
 document.querySelectorAll('a[href]:not([target="_blank"]):not([href^="#"]):not([href^="mailto:"]):not([href^="tel:"])').forEach(link => {
 link.addEventListener('click', (e) => {
 if (!e.ctrlKey && !e.metaKey && !e.shiftKey) {
 NProgress.start();
 }
 });
 });
});

window.addEventListener('pageshow', () => {
 NProgress.done();
});
import './style.css';

// Font: Inter (Essential weights: 400, 500, 600, 700)
import '@fontsource/inter/400.css';
import '@fontsource/inter/500.css';
import '@fontsource/inter/600.css';
import '@fontsource/inter/700.css';

// Alpine.js Framework & Plugins
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

Alpine.plugin(collapse);

/**
 * Global Alpine Stores & Helpers
 * Extend these or let AI agents add stores for your project.
 */

// Mobile Navigation Store
Alpine.store('nav', {
  mobileOpen: false,
  open() {
    this.mobileOpen = true;
    document.body.classList.add('overflow-hidden');
  },
  close() {
    this.mobileOpen = false;
    document.body.classList.remove('overflow-hidden');
  },
  toggle() {
    if (this.mobileOpen) {
      this.close();
    } else {
      this.open();
    }
  }
});

// Dropdown Component Helper
Alpine.data('dropdown', () => ({
  open: false,
  toggle() {
    this.open = !this.open;
  },
  close() {
    this.open = false;
  }
}));

// Make Alpine globally accessible for inline x-data attributes
window.Alpine = Alpine;
Alpine.start();

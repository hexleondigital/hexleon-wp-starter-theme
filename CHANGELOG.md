# Changelog

All notable changes to **HexleonWP** will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [Unreleased]

### Planned
- WordPress block patterns in `/patterns`.
- Additional Alpine.js accessible modal components.

---

## [1.0.0] - 2026-11-04

### Added
- **Tailwind CSS v4 (Native)**: CSS-first styling powered by `@tailwindcss/vite` using `@theme` color and font tokens without requiring `tailwind.config.js`.
- **Alpine.js v3**: Reactive UI layer with `@alpinejs/collapse` plugin.
- **Vite Bundler Integration**: Fast development server with Hot Module Replacement (HMR) and automatic PHP file live reloading.
- **Dynamic Asset Enqueue**: Self-contained manifest parser in `inc/enqueue-scripts.php` with relative URL generation (`./`), elimination of hardcoded theme slugs, and asset preloading.
- **Accessible Navigation**:
  - `HexleonWP_Nav_Walker` (`inc/nav-walker.php`) supporting accessible dropdown menus with click-outside and escape-key handling.
  - Mobile slide-over navigation drawer.
  - Accessible skip-to-content anchor.
- **Article & Discussion UI**:
  - Fully styled threaded comments list (`.comment-body`, `.comment-meta`, `.children`).
  - Redesigned 3-column responsive guest comment form with floating labels and focus rings.
- **Modern Multi-Column Footer**:
  - 4-column responsive grid layout with branding, tech stack pills, navigation, resources, and AI prompt guidelines.
  - Smooth Alpine.js Back-to-Top button.
- **AI Agent Context Files**:
  - `AGENTS.md`: Comprehensive guidelines for AI coding agents.
  - `.cursorrules`: Editor context for Cursor IDE.
  - `.github/copilot-instructions.md`: Rules for GitHub Copilot.
- **Release Automation**:
  - Multi-file version sync script (`scripts/sync-version.js`) hooked into `npm version`.
  - GitHub Actions automated release packager workflow (`.github/workflows/release.yml`).
- **Optional WooCommerce Module**:
  - `inc/woocommerce.php` integration that conditionally initializes only when the WooCommerce plugin is active.

### Removed
- Removed legacy, client-specific baggage (PC builder calculator, Sri Lankan contact hardcoding, scrapers).
- Pruned 8 heavy npm dependencies (`@fancyapps/ui`, `swiper`, `flatpickr`, `material-symbols`, `nprogress`, and extra fonts).
- Removed hardcoded absolute paths in `vite.config.js`.

---

[Unreleased]: https://github.com/hexleondigital/hexleon-wp-starter-theme/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/hexleondigital/hexleon-wp-starter-theme/releases/tag/v1.0.0


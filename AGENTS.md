# AGENTS.md — AI Agent Guidelines for HexleonWP

Welcome, AI Agent (Cursor, Claude Code, GitHub Copilot, Antigravity, Windsurf, etc.)!
This document outlines the architecture, rules, and best practices for developing and modifying **HexleonWP**, a modern, lightweight WordPress starter theme.

---

## 1. Tech Stack Overview

- **WordPress Core**: 6.2+ (PHP 8.1+)
- **CSS Framework**: **Tailwind CSS v4** (CSS-first, `@theme` directives, no `tailwind.config.js`)
- **JavaScript UI**: **Alpine.js v3** with `@alpinejs/collapse` plugin
- **Build Tool**: **Vite 6/8** with `@tailwindcss/vite` and `vite-plugin-live-reload`
- **Typography**: Inter (via `@fontsource/inter`)
- **Text Domain**: `hexleonwp`

---

## 2. Directory Structure

```text
hexleonwp/
├── AGENTS.md                   # You are here (AI guidelines)
├── .cursorrules                # Cursor IDE rule configurations
├── .github/copilot-instructions.md
├── package.json                # Lean dependencies (Vite + Tailwind v4 + Alpine)
├── vite.config.js              # Agnostic Vite configuration
├── style.css                   # WordPress theme header definition
├── functions.php               # Theme bootstrapping
├── header.php                  # Semantic HTML5 header & Alpine mobile navigation
├── footer.php                  # Semantic HTML5 footer & copyright
├── index.php                   # Fallback blog loop & layout
├── single.php                  # Single post layout with comments
├── page.php                    # Standard single page layout
├── archive.php                 # Category, tag, and date archives
├── search.php                  # Search results page
├── 404.php                     # Friendly 404 page
├── comments.php                # Tailwind-styled threaded comments
├── sidebar.php                 # Optional widgetized sidebar
│
├── inc/                        # Modular PHP functions
│   ├── assets.php / enqueue-scripts.php  # Vite dev server + manifest loader
│   ├── setup.php                         # Core theme supports & menu registration
│   ├── template-tags.php                 # Pagination & post meta helpers
│   ├── nav-walker.php                    # Accessible Alpine.js menu walker
│   └── woocommerce.php                   # Optional Woo integration (only if Woo is active)
│
├── src/                        # Front-end source code
│   ├── main.js                 # Alpine.js init + stores
│   └── style.css               # Tailwind v4 @import + @theme variables
│
└── template-parts/             # Reusable UI partials
    ├── content.php             # Archive card layout
    ├── content-page.php        # Single page body (prose typography)
    ├── content-search.php      # Search result card
    └── content-none.php        # Empty fallback state
```

---

## 3. Strict Coding Rules for AI Agents

### A. Tailwind CSS v4 Rules (IMPORTANT)
1. **Never create `tailwind.config.js` or `postcss.config.js`**: Tailwind v4 uses CSS-first configuration via `@theme` directly inside [src/style.css](file:///d:/Host/Root/hexleonwp/wp-content/themes/hexleonwp/src/style.css).
2. **Custom Colors & Tokens**:
   - Primary: `bg-brand-primary` / `text-brand-primary` (slate-900 `#0f172a`)
   - Accent: `bg-brand-accent` / `text-brand-accent` (blue-600 `#2563eb`)
   - Accent Hover: `hover:bg-brand-accent-hover` (blue-700 `#1d4ed8`)
   - To rebrand or customize, update the `--color-*` variables in `src/style.css`.
3. **Use Utility Classes in Templates**: Use Tailwind utilities directly within HTML/PHP templates rather than writing arbitrary CSS.
4. **Typography**: Use the `@tailwindcss/typography` plugin class `prose` (e.g. `prose prose-slate max-w-none`) for WordPress content output (`the_content()`).

### B. Alpine.js Rules
1. **Reactivity**: Use Alpine for client-side interactivity (modals, dropdowns, accordions, tabs, slide-overs).
2. **Prevent FOUC**: Always apply `x-cloak` to elements using `x-show` that should be hidden before Alpine boots. The theme has `[x-cloak] { display: none !important; }` in `wp_head`.
3. **Global Stores**: Global state belongs in `src/main.js` via `Alpine.store(...)`. Existing stores:
   - `Alpine.store('nav')`: Controls mobile drawer open/close states.

### C. WordPress PHP Standards
1. **Security & Escaping**:
   - Escaping output: Always use `esc_html()`, `esc_html__()`, `esc_html_e()`, `esc_attr()`, `esc_url()`, or `wp_kses_post()`.
   - Internationalization: Always use the text domain `'hexleonwp'`.
2. **Asset Loading**:
   - Do NOT hardcode script or style tags in `header.php` or `footer.php`.
   - Enqueueing is strictly handled via Vite manifest in `inc/enqueue-scripts.php`.
3. **Dynamic Template Names**:
   - When creating custom page templates, use the standard WordPress header:
     ```php
     <?php
     /**
      * Template Name: Custom Landing Page
      *
      * @package hexleonwp
      */
     get_header();
     ?>
     ```

---

## 4. Build & Development Commands

- Start local development (Vite HMR):
  ```bash
  npm run dev
  ```
  *(Creates `.vite-dev` and serves hot module reloads at `http://localhost:5173`)*

- Production build:
  ```bash
  npm run build
  ```
  *(Compiles bundled, hashed assets into `dist/` and writes `dist/.vite/manifest.json`)*


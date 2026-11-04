# 🚀 HexleonWP — Modern WordPress Starter Theme

> **Ultra-fast, zero-bloat WordPress starter theme powered by Tailwind CSS v4, Alpine.js, and Vite.**
> Engineered for human developers and optimized for AI coding agents (Cursor, Claude Code, GitHub Copilot, Antigravity).

[![Live Demo](https://img.shields.io/badge/Demo-Live_Preview-emerald?style=flat&logo=googlechrome&logoColor=white)](https://demos.hexleondigital.com/hexleonwp)
[![License: GPL v2](https://img.shields.io/badge/License-GPLv2-blue.svg)](https://www.gnu.org/licenses/gpl-2.0.html)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4.0-38bdf8.svg)](https://tailwindcss.com/)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-v3.x-77c1d2.svg)](https://alpinejs.dev/)
[![Vite](https://img.shields.io/badge/Vite-Bundler-646cff.svg)](https://vitejs.dev/)
[![WordPress](https://img.shields.io/badge/WordPress-6.2+-21759b.svg)](https://wordpress.org/)

🔗 **Live Demo**: [https://demos.hexleondigital.com/hexleonwp](https://demos.hexleondigital.com/hexleonwp)

---

## ⚡ Why HexleonWP?

Traditional WordPress starter themes are either too bulky (bloated with jQuery, CSS frameworks, and endless legacy files) or outdated. **HexleonWP** gives you a lightning-fast modern foundation:

- **Tailwind CSS v4 (Native)**: CSS-first configuration using `@theme` directly in `src/style.css`. No legacy `tailwind.config.js` or PostCSS clutter.
- **Alpine.js v3**: Declarative, reactive UI for dropdowns, drawers, modals, and accordions without heavy JavaScript frameworks.
- **Instant Vite Dev Server (HMR)**: Live PHP and CSS reloading with zero lag.
- **Dynamic Asset Loading**: Self-contained manifest-based asset enqueuing. No hardcoded paths — rename your theme folder anytime.
- **AI-Agent Ready**: Includes [`AGENTS.md`](AGENTS.md) and [`.cursorrules`](.cursorrules) so AI tools understand the architecture and write clean code immediately.
- **Optional WooCommerce Support**: Clean hook-ready wrappers that activate only when WooCommerce is installed.

---

## 📦 Quick Start

### 1. Clone into your WordPress themes directory
```bash
cd wp-content/themes
git clone https://github.com/salindalakmal/hexleonwp.git
cd hexleonwp
```

### 2. Install dependencies
```bash
npm install
```

### 3. Start development server (with Hot Module Replacement)
```bash
npm run dev
```
*The dev server runs on `http://localhost:5173` with automatic PHP live reloading and Tailwind CSS HMR.*

### 4. Build for production
```bash
npm run build
```
*Compiles minified, hashed assets to `dist/` and updates `dist/.vite/manifest.json`.*

### 5. Package for WordPress installation (Optional)
```bash
npm run zip
```
*Compiles production assets and generates a clean `hexleonwp.zip` ready for direct WordPress upload.*

### 6. Activate theme in WordPress Admin
Go to **Appearance > Themes** and activate **HexleonWP**.

### 7. Versioning & Releases
To bump the theme version and create a release tag:
```bash
npm version patch   # 1.0.0 -> 1.0.1 (or minor / major)
git push origin main --tags
```
*The `version-sync` hook automatically updates `package.json`, `style.css`, and `functions.php` in lockstep. Pushing a tag triggers the automated GitHub Release packager to generate `hexleonwp.zip`.*

---

## 🤖 Building with AI Agents (Cursor, Claude, Copilot)

This starter theme includes dedicated agent configuration files:

- **[`AGENTS.md`](AGENTS.md)**: Universal instructions for AI coding assistants.
- **[`.cursorrules`](.cursorrules)**: Automatic rules for Cursor IDE.
- **[`.github/copilot-instructions.md`](.github/copilot-instructions.md)**: Instructions for GitHub Copilot.

### Sample Prompts for AI Agents:
- *"Add a responsive testimonial slider to the front page using Tailwind CSS utilities and Alpine.js."*
- *"Create a custom page template for a portfolio gallery with filterable categories."*
- *"Change the theme's primary color to deep emerald `#064e3b` and accent to amber `#f59e0b` in `src/style.css`."*

---

## 📂 Project Structure

```text
hexleonwp/
├── AGENTS.md                   # AI Agent context and development rules
├── .cursorrules                # Cursor rules
├── .gitignore                  # Git ignore rules
├── package.json                # Lean dependencies
├── vite.config.js              # Agnostic Vite configuration
├── style.css                   # WordPress theme header definition
├── functions.php               # Theme bootstrapping
├── header.php                  # Semantic header with Alpine mobile drawer
├── footer.php                  # Semantic footer with dynamic copyright
├── index.php                   # Fallback blog archive & post loop
├── single.php                  # Single post layout with comments
├── page.php                    # Standard single page layout
├── archive.php                 # Category and tag archives
├── search.php                  # Search results page
├── 404.php                     # Friendly 404 page
├── comments.php                # Tailwind-styled threaded comments
├── sidebar.php                 # Widgetized sidebar
│
├── inc/                        # Modular PHP functions
│   ├── setup.php               # Theme features, menus, and widgets
│   ├── enqueue-scripts.php     # Vite dev server + production manifest loader
│   ├── template-tags.php       # Pagination and post meta helpers
│   ├── nav-walker.php          # Accessible Alpine.js dropdown menu walker
│   └── woocommerce.php         # Optional Woo support (only active if Woo is installed)
│
├── src/                        # Front-end source files
│   ├── main.js                 # Alpine.js init and stores
│   └── style.css               # Tailwind v4 @import + @theme tokens
│
└── template-parts/             # Reusable markup partials
    ├── content.php             # Post summary card
    ├── content-page.php        # Page body with Tailwind typography
    ├── content-search.php      # Search result card
    └── content-none.php        # Empty state fallback
```

---

## ⚙️ How the Enqueue System Works

HexleonWP bridges Vite with WordPress seamlessly:

1. **Development (`npm run dev`)**:
   - Creates a temporary `.vite-dev` file in the theme root.
   - Loads Vite client from `http://localhost:5173/@vite/client` and entry file `http://localhost:5173/src/main.js` with `type="module"`.
   - Modifying PHP templates triggers an instant browser reload via `vite-plugin-live-reload`.
2. **Production (`npm run build`)**:
   - Generates production bundles into `dist/`.
   - PHP parses `dist/.vite/manifest.json` and enqueues the versioned CSS and JS files.
   - Preload links and `[x-cloak]` are injected in `<head>` to prevent FOUC (Flash of Unstyled Content) and maximize Core Web Vitals (LCP/CLS).

---

## 📄 License

HexleonWP is open-source software licensed under the **GNU General Public License v2 or later** ([GPL-2.0-or-later](LICENSE)).

## 👨‍💻 Created By

Crafted with ❤️ by **[Salinda Lakmal](https://salindalakmal.com/)** at **[Hexleon Digital](https://hexleondigital.com/)**.
Contributions, issues, and feature requests are welcome!

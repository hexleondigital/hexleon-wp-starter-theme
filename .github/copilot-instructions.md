# GitHub Copilot Instructions for HexleonWP

## Architecture
- **WordPress 6.2+ / PHP 8.1+**
- **Tailwind CSS v4**: CSS-first configuration using `@theme` inside `src/style.css`. No `tailwind.config.js`.
- **Alpine.js v3**: UI reactivity layer. Registered in `src/main.js`.
- **Vite**: Asset bundler. Production assets in `dist/`.

## Conventions
- Use `hexleonwp` text domain for all `__()`, `_e()`, and `_x()` functions.
- Secure WordPress templates: Escape all dynamic outputs (`esc_html`, `esc_url`, `esc_attr`).
- Maintain zero bloat: Prefer utility classes and Alpine micro-interactions over heavy third-party npm packages.


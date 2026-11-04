# HexleonWP — Design Tokens & UI Guidelines

HexleonWP utilizes **Tailwind CSS v4** with native `@theme` directives configured in [src/style.css](file:///d:/Host/Root/hexleonwp/wp-content/themes/hexleonwp/src/style.css).

---

## 1. Color System

The default color tokens provide a clean, modern slate-and-blue foundation:

```css
@theme {
  /* Brand Tokens */
  --color-brand-primary: #0f172a;       /* Slate 900 - Headings & Brand Chrome */
  --color-brand-accent: #2563eb;        /* Blue 600 - Primary actions & interactive links */
  --color-brand-accent-hover: #1d4ed8;  /* Blue 700 - Hover state */
}
```

### Modifying Colors
To change the brand palette, simply modify the hex codes in `src/style.css` or ask your AI agent:
> *"Change the brand primary color to deep emerald `#064e3b` and accent to amber `#d97706`."*

---

## 2. Typography

- **Primary Font**: `Inter` (bundled via `@fontsource/inter`, weights: 400, 500, 600, 700)
- **Fallback Font Stack**: System UI (`system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif`)
- **Monospace Stack**: `ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace`

---

## 3. Core Component Utilities

Defined in `src/style.css`:

- `.btn-primary`: Primary call-to-action button with smooth focus and active scaling.
- `.btn-outline`: Clean bordered secondary action button.
- `.card`: White container with crisp borders and hover elevation.
- `.form-input`: Accessible text, select, and textarea input styling with focus rings.

---

## 4. Alpine.js Interactivity

- **Mobile Navigation**: Toggled via `Alpine.store('nav')` or inline `x-data="{ mobileMenuOpen: false }"`.
- **Accessible Dropdowns**: Powered by `HexleonWP_Nav_Walker` with hover, click, and keyboard ESC / click-outside support.
- **FOUC Prevention**: All hidden elements use `x-cloak` to prevent flash of unstyled content before Alpine initializes.

# Hexleon Tech - Design System & UI Guidelines

This document outlines the core design language, aesthetics, and Tailwind configuration for the Hexleon Tech WordPress theme to ensure consistency across all templates and generated code.

## 1. Core Aesthetics
- **Professional & Modern Tech:** The UI feels premium, tactile, and engineered. It combines a clean light foundation with dark contrast blocks for high-impact chrome (Header, Footer, Hero banners).
- **Subtle Border Radii (`rounded-md`):** We use small, consistent rounded corners across the site. See `header.php` for primary references:
  - Containers, cards, form inputs, search bars, and primary buttons use `rounded-md` (6px).
  - Micro-elements, compact filter tags, and small badges use `rounded` or `rounded-sm` (2px–4px).
  - Circular counters (such as cart item counts) and status pills use `rounded-full`.
- **Tasteful Depth & Elevation (`shadow-sm`):** Subtle, crisp shadows (`shadow-sm`) are applied to cards, buttons, and input bars to create tactile separation without excessive blur. Heavy drop-shadows are avoided.
- **Clean Border System:** Keep borders subtle and crisp (`border-slate-200` or `border-gray-300`). Use whitespace and clean background separation (`bg-slate-50` body vs `bg-white` cards).
- **Light Theme Dominant:** The site primarily uses a clean light mode (`bg-slate-50`), utilizing dark sections (`slate-950` / `brand-primary`) sparingly for navigation chrome, footer, and hero accents.

## 2. Color Palette (Tailwind v4)
The color system uses Tailwind v4 `@theme` variables located in `src/style.css`.

- **Brand Primary / Site Chrome:** `#14191c` / Tailwind's `slate-950` (Dark, near black with a cool slate tint). Used for the Header, Footer, and dark contrast blocks.
  - CSS Variable: `--color-header-footer: var(--color-slate-950);` and `--color-brand-primary: #14191c;`
- **Brand Accent:** `#509904` (Vibrant tech green). Used for call-to-actions, badges, active states, and hover states.
- **Backgrounds:** `bg-slate-50` for the main body background, `bg-white` for content cards and product containers.
- **Text Colors:** `text-slate-800` / `text-gray-800` for primary readable text, `text-slate-500` for secondary text and hints.

## 3. Typography
- **Primary Font (Sans-serif):** `Inter` - Used for all headings, body copy, navigation, and UI elements.
- **Secondary Font (Monospace):** `JetBrains Mono` - Used for prices, currency amounts, technical specs, stock status, delivery info, and SKUs to give a precision hardware aesthetic.

## 4. UI Components

### Buttons
- **Shape:** `rounded-md`.
- **Elevation:** `shadow-sm`.
- **Primary Action (Brand Accent):** `bg-brand-accent hover:bg-[#438003] text-white font-bold text-xs sm:text-sm tracking-wide rounded-md shadow-sm transition-all active:scale-[0.98]`.
- **Secondary / Outline:** `bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 hover:border-slate-400 rounded-md shadow-sm transition-all`.
- **Dark Primary Button:** `bg-brand-primary hover:bg-brand-accent text-white font-bold rounded-md shadow-sm transition-all`.
- **Reference:** Header "Custom PC" button (`px-4 h-11 bg-brand-accent hover:bg-[#438003] rounded-md text-white shadow-sm`).

### Input Fields & Forms
- **Shape:** `rounded-md`.
- **Borders:** `border border-slate-300` or `border-gray-300`.
- **Background:** `bg-white`.
- **Focus state:** `focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent transition-colors`.
- **Elevation:** Optional `shadow-sm` on primary input groups (e.g. Header live search bar `border border-gray-300 rounded-md bg-white shadow-sm overflow-hidden`).

### Cards & Containers
- **Shape:** `rounded-md`.
- **Borders:** `border border-slate-200` or `border-gray-200`.
- **Elevation:** `shadow-sm` with optional `hover:shadow-md hover:border-slate-300` on interactive cards.
- **Background:** `bg-white` for primary panels, `bg-slate-50` for nested sub-sections.

### Badges & Status Pills
- **Counters & Indicators:** `rounded-full` (e.g., cart count `rounded-full`, in-stock badges).
- **Technical Attribute Tags:** `rounded-md` or `rounded-sm` with light borders (`border border-slate-200 text-xs font-mono`).

## 5. Development Rules
- Use `rounded-md` as the default border radius across cards, buttons, and form inputs.
- Maintain CSS variables in `src/style.css` so global tokens propagate consistently.
- Run `npm run build` from the theme root whenever theme source files or CSS are modified.

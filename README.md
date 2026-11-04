# WP Tailwind v4 + Vite Starter

Modern WordPress theme starter using Tailwind CSS v4 and Vite.

## 🚀 Features
- Tailwind CSS v4 (zero-config)
- Vite dev server (HMR)
- Production-ready build with manifest
- Clean WordPress integration

## 📦 Setup

1. Copy theme into:
   wp-content/themes/

2. Install dependencies:
   npm install

3. Start dev:
   touch .vite-dev
   npm run dev

4. Activate theme in WordPress

## 🏗 Build for production
npm run build
rm .vite-dev

## ⚠️ Notes
- Update vite base path if theme folder name changes
- Use safelist in tailwind.config.js for dynamic PHP classes
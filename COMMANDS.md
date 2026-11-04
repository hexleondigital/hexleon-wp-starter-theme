# HexleonWP Starter Theme - Handy Cheatsheet

### 1. Development & Build
```bash
# Start Vite development server with HMR:
npm run dev

# Compile production assets:
npm run build

# Package installable theme ZIP (hexleonwp.zip):
npm run zip
```

---

### 2. Versioning & Releases
```bash
# Bumps version across package.json, style.css, and functions.php, stages them, and tags the commit:
npm version patch   # e.g., 1.0.0 -> 1.0.1
# or
npm version minor   # e.g., 1.0.0 -> 1.1.0

# Push changes and tags to GitHub (triggers automated GitHub Release with ZIP):
git push origin main --tags

# Re-sync version files manually anytime:
npm run version-sync
```

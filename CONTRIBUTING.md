# Contributing to HexleonWP

Thank you for your interest in contributing to **HexleonWP**! We welcome bug reports, feature suggestions, documentation improvements, and code contributions.

---

## 🛠 Local Development Setup

1. **Clone the repository** into your local WordPress installation:
   ```bash
   cd wp-content/themes
   git clone https://github.com/hexleondigital/hexleonwp.git
   cd hexleonwp
   ```

2. **Install dependencies**:
   ```bash
   npm install
   ```

3. **Start the development server**:
   ```bash
   npm run dev
   ```
   *Runs Vite at `http://localhost:5173` with PHP live reload and Tailwind CSS HMR.*

4. **Verify production build before submitting changes**:
   ```bash
   npm run build
   ```

5. **Package and test the installable zip locally**:
   ```bash
   npm run zip
   ```

---

## 📐 Development Guidelines

- **Tailwind CSS v4**: All design tokens belong in `src/style.css` under `@theme`. Do NOT create a `tailwind.config.js`.
- **Alpine.js**: Keep interactivity declarative with Alpine directives (`x-data`, `x-show`, `x-cloak`). Global stores belong in `src/main.js`.
- **WordPress PHP Standards**:
  - Use WordPress security functions (`esc_html`, `esc_url`, `esc_attr`, `wp_kses_post`).
  - Text domain must strictly be `'hexleonwp'`.
  - Maintain clean template hierarchy inside `template-parts/` and `inc/`.
- **Zero-Bloat Philosophy**: We keep core dependencies minimal. Before adding a new npm package, consider if the feature can be implemented using native Tailwind v4 or Alpine.js.

---

## 🌿 Git & Pull Request Workflow

1. Fork the repository on GitHub.
2. Create a feature branch:
   ```bash
   git checkout -b feature/your-feature-name
   ```
3. Commit your changes with a clear, descriptive message:
   ```bash
   git commit -m "feat: add accessible modal component"
   ```
4. Push your branch to GitHub:
   ```bash
   git push origin feature/your-feature-name
   ```
5. Open a Pull Request against the `main` branch.

---

## 📋 Code of Conduct

Please be respectful, collaborative, and constructive when opening issues, submitting pull requests, and discussing features.


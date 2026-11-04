import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';
import liveReload from 'vite-plugin-live-reload';
import fs from 'fs';

export default defineConfig(({ mode }) => ({
  // Relative base ensures assets work regardless of theme directory name or subdirectory installs
  base: mode === 'production' ? './' : '/',

  plugins: [
    tailwindcss(),
    liveReload('**/*.php'),
    {
      name: 'vite-dev-indicator',
      configureServer(server) {
        fs.writeFileSync('.vite-dev', 'Vite Dev Server is running');

        const cleanUp = () => {
          if (fs.existsSync('.vite-dev')) {
            try {
              fs.unlinkSync('.vite-dev');
            } catch (e) {
              // Ignore cleanup error if already removed
            }
          }
        };

        process.on('SIGINT', () => { cleanUp(); process.exit(); });
        process.on('SIGTERM', () => { cleanUp(); process.exit(); });
        process.on('exit', cleanUp);
      }
    }
  ],

  build: {
    outDir: 'dist',
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: {
        main: 'src/main.js'
      }
    }
  },

  server: {
    origin: 'http://localhost:5173',
    cors: true,
    strictPort: true,
    port: 5173,
    host: true
  }
}));

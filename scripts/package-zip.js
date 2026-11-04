import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';
import { execSync } from 'child_process';
import { ZipArchive } from 'archiver';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const themeDir = path.resolve(__dirname, '..');

const THEME_SLUG = 'hexleonwp';
const ZIP_FILENAME = `${THEME_SLUG}.zip`;
const zipOutputPath = path.join(themeDir, ZIP_FILENAME);

console.log('🔨 Step 1/3: Building production assets...');
try {
  execSync('npm run build', { cwd: themeDir, stdio: 'inherit' });
} catch (error) {
  console.error('❌ Build failed. Aborting zip packaging.');
  process.exit(1);
}

// Ensure .vite-dev is removed
const devIndicator = path.join(themeDir, '.vite-dev');
if (fs.existsSync(devIndicator)) {
  fs.unlinkSync(devIndicator);
}

console.log('\n📦 Step 2/3: Packaging production theme files...');

// Remove existing zip if present
if (fs.existsSync(zipOutputPath)) {
  fs.unlinkSync(zipOutputPath);
}

const output = fs.createWriteStream(zipOutputPath);
const archive = new ZipArchive({ zlib: { level: 9 } });

output.on('close', () => {
  const sizeMb = (archive.pointer() / 1024 / 1024).toFixed(2);
  const sizeKb = (archive.pointer() / 1024).toFixed(1);
  console.log(`\n🎉 Step 3/3: Packaging Complete!`);
  console.log(`  File: ${ZIP_FILENAME}`);
  console.log(`  Size: ${sizeMb > 1 ? sizeMb + ' MB' : sizeKb + ' KB'} (${archive.pointer()} bytes)`);
  console.log(`  Path: ${zipOutputPath}`);
  console.log(`\nReady to upload to WordPress Admin (Appearance > Themes > Add New > Upload Theme)\n`);
});

archive.on('warning', (err) => {
  if (err.code === 'ENOENT') {
    console.warn('⚠️ Warning:', err);
  } else {
    throw err;
  }
});

archive.on('error', (err) => {
  throw err;
});

archive.pipe(output);

// Define allowed files and folders
const filesToInclude = [
  'style.css',
  'screenshot.png',
  'functions.php',
  'index.php',
  'header.php',
  'footer.php',
  'page.php',
  'single.php',
  'archive.php',
  'search.php',
  '404.php',
  'comments.php',
  'sidebar.php',
  'README.md',
  'LICENSE',
  'CHANGELOG.md',
];

const directoriesToInclude = [
  'dist',
  'inc',
  'template-parts',
  'assets',
  'languages',
];

// Add single files
for (const file of filesToInclude) {
  const filePath = path.join(themeDir, file);
  if (fs.existsSync(filePath)) {
    archive.file(filePath, { name: `${THEME_SLUG}/${file}` });
  }
}

// Add directories
for (const dir of directoriesToInclude) {
  const dirPath = path.join(themeDir, dir);
  if (fs.existsSync(dirPath)) {
    archive.directory(dirPath, `${THEME_SLUG}/${dir}`);
  }
}

archive.finalize();

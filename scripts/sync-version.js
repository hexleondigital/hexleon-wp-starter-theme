import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const rootDir = path.resolve(__dirname, '..');

// 1. Read package.json to get current version
const pkgPath = path.join(rootDir, 'package.json');
const pkg = JSON.parse(fs.readFileSync(pkgPath, 'utf8'));
const version = pkg.version;

if (!version) {
  console.error('❌ Error: No version found in package.json');
  process.exit(1);
}

console.log(`\n🔄 Synchronizing version ${version} across theme files...`);

// 2. Update style.css (Theme Header)
const stylePath = path.join(rootDir, 'style.css');
if (fs.existsSync(stylePath)) {
  let styleContent = fs.readFileSync(stylePath, 'utf8');
  const styleRegex = /(Version:\s*)([^\r\n]+)/;
  if (styleRegex.test(styleContent)) {
    styleContent = styleContent.replace(styleRegex, `$1${version}`);
    fs.writeFileSync(stylePath, styleContent, 'utf8');
    console.log(`  ✓ Updated style.css -> Version: ${version}`);
  } else {
    console.warn('  ⚠️ Warning: "Version:" field not found in style.css');
  }
}

// 3. Update functions.php (HEXLEONWP_VERSION constant)
const functionsPath = path.join(rootDir, 'functions.php');
if (fs.existsSync(functionsPath)) {
  let functionsContent = fs.readFileSync(functionsPath, 'utf8');
  const constRegex = /(define\(\s*['"]HEXLEONWP_VERSION['"]\s*,\s*['"])([^'"]+)(['"]\s*\);)/;
  if (constRegex.test(functionsContent)) {
    functionsContent = functionsContent.replace(constRegex, `$1${version}$3`);
    fs.writeFileSync(functionsPath, functionsContent, 'utf8');
    console.log(`  ✓ Updated functions.php -> HEXLEONWP_VERSION = '${version}'`);
  } else {
    console.warn('  ⚠️ Warning: HEXLEONWP_VERSION constant not found in functions.php');
  }
}

console.log(`\n✨ Version synchronization complete! (${version})\n`);


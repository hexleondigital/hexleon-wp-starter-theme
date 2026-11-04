const fs = require('fs');
const html = fs.readFileSync('C:/Users/Salinda/.gemini/antigravity-ide/brain/19502f49-2ea6-4846-96ec-814ff23d6f18/.system_generated/steps/1192/content.md', 'utf-8');

const titleRegex = /<a[^>]*class="[^"]*elementor-toggle-title[^"]*"[^>]*>(.*?)<\/a>/g;
let match;
while ((match = titleRegex.exec(html)) !== null) {
  console.log('Q: ' + match[1].replace(/<[^>]+>/g, '').trim());
}

const contentRegex = /<div[^>]*class="[^"]*elementor-toggle-text[^"]*"[^>]*>(.*?)<\/div>/g;
let cMatch;
while ((cMatch = contentRegex.exec(html)) !== null) {
  console.log('A: ' + cMatch[1].replace(/<[^>]+>/g, '').trim());
}

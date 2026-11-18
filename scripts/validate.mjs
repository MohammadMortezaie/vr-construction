import { access, readdir, readFile } from 'node:fs/promises';
import { join } from 'node:path';

const root = new URL('../dist/', import.meta.url);
const htmlFiles = [];
const walk = async (directory) => {
  for (const entry of await readdir(directory, { withFileTypes: true })) {
    const path = join(directory, entry.name);
    if (entry.isDirectory()) await walk(path);
    else if (entry.name.endsWith('.html')) htmlFiles.push(path);
  }
};
await walk(root.pathname);

const errors = [];
const exists = async (path) => access(path).then(() => true).catch(() => false);
for (const file of htmlFiles) {
  const html = await readFile(file, 'utf8');
  const label = file.replace(root.pathname, '');
  const h1Count = (html.match(/<h1[\s>]/g) || []).length;
  if (h1Count !== 1) errors.push(`${label}: expected one h1, found ${h1Count}`);
  if (!/<meta name="description" content="[^"]+">/.test(html)) errors.push(`${label}: missing description`);
  if (!/<link rel="canonical" href="https:\/\/vrplusconstruction\.com/.test(html)) errors.push(`${label}: missing canonical`);
  for (const match of html.matchAll(/<script type="application\/ld\+json">([\s\S]*?)<\/script>/g)) {
    try { JSON.parse(match[1]); } catch { errors.push(`${label}: invalid JSON-LD`); }
  }
  for (const match of html.matchAll(/<img[^>]+src="([^"]+)"/g)) {
    if (!match[1].endsWith('.webp')) errors.push(`${label}: non-WebP image ${match[1]}`);
  }
  for (const match of html.matchAll(/(?:href|src)="(\/[^"]*)"/g)) {
    const url = match[1].split(/[?#]/)[0];
    if (!url || url === '/') continue;
    const target = url.endsWith('/') ? new URL(`.${url}index.html`, root).pathname : new URL(`.${url}`, root).pathname;
    if (!await exists(target)) errors.push(`${label}: broken local reference ${url}`);
  }
}

if (errors.length) {
  console.error(errors.join('\n'));
  process.exit(1);
}
console.log(`Validated ${htmlFiles.length} HTML files: metadata, schema, WebP assets and local links passed.`);

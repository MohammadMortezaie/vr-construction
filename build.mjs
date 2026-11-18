import { cp, mkdir, rm, writeFile } from 'node:fs/promises';
import { aliases, services, company } from './src/data.mjs';
import { aboutPage, aliasPage, blogPage, careerPage, contactPage, homePage, notFoundPage, portfolioPage, privacyPage, servicePage, servicesPage, teamPage } from './src/template.mjs';

const dist = new URL('./dist/', import.meta.url);
await rm(dist, { recursive: true, force: true });
await mkdir(new URL('./assets/images/', dist), { recursive: true });
await cp(new URL('./assets/images/', import.meta.url), new URL('./assets/images/', dist), { recursive: true });
await cp(new URL('./src/styles.css', import.meta.url), new URL('./assets/styles.css', dist));
await cp(new URL('./src/script.js', import.meta.url), new URL('./assets/script.js', dist));

async function page(path, html) {
  const directory = path === '/' ? dist : new URL(`.${path}`, dist);
  await mkdir(directory, { recursive: true });
  await writeFile(new URL('./index.html', directory), html);
}

await page('/', homePage());
await page('/about-us/', aboutPage());
await page('/our-team/', teamPage());
await page('/our-services/', servicesPage());
await page('/portfolio/', portfolioPage());
await page('/construction-projects/', portfolioPage());
await page('/contact-us/', contactPage());
await page('/career/', careerPage());
await page('/blog/', blogPage());
await page('/privacy-policy/', privacyPage());

for (const service of services) await page(`/${service.slug}/`, servicePage(service));
for (const [alias, target] of Object.entries(aliases)) {
  const service = services.find((item) => item.slug === target);
  await page(`/${alias}/`, aliasPage(alias, service));
}

await writeFile(new URL('./404.html', dist), notFoundPage());
await writeFile(new URL('./robots.txt', dist), `User-agent: *\nAllow: /\n\nSitemap: ${company.url}/sitemap.xml\n`);

const canonicalPaths = ['/', '/about-us/', '/our-team/', '/our-services/', '/portfolio/', '/contact-us/', '/career/', '/blog/', ...services.map((service) => `/${service.slug}/`)];
const sitemap = `<?xml version="1.0" encoding="UTF-8"?>\n<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n${canonicalPaths.map((path) => `  <url><loc>${company.url}${path === '/' ? '/' : path}</loc><changefreq>${path === '/' ? 'weekly' : 'monthly'}</changefreq><priority>${path === '/' ? '1.0' : path.includes('services') ? '0.9' : '0.8'}</priority></url>`).join('\n')}\n</urlset>\n`;
await writeFile(new URL('./sitemap.xml', dist), sitemap);
await writeFile(new URL('./llms.txt', dist), `# VR Plus Construction\n\nVR Plus Construction is a residential and commercial construction company serving Vancouver and Metro Vancouver, British Columbia.\n\n## Contact\n- Phone: ${company.phoneDisplay}\n- Email: ${company.email}\n- Primary office: ${company.primaryAddress}\n\n## Core services\n${services.map((service) => `- [${service.label}](${company.url}/${service.slug}/): ${service.short}`).join('\n')}\n\n## Service areas\n${company.areas.join(', ')}.\n`);
await writeFile(new URL('./site.webmanifest', dist), JSON.stringify({ name: company.name, short_name: 'VR Plus', start_url: '/', display: 'standalone', background_color: '#f4f2ed', theme_color: '#171714', icons: [{ src: '/assets/images/vr-plus-logo.webp', sizes: '512x512', type: 'image/webp' }] }, null, 2));

console.log(`Built ${canonicalPaths.length} canonical pages and ${Object.keys(aliases).length} SEO-safe legacy routes.`);

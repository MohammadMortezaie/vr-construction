import { company, projects, services } from './data.mjs';

const asset = (name) => `/assets/images/${name}`;
const canonical = (path = '/') => `${company.url}${path === '/' ? '' : path}`;
const tel = `tel:${company.phone}`;
const mail = `mailto:${company.email}`;

const arrow = '<svg aria-hidden="true" viewBox="0 0 20 20"><path d="M3 10h13M11 4l6 6-6 6"/></svg>';
const chevron = '<svg aria-hidden="true" viewBox="0 0 20 20"><path d="m5 7 5 6 5-6"/></svg>';

function jsonLd(data) {
  return `<script type="application/ld+json">${JSON.stringify(data)}</script>`;
}

function baseSchemas() {
  return [
    {
      '@context': 'https://schema.org',
      '@type': 'HomeAndConstructionBusiness',
      '@id': `${company.url}/#business`,
      name: company.name,
      url: company.url,
      image: `${company.url}${asset('contemporary-home.webp')}`,
      logo: `${company.url}${asset('vr-plus-logo.webp')}`,
      telephone: company.phone,
      email: company.email,
      address: {
        '@type': 'PostalAddress',
        streetAddress: '636 Clyde Ave',
        addressLocality: 'West Vancouver',
        addressRegion: 'BC',
        addressCountry: 'CA'
      },
      areaServed: company.areas.map((name) => ({ '@type': 'City', name })),
      priceRange: '$$–$$$$'
    },
    {
      '@context': 'https://schema.org',
      '@type': 'WebSite',
      '@id': `${company.url}/#website`,
      url: company.url,
      name: company.name,
      publisher: { '@id': `${company.url}/#business` },
      inLanguage: 'en-CA'
    }
  ];
}

function head({ title, description, path = '/', image = 'contemporary-home.webp', robots = 'index,follow', schema = [] }) {
  const fullTitle = title.includes('VR Plus') ? title : `${title} | VR Plus Construction`;
  const url = canonical(path);
  const schemas = [...baseSchemas(), ...schema];
  return `
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>${fullTitle}</title>
  <meta name="description" content="${description}">
  <meta name="robots" content="${robots}">
  <link rel="canonical" href="${url}">
  <meta name="theme-color" content="#171714">
  <meta property="og:type" content="website">
  <meta property="og:locale" content="en_CA">
  <meta property="og:site_name" content="VR Plus Construction">
  <meta property="og:title" content="${fullTitle}">
  <meta property="og:description" content="${description}">
  <meta property="og:url" content="${url}">
  <meta property="og:image" content="${company.url}${asset(image)}">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="${fullTitle}">
  <meta name="twitter:description" content="${description}">
  <link rel="icon" href="${asset('vr-plus-logo.webp')}" type="image/webp">
  <link rel="manifest" href="/site.webmanifest">
  <link rel="stylesheet" href="/assets/styles.css">
  ${schemas.map(jsonLd).join('\n  ')}`;
}

function logo() {
  return `<a class="brand" href="/" aria-label="VR Plus Construction home">
    <img src="${asset('vr-plus-logo.webp')}" width="58" height="58" alt="VR Plus Construction logo">
    <span><strong>VR Plus</strong><small>Construction</small></span>
  </a>`;
}

function header(active = '') {
  return `<header class="site-header" data-header>
    <div class="header-inner">
      ${logo()}
      <nav class="desktop-nav" aria-label="Primary navigation">
        <a class="${active === 'about' ? 'active' : ''}" href="/about-us/">About</a>
        <div class="nav-group">
          <button type="button" aria-expanded="false" data-mega-trigger>Services ${chevron}</button>
          <div class="mega-menu" data-mega-menu>
            <div class="mega-intro">
              <p class="eyebrow">What we build</p>
              <h2>From first idea to final detail.</h2>
              <a class="text-link" href="/our-services/">Explore all services ${arrow}</a>
            </div>
            <div class="mega-links">
              ${services.slice(0, 9).map((service) => `<a href="/${service.slug}/"><span>${service.label}</span><small>${service.short}</small></a>`).join('')}
            </div>
          </div>
        </div>
        <a class="${active === 'projects' ? 'active' : ''}" href="/portfolio/">Projects</a>
        <a class="${active === 'approach' ? 'active' : ''}" href="/construction-management/">Our Approach</a>
        <a class="${active === 'careers' ? 'active' : ''}" href="/career/">Careers</a>
      </nav>
      <div class="header-actions">
        <a class="header-phone" href="${tel}">${company.phoneDisplay}</a>
        <a class="button button-small" href="/contact-us/">Start a project</a>
        <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="mobile-menu" data-menu-toggle><span></span><span></span><span></span><b class="sr-only">Open menu</b></button>
      </div>
    </div>
    <div class="mobile-menu" id="mobile-menu" data-mobile-menu>
      <nav aria-label="Mobile navigation">
        <a href="/about-us/">About</a>
        <button type="button" aria-expanded="false" data-mobile-services>Services ${chevron}</button>
        <div class="mobile-subnav" data-mobile-subnav>
          <a href="/our-services/">All services</a>
          ${services.map((service) => `<a href="/${service.slug}/">${service.label}</a>`).join('')}
        </div>
        <a href="/portfolio/">Projects</a>
        <a href="/construction-management/">Our Approach</a>
        <a href="/career/">Careers</a>
        <a href="/contact-us/">Contact</a>
      </nav>
      <div class="mobile-contact"><a href="${tel}">${company.phoneDisplay}</a><a href="${mail}">${company.email}</a></div>
    </div>
  </header>`;
}

function footer() {
  return `<footer class="site-footer">
    <section class="footer-cta">
      <img src="${asset('contact-project.webp')}" alt="VR Plus Construction project team at work" loading="lazy" width="1024" height="576">
      <div class="footer-cta-card reveal">
        <p class="eyebrow">Let’s build together</p>
        <h2>Have a project in mind?</h2>
        <p>Tell us what you are planning. We’ll help you identify the clearest next step.</p>
        <a class="button" href="/contact-us/">Start a conversation ${arrow}</a>
      </div>
    </section>
    <div class="footer-main">
      <div class="footer-brand">${logo()}<p>Residential and commercial construction across Metro Vancouver, built with care, clarity and accountable project management.</p></div>
      <div class="footer-column"><h3>Explore</h3><a href="/about-us/">About</a><a href="/our-services/">Services</a><a href="/portfolio/">Projects</a><a href="/career/">Careers</a><a href="/contact-us/">Contact</a></div>
      <div class="footer-column"><h3>Services</h3>${services.slice(0, 6).map((service) => `<a href="/${service.slug}/">${service.label}</a>`).join('')}</div>
      <div class="footer-column footer-contact"><h3>Connect</h3><a href="${tel}">${company.phoneDisplay}</a><a href="${mail}">${company.email}</a><a href="https://maps.google.com/?q=${encodeURIComponent(company.primaryAddress)}" target="_blank" rel="noopener">${company.primaryAddress}</a><a href="https://www.linkedin.com/company/vr-plus-construction/" target="_blank" rel="noopener">LinkedIn</a></div>
    </div>
    <div class="footer-bottom"><span>© ${new Date().getFullYear()} VR Plus Construction. All rights reserved.</span><a href="/privacy-policy/">Privacy</a><span>Built for Metro Vancouver.</span></div>
  </footer>`;
}

function layout({ title, description, path, image, active, body, schema = [], robots }) {
  return `<!doctype html>
<html lang="en-CA">
<head>${head({ title, description, path, image, schema, robots })}</head>
<body>
  <a class="skip-link" href="#main">Skip to main content</a>
  ${header(active)}
  <main id="main">${body}</main>
  ${footer()}
  <script src="/assets/script.js" defer></script>
</body>
</html>`;
}

const serviceCards = (items = services.slice(0, 6)) => items.map((service, index) => `<article class="service-card reveal" style="--delay:${index * 55}ms">
  <span class="service-number">${String(index + 1).padStart(2, '0')}</span>
  <h3>${service.label}</h3>
  <p>${service.short}</p>
  <a href="/${service.slug}/" aria-label="Learn about ${service.label}">${arrow}</a>
</article>`).join('');

const projectCards = () => projects.map((project, index) => `<article class="project-card ${index === 0 ? 'project-card-wide' : ''}">
  <a href="/portfolio/">
    <div class="project-image"><img src="${asset(project.image)}" alt="${project.title}" ${index > 0 ? 'loading="lazy"' : ''} width="1280" height="720"></div>
    <div class="project-meta"><span>${project.category}</span><h3>${project.title}</h3><p>${project.location}</p></div>
  </a>
</article>`).join('');

export function homePage() {
  const homeFaqs = [
    ['What construction services does VR Plus provide?', 'VR Plus Construction provides custom home building, residential renovation, commercial construction, condo renovation, pre-construction and construction management across Metro Vancouver.'],
    ['Where does VR Plus Construction work?', `The team serves ${company.areas.join(', ')} and surrounding Metro Vancouver communities.`],
    ['Can VR Plus help before construction starts?', 'Yes. Pre-construction support can include scope review, design coordination, budgeting, schedule planning, constructability and permit coordination.'],
    ['How do I request a construction quote?', `Call ${company.phoneDisplay}, email ${company.email}, or use the project inquiry form to share your location, scope and preferred timing.`]
  ];
  const faqSchema = { '@context': 'https://schema.org', '@type': 'FAQPage', mainEntity: homeFaqs.map(([q, a]) => ({ '@type': 'Question', name: q, acceptedAnswer: { '@type': 'Answer', text: a } })) };
  const body = `
  <section class="hero home-hero">
    <div class="hero-media"><img src="${asset('project-modern-home.webp')}" alt="VR Plus construction team planning a home renovation" width="1440" height="810" fetchpriority="high"></div>
    <div class="hero-shape" aria-hidden="true"></div>
    <div class="hero-content">
      <p class="eyebrow light">Vancouver · West Vancouver · North Shore</p>
      <h1>Built with clarity.<br><strong>Finished with care.</strong></h1>
      <p class="hero-copy">Custom homes, renovations and commercial construction delivered by one accountable Metro Vancouver team.</p>
      <div class="button-row"><a class="button" href="/portfolio/">See our work ${arrow}</a><a class="button button-ghost" href="/contact-us/">Get a free consultation</a></div>
    </div>
    <a class="scroll-cue" href="#intro"><span>Explore</span><i></i></a>
  </section>

  <section class="intro-section section" id="intro">
    <div class="section-grid">
      <div class="intro-copy reveal">
        <p class="eyebrow">We love to build</p>
        <h2>Spaces that work beautifully—on day one and for years after.</h2>
        <p class="lead">VR Plus Construction brings design coordination, practical planning and disciplined execution to residential and commercial projects across Metro Vancouver.</p>
        <p>We believe the construction experience matters as much as the finished space. That means clear expectations, timely answers and steady care for the details that shape quality.</p>
        <a class="text-link" href="/about-us/">Meet VR Plus ${arrow}</a>
      </div>
      <div class="image-collage reveal">
        <figure class="collage-main"><img src="${asset('contemporary-home.webp')}" alt="Contemporary custom home with glass walls" loading="lazy" width="768" height="432"></figure>
        <figure class="collage-small"><img src="${asset('project-interior-1.webp')}" alt="Architectural steel stair structure" loading="lazy" width="738" height="741"></figure>
        <span class="collage-label">Homes · Renovations · Commercial</span>
      </div>
    </div>
  </section>

  <section class="statement-section">
    <div class="statement-media"><img src="${asset('design-engineering.webp')}" alt="Construction planning with drawings and a laptop" loading="lazy" width="1024" height="576"></div>
    <div class="statement-copy reveal"><p class="eyebrow light">A collaborative partner</p><h2>Your goals lead the project. Our process keeps it moving.</h2><p>From early feasibility through final handover, we organize people, information and decisions around one clear project plan.</p><a class="button button-light" href="/construction-management/">Our approach ${arrow}</a></div>
  </section>

  <section class="projects-section section">
    <div class="section-heading"><div><p class="eyebrow">Selected work</p><h2>If you can imagine it,<br><strong>we can help build it.</strong></h2></div><a class="text-link" href="/portfolio/">View projects ${arrow}</a></div>
    <div class="project-rail" data-project-rail>${projectCards()}</div>
    <div class="rail-controls"><button type="button" data-rail-prev aria-label="Previous projects">←</button><div class="rail-progress"><i data-rail-progress></i></div><button type="button" data-rail-next aria-label="Next projects">→</button></div>
  </section>

  <section class="services-section section">
    <div class="section-heading"><div><p class="eyebrow">What we do</p><h2>One team. Every critical phase.</h2></div><p>Construction becomes more predictable when planning, coordination and execution stay connected.</p></div>
    <div class="service-grid">${serviceCards()}</div>
    <div class="center-link"><a class="button button-dark" href="/our-services/">Explore all services ${arrow}</a></div>
  </section>

  <section class="process-section section">
    <div class="process-intro reveal"><p class="eyebrow light">How we work</p><h2>A better experience is built into the process.</h2><p>Every phase has a purpose, an owner and a clear next decision.</p></div>
    <ol class="process-list">
      <li class="reveal"><span>01</span><div><h3>Listen + Define</h3><p>We clarify your goals, site, scope, priorities and practical constraints.</p></div></li>
      <li class="reveal"><span>02</span><div><h3>Plan + Align</h3><p>Design, budget, permits, procurement and schedule become one coordinated roadmap.</p></div></li>
      <li class="reveal"><span>03</span><div><h3>Build + Communicate</h3><p>Site work moves forward with regular updates, documented decisions and quality reviews.</p></div></li>
      <li class="reveal"><span>04</span><div><h3>Finish + Handover</h3><p>We close out details carefully and help you understand the completed space.</p></div></li>
    </ol>
  </section>

  <section class="area-section section">
    <div class="area-map reveal"><span class="map-ring ring-one"></span><span class="map-ring ring-two"></span><span class="map-dot"></span><strong>Metro<br>Vancouver</strong></div>
    <div class="area-copy reveal"><p class="eyebrow">Local knowledge. Broad capability.</p><h2>Building across Greater Vancouver.</h2><p>We serve homeowners and businesses throughout the North Shore and Metro Vancouver, with a process shaped around local approvals, site conditions and building requirements.</p><ul>${company.areas.map((area) => `<li>${area}</li>`).join('')}</ul><a class="text-link" href="/contact-us/">Find your local team ${arrow}</a></div>
  </section>

  <section class="faq-section section">
    <div class="faq-heading"><p class="eyebrow">Straight answers</p><h2>Planning your next project?</h2><p>Start with the questions clients ask us most.</p></div>
    <div class="accordion">${homeFaqs.map(([q, a], index) => `<details ${index === 0 ? 'open' : ''}><summary><span>${q}</span><i></i></summary><p>${a}</p></details>`).join('')}</div>
  </section>`;
  return layout({
    title: 'Vancouver Custom Homes & Renovations | VR Plus Construction',
    description: 'VR Plus Construction builds custom homes, renovations and commercial projects across Vancouver and Metro Vancouver with clear planning and quality craftsmanship.',
    path: '/', image: 'project-modern-home.webp', body, schema: [faqSchema]
  });
}

export function servicePage(service) {
  const pagePath = `/${service.slug}/`;
  const faqSchema = { '@context': 'https://schema.org', '@type': 'FAQPage', mainEntity: service.faqs.map(([q, a]) => ({ '@type': 'Question', name: q, acceptedAnswer: { '@type': 'Answer', text: a } })) };
  const serviceSchema = {
    '@context': 'https://schema.org', '@type': 'Service', name: service.title, description: service.meta,
    provider: { '@id': `${company.url}/#business` }, areaServed: company.areas.map((name) => ({ '@type': 'City', name })), url: canonical(pagePath)
  };
  const breadcrumb = { '@context': 'https://schema.org', '@type': 'BreadcrumbList', itemListElement: [
    { '@type': 'ListItem', position: 1, name: 'Home', item: company.url },
    { '@type': 'ListItem', position: 2, name: 'Services', item: `${company.url}/our-services/` },
    { '@type': 'ListItem', position: 3, name: service.label, item: canonical(pagePath) }
  ] };
  const body = `
  <section class="inner-hero">
    <div class="inner-hero-media"><img src="${asset(service.image)}" alt="${service.title}" width="1280" height="720" fetchpriority="high"></div>
    <div class="inner-hero-overlay"></div>
    <div class="inner-hero-content"><nav class="breadcrumbs" aria-label="Breadcrumb"><a href="/">Home</a><span>/</span><a href="/our-services/">Services</a><span>/</span><span>${service.label}</span></nav><p class="eyebrow light">VR Plus Construction</p><h1>${service.title}</h1><p>${service.meta}</p><a class="button" href="/contact-us/">Discuss your project ${arrow}</a></div>
  </section>
  <section class="service-overview section">
    <div class="service-lead reveal"><p class="eyebrow">Built around your project</p><h2>${service.intro}</h2></div>
    <div class="service-checklist reveal"><h3>How we can help</h3><ul>${service.bullets.map((item) => `<li><span>✓</span>${item}</li>`).join('')}</ul><a class="text-link" href="${tel}">Call ${company.phoneDisplay} ${arrow}</a></div>
  </section>
  <section class="detail-band"><div class="detail-image"><img src="${asset(service.image)}" alt="${service.label} project in Metro Vancouver" loading="lazy" width="1280" height="720"></div><div class="detail-copy">${service.sections.map(([heading, copy], index) => `<article class="reveal"><span>0${index + 1}</span><h2>${heading}</h2><p>${copy}</p></article>`).join('')}</div></section>
  <section class="service-process section"><div class="section-heading"><div><p class="eyebrow">What to expect</p><h2>Clear steps. Fewer surprises.</h2></div><p>Every project is different, but the communication principles stay consistent.</p></div><div class="mini-process"><article><span>01</span><h3>Discovery</h3><p>We learn the site, goals, budget context and decision-makers.</p></article><article><span>02</span><h3>Planning</h3><p>Scope, consultants, schedule and key selections are coordinated.</p></article><article><span>03</span><h3>Construction</h3><p>Work proceeds with updates, documentation and active quality control.</p></article><article><span>04</span><h3>Closeout</h3><p>Inspections, deficiencies, documentation and handover are completed.</p></article></div></section>
  <section class="faq-section section"><div class="faq-heading"><p class="eyebrow">${service.label} FAQ</p><h2>Useful answers before you begin.</h2></div><div class="accordion">${service.faqs.map(([q, a], index) => `<details ${index === 0 ? 'open' : ''}><summary><span>${q}</span><i></i></summary><p>${a}</p></details>`).join('')}</div></section>`;
  return layout({ title: service.title, description: service.meta, path: pagePath, image: service.image, active: 'services', body, schema: [serviceSchema, faqSchema, breadcrumb] });
}

export function servicesPage() {
  const body = `
  <section class="page-hero page-hero-dark"><div><nav class="breadcrumbs" aria-label="Breadcrumb"><a href="/">Home</a><span>/</span><span>Services</span></nav><p class="eyebrow light">Capabilities</p><h1>Built to move the whole project forward.</h1><p>Integrated planning and construction services for homes, renovations and commercial spaces across Metro Vancouver.</p></div></section>
  <section class="all-services section"><div class="service-grid service-grid-all">${serviceCards(services)}</div></section>
  <section class="feature-split section"><div><img src="${asset('pre-construction.webp')}" alt="VR Plus pre-construction planning" loading="lazy" width="1024" height="576"></div><div class="reveal"><p class="eyebrow">Not sure where to start?</p><h2>Bring us your goal. We’ll help define the path.</h2><p>We can review an early idea, an existing set of drawings or a property you are considering. The right first step depends on the project—not a one-size-fits-all sales process.</p><a class="button button-dark" href="/contact-us/">Talk with our team ${arrow}</a></div></section>`;
  return layout({ title: 'Construction Services in Vancouver', description: 'Explore VR Plus Construction services for custom homes, renovations, commercial projects, pre-construction, construction management and energy upgrades.', path: '/our-services/', image: 'pre-construction.webp', body });
}

export function aboutPage() {
  const body = `
  <section class="page-hero page-hero-image"><img src="${asset('careers-site.webp')}" alt="VR Plus Construction team at work" width="1200" height="675" fetchpriority="high"><div><nav class="breadcrumbs" aria-label="Breadcrumb"><a href="/">Home</a><span>/</span><span>About</span></nav><p class="eyebrow light">About VR Plus</p><h1>Construction is personal. We treat it that way.</h1><p>Your home, business and investment deserve clear ownership from the people building it.</p></div></section>
  <section class="about-story section"><div class="reveal"><p class="eyebrow">Who we are</p><h2>A Metro Vancouver builder focused on the experience behind the result.</h2></div><div class="about-copy reveal"><p class="lead">VR Plus Construction provides residential and commercial construction services across Greater Vancouver.</p><p>Our work includes custom homes, complete renovations, commercial improvements and the planning services that make those projects possible. We coordinate designers, engineers, trades, suppliers and inspections around a clear plan.</p><p>What clients should feel is straightforward: informed, respected and confident about what happens next.</p></div></section>
  <section class="values-section section"><article><span>01</span><h3>Clarity</h3><p>Make the scope, decisions and next steps understandable.</p></article><article><span>02</span><h3>Care</h3><p>Protect the property, the design intent and the people around the work.</p></article><article><span>03</span><h3>Craft</h3><p>Pay attention to the details that determine how a space performs and feels.</p></article><article><span>04</span><h3>Accountability</h3><p>Own the plan, communicate changes and follow through.</p></article></section>
  <section class="feature-split feature-split-reverse section"><div><img src="${asset('project-kitchen.webp')}" alt="Construction team reviewing a project on site" loading="lazy" width="2560" height="1706"></div><div class="reveal"><p class="eyebrow">Local by design</p><h2>Serving the communities where we live and build.</h2><p>${company.areas.join(', ')} and nearby Metro Vancouver communities.</p><a class="text-link" href="/contact-us/">Connect with us ${arrow}</a></div></section>`;
  return layout({ title: 'About VR Plus Construction', description: 'Learn about VR Plus Construction, a Metro Vancouver builder for custom homes, renovations and commercial projects with a clear, accountable process.', path: '/about-us/', image: 'careers-site.webp', active: 'about', body });
}

export function portfolioPage() {
  const body = `
  <section class="page-hero page-hero-light"><div><nav class="breadcrumbs dark" aria-label="Breadcrumb"><a href="/">Home</a><span>/</span><span>Projects</span></nav><p class="eyebrow">Our work</p><h1>Spaces shaped around how people live and work.</h1><p>A selection of residential, renovation and commercial project imagery from the VR Plus portfolio.</p></div></section>
  <section class="portfolio-grid section">${projects.concat([
    { title: 'Interior Renewal', location: 'Metro Vancouver, BC', category: 'Renovation', image: 'project-interior-2.webp' },
    { title: 'Construction Planning', location: 'Vancouver, BC', category: 'Pre-Construction', image: 'design-engineering.webp' },
    { title: 'Field Coordination', location: 'Greater Vancouver, BC', category: 'Construction', image: 'construction-management.webp' }
  ]).map((project, index) => `<article class="portfolio-item reveal ${index % 5 === 0 ? 'large' : ''}"><img src="${asset(project.image)}" alt="${project.title}" loading="lazy" width="1280" height="720"><div><p>${project.category}</p><h2>${project.title}</h2><span>${project.location}</span></div></article>`).join('')}</section>`;
  return layout({ title: 'Construction Projects in Metro Vancouver', description: 'Explore VR Plus Construction project imagery for custom homes, renovations, interiors and commercial work across Metro Vancouver.', path: '/portfolio/', image: 'contemporary-home.webp', active: 'projects', body });
}

export function contactPage() {
  const body = `
  <section class="contact-hero">
    <div class="contact-intro"><nav class="breadcrumbs dark" aria-label="Breadcrumb"><a href="/">Home</a><span>/</span><span>Contact</span></nav><p class="eyebrow">Let’s talk</p><h1>Tell us what you want to build.</h1><p>Share the project type, location and what stage you are at. Our team will help you identify a practical next step.</p><div class="direct-contact"><a href="${tel}"><span>Call</span>${company.phoneDisplay}</a><a href="${mail}"><span>Email</span>${company.email}</a></div></div>
    <form class="project-form" data-contact-form><div class="form-grid"><label><span>Full name *</span><input type="text" name="name" autocomplete="name" required></label><label><span>Phone *</span><input type="tel" name="phone" autocomplete="tel" required></label><label><span>Email *</span><input type="email" name="email" autocomplete="email" required></label><label><span>Project location</span><input type="text" name="location" autocomplete="address-level2"></label><label><span>Project type</span><select name="project"><option>Custom home</option><option>Home renovation</option><option>Condo renovation</option><option>Commercial construction</option><option>Pre-construction</option><option>Other</option></select></label><label><span>Preferred timing</span><select name="timing"><option>As soon as practical</option><option>Within 3 months</option><option>3–6 months</option><option>6–12 months</option><option>Planning ahead</option></select></label><label class="full"><span>Tell us about the project *</span><textarea name="message" rows="5" required></textarea></label></div><button class="button button-dark" type="submit">Prepare email ${arrow}</button><p class="form-note" data-form-note>This form opens your email app so you can review the message before sending.</p></form>
  </section>
  <section class="offices-section section"><div><p class="eyebrow">Our locations</p><h2>Close to the communities we serve.</h2></div><div class="office-list">${company.addresses.map((address, index) => `<a href="https://maps.google.com/?q=${encodeURIComponent(address)}" target="_blank" rel="noopener"><span>0${index + 1}</span><h3>${address}</h3>${arrow}</a>`).join('')}</div></section>`;
  return layout({ title: 'Contact VR Plus Construction', description: `Contact VR Plus Construction at ${company.phoneDisplay} for custom homes, renovations and commercial construction in Metro Vancouver.`, path: '/contact-us/', image: 'contact-project.webp', body });
}

export function careerPage() {
  const body = `
  <section class="page-hero page-hero-image"><img src="${asset('careers-site.webp')}" alt="Construction team on a Metro Vancouver jobsite" width="1200" height="675" fetchpriority="high"><div><nav class="breadcrumbs" aria-label="Breadcrumb"><a href="/">Home</a><span>/</span><span>Careers</span></nav><p class="eyebrow light">Build your craft</p><h1>Do work you can stand behind.</h1><p>We value people who communicate clearly, solve problems and care about the finished result.</p><a class="button" href="${mail}?subject=Career%20interest%20at%20VR%20Plus%20Construction">Introduce yourself ${arrow}</a></div></section>
  <section class="about-story section"><div class="reveal"><p class="eyebrow">Working at VR Plus</p><h2>Good construction depends on good people.</h2></div><div class="about-copy reveal"><p class="lead">We are interested in meeting experienced construction professionals and motivated people who want to grow their skills.</p><p>Email your introduction and résumé to <a class="inline-link" href="${mail}">${company.email}</a>. Include the type of work you do, your experience and where you are based.</p></div></section>
  <section class="values-section section"><article><span>01</span><h3>Take ownership</h3><p>Follow the work through and communicate early.</p></article><article><span>02</span><h3>Respect the site</h3><p>Work safely, stay organized and protect the client’s property.</p></article><article><span>03</span><h3>Keep learning</h3><p>Ask questions, share knowledge and improve the process.</p></article><article><span>04</span><h3>Build as a team</h3><p>Strong outcomes come from dependable coordination.</p></article></section>`;
  return layout({ title: 'Construction Careers in Vancouver', description: 'Explore career opportunities and introduce yourself to VR Plus Construction, a residential and commercial builder serving Metro Vancouver.', path: '/career/', image: 'careers-site.webp', active: 'careers', body });
}

export function teamPage() {
  const body = `
  <section class="page-hero page-hero-dark"><div><nav class="breadcrumbs" aria-label="Breadcrumb"><a href="/">Home</a><span>/</span><span>Our Team</span></nav><p class="eyebrow light">The people behind the work</p><h1>One coordinated team, accountable to your project.</h1><p>VR Plus brings project leadership, site coordination and a network of qualified consultants and trades together around the work.</p></div></section>
  <section class="about-story section"><div class="reveal"><p class="eyebrow">Built on collaboration</p><h2>The right people at the right moment.</h2></div><div class="about-copy reveal"><p class="lead">Construction requires many specialties. Our role is to keep those specialists aligned.</p><p>Project needs determine the team: designers, engineers, permit consultants, skilled trades, suppliers and inspectors. VR Plus coordinates the interfaces so responsibilities and next steps stay clear.</p><a class="text-link" href="/contact-us/">Meet us through your project ${arrow}</a></div></section>`;
  return layout({ title: 'Our Construction Team', description: 'Meet the coordinated project approach behind VR Plus Construction’s custom homes, renovations and commercial projects in Metro Vancouver.', path: '/our-team/', image: 'careers-site.webp', active: 'about', body });
}

export function blogPage() {
  const articles = [
    ['Renovation Planning', 'Before demolition: the decisions that make a Vancouver renovation smoother', 'Clear scope, product selections, permit needs and site logistics create a stronger start.', '/remodeling-and-renovation/', 'renovation-project.webp'],
    ['Custom Homes', 'What to align before custom home design goes too far', 'Site constraints, priorities, budget context and performance goals belong in the early conversation.', '/custom-homes-vancouver-bc/', 'contemporary-home.webp'],
    ['High Performance', 'Energy upgrades work best as a coordinated system', 'Insulation, air sealing, ventilation and mechanical choices affect one another.', '/energy-efficient-home/', 'energy-efficient-homes.webp']
  ];
  const body = `<section class="page-hero page-hero-light"><div><nav class="breadcrumbs dark" aria-label="Breadcrumb"><a href="/">Home</a><span>/</span><span>Insights</span></nav><p class="eyebrow">Project insights</p><h1>Practical thinking for better construction decisions.</h1><p>Clear explanations for homeowners and businesses planning work in Metro Vancouver.</p></div></section><section class="insights-grid section">${articles.map(([type, title, excerpt, link, image]) => `<article class="insight-card reveal"><a href="${link}"><img src="${asset(image)}" alt="${title}" loading="lazy" width="1024" height="576"><p>${type}</p><h2>${title}</h2><span>${excerpt}</span><b>Read the guide ${arrow}</b></a></article>`).join('')}</section>`;
  return layout({ title: 'Construction Insights', description: 'Practical guides for planning custom homes, renovations, commercial construction and energy upgrades in Metro Vancouver.', path: '/blog/', image: 'design-engineering.webp', body });
}

export function privacyPage() {
  const body = `<section class="page-hero page-hero-light compact"><div><p class="eyebrow">Privacy</p><h1>Privacy policy</h1><p>How information shared with VR Plus Construction is handled.</p></div></section><section class="legal section"><h2>Information you choose to provide</h2><p>If you contact VR Plus Construction, you may provide your name, contact details and information about a potential project. This information is used to respond to your inquiry and communicate about requested services.</p><h2>Email-based inquiry form</h2><p>The inquiry form on this website prepares a message in your own email application. The website does not store the form submission.</p><h2>Website operation</h2><p>Basic server logs may be used for security and reliable operation. This site does not include advertising trackers.</p><h2>Contact</h2><p>Questions can be sent to <a class="inline-link" href="${mail}">${company.email}</a>.</p></section>`;
  return layout({ title: 'Privacy Policy', description: 'Privacy information for the VR Plus Construction website and project inquiries.', path: '/privacy-policy/', body });
}

export function aliasPage(alias, targetService) {
  const target = `/${targetService.slug}/`;
  return `<!doctype html><html lang="en-CA"><head>${head({ title: targetService.title, description: targetService.meta, path: target, image: targetService.image, robots: 'noindex,follow' })}<meta http-equiv="refresh" content="0;url=${target}"></head><body><main class="redirect-page"><img src="${asset('vr-plus-logo.webp')}" alt="VR Plus Construction" width="90" height="90"><h1>Page moved</h1><p>This service is now available at its updated address.</p><a class="button button-dark" href="${target}">Continue to ${targetService.label}</a></main></body></html>`;
}

export function notFoundPage() {
  const body = `<section class="not-found"><p class="eyebrow">404</p><h1>This page is not on the plan.</h1><p>Let’s get you back to a useful part of the site.</p><div class="button-row"><a class="button button-dark" href="/">Go home</a><a class="button button-outline" href="/contact-us/">Contact us</a></div></section>`;
  return layout({ title: 'Page Not Found', description: 'The requested page could not be found.', path: '/404.html', robots: 'noindex,follow', body });
}

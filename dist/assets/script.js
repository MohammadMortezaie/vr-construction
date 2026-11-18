(() => {
  const header = document.querySelector('[data-header]');
  const menuToggle = document.querySelector('[data-menu-toggle]');
  const mobileMenu = document.querySelector('[data-mobile-menu]');
  const mobileServices = document.querySelector('[data-mobile-services]');
  const mobileSubnav = document.querySelector('[data-mobile-subnav]');
  const megaTrigger = document.querySelector('[data-mega-trigger]');
  const megaMenu = document.querySelector('[data-mega-menu]');

  if (document.querySelector('.page-hero-light, .contact-hero')) header?.classList.add('header-on-light');

  const updateHeader = () => header?.classList.toggle('scrolled', window.scrollY > 24);
  updateHeader();
  window.addEventListener('scroll', updateHeader, { passive: true });

  menuToggle?.addEventListener('click', () => {
    const open = menuToggle.getAttribute('aria-expanded') !== 'true';
    menuToggle.setAttribute('aria-expanded', String(open));
    mobileMenu?.classList.toggle('open', open);
    header?.classList.toggle('menu-active', open);
    document.body.classList.toggle('menu-open', open);
  });

  mobileServices?.addEventListener('click', () => {
    const open = mobileServices.getAttribute('aria-expanded') !== 'true';
    mobileServices.setAttribute('aria-expanded', String(open));
    mobileSubnav?.classList.toggle('open', open);
  });

  const closeMega = () => {
    megaTrigger?.setAttribute('aria-expanded', 'false');
    megaMenu?.classList.remove('open');
  };
  megaTrigger?.addEventListener('click', (event) => {
    event.stopPropagation();
    const open = megaTrigger.getAttribute('aria-expanded') !== 'true';
    megaTrigger.setAttribute('aria-expanded', String(open));
    megaMenu?.classList.toggle('open', open);
  });
  document.addEventListener('click', (event) => {
    if (!megaMenu?.contains(event.target) && event.target !== megaTrigger) closeMega();
  });
  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      closeMega();
      if (menuToggle?.getAttribute('aria-expanded') === 'true') menuToggle.click();
    }
  });

  const revealItems = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: .12, rootMargin: '0px 0px -40px' });
    revealItems.forEach((item) => observer.observe(item));
  } else {
    revealItems.forEach((item) => item.classList.add('visible'));
  }

  const rail = document.querySelector('[data-project-rail]');
  const progress = document.querySelector('[data-rail-progress]');
  const scrollRail = (direction) => rail?.scrollBy({ left: direction * Math.min(rail.clientWidth * .8, 560), behavior: 'smooth' });
  document.querySelector('[data-rail-prev]')?.addEventListener('click', () => scrollRail(-1));
  document.querySelector('[data-rail-next]')?.addEventListener('click', () => scrollRail(1));
  rail?.addEventListener('scroll', () => {
    const available = rail.scrollWidth - rail.clientWidth;
    const ratio = available > 0 ? rail.scrollLeft / available : 0;
    if (progress) progress.style.transform = `translateX(${ratio * 400}%)`;
  }, { passive: true });

  document.querySelector('[data-contact-form]')?.addEventListener('submit', (event) => {
    event.preventDefault();
    const form = event.currentTarget;
    if (!form.reportValidity()) return;
    const data = new FormData(form);
    const subject = `Project inquiry: ${data.get('project')} in ${data.get('location') || 'Metro Vancouver'}`;
    const body = [
      `Name: ${data.get('name')}`,
      `Phone: ${data.get('phone')}`,
      `Email: ${data.get('email')}`,
      `Project location: ${data.get('location') || 'Not provided'}`,
      `Project type: ${data.get('project')}`,
      `Preferred timing: ${data.get('timing')}`,
      '',
      'Project details:',
      data.get('message')
    ].join('\n');
    const note = form.querySelector('[data-form-note]');
    if (note) note.textContent = 'Your email app is opening with the project details. Review the message, then send it when ready.';
    window.location.href = `mailto:admin@vrplusconstruction.com?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
  });
})();

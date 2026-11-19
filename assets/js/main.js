(() => {
    const header = document.querySelector('[data-header]');
    const menuButton = document.querySelector('[data-menu-button]');
    const mobileNavigation = document.querySelector('[data-mobile-navigation]');
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const updateHeader = () => {
        if (!header || window.innerWidth <= 900) return;
        header.classList.toggle('is-fixed', window.scrollY > 120);
    };

    updateHeader();
    window.addEventListener('scroll', updateHeader, { passive: true });

    menuButton?.addEventListener('click', () => {
        const open = menuButton.getAttribute('aria-expanded') !== 'true';
        menuButton.setAttribute('aria-expanded', String(open));
        mobileNavigation?.classList.toggle('is-open', open);
        header?.classList.toggle('menu-active', open);
        document.body.classList.toggle('menu-open', open);
    });

    mobileNavigation?.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => {
            menuButton?.setAttribute('aria-expanded', 'false');
            mobileNavigation.classList.remove('is-open');
            header?.classList.remove('menu-active');
            document.body.classList.remove('menu-open');
        });
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && menuButton?.getAttribute('aria-expanded') === 'true') {
            menuButton.click();
            menuButton.focus();
        }
    });

    const autoRevealSelectors = [
        'main section h1',
        'main section h2',
        'main section h3',
        'main section > div > p',
        'main section .button',
        'main section .text-link'
    ].join(',');

    document.querySelectorAll(autoRevealSelectors).forEach((item, index) => {
        if (item.closest('.reveal') || item.classList.contains('reveal')) return;
        item.classList.add('auto-reveal');
        item.style.setProperty('--reveal-delay', `${Math.min(index % 4, 3) * 65}ms`);
    });

    const revealItems = document.querySelectorAll('.reveal, .auto-reveal');
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        }, { threshold: .12, rootMargin: '0px 0px -45px' });
        revealItems.forEach((item) => observer.observe(item));
    } else {
        revealItems.forEach((item) => item.classList.add('is-visible'));
    }

    const serviceTabs = document.querySelectorAll('[data-service-tab]');
    const serviceImages = document.querySelectorAll('[data-service-image]');
    serviceTabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            const index = tab.dataset.serviceTab;
            serviceTabs.forEach((item) => {
                const active = item === tab;
                item.classList.toggle('active', active);
                item.setAttribute('aria-selected', String(active));
            });
            serviceImages.forEach((image) => image.classList.toggle('active', image.dataset.serviceImage === index));
        });
    });

    const multiStepForm = document.querySelector('[data-multi-step-form]');
    if (multiStepForm) {
        const formAlert = document.querySelector('[data-form-alert]');
        const steps = [...multiStepForm.querySelectorAll('[data-form-step]')];
        const progress = multiStepForm.querySelector('[data-form-progress]');
        const progressLine = multiStepForm.querySelector('[data-form-progress-line]');
        const progressSteps = [...multiStepForm.querySelectorAll('.form-progress-step')];
        const recaptchaToken = multiStepForm.querySelector('[data-recaptcha-token]');
        const recaptchaStatus = multiStepForm.querySelector('[data-recaptcha-status]');
        const submitButton = multiStepForm.querySelector('[type="submit"]');
        const recaptchaSiteKey = multiStepForm.dataset.recaptchaSiteKey || '';
        const recaptchaAction = multiStepForm.dataset.recaptchaAction || 'contact_form';
        let recaptchaSubmitting = false;
        let currentStep = Math.max(0, Math.min(steps.length - 1, Number(multiStepForm.dataset.initialStep || 1) - 1));

        multiStepForm.classList.add('is-enhanced');

        if (formAlert && window.matchMedia('(max-width: 900px)').matches) {
            window.requestAnimationFrame(() => {
                formAlert.focus({ preventScroll: true });
                const alertTop = formAlert.getBoundingClientRect().top + window.scrollY - 20;
                window.scrollTo({ top: Math.max(0, alertTop), behavior: 'auto' });
            });
        }

        const showStep = (index, moveFocus = false) => {
            currentStep = Math.max(0, Math.min(steps.length - 1, index));
            steps.forEach((step, stepIndex) => step.classList.toggle('is-active', stepIndex === currentStep));
            progressSteps.forEach((step, stepIndex) => {
                step.classList.toggle('is-current', stepIndex === currentStep);
                step.classList.toggle('is-complete', stepIndex < currentStep);
            });
            const ratio = steps.length > 1 ? currentStep / (steps.length - 1) : 1;
            if (progressLine) progressLine.style.transform = `scaleX(${ratio})`;
            progress?.setAttribute('aria-valuenow', String(currentStep + 1));
            if (moveFocus) {
                window.requestAnimationFrame(() => {
                    steps[currentStep]?.querySelector('legend')?.focus({ preventScroll: true });

                    if (window.matchMedia('(max-width: 900px)').matches) {
                        const formTop = multiStepForm.getBoundingClientRect().top + window.scrollY - 20;
                        window.scrollTo({
                            top: Math.max(0, formTop),
                            behavior: reducedMotion ? 'auto' : 'smooth'
                        });
                    }
                });
            }
        };

        const validateStep = (step) => {
            const requiredFields = [...step.querySelectorAll('[required]')];
            requiredFields.forEach((field) => field.removeAttribute('aria-invalid'));

            for (const field of requiredFields) {
                if (field.type === 'radio') {
                    const group = [...step.querySelectorAll(`input[type="radio"][name="${field.name}"]`)];
                    if (!group.some((input) => input.checked)) {
                        field.setAttribute('aria-invalid', 'true');
                        field.reportValidity();
                        return false;
                    }
                    continue;
                }
                if (!field.checkValidity()) {
                    field.setAttribute('aria-invalid', 'true');
                    field.reportValidity();
                    return false;
                }
            }
            return true;
        };

        multiStepForm.querySelectorAll('[data-form-next]').forEach((button) => {
            button.addEventListener('click', () => {
                if (!validateStep(steps[currentStep])) return;
                showStep(currentStep + 1, true);
            });
        });

        multiStepForm.querySelectorAll('[data-form-back]').forEach((button) => {
            button.addEventListener('click', () => showStep(currentStep - 1, true));
        });

        multiStepForm.addEventListener('submit', (event) => {
            for (let index = 0; index < steps.length; index += 1) {
                if (validateStep(steps[index])) continue;
                event.preventDefault();
                showStep(index, true);
                return;
            }

            if (!recaptchaSiteKey || recaptchaSubmitting) return;

            event.preventDefault();
            if (!window.grecaptcha?.ready || !window.grecaptcha?.execute) {
                if (recaptchaStatus) recaptchaStatus.textContent = 'Verification could not load. Please check your connection and try again.';
                return;
            }

            if (submitButton) submitButton.disabled = true;
            if (recaptchaStatus) recaptchaStatus.textContent = 'Verifying submission…';

            window.grecaptcha.ready(() => {
                window.grecaptcha.execute(recaptchaSiteKey, { action: recaptchaAction })
                    .then((token) => {
                        if (!token || !recaptchaToken) throw new Error('Missing verification token');
                        recaptchaToken.value = token;
                        recaptchaSubmitting = true;
                        HTMLFormElement.prototype.submit.call(multiStepForm);
                    })
                    .catch(() => {
                        if (submitButton) submitButton.disabled = false;
                        if (recaptchaStatus) recaptchaStatus.textContent = 'Verification failed. Please try again.';
                    });
            });
        });

        showStep(currentStep);
    }

    const parallaxSelector = [
        '.hero-background img',
        '.people-mosaic img',
        '.partner-photo img',
        '.dream-background img',
        '.project-showcase-media img',
        '.home-team-card img',
        '.team-card-image img',
        '.engineer-feature-image img',
        '.services-image > img',
        '.community-photo img',
        '.inner-hero-media img',
        '.editorial-image img',
        '.next-project-image img',
        '.service-index-image img',
        '.project-tile img',
        '.contact-hero-image img',
        '.footer-photo img'
    ].join(',');
    const parallaxImages = [...document.querySelectorAll(parallaxSelector)];
    parallaxImages.forEach((image) => image.classList.add('parallax-image'));

    const beamAssembly = document.querySelector('[data-beam-assembly]');
    const beamMember = beamAssembly?.querySelector('[data-beam-member]');
    const beamColumns = [...(beamAssembly?.querySelectorAll('[data-beam-column]') || [])];
    const beamPlates = [...(beamAssembly?.querySelectorAll('[data-beam-plate]') || [])];
    const beamBolts = [...(beamAssembly?.querySelectorAll('[data-beam-plate] i') || [])];
    const beamLevel = beamAssembly?.querySelector('[data-beam-level]');
    const beamPhases = [...(beamAssembly?.querySelectorAll('[data-beam-phase]') || [])];

    const clamp = (value, min = 0, max = 1) => Math.max(min, Math.min(max, value));
    const smooth = (value) => {
        const progress = clamp(value);
        return progress * progress * (3 - 2 * progress);
    };

    const updateBeamAssembly = (forceComplete = false) => {
        if (!beamAssembly || !beamMember) return;
        const rect = beamAssembly.getBoundingClientRect();
        const travel = Math.max(1, rect.height - window.innerHeight);
        const progress = forceComplete ? 1 : clamp(-rect.top / travel);
        const columnProgress = smooth(progress / .28);
        const memberProgress = smooth((progress - .12) / .5);
        const connectionProgress = smooth((progress - .58) / .2);
        const boltProgress = smooth((progress - .7) / .18);

        beamColumns.forEach((column) => {
            column.style.transform = `translateY(${(1 - columnProgress) * 100}px)`;
            column.style.opacity = String(.28 + columnProgress * .72);
        });
        beamMember.style.transform = `translate3d(${(1 - memberProgress) * -95}vw, ${(1 - memberProgress) * -30}px, 0) rotate(${(1 - memberProgress) * -3}deg)`;
        beamMember.style.opacity = String(.3 + memberProgress * .7);
        beamPlates.forEach((plate) => {
            plate.style.opacity = String(connectionProgress);
            plate.style.transform = `scale(${.72 + connectionProgress * .28})`;
        });
        beamBolts.forEach((bolt, index) => {
            bolt.style.transform = `scale(${clamp(boltProgress * 1.35 - index * .07)})`;
        });
        if (beamLevel) beamLevel.style.width = `${progress * 100}%`;

        const activePhase = progress < .36 ? 0 : progress < .72 ? 1 : 2;
        beamPhases.forEach((phase, index) => phase.classList.toggle('active', index === activePhase));
    };

    let ticking = false;
    const updateParallax = () => {
        const viewport = window.innerHeight;
        parallaxImages.forEach((image) => {
            const frame = image.parentElement;
            if (!frame) return;
            const rect = frame.getBoundingClientRect();
            if (rect.bottom < 0 || rect.top > viewport) return;
            const distance = viewport / 2 - (rect.top + rect.height / 2);
            const strength = window.innerWidth <= 620 ? 22 : 38;
            const ratio = Math.max(-1, Math.min(1, distance / ((viewport + rect.height) / 2)));
            image.style.translate = `0 ${ratio * strength}px`;
        });
        ticking = false;
    };

    if (!reducedMotion) {
        updateParallax();
        updateBeamAssembly();
        window.addEventListener('scroll', () => {
            if (ticking) return;
            ticking = true;
            requestAnimationFrame(() => {
                updateParallax();
                updateBeamAssembly();
            });
        }, { passive: true });
        window.addEventListener('resize', () => {
            updateParallax();
            updateBeamAssembly();
        }, { passive: true });
    } else {
        updateBeamAssembly(true);
    }
})();

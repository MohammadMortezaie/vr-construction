<?php
$page_title = 'Vancouver Custom Homes & Renovations | VR Plus Construction';
$page_description = 'VR Plus Construction builds custom homes, complete renovations and commercial spaces across Vancouver and Metro Vancouver with clear planning and quality craftsmanship.';
$canonical = 'https://vrplusconstruction.com/';
$body_class = 'home-page';
$active_page = 'home';
$og_image = 'https://vrplusconstruction.com/assets/images/VR-Construction-Team.webp';
require __DIR__ . '/includes/header.php';
?>

<main id="main-content">
    <section class="hero" aria-labelledby="hero-title">
        <div class="hero-background" aria-hidden="true">
            <img src="/assets/images/VR-Construction-Team.webp" width="1565" height="1005" alt="">
        </div>
        <div class="hero-shade" aria-hidden="true"></div>
        <div class="hero-content">
            <h1 id="hero-title"><strong>Built Right.</strong> Great Spaces for Everyone.</h1>
            <div class="hero-actions">
                <a class="button button-accent" href="/projects.php">See Our Work</a>
                <a class="button button-dark" href="/contact.php">Start a Project</a>
            </div>
        </div>
        <a class="hero-scroll" href="#about" aria-label="Scroll to learn about VR Plus Construction">
            <span>Scroll</span><i></i>
        </a>
    </section>

    <section class="build-story blueprint-section" id="about">
        <div class="story-copy reveal">
            <h2><strong>We Love to Build.</strong><br>It’s Who We Are<br>and What We Do.</h2>
            <p>It’s not only what we build. It’s how we deliver it. VR Plus Construction brings clear planning, accountable coordination and care for the details to every residential and commercial project.</p>
            <p>From custom homes and full renovations to commercial improvements, our team connects the people, information and decisions required to move the work forward with confidence.</p>
            <a class="button button-accent" href="/about.php">How We Build</a>
        </div>

        <div class="people-mosaic" aria-label="VR Plus project and construction imagery">
            <figure class="mosaic-a reveal"><img src="/assets/images/commercial-site.webp" width="768" height="1024" alt="Commercial construction work in progress" loading="lazy"></figure>
            <figure class="mosaic-b reveal"><img src="/assets/images/project-interior-2.webp" width="738" height="741" alt="Construction professional working on a building envelope" loading="lazy"></figure>
            <figure class="mosaic-c reveal"><img src="/assets/images/project-modern-home.webp" width="1440" height="810" alt="Builder reviewing a renovation plan with homeowners" loading="lazy"></figure>
            <figure class="mosaic-d reveal"><img src="/assets/images/design-engineering.webp" width="1024" height="576" alt="Project planning and design coordination" loading="lazy"></figure>
            <figure class="mosaic-e reveal"><img src="/assets/images/project-interior-1.webp" width="738" height="741" alt="Commercial construction structure" loading="lazy"></figure>
            <figure class="mosaic-f reveal"><img src="/assets/images/projects/taylor-way-west-vancouver-01.webp" width="1080" height="654" alt="Completed West Vancouver renovation" loading="lazy"></figure>
            <figure class="mosaic-g reveal"><img src="/assets/images/luxury-interior.webp" width="1280" height="720" alt="Completed modern interior construction" loading="lazy"></figure>
        </div>
    </section>

    <section class="partner-section" id="approach">
        <div class="partner-photo">
            <img src="/assets/images/project-interior-2.webp" width="738" height="741" alt="Construction professional completing building-envelope work" loading="lazy">
        </div>
        <article class="partner-card reveal">
            <p class="section-kicker">A trusted, collaborative partner</p>
            <h2>Focused on your goals.</h2>
            <p>We are builders and problem solvers. By connecting design, budgeting, permits, procurement and site execution, we make complex work easier to understand and easier to move forward.</p>
            <a class="button button-accent" href="/services.php">Our Approach</a>
        </article>
    </section>

    <section class="beam-assembly" data-beam-assembly aria-labelledby="beam-title">
        <div class="beam-stage">
            <div class="beam-copy">
                <p class="section-kicker light">Engineering in motion</p>
                <h2 id="beam-title"><strong>Designed to Carry.</strong><br>Built to Connect.</h2>
                <p>Structural engineering, coordination and field execution come together at every connection. Scroll to assemble the frame.</p>
                <div class="beam-phases" aria-label="Structural delivery phases">
                    <span class="active" data-beam-phase="0">01 · Engineer</span>
                    <span data-beam-phase="1">02 · Coordinate</span>
                    <span data-beam-phase="2">03 · Build</span>
                </div>
            </div>
            <div class="beam-visual" aria-hidden="true">
                <div class="beam-grid-lines"></div>
                <div class="beam-column beam-column-left" data-beam-column><i></i></div>
                <div class="beam-column beam-column-right" data-beam-column><i></i></div>
                <div class="beam-member" data-beam-member><i></i><span>VR+</span></div>
                <div class="beam-plate beam-plate-left" data-beam-plate><i></i><i></i><i></i><i></i></div>
                <div class="beam-plate beam-plate-right" data-beam-plate><i></i><i></i><i></i><i></i></div>
                <div class="beam-level"><span data-beam-level></span></div>
            </div>
            <div class="beam-scroll-note"><span>Scroll to assemble</span><i></i></div>
        </div>
    </section>

    <section class="dream-section" aria-label="VR Plus construction capability">
        <div class="dream-background" aria-hidden="true">
            <img src="/assets/images/multiplex-house.webp" width="1920" height="1080" alt="">
        </div>
        <div class="dream-overlay" aria-hidden="true"></div>
        <div class="dream-lines" aria-hidden="true"><i></i><i></i><i></i></div>
        <div class="dream-copy reveal">
            <span>If you can dream it</span>
            <strong>We can build it.</strong>
        </div>
    </section>

    <section class="work-section" id="work">
        <div class="work-intro reveal">
            <div>
                <p class="section-kicker">Selected work</p>
                <h2><strong>Built With Purpose.</strong><br>Finished With Pride.</h2>
            </div>
            <div class="work-intro-aside">
                <p>From custom homes to commercial spaces, every project is shaped by clear planning, careful coordination and work made to last.</p>
                <a class="text-link" href="/projects.php">Explore all projects <span>→</span></a>
            </div>
        </div>

        <div class="project-showcase">
            <article class="project-feature project-feature-primary reveal">
                <a href="/projects.php#west-vancouver-home-renovation">
                    <div class="project-showcase-media"><img src="/assets/images/projects/home-renovation-west-vancouver-07.webp" width="1600" height="1200" alt="Completed home renovation project in West Vancouver" loading="lazy"></div>
                    <div class="project-feature-overlay"></div>
                    <div class="project-feature-copy"><span>01 · Residential Renovation</span><h3>Home Renovation Project</h3><p>West Vancouver, BC</p></div>
                    <b aria-hidden="true">↗</b>
                </a>
            </article>
            <article class="project-feature reveal">
                <a href="/projects.php#328-taylor-way">
                    <div class="project-showcase-media"><img src="/assets/images/projects/taylor-way-west-vancouver-01.webp" width="1080" height="654" alt="Construction project at 328 Taylor Way in West Vancouver" loading="lazy"></div>
                    <div class="project-feature-overlay"></div>
                    <div class="project-feature-copy"><span>02 · Residential Construction</span><h3>328 Taylor Way</h3><p>West Vancouver, BC</p></div>
                    <b aria-hidden="true">↗</b>
                </a>
            </article>
            <article class="project-feature reveal">
                <a href="/projects.php#north-vancouver-luxury-garage">
                    <div class="project-showcase-media"><img src="/assets/images/projects/luxury-garage-north-vancouver-03.webp" width="1080" height="1342" alt="Luxury garage renovation in North Vancouver" loading="lazy"></div>
                    <div class="project-feature-overlay"></div>
                    <div class="project-feature-copy"><span>03 · Specialty Renovation</span><h3>Luxury Garage Renovation</h3><p>North Vancouver, BC</p></div>
                    <b aria-hidden="true">↗</b>
                </a>
            </article>
            <article class="project-feature reveal">
                <a href="/projects.php#chilliwack-storage-building">
                    <div class="project-showcase-media"><img src="/assets/images/projects/storage-building-chilliwack-01.webp" width="1600" height="1200" alt="Storage building project in Chilliwack" loading="lazy"></div>
                    <div class="project-feature-overlay"></div>
                    <div class="project-feature-copy"><span>04 · Commercial Construction</span><h3>Storage Building</h3><p>Chilliwack, BC</p></div>
                    <b aria-hidden="true">↗</b>
                </a>
            </article>
            <article class="project-feature project-feature-wide reveal">
                <a href="/projects.php#delta-lighting-pole">
                    <div class="project-showcase-media"><img src="/assets/images/projects/lighting-pole-delta-01.webp" width="1200" height="1600" alt="Lighting pole installation project in Delta" loading="lazy"></div>
                    <div class="project-feature-overlay"></div>
                    <div class="project-feature-copy"><span>05 · Commercial Infrastructure</span><h3>Lighting Pole Project</h3><p>Delta, BC</p></div>
                    <b aria-hidden="true">↗</b>
                </a>
            </article>
        </div>
    </section>

    <section class="home-project-film">
        <div class="home-project-film-copy reveal">
            <p class="section-kicker light">Project film · Coquitlam</p>
            <h2><strong>291 Panorama Drive.</strong><br>See the Work in Motion.</h2>
            <p>Watch a closer view of the construction process and completed work, then explore the full project collection.</p>
            <a class="button button-accent" href="/projects.php#291-panorama-drive">Explore the Project</a>
        </div>
        <div class="home-project-film-media reveal">
            <video controls playsinline preload="metadata" poster="/assets/images/projects/panorama-drive-coquitlam-poster.webp">
                <source src="/assets/images/projects/panorama-drive-coquitlam.mp4" type="video/mp4">
                Your browser does not support HTML video.
            </video>
        </div>
    </section>

    <section class="solutions-section" id="services">
        <div class="solutions-heading reveal">
            <h2><strong>Solving Problems</strong><br>Before They Happen.</h2>
            <p>We combine construction experience, organized planning and active coordination to identify challenges early while protecting your budget, schedule and finished result.</p>
        </div>

        <div class="services-stage">
            <div class="services-image" data-service-images>
                <img class="active" data-service-image="0" src="/assets/images/design-engineering.webp" width="1024" height="576" alt="Planning before construction">
                <img data-service-image="1" src="/assets/images/pre-construction.webp" width="1024" height="576" alt="Structural engineers reviewing concrete formwork and reinforcement on site" loading="lazy">
                <img data-service-image="2" src="/assets/images/project-interior-2.webp" width="738" height="741" alt="Construction management" loading="lazy">
                <img data-service-image="3" src="/assets/images/energy-efficient-homes.webp" width="768" height="432" alt="Energy-efficient home construction" loading="lazy">
                <div class="services-image-shade" aria-hidden="true"></div>
            </div>

            <div class="service-tabs" role="tablist" aria-label="Construction services">
                <button class="active" type="button" role="tab" aria-selected="true" data-service-tab="0">
                    <span>01</span><strong>Preconstruction</strong><small>Plan scope, budget, schedule and procurement before site work begins.</small>
                </button>
                <button type="button" role="tab" aria-selected="false" data-service-tab="1">
                    <span>02</span><strong>Structural Engineering</strong><small>Licensed structural design and coordination led by Moe Ghanbari, P.Eng., M.Sc.</small>
                </button>
                <button type="button" role="tab" aria-selected="false" data-service-tab="2">
                    <span>03</span><strong>Construction Management</strong><small>Keep trades, information, quality and schedule aligned.</small>
                </button>
                <button type="button" role="tab" aria-selected="false" data-service-tab="3">
                    <span>04</span><strong>High Performance Homes</strong><small>Integrate envelope, insulation and efficient building systems.</small>
                </button>
            </div>
        </div>
    </section>

    <section class="home-team-section">
        <div class="home-team-heading reveal">
            <div><p class="section-kicker">Our team</p><h2><strong>Real People.</strong><br>Connected Expertise.</h2></div>
            <div><p>Construction, restoration, structural engineering and project coordination working as one team.</p><a class="text-link" href="/team.php">Meet everyone <span>→</span></a></div>
        </div>
        <div class="home-team-grid">
            <a class="home-team-card reveal" href="/team.php"><div><img src="/assets/images/team-sasan-ghanbari.webp" width="600" height="600" alt="Sasan Ghanbari" loading="lazy"></div><span>Founder & CEO</span><h3>Sasan Ghanbari</h3></a>
            <a class="home-team-card reveal" href="/team.php"><div><img src="/assets/images/team-saman-ghanbari.webp" width="600" height="600" alt="Saman Ghanbari" loading="lazy"></div><span>Restoration & Logistics</span><h3>Saman Ghanbari</h3></a>
            <a class="home-team-card home-team-engineer reveal" href="/structural-engineering.php"><div><img src="/assets/images/team-moe-ghanbari.webp" width="900" height="900" alt="Moe Ghanbari, Structural Engineer" loading="lazy"></div><span>Structural Engineer · P.Eng. · M.Sc.</span><h3>Moe Ghanbari</h3></a>
        </div>
    </section>

    <section class="certification-section" aria-labelledby="certification-title">
        <div class="certification-heading reveal">
            <p class="section-kicker">Credentials & memberships</p>
            <h2 id="certification-title"><strong>Recognized.</strong><br>Connected. Accountable.</h2>
        </div>
        <div class="certification-grid">
            <article class="certification-card reveal"><div><img src="/assets/images/cert-iicrc.webp" width="300" height="100" alt="IICRC Certified" loading="lazy"></div><p>IICRC Certified</p></article>
            <article class="certification-card reveal"><div><img src="/assets/images/cert-bc-housing.webp" width="300" height="71" alt="BC Housing" loading="lazy"></div><p>BC Housing</p></article>
            <article class="certification-card reveal"><div><img src="/assets/images/cert-vrca.webp" width="300" height="118" alt="VRCA Certified in Vancouver" loading="lazy"></div><p>VRCA Certified in Vancouver</p></article>
            <article class="certification-card reveal"><div><img src="/assets/images/cert-home-depot.webp" width="300" height="200" alt="Home Depot Certified" loading="lazy"></div><p>Home Depot Certified</p></article>
            <article class="certification-card reveal"><div><img src="/assets/images/cert-proudly-canadian.webp" width="300" height="82" alt="Proudly Canadian Business" loading="lazy"></div><p>Proudly Canadian Business</p></article>
            <article class="certification-card reveal"><div><img src="/assets/images/cert-member-canada.webp" width="1024" height="256" alt="Member of Canadian construction associations" loading="lazy"></div><p>Construction Association Memberships</p></article>
        </div>
    </section>

    <section class="community-section">
        <div class="community-photo" aria-hidden="true">
            <img src="/assets/images/projects/panorama-drive-coquitlam-poster.webp" width="1920" height="1080" alt="">
        </div>
        <div class="community-shade" aria-hidden="true"></div>
        <div class="community-copy reveal">
            <p class="section-kicker light">Built here. Committed here.</p>
            <h2>Local Builders, Deeply Committed to Our Communities.</h2>
            <p>We serve Vancouver, West Vancouver, North Vancouver, Burnaby, Coquitlam, Richmond, Surrey and Delta with local knowledge and a practical, accountable approach.</p>
            <a class="button button-accent" href="/contact.php">Talk With Our Team</a>
        </div>
    </section>

    <section class="insights-section" id="insights">
        <div class="insights-heading">
            <div class="reveal"><p class="section-kicker">Project guidance</p><h2>Questions Owners Should Ask Early.</h2></div>
            <a class="text-link" href="/blog/">Explore the Journal <span>→</span></a>
        </div>

        <div class="insights-grid">
            <article class="insight-card reveal">
                <a href="/small-home-remodeling-vancouver/"><img src="/assets/images/blog/change-home-1.webp" width="1402" height="1122" alt="Small home remodeling ideas for limited space" loading="lazy"><div><p>Renovation</p><h3>Smart Ideas for Remodeling a Smaller Home</h3><span>Space-saving design, better storage and practical ways to make limited square footage work harder.</span></div></a>
            </article>
            <article class="insight-card reveal">
                <a href="/kitchen-remodeling-vancouver/"><img src="/assets/images/blog/kitchen-remodeling-in-vancouver-bc-affordable-1.webp" width="1536" height="1024" alt="Modern kitchen remodeling in Vancouver" loading="lazy"><div><p>Kitchen Remodeling</p><h3>Modern Design, Cost and Renovation Planning</h3><span>What Vancouver homeowners should consider before starting a complete kitchen remodel.</span></div></a>
            </article>
            <article class="insight-card reveal">
                <a href="/barbershop-renovation-vancouver/"><img src="/assets/images/blog/barbershop-vancouver-renovation.webp" width="1536" height="1024" alt="Modern barbershop renovation in Vancouver" loading="lazy"><div><p>Commercial</p><h3>Barbershop Renovation and Buildout Guide</h3><span>Design priorities, typical costs and construction planning for a modern commercial interior.</span></div></a>
            </article>
        </div>
    </section>

    <section class="faq-section" aria-labelledby="faq-title">
        <div class="faq-heading reveal">
            <p class="section-kicker">Straight answers</p>
            <h2 id="faq-title">Planning a Project in Metro Vancouver?</h2>
        </div>
        <div class="faq-list">
            <details open>
                <summary>What does VR Plus Construction build?<i></i></summary>
                <p>VR Plus Construction delivers custom homes, full home renovations, condo renovations, commercial improvements, early project planning and construction management.</p>
            </details>
            <details>
                <summary>Which areas do you serve?<i></i></summary>
                <p>We serve Vancouver, West Vancouver, North Vancouver, Burnaby, Coquitlam, Richmond, Surrey, Delta and nearby Metro Vancouver communities.</p>
            </details>
            <details>
                <summary>Can you help with design, engineering and permits?<i></i></summary>
                <p>Yes. We coordinate with qualified designers, engineers and permit professionals based on the requirements of each project.</p>
            </details>
            <details>
                <summary>How can I discuss a new project?<i></i></summary>
                <p>Call <a href="tel:+17783186796">(778) 318-6796</a> or email <a href="mailto:admin@vrplusconstruction.com">admin@vrplusconstruction.com</a> with your project type, location and preferred timing.</p>
            </details>
        </div>
    </section>
</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "HomeAndConstructionBusiness",
      "@id": "https://vrplusconstruction.com/#business",
      "name": "VR Plus Construction",
      "url": "https://vrplusconstruction.com/",
      "logo": "https://vrplusconstruction.com/assets/images/brand-logo.webp",
      "image": "https://vrplusconstruction.com/assets/images/VR-Construction-Team.webp",
      "telephone": "+1-778-318-6796",
      "email": "admin@vrplusconstruction.com",
      "sameAs": ["https://www.linkedin.com/company/vr-plus-construction-and-restoration"],
      "address": [
        {"@type": "PostalAddress", "streetAddress": "636 Clyde Ave", "addressLocality": "West Vancouver", "addressRegion": "BC", "addressCountry": "CA"},
        {"@type": "PostalAddress", "streetAddress": "828 Harbourside Dr", "addressLocality": "North Vancouver", "addressRegion": "BC", "addressCountry": "CA"},
        {"@type": "PostalAddress", "streetAddress": "3030 Lincoln Ave", "addressLocality": "Coquitlam", "addressRegion": "BC", "addressCountry": "CA"}
      ],
      "areaServed": ["Vancouver", "West Vancouver", "North Vancouver", "Burnaby", "Coquitlam", "Richmond", "Surrey", "Delta"]
    },
    {
      "@type": "FAQPage",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "What does VR Plus Construction build?",
          "acceptedAnswer": {"@type": "Answer", "text": "VR Plus Construction delivers custom homes, full home renovations, condo renovations, commercial improvements, early project planning and construction management."}
        },
        {
          "@type": "Question",
          "name": "Which areas does VR Plus Construction serve?",
          "acceptedAnswer": {"@type": "Answer", "text": "VR Plus Construction serves Vancouver, West Vancouver, North Vancouver, Burnaby, Coquitlam, Richmond, Surrey, Delta and nearby Metro Vancouver communities."}
        },
        {
          "@type": "Question",
          "name": "Can VR Plus help with design, engineering and permits?",
          "acceptedAnswer": {"@type": "Answer", "text": "Yes. VR Plus coordinates with qualified designers, engineers and permit professionals based on the requirements of each project."}
        }
      ]
    }
  ]
}
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>

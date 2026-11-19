<?php
$page_title = 'Construction Services Vancouver | VR Plus Construction';
$page_description = 'Explore residential, commercial, renovation, custom home, early planning and construction management services from VR Plus Construction.';
$canonical = 'https://vrplusconstruction.com/services.php';
$body_class = 'inner-body';
$active_page = 'services';
require __DIR__ . '/includes/header.php';

$services = [
    ['number' => '01', 'title' => 'Residential Construction', 'text' => 'Custom homes and major residential projects planned around real life.', 'image' => '/assets/images/contemporary-home.webp', 'url' => '/residential.php'],
    ['number' => '02', 'title' => 'Commercial Construction', 'text' => 'Commercial improvements and interior builds managed around schedule and operations.', 'image' => '/assets/images/commercial-site.webp', 'url' => '/commercial.php'],
    ['number' => '03', 'title' => 'Custom Homes', 'text' => 'New homes that connect your vision, site, systems and details.', 'image' => '/assets/images/multiplex-house.webp', 'url' => '/custom-homes.php'],
    ['number' => '04', 'title' => 'Renovations', 'text' => 'Complete home, condo and interior transformations with clear coordination.', 'image' => '/assets/images/renovation-project.webp', 'url' => '/renovations.php'],
    ['number' => '05', 'title' => 'Structural Engineering', 'text' => 'Licensed structural design and coordination led by Moe Ghanbari, P.Eng., M.Sc.', 'image' => '/assets/images/design-engineering.webp', 'url' => '/structural-engineering.php'],
    ['number' => '06', 'title' => 'Construction Management', 'text' => 'Accountable coordination from early planning through closeout.', 'image' => '/assets/images/construction-management.webp', 'url' => '/construction-management.php'],
    ['number' => '07', 'title' => 'Design + Engineering Coordination', 'text' => 'Connect design intent, consultants, permits and buildability before work begins.', 'image' => '/assets/images/project-kitchen.webp', 'url' => '/structural-engineering.php']
];
?>

<main id="main-content" class="inner-page">
    <section class="inner-hero services-hero">
        <div class="inner-hero-media" aria-hidden="true"><img src="/assets/images/project-kitchen.webp" width="2560" height="1706" alt=""></div>
        <div class="inner-hero-shade" aria-hidden="true"></div>
        <div class="inner-hero-content">
            <p class="inner-eyebrow">What we do</p>
            <h1><strong>Plan With Clarity.</strong><br>Build With Confidence.</h1>
            <p>Residential and commercial construction services connected by one practical, accountable delivery process.</p>
        </div>
    </section>

    <section class="services-index blueprint-section">
        <div class="services-index-heading reveal">
            <p class="section-kicker">Construction expertise</p>
            <h2><strong>Built to Solve</strong><br>the Whole Problem.</h2>
            <p>Every project is different, but the fundamentals stay consistent: understand the goal, expose risk early, coordinate the right people and protect the finished result.</p>
        </div>
        <div class="service-card-grid">
            <?php foreach ($services as $service): ?>
                <a class="service-index-card reveal" href="<?= $service['url'] ?>">
                    <div class="service-index-image"><img src="<?= $service['image'] ?>" width="800" height="600" alt="<?= htmlspecialchars($service['title'], ENT_QUOTES, 'UTF-8') ?>" loading="lazy"></div>
                    <div class="service-index-copy">
                        <span><?= $service['number'] ?></span>
                        <h2><?= htmlspecialchars($service['title'], ENT_QUOTES, 'UTF-8') ?></h2>
                        <p><?= htmlspecialchars($service['text'], ENT_QUOTES, 'UTF-8') ?></p>
                        <b>Explore service →</b>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="process-section">
        <div class="process-heading reveal"><p class="section-kicker light">How we work</p><h2>One Connected<br>Building Process.</h2></div>
        <ol class="process-list">
            <li class="reveal"><span>01</span><div><h3>Understand</h3><p>Clarify the project, priorities, site, constraints and measures of success.</p></div></li>
            <li class="reveal"><span>02</span><div><h3>Coordinate</h3><p>Align design, budget, schedule, approvals, procurement and responsibilities.</p></div></li>
            <li class="reveal"><span>03</span><div><h3>Build</h3><p>Lead the site with clear information, active management and quality control.</p></div></li>
            <li class="reveal"><span>04</span><div><h3>Complete</h3><p>Close details, organize documentation and provide a clear handover.</p></div></li>
        </ol>
    </section>
</main>

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"ItemList","name":"VR Plus Construction Services","itemListElement":[{"@type":"ListItem","position":1,"name":"Residential Construction","url":"https://vrplusconstruction.com/residential.php"},{"@type":"ListItem","position":2,"name":"Commercial Construction","url":"https://vrplusconstruction.com/commercial.php"},{"@type":"ListItem","position":3,"name":"Custom Homes","url":"https://vrplusconstruction.com/custom-homes.php"},{"@type":"ListItem","position":4,"name":"Renovations","url":"https://vrplusconstruction.com/renovations.php"},{"@type":"ListItem","position":5,"name":"Structural Engineering","url":"https://vrplusconstruction.com/structural-engineering.php"},{"@type":"ListItem","position":6,"name":"Construction Management","url":"https://vrplusconstruction.com/construction-management.php"},{"@type":"ListItem","position":7,"name":"Design and Engineering Coordination","url":"https://vrplusconstruction.com/structural-engineering.php"}]}
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>

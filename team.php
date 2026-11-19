<?php
$page_title = 'Our Team | VR Plus Construction Vancouver';
$page_description = 'Meet the VR Plus Construction team, including builders, project coordinators, restoration specialists and licensed structural engineer Moe Ghanbari, P.Eng., M.Sc.';
$canonical = 'https://vrplusconstruction.com/team.php';
$body_class = 'inner-body team-body';
$active_page = 'team';
$og_image = 'https://vrplusconstruction.com/assets/images/team-moe-ghanbari.webp';
require __DIR__ . '/includes/header.php';

$team_members = [
    ['name' => 'Sasan Ghanbari', 'role' => 'Founder & CEO', 'image' => '/assets/images/team-sasan-ghanbari.webp'],
    ['name' => 'Saman Ghanbari', 'role' => 'Restoration & Logistics Manager', 'image' => '/assets/images/team-saman-ghanbari.webp'],
    ['name' => 'Moe Ghanbari', 'role' => 'Structural Engineer, P.Eng., M.Sc.', 'image' => '/assets/images/team-moe-ghanbari.webp'],
    ['name' => 'Moe Mortezaei', 'role' => 'IT & Web Developer', 'image' => '/assets/images/team-moe-mortezaei.webp'],
    ['name' => 'Nirvana Asadi', 'role' => 'Project Coordinator', 'image' => '/assets/images/team-nirvana-asadi.webp']
];

$team_schema = [
    '@context' => 'https://schema.org',
    '@type' => 'AboutPage',
    'name' => 'VR Plus Construction Team',
    'url' => $canonical,
    'about' => [
        '@type' => 'Organization',
        'name' => 'VR Plus Construction',
        'employee' => array_map(static fn(array $member): array => [
            '@type' => 'Person',
            'name' => $member['name'],
            'jobTitle' => $member['role'],
            'image' => 'https://vrplusconstruction.com' . $member['image']
        ], $team_members)
    ]
];
?>

<main id="main-content" class="inner-page">
    <section class="inner-hero team-hero">
        <div class="inner-hero-media" aria-hidden="true"><img src="/assets/images/VR-Construction-Team-v2.webp" width="1672" height="941" alt=""></div>
        <div class="inner-hero-shade" aria-hidden="true"></div>
        <div class="inner-hero-content">
            <p class="inner-eyebrow">Our Team</p>
            <h1><strong>Expertise Behind</strong><br>Every Decision.</h1>
            <p>Builders, coordinators and technical professionals working together to move complex projects forward with clarity.</p>
        </div>
    </section>

    <section class="team-intro blueprint-section">
        <div class="team-intro-heading reveal">
            <p class="section-kicker">The people behind the work</p>
            <h2><strong>Different Skills.</strong><br>One Standard.</h2>
        </div>
        <div class="team-intro-copy reveal">
            <p>VR Plus Construction brings construction, restoration, logistics, structural engineering, project coordination and digital systems into one collaborative team.</p>
            <p>That range of experience helps us identify challenges earlier, communicate decisions clearly and keep each project connected from planning through completion.</p>
        </div>
    </section>

    <section class="team-directory">
        <div class="team-directory-heading reveal">
            <p class="section-kicker">Meet VR Plus</p>
            <h2>Our Team.</h2>
        </div>
        <div class="team-grid">
            <?php foreach ($team_members as $index => $member): ?>
                <article class="team-card reveal<?= $member['name'] === 'Moe Ghanbari' ? ' is-engineer' : '' ?>">
                    <div class="team-card-image"><img src="<?= htmlspecialchars($member['image'], ENT_QUOTES, 'UTF-8') ?>" width="900" height="900" alt="<?= htmlspecialchars($member['name'], ENT_QUOTES, 'UTF-8') ?>" loading="lazy"></div>
                    <div class="team-card-copy"><span><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span><h2><?= htmlspecialchars($member['name'], ENT_QUOTES, 'UTF-8') ?></h2><p><?= htmlspecialchars($member['role'], ENT_QUOTES, 'UTF-8') ?></p></div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="engineer-feature">
        <div class="engineer-feature-image"><img src="/assets/images/team-moe-ghanbari.webp" width="1280" height="1280" alt="Moe Ghanbari, Structural Engineer at VR Plus Construction" loading="lazy"></div>
        <div class="engineer-feature-copy reveal">
            <p class="section-kicker light">Structural Engineering</p>
            <h2>Moe Ghanbari</h2>
            <p class="engineer-credential">Structural Engineer, P.Eng., M.Sc.</p>
            <p>Moe is a licensed Professional Engineer (P.Eng.) with over 8 years of experience in structural and civil engineering across Canada and Germany. His expertise includes structural design, roadway and pedestrian bridges, retaining walls, culverts, foundations, and infrastructure projects, as well as site inspections and multidisciplinary coordination.
He has contributed to the delivery of complex projects at various stages, from tendering and feasibility studies through detailed design, construction, and site management. At VR Plus, he provides structural engineering expertise, supporting technical assessments, design development, and practical engineering solutions for construction, renovation, and structural improvement projects.</p>
            <a class="button button-accent" href="/structural-engineering.php">Structural Engineering Services</a>
        </div>
    </section>

    <section class="next-project">
        <div class="next-project-image" aria-hidden="true"><img src="/assets/images/projects/home-renovation-west-vancouver-07.webp" width="1600" height="1200" alt="" loading="lazy"></div>
        <div class="next-project-shade" aria-hidden="true"></div>
        <div class="next-project-copy reveal"><p class="section-kicker light">Work with our team</p><h2>Bring Us Your Challenge.</h2><a class="button button-accent" href="/contact.php">Start a Conversation</a></div>
    </section>
</main>

<script type="application/ld+json"><?= json_encode($team_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>

<?php require __DIR__ . '/includes/footer.php'; ?>

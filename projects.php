<?php
$page_title = 'Completed Construction Projects Vancouver | VR Plus Construction';
$page_description = 'Explore real VR Plus Construction renovation, residential and commercial projects in West Vancouver, North Vancouver, Coquitlam, Chilliwack and Delta.';
$canonical = 'https://vrplusconstruction.com/projects.php';
$body_class = 'inner-body';
$active_page = 'projects';
$og_image = 'https://vrplusconstruction.com/assets/images/projects/home-renovation-west-vancouver-07.webp';
require __DIR__ . '/includes/header.php';

$projects = [
    [
        'id' => 'west-vancouver-home-renovation',
        'title' => 'Home Renovation Project',
        'location' => 'West Vancouver, BC',
        'type' => 'Residential Renovation',
        'summary' => 'A complete interior transformation connecting modern bathrooms, open living areas, new flooring and refined staircase details.',
        'cover' => '/assets/images/projects/home-renovation-west-vancouver-07.webp',
        'images' => array_map(static fn(int $number): string => sprintf('/assets/images/projects/home-renovation-west-vancouver-%02d.webp', $number), range(1, 12))
    ],
    [
        'id' => '328-taylor-way',
        'title' => '328 Taylor Way',
        'location' => 'West Vancouver, BC',
        'type' => 'Residential Construction',
        'summary' => 'Construction and renovation work at 328 Taylor Way, documented through completed exterior and interior spaces.',
        'cover' => '/assets/images/projects/taylor-way-west-vancouver-01.webp',
        'images' => array_map(static fn(int $number): string => sprintf('/assets/images/projects/taylor-way-west-vancouver-%02d.webp', $number), range(1, 5))
    ],
    [
        'id' => 'north-vancouver-luxury-garage',
        'title' => 'Luxury Garage Renovation',
        'location' => 'North Vancouver, BC',
        'type' => 'Specialty Renovation',
        'summary' => 'A premium residential garage created around architectural lighting, polished finishes and carefully planned vehicle storage.',
        'cover' => '/assets/images/projects/luxury-garage-north-vancouver-03.webp',
        'images' => array_map(static fn(int $number): string => sprintf('/assets/images/projects/luxury-garage-north-vancouver-%02d.webp', $number), range(1, 6))
    ],
    [
        'id' => '291-panorama-drive',
        'title' => '291 Panorama Drive',
        'location' => 'Coquitlam, BC',
        'type' => 'Project Film',
        'summary' => 'A closer look at the construction process and completed work at 291 Panorama Drive in Coquitlam.',
        'cover' => '/assets/images/projects/panorama-drive-coquitlam-poster.webp',
        'video' => '/assets/images/projects/panorama-drive-coquitlam.mp4',
        'images' => []
    ],
    [
        'id' => 'chilliwack-storage-building',
        'title' => 'Storage Building',
        'location' => 'Chilliwack, BC',
        'type' => 'Commercial Construction',
        'summary' => 'A durable storage building planned around clean construction, efficient use of space and lasting performance.',
        'cover' => '/assets/images/projects/storage-building-chilliwack-01.webp',
        'images' => ['/assets/images/projects/storage-building-chilliwack-01.webp']
    ],
    [
        'id' => 'delta-lighting-pole',
        'title' => 'Lighting Pole Project',
        'location' => 'Delta, BC',
        'type' => 'Commercial Infrastructure',
        'summary' => 'Lighting pole installation work delivered with careful site coordination and attention to the finished result.',
        'cover' => '/assets/images/projects/lighting-pole-delta-01.webp',
        'images' => [
            '/assets/images/projects/lighting-pole-delta-01.webp',
            '/assets/images/projects/lighting-pole-delta-02.webp'
        ]
    ]
];

$project_schema = [
    '@context' => 'https://schema.org',
    '@type' => 'CollectionPage',
    'name' => 'Completed VR Plus Construction Projects',
    'description' => $page_description,
    'url' => $canonical,
    'mainEntity' => [
        '@type' => 'ItemList',
        'itemListElement' => array_map(static fn(array $project, int $index): array => [
            '@type' => 'ListItem',
            'position' => $index + 1,
            'name' => $project['title'] . ', ' . $project['location'],
            'url' => 'https://vrplusconstruction.com/projects.php#' . $project['id'],
            'image' => 'https://vrplusconstruction.com' . $project['cover']
        ], $projects, array_keys($projects))
    ]
];
?>

<main id="main-content" class="inner-page">
    <section class="inner-hero project-hero">
        <div class="inner-hero-media" aria-hidden="true"><img src="/assets/images/projects/home-renovation-west-vancouver-07.webp" width="1600" height="1200" alt=""></div>
        <div class="inner-hero-shade" aria-hidden="true"></div>
        <div class="inner-hero-content"><p class="inner-eyebrow">Real VR Plus projects</p><h1><strong>Built Here.</strong><br>Documented Honestly.</h1><p>Completed renovation, residential and commercial work from across British Columbia, shown through real project photography.</p></div>
    </section>

    <section class="project-index">
        <div class="project-index-heading reveal"><p class="section-kicker">Project directory</p><h2><strong>Real Work.</strong><br>Real Locations.</h2><p>Choose a project to explore its full gallery or watch the Panorama Drive project film.</p></div>
        <div class="project-grid">
            <?php foreach ($projects as $index => $project): ?>
                <article class="project-tile reveal">
                    <a href="#<?= htmlspecialchars($project['id'], ENT_QUOTES, 'UTF-8') ?>">
                        <div><img src="<?= htmlspecialchars($project['cover'], ENT_QUOTES, 'UTF-8') ?>" width="1200" height="900" alt="<?= htmlspecialchars($project['title'] . ' in ' . $project['location'], ENT_QUOTES, 'UTF-8') ?>"<?= $index > 1 ? ' loading="lazy"' : '' ?>></div>
                        <p><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?> · <?= htmlspecialchars($project['type'], ENT_QUOTES, 'UTF-8') ?></p>
                        <h2><?= htmlspecialchars($project['title'], ENT_QUOTES, 'UTF-8') ?></h2>
                        <span><?= htmlspecialchars($project['location'], ENT_QUOTES, 'UTF-8') ?></span>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <div class="project-detail-list">
        <?php foreach ($projects as $project_index => $project): ?>
            <?php
            $gallery_count = count($project['images']);
            $gallery_class = $gallery_count === 1 ? ' is-single' : ($gallery_count === 2 ? ' is-pair' : '');
            ?>
            <section class="project-detail" id="<?= htmlspecialchars($project['id'], ENT_QUOTES, 'UTF-8') ?>" aria-labelledby="<?= htmlspecialchars($project['id'], ENT_QUOTES, 'UTF-8') ?>-title">
                <div class="project-detail-heading reveal">
                    <div><p class="section-kicker"><?= str_pad((string) ($project_index + 1), 2, '0', STR_PAD_LEFT) ?> · <?= htmlspecialchars($project['type'], ENT_QUOTES, 'UTF-8') ?></p><h2 id="<?= htmlspecialchars($project['id'], ENT_QUOTES, 'UTF-8') ?>-title"><?= htmlspecialchars($project['title'], ENT_QUOTES, 'UTF-8') ?></h2></div>
                    <div><p class="project-location"><?= htmlspecialchars($project['location'], ENT_QUOTES, 'UTF-8') ?></p><p><?= htmlspecialchars($project['summary'], ENT_QUOTES, 'UTF-8') ?></p></div>
                </div>

                <?php if (!empty($project['video'])): ?>
                    <div class="project-video-shell reveal">
                        <video controls playsinline preload="metadata" poster="<?= htmlspecialchars($project['cover'], ENT_QUOTES, 'UTF-8') ?>">
                            <source src="<?= htmlspecialchars($project['video'], ENT_QUOTES, 'UTF-8') ?>" type="video/mp4">
                            Your browser does not support HTML video.
                        </video>
                    </div>
                <?php else: ?>
                    <div class="project-gallery<?= $gallery_class ?>">
                        <?php foreach ($project['images'] as $image_index => $image): ?>
                            <figure class="project-gallery-item reveal">
                                <a href="<?= htmlspecialchars($image, ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener" aria-label="Open full image <?= $image_index + 1 ?> from <?= htmlspecialchars($project['title'], ENT_QUOTES, 'UTF-8') ?>">
                                    <img src="<?= htmlspecialchars($image, ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($project['title'] . ' in ' . $project['location'] . ', project image ' . ($image_index + 1), ENT_QUOTES, 'UTF-8') ?>" loading="lazy" decoding="async">
                                    <span aria-hidden="true"><?= str_pad((string) ($image_index + 1), 2, '0', STR_PAD_LEFT) ?> ↗</span>
                                </a>
                            </figure>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        <?php endforeach; ?>
    </div>

    <section class="next-project">
        <div class="next-project-image" aria-hidden="true"><img src="/assets/images/projects/taylor-way-west-vancouver-01.webp" width="1080" height="654" alt="" loading="lazy"></div>
        <div class="next-project-shade" aria-hidden="true"></div>
        <div class="next-project-copy reveal"><p class="section-kicker light">Have a project in mind?</p><h2>Let’s Build the Next One.</h2><a class="button button-accent" href="/contact.php">Start a Conversation</a></div>
    </section>
</main>

<script type="application/ld+json"><?= json_encode($project_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>

<?php require __DIR__ . '/includes/footer.php'; ?>

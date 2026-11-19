<?php
require __DIR__ . '/header.php';

$service_schema = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Service',
            'name' => $service_name,
            'description' => $page_description,
            'provider' => [
                '@type' => 'HomeAndConstructionBusiness',
                'name' => 'VR Plus Construction',
                'telephone' => '+1-778-318-6796',
                'url' => 'https://vrplusconstruction.com/'
            ],
            'areaServed' => ['Vancouver', 'West Vancouver', 'North Vancouver', 'Burnaby', 'Coquitlam', 'Richmond', 'Surrey', 'Delta'],
            'url' => $canonical
        ],
        [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => 'https://vrplusconstruction.com/'],
                ['@type' => 'ListItem', 'position' => 2, 'name' => $service_name, 'item' => $canonical]
            ]
        ],
        [
            '@type' => 'FAQPage',
            'mainEntity' => array_map(static fn(array $item): array => [
                '@type' => 'Question',
                'name' => $item['question'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['answer']]
            ], $faqs)
        ]
    ]
];

if (!empty($service_additional_schema) && is_array($service_additional_schema)) {
    $service_schema['@graph'] = array_merge($service_schema['@graph'], $service_additional_schema);
}
?>

<main id="main-content" class="inner-page">
    <section class="inner-hero">
        <div class="inner-hero-media" aria-hidden="true">
            <img src="<?= htmlspecialchars($hero_image, ENT_QUOTES, 'UTF-8') ?>" width="1440" height="900" alt="">
        </div>
        <div class="inner-hero-shade" aria-hidden="true"></div>
        <div class="inner-hero-content">
            <p class="inner-eyebrow"><?= htmlspecialchars($eyebrow, ENT_QUOTES, 'UTF-8') ?></p>
            <h1><?= $headline ?></h1>
            <p><?= htmlspecialchars($hero_text, ENT_QUOTES, 'UTF-8') ?></p>
        </div>
    </section>

    <section class="service-intro blueprint-section">
        <div class="service-intro-copy reveal">
            <p class="section-kicker"><?= htmlspecialchars($intro_kicker, ENT_QUOTES, 'UTF-8') ?></p>
            <h2><?= $intro_title ?></h2>
        </div>
        <div class="service-intro-body reveal">
            <?php foreach ($intro_paragraphs as $paragraph): ?>
                <p><?= htmlspecialchars($paragraph, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endforeach; ?>
            <a class="button button-accent" href="/contact.php">Discuss Your Project</a>
        </div>
    </section>

    <section class="capability-section">
        <div class="capability-heading reveal">
            <p class="section-kicker">What we deliver</p>
            <h2>Built Around the Needs of Your Project.</h2>
        </div>
        <div class="capability-grid">
            <?php foreach ($capabilities as $index => $capability): ?>
                <article class="capability-card reveal">
                    <span><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
                    <h3><?= htmlspecialchars($capability['title'], ENT_QUOTES, 'UTF-8') ?></h3>
                    <p><?= htmlspecialchars($capability['text'], ENT_QUOTES, 'UTF-8') ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="editorial-split">
        <div class="editorial-image">
            <img src="<?= htmlspecialchars($detail_image, ENT_QUOTES, 'UTF-8') ?>" width="1280" height="900" alt="<?= htmlspecialchars($detail_alt, ENT_QUOTES, 'UTF-8') ?>" loading="lazy">
        </div>
        <div class="editorial-copy reveal">
            <p class="section-kicker"><?= htmlspecialchars($detail_kicker, ENT_QUOTES, 'UTF-8') ?></p>
            <h2><?= $detail_title ?></h2>
            <p><?= htmlspecialchars($detail_text, ENT_QUOTES, 'UTF-8') ?></p>
        </div>
    </section>

    <section class="process-section">
        <div class="process-heading reveal">
            <p class="section-kicker light">Our process</p>
            <h2>Clear Decisions.<br>Accountable Delivery.</h2>
        </div>
        <ol class="process-list">
            <?php foreach ($process as $index => $step): ?>
                <li class="reveal">
                    <span><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
                    <div><h3><?= htmlspecialchars($step['title'], ENT_QUOTES, 'UTF-8') ?></h3><p><?= htmlspecialchars($step['text'], ENT_QUOTES, 'UTF-8') ?></p></div>
                </li>
            <?php endforeach; ?>
        </ol>
    </section>

    <section class="faq-section" aria-labelledby="service-faq-title">
        <div class="faq-heading reveal">
            <p class="section-kicker">Helpful answers</p>
            <h2 id="service-faq-title"><?= htmlspecialchars($faq_title, ENT_QUOTES, 'UTF-8') ?></h2>
        </div>
        <div class="faq-list">
            <?php foreach ($faqs as $index => $faq): ?>
                <details<?= $index === 0 ? ' open' : '' ?>>
                    <summary><?= htmlspecialchars($faq['question'], ENT_QUOTES, 'UTF-8') ?><i></i></summary>
                    <p><?= htmlspecialchars($faq['answer'], ENT_QUOTES, 'UTF-8') ?></p>
                </details>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="next-project">
        <div class="next-project-image" aria-hidden="true"><img src="/assets/images/project-kitchen.webp" width="2560" height="1706" alt="" loading="lazy"></div>
        <div class="next-project-shade" aria-hidden="true"></div>
        <div class="next-project-copy reveal">
            <p class="section-kicker light">Your next project</p>
            <h2>Let’s Build It Right.</h2>
            <a class="button button-accent" href="/contact.php">Start a Conversation</a>
        </div>
    </section>
</main>

<script type="application/ld+json"><?= json_encode($service_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>

<?php require __DIR__ . '/footer.php'; ?>

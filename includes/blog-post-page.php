<?php

declare(strict_types=1);

require_once __DIR__ . '/blog.php';

$post = blog_find_post((string) ($blog_slug ?? ''));
if ($post === null) {
    http_response_code(404);
    $page_title = 'Article Not Found | VR Plus Construction';
    $page_description = 'The requested construction article could not be found.';
    $canonical = 'https://vrplusconstruction.com/';
    $body_class = 'inner-body blog-body';
    $active_page = 'blog';
    require __DIR__ . '/header.php';
    ?>
    <main id="main-content" class="inner-page"><section class="blog-not-found"><p class="section-kicker">Blog</p><h1>Article Not Found.</h1><p>The article may have moved or is no longer available.</p><a class="button button-accent" href="/blog/">Browse the Blog</a></section></main>
    <?php
    require __DIR__ . '/footer.php';
    return;
}

$page_title = (string) $post['seo_title'];
$page_description = (string) $post['description'];
$canonical = 'https://vrplusconstruction.com' . blog_post_url($post);
$body_class = 'inner-body blog-body';
$active_page = 'blog';
$og_image = 'https://vrplusconstruction.com' . (string) $post['featured_image'];
$related_posts = blog_related_posts($post);

require __DIR__ . '/header.php';
?>

<main id="main-content" class="inner-page blog-article-page">
    <article>
        <header class="blog-article-hero">
            <div class="blog-article-hero-copy">
                <a class="blog-back-link" href="/blog/">VR Plus Journal</a>
                <p class="blog-article-meta"><span><?= htmlspecialchars((string) $post['category'], ENT_QUOTES, 'UTF-8') ?></span><time datetime="<?= htmlspecialchars((string) $post['date'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(blog_format_date((string) $post['date']), ENT_QUOTES, 'UTF-8') ?></time></p>
                <h1><?= htmlspecialchars((string) $post['title'], ENT_QUOTES, 'UTF-8') ?></h1>
                <p class="blog-article-deck"><?= htmlspecialchars((string) $post['excerpt'], ENT_QUOTES, 'UTF-8') ?></p>
            </div>
            <figure class="blog-article-featured">
                <img src="<?= htmlspecialchars((string) $post['featured_image'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars((string) $post['featured_alt'], ENT_QUOTES, 'UTF-8') ?>" fetchpriority="high">
            </figure>
        </header>

        <div class="blog-article-layout">
            <div class="blog-article-content">
                <?= (string) $post['content'] ?>
            </div>
            <aside class="blog-article-aside">
                <p class="section-kicker">Planning a project?</p>
                <h2>Build With a Clear Next Step.</h2>
                <p>Tell us what you are planning and where the project is located. Our team will help you identify the right path forward.</p>
                <a class="button button-accent" href="/contact.php">Start a Project</a>
            </aside>
        </div>
    </article>

    <?php if ($related_posts): ?>
    <section class="blog-related" aria-labelledby="related-articles-title">
        <div class="blog-related-heading"><p class="section-kicker">Keep reading</p><h2 id="related-articles-title">Related Articles.</h2></div>
        <div class="blog-card-grid">
            <?php foreach ($related_posts as $related): ?>
            <article class="blog-card reveal">
                <a href="<?= htmlspecialchars(blog_post_url($related), ENT_QUOTES, 'UTF-8') ?>">
                    <div class="blog-card-image"><img src="<?= htmlspecialchars((string) $related['featured_image'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars((string) $related['featured_alt'], ENT_QUOTES, 'UTF-8') ?>" loading="lazy"></div>
                    <div class="blog-card-copy"><p><span><?= htmlspecialchars((string) $related['category'], ENT_QUOTES, 'UTF-8') ?></span><time datetime="<?= htmlspecialchars((string) $related['date'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(blog_format_date((string) $related['date']), ENT_QUOTES, 'UTF-8') ?></time></p><h3><?= htmlspecialchars((string) $related['title'], ENT_QUOTES, 'UTF-8') ?></h3><span class="blog-read-link">Read article</span></div>
                </a>
            </article>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
</main>

<script type="application/ld+json"><?= json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BlogPosting',
    'headline' => $post['title'],
    'description' => $post['description'],
    'datePublished' => $post['date'],
    'dateModified' => $post['modified'],
    'mainEntityOfPage' => $canonical,
    'image' => $og_image,
    'author' => ['@type' => 'Organization', 'name' => 'VR Plus Construction'],
    'publisher' => ['@type' => 'Organization', 'name' => 'VR Plus Construction', 'url' => 'https://vrplusconstruction.com/'],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>

<?php require __DIR__ . '/footer.php'; ?>

<?php

declare(strict_types=1);

require_once __DIR__ . '/blog.php';

$posts = blog_all_posts();
$posts_per_page = 6;
$total_pages = max(1, (int) ceil(count($posts) / $posts_per_page));
$blog_page = max(1, (int) ($blog_page ?? 1));

if ($blog_page > $total_pages) {
    http_response_code(404);
    $blog_page = $total_pages;
}

$page_posts = array_slice($posts, ($blog_page - 1) * $posts_per_page, $posts_per_page);
$page_title = $blog_page === 1 ? 'Construction & Renovation Blog | VR Plus Construction' : 'Construction Blog – Page ' . $blog_page . ' | VR Plus Construction';
$page_description = 'Practical guidance about custom homes, renovations, permits, construction costs and building across Vancouver and Metro Vancouver.';
$canonical_path = $blog_page === 1 ? '/blog/' : '/blog/page/' . $blog_page . '/';
$canonical = 'https://vrplusconstruction.com' . $canonical_path;
$body_class = 'inner-body blog-body';
$active_page = 'blog';
$rel_prev = $blog_page > 1 ? ($blog_page === 2 ? '/blog/' : '/blog/page/' . ($blog_page - 1) . '/') : null;
$rel_next = $blog_page < $total_pages ? '/blog/page/' . ($blog_page + 1) . '/' : null;

require __DIR__ . '/header.php';
?>

<main id="main-content" class="inner-page blog-index-page">
    <section class="blog-index-hero">
        <p class="inner-eyebrow">VR Plus Journal</p>
        <h1><strong>Ideas That Build</strong><br>Better Projects.</h1>
        <p>Practical guidance for planning, renovating and building across Vancouver and Metro Vancouver.</p>
    </section>

    <section class="blog-index-content" aria-labelledby="blog-articles-title">
        <div class="blog-index-heading">
            <p class="section-kicker">Latest insights</p>
            <h2 id="blog-articles-title">Construction Knowledge,<br>Made Useful.</h2>
        </div>

        <div class="blog-card-grid">
            <?php foreach ($page_posts as $index => $post): ?>
            <article class="blog-card reveal">
                <a href="<?= htmlspecialchars(blog_post_url($post), ENT_QUOTES, 'UTF-8') ?>">
                    <div class="blog-card-image"><img src="<?= htmlspecialchars((string) $post['featured_image'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars((string) $post['featured_alt'], ENT_QUOTES, 'UTF-8') ?>"<?= $index === 0 ? ' fetchpriority="high"' : ' loading="lazy"' ?>></div>
                    <div class="blog-card-copy">
                        <p><span><?= htmlspecialchars((string) $post['category'], ENT_QUOTES, 'UTF-8') ?></span><time datetime="<?= htmlspecialchars((string) $post['date'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(blog_format_date((string) $post['date']), ENT_QUOTES, 'UTF-8') ?></time></p>
                        <h2><?= htmlspecialchars((string) $post['title'], ENT_QUOTES, 'UTF-8') ?></h2>
                        <span class="blog-read-link">Read article</span>
                    </div>
                </a>
            </article>
            <?php endforeach; ?>
        </div>

        <?php if ($total_pages > 1): ?>
        <nav class="blog-pagination" aria-label="Blog pages">
            <?php if ($rel_prev): ?><a class="blog-pagination-direction" href="<?= htmlspecialchars($rel_prev, ENT_QUOTES, 'UTF-8') ?>">Previous</a><?php endif; ?>
            <div>
                <?php for ($page = 1; $page <= $total_pages; $page++): $page_url = $page === 1 ? '/blog/' : '/blog/page/' . $page . '/'; ?>
                <a<?= $page === $blog_page ? ' class="active" aria-current="page"' : '' ?> href="<?= htmlspecialchars($page_url, ENT_QUOTES, 'UTF-8') ?>"><?= $page ?></a>
                <?php endfor; ?>
            </div>
            <?php if ($rel_next): ?><a class="blog-pagination-direction" href="<?= htmlspecialchars($rel_next, ENT_QUOTES, 'UTF-8') ?>">Next</a><?php endif; ?>
        </nav>
        <?php endif; ?>
    </section>
</main>

<?php require __DIR__ . '/footer.php'; ?>

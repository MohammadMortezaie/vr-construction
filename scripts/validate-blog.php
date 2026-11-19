<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$posts = json_decode((string) file_get_contents($root . '/data/blog-posts.json'), true, 512, JSON_THROW_ON_ERROR);
$errors = [];
$seenSlugs = [];
$seenImages = [];

if (count($posts) !== 38) {
    $errors[] = 'Expected 38 posts, found ' . count($posts) . '.';
}

foreach ($posts as $post) {
    $slug = (string) ($post['slug'] ?? '');
    if ($slug === '' || isset($seenSlugs[$slug])) {
        $errors[] = 'Missing or duplicate slug: ' . $slug;
        continue;
    }
    $seenSlugs[$slug] = true;

    $route = $root . '/' . $slug . '/index.php';
    if (!is_file($route)) {
        $errors[] = 'Missing route for ' . $slug;
    }
    if (substr_count(strtolower((string) $post['content']), '<h1') !== 0) {
        $errors[] = 'Imported content includes an extra H1 for ' . $slug;
    }
    if (str_contains((string) $post['content'], 'wp-content/uploads')) {
        $errors[] = 'Remote WordPress image remains in ' . $slug;
    }

    $images = array_merge([(string) $post['featured_image']], $post['content_images'] ?? []);
    foreach ($images as $image) {
        if (!str_ends_with(strtolower((string) $image), '.webp')) {
            $errors[] = 'Non-WebP image in ' . $slug . ': ' . $image;
            continue;
        }
        $imagePath = $root . '/' . ltrim((string) $image, '/');
        if (!is_file($imagePath)) {
            $errors[] = 'Missing image: ' . $image;
            continue;
        }
        if (!isset($seenImages[$imagePath])) {
            $seenImages[$imagePath] = true;
            $size = @getimagesize($imagePath);
            if (!is_array($size) || ($size['mime'] ?? '') !== 'image/webp') {
                $errors[] = 'Invalid WebP image: ' . $image;
            }
        }
    }
}

for ($page = 1; $page <= 7; $page++) {
    $route = $page === 1 ? $root . '/blog/index.php' : $root . '/blog/page/' . $page . '/index.php';
    if (!is_file($route)) {
        $errors[] = 'Missing blog archive page ' . $page;
    }
}

$postSitemap = (string) file_get_contents($root . '/post-sitemap.xml');
foreach (array_keys($seenSlugs) as $slug) {
    if (!str_contains($postSitemap, 'https://vrplusconstruction.com/' . $slug . '/')) {
        $errors[] = 'Post sitemap is missing ' . $slug;
    }
}

if ($errors !== []) {
    fwrite(STDERR, implode(PHP_EOL, $errors) . PHP_EOL);
    exit(1);
}

printf(
    "Blog validation passed: %d posts, %d routes, %d archive pages, %d valid WebP images.\n",
    count($posts),
    count($seenSlugs),
    7,
    count($seenImages)
);

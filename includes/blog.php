<?php

declare(strict_types=1);

function blog_all_posts(): array
{
    static $posts = null;
    if (is_array($posts)) {
        return $posts;
    }

    $path = dirname(__DIR__) . '/data/blog-posts.json';
    if (!is_readable($path)) {
        return $posts = [];
    }

    try {
        $decoded = json_decode((string) file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
        $posts = is_array($decoded) ? $decoded : [];
    } catch (JsonException) {
        $posts = [];
    }

    return $posts;
}

function blog_find_post(string $slug): ?array
{
    foreach (blog_all_posts() as $post) {
        if (($post['slug'] ?? '') === $slug) {
            return $post;
        }
    }
    return null;
}

function blog_post_url(array $post): string
{
    return '/' . rawurlencode((string) $post['slug']) . '/';
}

function blog_format_date(string $date): string
{
    $timestamp = strtotime($date);
    return $timestamp === false ? $date : date('F j, Y', $timestamp);
}

function blog_related_posts(array $current, int $limit = 3): array
{
    $sameCategory = [];
    $otherPosts = [];
    foreach (blog_all_posts() as $post) {
        if (($post['slug'] ?? '') === ($current['slug'] ?? '')) {
            continue;
        }
        if (($post['category'] ?? '') === ($current['category'] ?? '')) {
            $sameCategory[] = $post;
        } else {
            $otherPosts[] = $post;
        }
    }
    return array_slice(array_merge($sameCategory, $otherPosts), 0, $limit);
}

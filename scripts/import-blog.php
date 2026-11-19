<?php

declare(strict_types=1);

const BLOG_API_URL = 'https://vrplusconstruction.com/wp-json/wp/v2/posts?per_page=100&_embed';
const BLOG_SITE_URL = 'https://vrplusconstruction.com';

$root = dirname(__DIR__);
$dataDirectory = $root . '/data';
$imageDirectory = $root . '/assets/images/blog';

foreach ([$dataDirectory, $imageDirectory] as $directory) {
    if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
        throw new RuntimeException('Could not create directory: ' . $directory);
    }
}

function blogFetch(string $url): string
{
    $request = curl_init($url);
    if ($request === false) {
        throw new RuntimeException('Could not initialize request for ' . $url);
    }

    curl_setopt_array($request, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT => 45,
        CURLOPT_ENCODING => '',
        CURLOPT_USERAGENT => 'VR Plus Construction blog migration/1.0',
    ]);

    $body = curl_exec($request);
    $status = (int) curl_getinfo($request, CURLINFO_HTTP_CODE);
    $error = curl_error($request);
    curl_close($request);

    if (!is_string($body) || $status < 200 || $status >= 300) {
        throw new RuntimeException(sprintf('Download failed (%d): %s %s', $status, $url, $error));
    }

    return $body;
}

function blogCleanText(string $value): string
{
    $value = html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    return trim((string) preg_replace('/\s+/u', ' ', $value));
}

function blogSeoMeta(string $html, string $fallbackTitle, string $fallbackDescription): array
{
    $dom = new DOMDocument('1.0', 'UTF-8');
    libxml_use_internal_errors(true);
    @$dom->loadHTML($html, LIBXML_NOWARNING | LIBXML_NOERROR);
    libxml_clear_errors();
    $xpath = new DOMXPath($dom);

    $titleNode = $xpath->query('//title')->item(0);
    $descriptionNode = $xpath->query('//meta[translate(@name,"ABCDEFGHIJKLMNOPQRSTUVWXYZ","abcdefghijklmnopqrstuvwxyz")="description"]/@content')->item(0);

    return [
        'title' => $titleNode ? blogCleanText($titleNode->nodeValue ?? '') : $fallbackTitle,
        'description' => $descriptionNode ? blogCleanText($descriptionNode->nodeValue ?? '') : $fallbackDescription,
    ];
}

function blogOriginalImageUrl(string $url): string
{
    $parts = parse_url(html_entity_decode(trim($url), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    if (!is_array($parts) || empty($parts['scheme']) || empty($parts['host']) || empty($parts['path'])) {
        return $url;
    }

    $path = preg_replace('/-\d+x\d+(?=\.[a-z0-9]+$)/i', '', $parts['path']) ?? $parts['path'];
    return $parts['scheme'] . '://' . $parts['host'] . $path;
}

function blogBestSrcsetUrl(string $srcset, string $fallback): string
{
    $bestUrl = $fallback;
    $bestWidth = 0;
    foreach (explode(',', $srcset) as $candidate) {
        $candidate = trim($candidate);
        if ($candidate === '') {
            continue;
        }
        $parts = preg_split('/\s+/', $candidate);
        $url = $parts[0] ?? '';
        $width = isset($parts[1]) ? (int) rtrim($parts[1], 'w') : 0;
        if ($url !== '' && $width >= $bestWidth) {
            $bestUrl = $url;
            $bestWidth = $width;
        }
    }
    return blogOriginalImageUrl($bestUrl);
}

function blogImageFilename(string $url, array &$usedNames): string
{
    $path = (string) parse_url($url, PHP_URL_PATH);
    $base = pathinfo(rawurldecode($path), PATHINFO_FILENAME);
    $base = preg_replace('/-\d+x\d+$/', '', $base) ?? $base;
    $base = strtolower((string) preg_replace('/[^a-z0-9]+/i', '-', $base));
    $base = trim($base, '-');
    if ($base === '') {
        $base = 'blog-image';
    }

    $name = $base . '.webp';
    if (isset($usedNames[$name]) && $usedNames[$name] !== $url) {
        $name = $base . '-' . substr(sha1($url), 0, 8) . '.webp';
    }
    $usedNames[$name] = $url;
    return $name;
}

function blogConvertImage(string $sourceUrl, string $destination): void
{
    $sourceData = blogFetch($sourceUrl);
    $sourcePath = tempnam(sys_get_temp_dir(), 'vr-blog-source-');
    if ($sourcePath === false) {
        throw new RuntimeException('Could not create a temporary image file.');
    }
    file_put_contents($sourcePath, $sourceData);

    $extension = strtolower(pathinfo((string) parse_url($sourceUrl, PHP_URL_PATH), PATHINFO_EXTENSION));
    $command = '';
    $decodedPath = null;

    if ($extension === 'webp') {
        if (!copy($sourcePath, $destination)) {
            @unlink($sourcePath);
            throw new RuntimeException('Could not copy WebP image: ' . $sourceUrl);
        }
    } else {
        $inputPath = $sourcePath;
        if ($extension === 'avif') {
            $decodedPath = $sourcePath . '.png';
            $decodeCommand = sprintf(
                '%s %s %s 2>/dev/null',
                escapeshellcmd('/opt/homebrew/bin/avifdec'),
                escapeshellarg($sourcePath),
                escapeshellarg($decodedPath)
            );
            exec($decodeCommand, $decodeOutput, $decodeStatus);
            if ($decodeStatus !== 0 || !is_file($decodedPath)) {
                @unlink($sourcePath);
                throw new RuntimeException('Could not decode AVIF image: ' . $sourceUrl);
            }
            $inputPath = $decodedPath;
        }

        $command = sprintf(
            '%s -quiet -mt -q 82 %s -o %s',
            escapeshellcmd('/opt/homebrew/bin/cwebp'),
            escapeshellarg($inputPath),
            escapeshellarg($destination)
        );
        exec($command, $output, $status);
        if ($status !== 0 || !is_file($destination)) {
            $fallback = sprintf(
                '%s -loglevel error -y -i %s -quality 82 %s',
                escapeshellcmd('/opt/homebrew/bin/ffmpeg'),
                escapeshellarg($inputPath),
                escapeshellarg($destination)
            );
            exec($fallback, $fallbackOutput, $fallbackStatus);
            if ($fallbackStatus !== 0 || !is_file($destination)) {
                @unlink($sourcePath);
                if ($decodedPath !== null) {
                    @unlink($decodedPath);
                }
                throw new RuntimeException('Could not convert image: ' . $sourceUrl);
            }
        }
    }

    @unlink($sourcePath);
    if ($decodedPath !== null) {
        @unlink($decodedPath);
    }
}

function blogReplaceHeading(DOMDocument $dom, DOMElement $heading, string $replacementName): void
{
    $replacement = $dom->createElement($replacementName);
    foreach (iterator_to_array($heading->attributes ?? []) as $attribute) {
        $replacement->setAttribute($attribute->nodeName, $attribute->nodeValue ?? '');
    }
    while ($heading->firstChild) {
        $replacement->appendChild($heading->firstChild);
    }
    $heading->parentNode?->replaceChild($replacement, $heading);
}

$rawPosts = json_decode(blogFetch(BLOG_API_URL), true, 512, JSON_THROW_ON_ERROR);
if (!is_array($rawPosts)) {
    throw new RuntimeException('The WordPress API response was not a post list.');
}

usort($rawPosts, static fn(array $a, array $b): int => strcmp((string) $b['date'], (string) $a['date']));

$imageMap = [];
$usedNames = [];
$convertedImages = 0;

$importImage = static function (string $url) use (&$imageMap, &$usedNames, &$convertedImages, $imageDirectory): string {
    $sourceUrl = blogOriginalImageUrl($url);
    if (isset($imageMap[$sourceUrl])) {
        return $imageMap[$sourceUrl];
    }

    $filename = blogImageFilename($sourceUrl, $usedNames);
    $destination = $imageDirectory . '/' . $filename;
    if (!is_file($destination)) {
        blogConvertImage($sourceUrl, $destination);
        $convertedImages++;
    }

    $localUrl = '/assets/images/blog/' . $filename;
    $imageMap[$sourceUrl] = $localUrl;
    return $localUrl;
};

$oldPathMap = [
    '/about-us/' => '/about.php',
    '/our-team/' => '/team.php',
    '/our-services/' => '/services.php',
    '/custom-home-services/' => '/custom-homes.php',
    '/custom-homes-vancouver-bc/' => '/custom-homes.php',
    '/luxury-home-builder/' => '/custom-homes.php',
    '/luxury-home-builder' => '/custom-homes.php',
    '/green-building-contractor/' => '/custom-homes.php',
    '/energy-efficient-home/' => '/custom-homes.php',
    '/energy-efficient-homes' => '/custom-homes.php',
    '/renovation-services/' => '/renovations.php',
    '/condo-renovation-vancouver/' => '/renovations.php',
    '/home-remodeling-vancouver-bc/' => '/renovations.php',
    '/home-remodeling/' => '/renovations.php',
    '/luxury-renovation/' => '/renovations.php',
    '/commercial-services/' => '/commercial.php',
    '/commercial-construction/' => '/commercial.php',
    '/general-contractor-vancouver-bc/' => '/services.php',
    '/construction-projects/' => '/projects.php',
    '/portfolio/' => '/projects.php',
    '/contact-us/' => '/contact.php',
    '/contact-us' => '/contact.php',
    '/contact' => '/contact.php',
];

$posts = [];
foreach ($rawPosts as $index => $rawPost) {
    $slug = (string) $rawPost['slug'];
    $title = blogCleanText((string) $rawPost['title']['rendered']);
    $excerpt = blogCleanText((string) $rawPost['excerpt']['rendered']);
    if ($excerpt === '') {
        $excerpt = mb_substr(blogCleanText((string) $rawPost['content']['rendered']), 0, 220) . '…';
    }

    $liveHtml = blogFetch((string) $rawPost['link']);
    $seo = blogSeoMeta($liveHtml, $title . ' | VR Plus Construction', $excerpt);

    $featured = $rawPost['_embedded']['wp:featuredmedia'][0] ?? [];
    $featuredSource = (string) ($featured['source_url'] ?? '');
    if ($featuredSource === '') {
        throw new RuntimeException('Missing featured image for ' . $slug);
    }
    $featuredLocal = $importImage($featuredSource);
    $featuredAlt = blogCleanText((string) ($featured['alt_text'] ?? '')) ?: $title;

    $dom = new DOMDocument('1.0', 'UTF-8');
    libxml_use_internal_errors(true);
    $wrapperHtml = '<?xml encoding="UTF-8"><div id="vr-blog-content">' . (string) $rawPost['content']['rendered'] . '</div>';
    @$dom->loadHTML($wrapperHtml, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOWARNING | LIBXML_NOERROR);
    libxml_clear_errors();
    $xpath = new DOMXPath($dom);
    $contentImages = [];

    foreach (iterator_to_array($xpath->query('//script|//style') ?: []) as $unsafeNode) {
        $unsafeNode->parentNode?->removeChild($unsafeNode);
    }

    foreach (iterator_to_array($xpath->query('//h1') ?: []) as $heading) {
        if ($heading instanceof DOMElement) {
            blogReplaceHeading($dom, $heading, 'h2');
        }
    }

    foreach (iterator_to_array($xpath->query('//img') ?: []) as $image) {
        if (!$image instanceof DOMElement) {
            continue;
        }
        $source = $image->getAttribute('src');
        if ($image->hasAttribute('srcset')) {
            $source = blogBestSrcsetUrl($image->getAttribute('srcset'), $source);
        } else {
            $source = blogOriginalImageUrl($source);
        }
        if ($source === '') {
            continue;
        }
        $localUrl = $importImage($source);
        $contentImages[] = $localUrl;
        $image->setAttribute('src', $localUrl);
        $image->setAttribute('loading', 'lazy');
        $image->setAttribute('decoding', 'async');
        $image->removeAttribute('srcset');
        $image->removeAttribute('sizes');
        $image->removeAttribute('fetchpriority');
    }

    foreach (iterator_to_array($xpath->query('//a[@href]') ?: []) as $anchor) {
        if (!$anchor instanceof DOMElement) {
            continue;
        }
        $href = html_entity_decode($anchor->getAttribute('href'), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $parts = parse_url($href);
        if (is_array($parts) && ($parts['host'] ?? '') === 'vrplusconstruction.com') {
            $path = $parts['path'] ?? '/';
            $path = $oldPathMap[$path] ?? $path;
            $href = $path;
            if (!empty($parts['query'])) {
                $href .= '?' . $parts['query'];
            }
            if (!empty($parts['fragment'])) {
                $href .= '#' . $parts['fragment'];
            }
            $anchor->setAttribute('href', $href);
        }
        if ($anchor->getAttribute('target') === '_blank') {
            $anchor->setAttribute('rel', 'noopener noreferrer');
        }
    }

    foreach (iterator_to_array($xpath->query('//iframe') ?: []) as $iframe) {
        if ($iframe instanceof DOMElement) {
            $iframe->setAttribute('loading', 'lazy');
            $iframe->setAttribute('title', $iframe->getAttribute('title') ?: 'Embedded media');
        }
    }

    $contentRoot = $dom->getElementById('vr-blog-content');
    $contentHtml = '';
    if ($contentRoot !== null) {
        foreach ($contentRoot->childNodes as $child) {
            $contentHtml .= $dom->saveHTML($child);
        }
    }

    $categories = [];
    foreach (($rawPost['_embedded']['wp:term'] ?? []) as $termGroup) {
        foreach ($termGroup as $term) {
            if (($term['taxonomy'] ?? '') === 'category') {
                $categories[] = blogCleanText((string) ($term['name'] ?? ''));
            }
        }
    }
    $categories = array_values(array_filter(array_unique($categories)));

    $posts[] = [
        'slug' => $slug,
        'title' => $title,
        'seo_title' => $seo['title'],
        'description' => $seo['description'],
        'excerpt' => $excerpt,
        'date' => (string) $rawPost['date'],
        'modified' => (string) $rawPost['modified'],
        'category' => $categories[0] ?? 'Construction',
        'featured_image' => $featuredLocal,
        'featured_alt' => $featuredAlt,
        'content_images' => array_values(array_unique($contentImages)),
        'content' => $contentHtml,
    ];

    printf("[%d/%d] Imported %s\n", $index + 1, count($rawPosts), $slug);
}

$json = json_encode($posts, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
file_put_contents($dataDirectory . '/blog-posts.json', $json . PHP_EOL);

$sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . PHP_EOL;
foreach ($posts as $post) {
    $sitemap .= "  <url>\n";
    $sitemap .= '    <loc>' . htmlspecialchars(BLOG_SITE_URL . '/' . $post['slug'] . '/', ENT_XML1) . "</loc>\n";
    $sitemap .= '    <lastmod>' . htmlspecialchars((string) $post['modified'], ENT_XML1) . "</lastmod>\n";
    foreach (array_values(array_unique(array_merge([$post['featured_image']], $post['content_images']))) as $imageUrl) {
        $sitemap .= "    <image:image><image:loc>" . htmlspecialchars(BLOG_SITE_URL . $imageUrl, ENT_XML1) . "</image:loc></image:image>\n";
    }
    $sitemap .= "  </url>\n";
}
$sitemap .= '</urlset>' . PHP_EOL;
file_put_contents($root . '/post-sitemap.xml', $sitemap);

printf("Completed: %d posts, %d unique local WebP images.\n", count($posts), count($imageMap));

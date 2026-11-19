<?php
$page_title = $page_title ?? 'VR Plus Construction | Vancouver Custom Homes & Renovations';
$page_description = $page_description ?? 'VR Plus Construction delivers custom homes, renovations and commercial construction across Vancouver and Metro Vancouver.';
$canonical = $canonical ?? 'https://vrplusconstruction.com/';
$body_class = $body_class ?? '';
$active_page = $active_page ?? '';
$og_image = $og_image ?? 'https://vrplusconstruction.com/assets/images/VR-Construction-Team.webp';
$load_icons = $load_icons ?? false;
?>
<!doctype html>
<html lang="en-CA">
<head>
    <!-- Google tag -->
    <script async src="https://www.googletagmanager.com/gtm.js?id=G-F44PZLB0QX"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?></title>
    <meta name="description" content="<?= htmlspecialchars($page_description, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="robots" content="index,follow,max-image-preview:large">
    <link rel="canonical" href="<?= htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="theme-color" content="#111111">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="en_CA">
    <meta property="og:site_name" content="VR Plus Construction">
    <meta property="og:title" content="<?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:description" content="<?= htmlspecialchars($page_description, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:image" content="<?= htmlspecialchars($og_image, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="twitter:card" content="summary_large_image">
    <?php if (!empty($rel_prev)): ?><link rel="prev" href="<?= htmlspecialchars((string) $rel_prev, ENT_QUOTES, 'UTF-8') ?>"><?php endif; ?>
    <?php if (!empty($rel_next)): ?><link rel="next" href="<?= htmlspecialchars((string) $rel_next, ENT_QUOTES, 'UTF-8') ?>"><?php endif; ?>
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon-32x32.png" type="image/png" sizes="32x32">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <?php if ($load_icons): ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.2/font/bootstrap-icons.min.css">
    <?php endif; ?>
    <?php if (!empty($recaptcha_site_key)): ?>
    <script src="https://www.google.com/recaptcha/api.js?render=<?= rawurlencode((string) $recaptcha_site_key) ?>" defer></script>
    <?php endif; ?>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="<?= htmlspecialchars($body_class, ENT_QUOTES, 'UTF-8') ?>">
<a class="skip-link" href="#main-content">Skip to main content</a>

<header class="site-header" data-header>
    <div class="header-frame">
        <div class="header-utility">
            <a href="tel:+17783186796">(778) 318-6796</a>
        </div>
        <div class="header-rule" aria-hidden="true"></div>

        <a class="site-logo" href="/" aria-label="VR Plus Construction home">
            <img src="/android-chrome-512x512.png" width="72" height="72" alt="VR Plus Construction">
        </a>

        <nav class="desktop-navigation" aria-label="Primary navigation">
            <a<?= $active_page === 'home' ? ' class="active" aria-current="page"' : '' ?> href="/">Home</a>
            <a<?= $active_page === 'about' ? ' class="active" aria-current="page"' : '' ?> href="/about.php">About</a>
            <a<?= $active_page === 'team' ? ' class="active" aria-current="page"' : '' ?> href="/team.php">Team</a>
            <a<?= $active_page === 'projects' ? ' class="active" aria-current="page"' : '' ?> href="/projects.php">Projects</a>
            <a<?= $active_page === 'residential' ? ' class="active" aria-current="page"' : '' ?> href="/residential.php">Residential</a>
            <a<?= $active_page === 'commercial' ? ' class="active" aria-current="page"' : '' ?> href="/commercial.php">Commercial</a>
            <a<?= $active_page === 'services' ? ' class="active" aria-current="page"' : '' ?> href="/services.php">Services</a>
            <a<?= $active_page === 'blog' ? ' class="active" aria-current="page"' : '' ?> href="/blog/">Blog</a>
            <a<?= $active_page === 'contact' ? ' class="active" aria-current="page"' : '' ?> href="/contact.php">Contact</a>
        </nav>

        <div class="header-actions">
            <a class="header-contact" href="/contact.php">Get a Quote</a>
        </div>

        <div class="mobile-header-shape" aria-hidden="true"></div>
        <button class="menu-button" type="button" aria-expanded="false" aria-controls="mobile-navigation" data-menu-button>
            <span></span><span></span><span></span><b class="sr-only">Open menu</b>
        </button>
    </div>

    <div class="mobile-navigation" id="mobile-navigation" data-mobile-navigation>
        <nav aria-label="Mobile navigation">
            <a href="/"><span>01</span>Home</a>
            <a href="/about.php"><span>02</span>About</a>
            <a href="/team.php"><span>03</span>Team</a>
            <a href="/projects.php"><span>04</span>Projects</a>
            <a href="/residential.php"><span>05</span>Residential</a>
            <a href="/commercial.php"><span>06</span>Commercial</a>
            <a href="/services.php"><span>07</span>Services</a>
            <a href="/blog/"><span>08</span>Blog</a>
            <a href="/contact.php"><span>09</span>Contact</a>
        </nav>
        <div class="mobile-contact-details">
            <a href="tel:+17783186796">(778) 318-6796</a>
            <a href="mailto:admin@vrplusconstruction.com">admin@vrplusconstruction.com</a>
        </div>
    </div>
</header>

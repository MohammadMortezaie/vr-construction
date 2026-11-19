<?php
require_once __DIR__ . '/includes/env.php';
require_once __DIR__ . '/includes/recaptcha.php';

vr_load_env(__DIR__ . '/.env');

session_start(['cookie_httponly' => true, 'cookie_samesite' => 'Lax']);

$page_title = 'Contact VR Plus Construction | Vancouver, BC';
$page_description = 'Contact VR Plus Construction to discuss a custom home, renovation, commercial project or construction management need in Metro Vancouver.';
$canonical = 'https://vrplusconstruction.com/contact.php';
$body_class = 'inner-body contact-body';
$active_page = 'contact';
$load_icons = true;
$form_errors = [];
$form_success = false;
$initial_step = 1;
$recaptcha_site_key = vr_env('RECAPTCHA_SITE_KEY', '') ?? '';
$recaptcha_secret_key = vr_env('RECAPTCHA_SECRET_KEY', '') ?? '';
$recaptcha_min_score = (float) (vr_env('RECAPTCHA_MIN_SCORE', '0.5') ?? '0.5');
$recaptcha_action = 'contact_form';
$mail_mailer = strtolower(vr_env('MAIL_MAILER', 'sendmail') ?? 'sendmail');
$mail_from_address = filter_var(vr_env('MAIL_FROM_ADDRESS', '') ?? '', FILTER_VALIDATE_EMAIL) ?: '';
$mail_from_name = trim((string) preg_replace('/[\r\n]+/', ' ', vr_env('MAIL_FROM_NAME', 'VR PLUS Website') ?? 'VR PLUS Website'));
$mail_to_addresses = array_values(array_filter(
    array_map('trim', explode(',', vr_env('MAIL_TO_ADDRESSES', '') ?? '')),
    static fn(string $address): bool => filter_var($address, FILTER_VALIDATE_EMAIL) !== false
));
$mail_cc_addresses = array_values(array_filter(
    array_map('trim', explode(',', vr_env('MAIL_CC_ADDRESSES', '') ?? '')),
    static fn(string $address): bool => filter_var($address, FILTER_VALIDATE_EMAIL) !== false
));
$mail_is_configured = $mail_mailer === 'sendmail' && $mail_from_address !== '' && $mail_to_addresses !== [];

if (empty($_SESSION['contact_token'])) {
    $_SESSION['contact_token'] = bin2hex(random_bytes(32));
}

$clean_text = static function (string $value, int $max = 1000): string {
    $value = trim(strip_tags($value));
    $value = preg_replace('/[\r\n]+/', ' ', $value) ?? '';
    return mb_substr($value, 0, $max);
};

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $token = (string) ($_POST['contact_token'] ?? '');
    $honeypot = trim((string) ($_POST['website'] ?? ''));
    $project_type = $clean_text((string) ($_POST['project_type'] ?? ''), 80);
    $location = $clean_text((string) ($_POST['location'] ?? ''), 140);
    $timeline = $clean_text((string) ($_POST['timeline'] ?? ''), 80);
    $budget = $clean_text((string) ($_POST['budget'] ?? ''), 80);
    $details = mb_substr(trim(strip_tags((string) ($_POST['details'] ?? ''))), 0, 2500);
    $name = $clean_text((string) ($_POST['name'] ?? ''), 100);
    $email = filter_var(trim((string) ($_POST['email'] ?? '')), FILTER_SANITIZE_EMAIL);
    $phone = $clean_text((string) ($_POST['phone'] ?? ''), 40);
    $preferred_contact = $clean_text((string) ($_POST['preferred_contact'] ?? ''), 30);
    $consent = isset($_POST['consent']);

    if ($honeypot !== '') {
        $form_errors[] = 'We could not verify this submission.';
    }
    if (!hash_equals($_SESSION['contact_token'], $token)) {
        $form_errors[] = 'Your form session expired. Please refresh the page and try again.';
    }
    if ($project_type === '') {
        $form_errors[] = 'Please choose a project type.';
        $initial_step = 1;
    } elseif ($location === '') {
        $form_errors[] = 'Please enter the project location.';
        $initial_step = 2;
    } else {
        $initial_step = 3;
    }
    if ($name === '') {
        $form_errors[] = 'Please enter your name.';
    }
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $form_errors[] = 'Please enter a valid email address.';
    }
    if (!$consent) {
        $form_errors[] = 'Please confirm that we may contact you about this project.';
    }

    if (!$form_errors) {
        $recaptcha_token = trim((string) ($_POST['g-recaptcha-response'] ?? ''));
        $recaptcha_valid = vr_verify_recaptcha_v3(
            $recaptcha_token,
            $recaptcha_secret_key,
            $recaptcha_action,
            $recaptcha_min_score,
            (string) ($_SERVER['REMOTE_ADDR'] ?? '')
        );
        if (!$recaptcha_valid) {
            $form_errors[] = 'We could not verify that you are human. Please try again.';
            $initial_step = 3;
        }
    }

    if (!$form_errors) {
        if (!$mail_is_configured) {
            $form_errors[] = 'Email delivery is not configured correctly. Please call (778) 318-6796 or email admin@vrplusconstruction.com.';
            $initial_step = 3;
        }
    }

    if (!$form_errors) {
        $subject = 'New website inquiry: ' . $project_type;
        $message = implode("\n", [
            'New project inquiry from vrplusconstruction.com', '',
            'Project type: ' . $project_type,
            'Location: ' . $location,
            'Timeline: ' . ($timeline ?: 'Not specified'),
            'Budget: ' . ($budget ?: 'Not specified'),
            'Preferred contact: ' . ($preferred_contact ?: 'Not specified'), '',
            'Name: ' . $name,
            'Email: ' . $email,
            'Phone: ' . ($phone ?: 'Not provided'), '',
            'Project details:', $details ?: 'No additional details provided.'
        ]);
        $headers = [
            'From: ' . $mail_from_name . ' <' . $mail_from_address . '>',
            'Reply-To: ' . $name . ' <' . $email . '>',
            'Content-Type: text/plain; charset=UTF-8'
        ];
        if ($mail_cc_addresses !== []) {
            $headers[] = 'Cc: ' . implode(', ', $mail_cc_addresses);
        }

        if (@mail(implode(', ', $mail_to_addresses), $subject, $message, implode("\r\n", $headers))) {
            $form_success = true;
            $_POST = [];
            $_SESSION['contact_token'] = bin2hex(random_bytes(32));
        } else {
            $form_errors[] = 'The form could not send from this server. Please call (778) 318-6796 or email admin@vrplusconstruction.com.';
            $initial_step = 3;
        }
    }
}

$old_value = static fn(string $key): string => htmlspecialchars((string) ($_POST[$key] ?? ''), ENT_QUOTES, 'UTF-8');
$is_checked = static fn(string $key, string $value): bool => (string) ($_POST[$key] ?? '') === $value;
require __DIR__ . '/includes/header.php';
?>

<main id="main-content" class="inner-page">
    <section class="contact-hero">
        <div class="contact-hero-copy">
            <p class="inner-eyebrow">Let’s build together</p>
            <h1><strong>Tell Us What</strong><br>You’re Planning.</h1>
            <p>A few useful details are enough to start. Our project form takes about two minutes.</p>
            <a class="contact-hero-link" href="#project-form">Start your project <span>↓</span></a>
        </div>
        <div class="contact-hero-image"><img src="/assets/images/VR-Construction-Team.webp" width="1565" height="1005" alt="VR Plus Construction team at a Vancouver construction site"></div>
    </section>

    <section class="project-form-section" id="project-form">
        <aside class="project-form-aside reveal">
            <p class="section-kicker light">Project inquiry</p>
            <h2>Let’s Get the Right Conversation Started.</h2>
            <p>Tell us what you are building, where it is and how we can reach you. We’ll review the details and follow up directly.</p>
            <div class="form-direct-contact">
                <a href="tel:+17783186796"><i class="bi bi-telephone" aria-hidden="true"></i><span><small>Call us</small>(778) 318-6796</span></a>
                <a href="mailto:admin@vrplusconstruction.com"><i class="bi bi-envelope" aria-hidden="true"></i><span><small>Email us</small>admin@vrplusconstruction.com</span></a>
            </div>
        </aside>

        <div class="project-form-shell reveal" id="project-form-panel">
            <?php if ($form_success): ?>
                <div class="form-success" role="status"><i class="bi bi-check-circle-fill" aria-hidden="true"></i><p class="section-kicker">Inquiry received</p><h2>Thank You.</h2><p>Your project details were sent to VR Plus Construction. Our team will review them and follow up using the contact information you provided.</p><a class="button button-dark" href="/">Return Home</a></div>
            <?php else: ?>
                <?php if ($form_errors): ?>
                    <div class="form-alert" role="alert" tabindex="-1" data-form-alert><i class="bi bi-exclamation-circle" aria-hidden="true"></i><div><strong>Please check the form.</strong><ul><?php foreach ($form_errors as $error): ?><li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li><?php endforeach; ?></ul></div></div>
                <?php endif; ?>

                <form class="multi-step-form" method="post" action="/contact.php#project-form-panel" data-multi-step-form data-initial-step="<?= $initial_step ?>" data-recaptcha-site-key="<?= htmlspecialchars($recaptcha_site_key, ENT_QUOTES, 'UTF-8') ?>" data-recaptcha-action="<?= htmlspecialchars($recaptcha_action, ENT_QUOTES, 'UTF-8') ?>" novalidate>
                    <input type="hidden" name="contact_token" value="<?= htmlspecialchars($_SESSION['contact_token'], ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="g-recaptcha-response" value="" data-recaptcha-token>
                    <label class="form-honeypot" aria-hidden="true">Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label>

                    <div class="form-progress" role="progressbar" aria-label="Project inquiry progress" aria-valuemin="1" aria-valuemax="3" aria-valuenow="<?= $initial_step ?>" data-form-progress>
                        <div class="form-progress-line"><i data-form-progress-line></i></div>
                        <div class="form-progress-step"><span><i class="bi bi-buildings" aria-hidden="true"></i></span><small>Project</small></div>
                        <div class="form-progress-step"><span><i class="bi bi-geo-alt" aria-hidden="true"></i></span><small>Details</small></div>
                        <div class="form-progress-step"><span><i class="bi bi-person" aria-hidden="true"></i></span><small>Contact</small></div>
                    </div>

                    <fieldset class="form-step<?= $initial_step === 1 ? ' is-active' : '' ?>" data-form-step="1">
                        <legend tabindex="-1"><span>Step 01</span>What are you planning?</legend>
                        <p class="form-step-intro">Choose the option that best describes your project.</p>
                        <div class="project-type-grid">
                            <label><input type="radio" name="project_type" value="Custom Home"<?= $is_checked('project_type', 'Custom Home') ? ' checked' : '' ?> required><span><i class="bi bi-house-heart" aria-hidden="true"></i><strong>Custom Home</strong><small>New residential construction</small></span></label>
                            <label><input type="radio" name="project_type" value="Renovation"<?= $is_checked('project_type', 'Renovation') ? ' checked' : '' ?> required><span><i class="bi bi-hammer" aria-hidden="true"></i><strong>Renovation</strong><small>Home, condo or major interior work</small></span></label>
                            <label><input type="radio" name="project_type" value="Commercial"<?= $is_checked('project_type', 'Commercial') ? ' checked' : '' ?> required><span><i class="bi bi-building" aria-hidden="true"></i><strong>Commercial</strong><small>Interior construction or commercial improvement</small></span></label>
                            <label><input type="radio" name="project_type" value="Construction Management"<?= $is_checked('project_type', 'Construction Management') ? ' checked' : '' ?> required><span><i class="bi bi-clipboard2-check" aria-hidden="true"></i><strong>Management</strong><small>Planning and project coordination</small></span></label>
                            <label><input type="radio" name="project_type" value="Structural Engineering"<?= $is_checked('project_type', 'Structural Engineering') ? ' checked' : '' ?> required><span><i class="bi bi-rulers" aria-hidden="true"></i><strong>Structural Engineering</strong><small>Licensed structural review, design or alteration</small></span></label>
                        </div>
                        <div class="form-actions form-actions-end"><button class="form-next" type="button" data-form-next>Continue <i class="bi bi-arrow-right" aria-hidden="true"></i></button></div>
                    </fieldset>

                    <fieldset class="form-step<?= $initial_step === 2 ? ' is-active' : '' ?>" data-form-step="2">
                        <legend tabindex="-1"><span>Step 02</span>Tell us about the project.</legend>
                        <p class="form-step-intro">Approximate information is completely fine at this stage.</p>
                        <div class="form-field-grid">
                            <label class="form-field form-field-wide"><span>Project location *</span><div><i class="bi bi-geo-alt" aria-hidden="true"></i><input type="text" name="location" value="<?= $old_value('location') ?>" placeholder="City or neighbourhood" required autocomplete="street-address"></div></label>
                            <label class="form-field"><span>Ideal timeline</span><div><i class="bi bi-calendar3" aria-hidden="true"></i><select name="timeline"><option value="">Select timing</option><option<?= $is_checked('timeline', 'As soon as possible') ? ' selected' : '' ?>>As soon as possible</option><option<?= $is_checked('timeline', 'Within 3 to 6 months') ? ' selected' : '' ?>>Within 3 to 6 months</option><option<?= $is_checked('timeline', 'Within 6 to 12 months') ? ' selected' : '' ?>>Within 6 to 12 months</option><option<?= $is_checked('timeline', 'More than 12 months') ? ' selected' : '' ?>>More than 12 months</option></select></div></label>
                            <label class="form-field"><span>Estimated investment</span><div><i class="bi bi-wallet2" aria-hidden="true"></i><select name="budget"><option value="">Select a range</option><option<?= $is_checked('budget', '$100k to $250k') ? ' selected' : '' ?>>$100k to $250k</option><option<?= $is_checked('budget', '$250k to $500k') ? ' selected' : '' ?>>$250k to $500k</option><option<?= $is_checked('budget', '$500k to $1M') ? ' selected' : '' ?>>$500k to $1M</option><option<?= $is_checked('budget', '$1M+') ? ' selected' : '' ?>>$1M+</option><option<?= $is_checked('budget', 'Not sure yet') ? ' selected' : '' ?>>Not sure yet</option></select></div></label>
                            <label class="form-field form-field-wide"><span>Project details</span><textarea name="details" rows="5" placeholder="What would you like to build or change?"><?= $old_value('details') ?></textarea></label>
                        </div>
                        <div class="form-actions"><button class="form-back" type="button" data-form-back><i class="bi bi-arrow-left" aria-hidden="true"></i> Back</button><button class="form-next" type="button" data-form-next>Continue <i class="bi bi-arrow-right" aria-hidden="true"></i></button></div>
                    </fieldset>

                    <fieldset class="form-step<?= $initial_step === 3 ? ' is-active' : '' ?>" data-form-step="3">
                        <legend tabindex="-1"><span>Step 03</span>How should we reach you?</legend>
                        <p class="form-step-intro">Your information is used only to respond to this project inquiry.</p>
                        <div class="form-field-grid">
                            <label class="form-field"><span>Name *</span><div><i class="bi bi-person" aria-hidden="true"></i><input type="text" name="name" value="<?= $old_value('name') ?>" required autocomplete="name"></div></label>
                            <label class="form-field"><span>Email *</span><div><i class="bi bi-envelope" aria-hidden="true"></i><input type="email" name="email" value="<?= $old_value('email') ?>" required autocomplete="email"></div></label>
                            <label class="form-field"><span>Phone</span><div><i class="bi bi-telephone" aria-hidden="true"></i><input type="tel" name="phone" value="<?= $old_value('phone') ?>" autocomplete="tel"></div></label>
                            <label class="form-field"><span>Preferred contact</span><div><i class="bi bi-chat-dots" aria-hidden="true"></i><select name="preferred_contact"><option value="">No preference</option><option<?= $is_checked('preferred_contact', 'Phone') ? ' selected' : '' ?>>Phone</option><option<?= $is_checked('preferred_contact', 'Email') ? ' selected' : '' ?>>Email</option><option<?= $is_checked('preferred_contact', 'Text message') ? ' selected' : '' ?>>Text message</option></select></div></label>
                            <label class="form-consent form-field-wide"><input type="checkbox" name="consent" value="1"<?= isset($_POST['consent']) ? ' checked' : '' ?> required><span>I agree that VR Plus Construction may contact me about this project inquiry.</span></label>
                        </div>
                        <p class="form-recaptcha-status" data-recaptcha-status role="status" aria-live="polite"></p>
                        <div class="form-actions"><button class="form-back" type="button" data-form-back><i class="bi bi-arrow-left" aria-hidden="true"></i> Back</button><button class="form-submit" type="submit">Send Project Inquiry <i class="bi bi-send" aria-hidden="true"></i></button></div>
                    </fieldset>
                </form>
            <?php endif; ?>
        </div>
    </section>

    <section class="contact-details blueprint-section">
        <div class="contact-details-heading reveal"><p class="section-kicker">Direct contact</p><h2><strong>Prefer to Talk?</strong><br>Reach Us Directly.</h2></div>
        <div class="contact-methods">
            <article class="reveal"><span><i class="bi bi-telephone" aria-hidden="true"></i> Phone</span><a href="tel:+17783186796">(778) 318-6796</a><p>Call to discuss your project and preferred timing.</p></article>
            <article class="reveal"><span><i class="bi bi-envelope" aria-hidden="true"></i> Email</span><a href="mailto:admin@vrplusconstruction.com?subject=Project%20Inquiry">admin@vrplusconstruction.com</a><p>Include the project type, location and a short description.</p></article>
            <article class="reveal"><span><i class="bi bi-linkedin" aria-hidden="true"></i> LinkedIn</span><a href="https://www.linkedin.com/company/vr-plus-construction-and-restoration" target="_blank" rel="noopener">Follow VR Plus <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a><p>Connect with our team and follow company updates.</p></article>
        </div>

        <div class="location-heading reveal">
            <p class="section-kicker">Three local offices</p>
            <h2>Find VR Plus Near You.</h2>
        </div>
        <div class="location-grid">
            <a class="location-card reveal" href="https://maps.google.com/?q=636+Clyde+Ave+West+Vancouver+BC" target="_blank" rel="noopener">
                <span>01</span><div><p>West Vancouver</p><h3>636 Clyde Ave<br>West Vancouver, BC</h3><small>Get directions <i class="bi bi-arrow-up-right" aria-hidden="true"></i></small></div>
            </a>
            <a class="location-card reveal" href="https://maps.google.com/?q=828+Harbourside+Dr+North+Vancouver+BC" target="_blank" rel="noopener">
                <span>02</span><div><p>North Vancouver</p><h3>828 Harbourside Dr<br>North Vancouver, BC</h3><small>Get directions <i class="bi bi-arrow-up-right" aria-hidden="true"></i></small></div>
            </a>
            <a class="location-card reveal" href="https://maps.google.com/?q=3030+Lincoln+Ave+Coquitlam+BC" target="_blank" rel="noopener">
                <span>03</span><div><p>Coquitlam</p><h3>3030 Lincoln Ave<br>Coquitlam, BC</h3><small>Get directions <i class="bi bi-arrow-up-right" aria-hidden="true"></i></small></div>
            </a>
        </div>
    </section>
</main>

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"ContactPage","name":"Contact VR Plus Construction","url":"https://vrplusconstruction.com/contact.php","mainEntity":{"@type":"HomeAndConstructionBusiness","name":"VR Plus Construction","telephone":"+1-778-318-6796","email":"admin@vrplusconstruction.com","sameAs":["https://www.linkedin.com/company/vr-plus-construction-and-restoration"],"address":[{"@type":"PostalAddress","streetAddress":"636 Clyde Ave","addressLocality":"West Vancouver","addressRegion":"BC","addressCountry":"CA"},{"@type":"PostalAddress","streetAddress":"828 Harbourside Dr","addressLocality":"North Vancouver","addressRegion":"BC","addressCountry":"CA"},{"@type":"PostalAddress","streetAddress":"3030 Lincoln Ave","addressLocality":"Coquitlam","addressRegion":"BC","addressCountry":"CA"}]}}
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>

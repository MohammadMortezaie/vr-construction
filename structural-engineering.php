<?php
$page_title = 'Structural Engineering Vancouver | P.Eng. | VR Plus Construction';
$page_description = 'Licensed structural engineering services for renovations, custom homes, structural alterations and construction projects in Vancouver and Metro Vancouver.';
$canonical = 'https://vrplusconstruction.com/structural-engineering.php';
$body_class = 'inner-body';
$active_page = 'services';
$service_name = 'Structural Engineering';
$eyebrow = 'Licensed Structural Engineering';
$headline = '<strong>Safe by Design.</strong><br>Clear to Build.';
$hero_text = 'Structural engineering led by Moe Ghanbari, P.Eng., M.Sc., connected directly with practical construction planning and execution.';
$hero_image = '/assets/images/design-engineering.webp';
$intro_kicker = 'Professional engineering';
$intro_title = '<strong>Engineering That</strong><br>Works on Site.';
$intro_paragraphs = [
    'Structural decisions affect safety, permitting, cost, sequencing and the finished space. Bringing engineering and construction coordination together helps those decisions move from drawings to site with fewer gaps.',
    'VR Plus provides structural engineering support for residential and commercial projects under the direction of licensed Professional Engineer Moe Ghanbari, P.Eng., M.Sc.'
];
$capabilities = [
    ['title' => 'Structural Assessment', 'text' => 'Review existing conditions and structural requirements before renovation or construction decisions are finalized.'],
    ['title' => 'Structural Wall Alterations', 'text' => 'Engineering for wall removals, new openings, beam requirements and related structural changes.'],
    ['title' => 'Design + Permit Support', 'text' => 'Structural drawings, details and coordination required for applicable permit submissions.'],
    ['title' => 'Construction Coordination', 'text' => 'Clarify structural intent, respond to site conditions and connect engineering details with the work in place.']
];
$detail_image = '/assets/images/team-moe-ghanbari.webp';
$detail_alt = 'Moe Ghanbari, licensed Structural Engineer, P.Eng., M.Sc.';
$detail_kicker = 'Licensed expertise';
$detail_title = '<strong>Moe Ghanbari</strong><br>P.Eng., M.Sc.';
$detail_text = 'Structural engineering services are led by Moe Ghanbari, a licensed Professional Engineer. His role connects technical design, code and permit considerations with practical construction requirements.';
$process = [
    ['title' => 'Understand', 'text' => 'Review the project goals, available drawings, existing conditions and proposed structural changes.'],
    ['title' => 'Assess', 'text' => 'Identify structural requirements, constraints, investigation needs and applicable design criteria.'],
    ['title' => 'Design', 'text' => 'Prepare structural solutions and coordinate the information required for the project and permit process.'],
    ['title' => 'Support', 'text' => 'Provide clarification and site coordination as the structural work is completed.']
];
$faq_title = 'Structural Engineering Questions.';
$faqs = [
    ['question' => 'Who leads structural engineering at VR Plus?', 'answer' => 'Structural engineering services are led by Moe Ghanbari, Structural Engineer, P.Eng., M.Sc.'],
    ['question' => 'Do I need an engineer to remove a structural wall?', 'answer' => 'Structural changes such as removing a wall that carries weight typically require engineering review and may require structural drawings and permit approval. The exact requirements depend on the property and municipality.'],
    ['question' => 'Can structural engineering be coordinated with construction?', 'answer' => 'Yes. Integrating engineering and construction coordination helps ensure structural details are understood, sequenced and executed as intended.'],
    ['question' => 'Which project types can require structural engineering?', 'answer' => 'Custom homes, additions, major renovations, new openings, beam installations, structural repairs and some commercial improvements can require structural engineering.']
];
$service_additional_schema = [[
    '@type' => 'Person',
    'name' => 'Moe Ghanbari',
    'jobTitle' => 'Structural Engineer',
    'honorificSuffix' => 'P.Eng., M.Sc.',
    'image' => 'https://vrplusconstruction.com/assets/images/team-moe-ghanbari.webp',
    'worksFor' => ['@type' => 'Organization', 'name' => 'VR Plus Construction'],
    'hasCredential' => [
        '@type' => 'EducationalOccupationalCredential',
        'credentialCategory' => 'Professional Engineer (P.Eng.)'
    ]
]];
require __DIR__ . '/includes/service-page.php';

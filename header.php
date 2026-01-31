<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#2c8c4f">
    <meta name="format-detection" content="telephone=no">

    <?php
    // SEO Meta Tags - NO HARDCODED CONTENT
    $page_title = wp_get_document_title();
    $meta_description = '';

    // Get meta description from ACF field or excerpt
    if (is_singular()) {
        $meta_description = get_field('seo_description') ?: get_the_excerpt();
    } elseif (is_front_page()) {
        $meta_description = get_field('seo_description') ?: get_bloginfo('description');
    }

    $canonical_url = is_front_page() ? home_url('/') : get_permalink();
    $site_name = get_bloginfo('name');
    ?>

    <!-- Resource Hints for Performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">

    <!-- Favicon & App Icons -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%232c8c4f'/><text x='50' y='70' font-size='60' font-weight='bold' text-anchor='middle' fill='white' font-family='system-ui'>W</text></svg>">
    <link rel="apple-touch-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 180 180'><rect width='180' height='180' rx='40' fill='%232c8c4f'/><text x='90' y='130' font-size='110' font-weight='bold' text-anchor='middle' fill='white' font-family='system-ui'>W</text></svg>">

    <!-- SEO Meta Tags -->
    <?php if ($meta_description): ?>
        <meta name="description" content="<?php echo esc_attr($meta_description); ?>">
    <?php endif; ?>
    <?php if (is_404() || is_search()): ?>
        <meta name="robots" content="noindex, follow">
    <?php endif; ?>
    <link rel="canonical" href="<?php echo esc_url($canonical_url); ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo esc_url($canonical_url); ?>">
    <meta property="og:title" content="<?php echo esc_attr($page_title); ?>">
    <?php if ($meta_description): ?>
        <meta property="og:description" content="<?php echo esc_attr($meta_description); ?>">
    <?php endif; ?>
    <?php
    // Get OG image
    $og_image = get_template_directory_uri() . '/assets/images/hero-bg.jpg';
    if (has_post_thumbnail() && !is_front_page()) {
        $og_image = get_the_post_thumbnail_url(null, 'large');
    }
    ?>
    <meta property="og:image" content="<?php echo esc_url($og_image); ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="<?php echo esc_attr(get_bloginfo('name')); ?>">
    <meta property="og:site_name" content="<?php echo esc_attr($site_name); ?>">
    <meta property="og:locale" content="de_AT">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?php echo esc_url($canonical_url); ?>">
    <meta name="twitter:title" content="<?php echo esc_attr($page_title); ?>">
    <?php if ($meta_description): ?>
        <meta name="twitter:description" content="<?php echo esc_attr($meta_description); ?>">
    <?php endif; ?>
    <meta name="twitter:image" content="<?php echo esc_url($og_image); ?>">
    <meta name="twitter:image:alt" content="<?php echo esc_attr(get_bloginfo('name')); ?>">

    <!-- Structured Data - Organization -->
    <?php
    $schema_phone = wohnegruen_get_option('contact_phone');
    $schema_email = wohnegruen_get_option('contact_email');
    $schema_address = wohnegruen_get_option('contact_address');
    ?>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "<?php echo esc_js(get_bloginfo('name')); ?>",
      "url": "<?php echo esc_url(home_url('/')); ?>",
      "logo": "<?php echo esc_url($og_image); ?>",
      <?php if ($meta_description): ?>
      "description": "<?php echo esc_js($meta_description); ?>",
      <?php endif; ?>
      <?php if ($schema_address): ?>
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "<?php echo esc_js($schema_address); ?>",
        "addressCountry": "AT"
      },
      <?php endif; ?>
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "<?php echo esc_js($schema_phone); ?>",
        "email": "<?php echo esc_js($schema_email); ?>",
        "contactType": "customer service",
        "areaServed": "AT",
        "availableLanguage": ["de", "de-AT"]
      },
      "sameAs": [
        <?php
        $social = array();
        if ($fb = wohnegruen_get_option('social_facebook')) $social[] = '"' . esc_url($fb) . '"';
        if ($ig = wohnegruen_get_option('social_instagram')) $social[] = '"' . esc_url($ig) . '"';
        if ($li = wohnegruen_get_option('social_linkedin')) $social[] = '"' . esc_url($li) . '"';
        echo implode(',', $social);
        ?>
      ]
    }
    </script>

    <!-- Structured Data - Website -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "name": "<?php echo esc_js(get_bloginfo('name')); ?>",
      "url": "<?php echo esc_url(home_url('/')); ?>",
      <?php if ($meta_description): ?>
      "description": "<?php echo esc_js($meta_description); ?>",
      <?php endif; ?>
      "inLanguage": "de-AT"
    }
    </script>

    <?php if (!is_front_page() && !is_404()): ?>
    <!-- Breadcrumb Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BreadcrumbList",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Startseite",
          "item": "<?php echo esc_url(home_url('/')); ?>"
        }<?php if (is_singular()): ?>,
        {
          "@type": "ListItem",
          "position": 2,
          "name": "<?php echo esc_js(get_the_title()); ?>",
          "item": "<?php echo esc_url(get_permalink()); ?>"
        }
        <?php endif; ?>
      ]
    }
    </script>
    <?php endif; ?>

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Skip to Content Link (Accessibility) -->
<a href="#main-content" class="skip-to-content">Zum Hauptinhalt springen</a>

<?php
// Get navigation ACF fields
$nav_logo = wohnegruen_get_option('nav_logo');
$nav_cta_text = wohnegruen_get_option('nav_cta_text');
$nav_cta_link = wohnegruen_get_option('nav_cta_link', '#kontakt');
$contact_phone = wohnegruen_get_option('contact_phone');
?>

<!-- Navigation -->
<nav class="site-navigation">
    <div class="nav-container">
        <!-- Logo -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" aria-label="<?php echo esc_attr(get_bloginfo('name') . ' - Startseite'); ?>">
            <?php if ($nav_logo && isset($nav_logo['url'])) : ?>
                <img src="<?php echo esc_url($nav_logo['url']); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
            <?php else : ?>
                <div class="logo-icon"><?php echo esc_html(substr(get_bloginfo('name'), 0, 1)); ?></div>
                <span class="logo-text"><?php echo esc_html(get_bloginfo('name')); ?></span>
            <?php endif; ?>
        </a>

        <!-- Desktop Menu -->
        <div class="nav-menu">
            <?php
            if (has_nav_menu('primary')) :
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'items_wrap' => '%3$s',
                    'walker' => new wohnegruen_Nav_Walker(),
                ));
            endif; ?>
        </div>

        <!-- Right side: Phone + CTA -->
        <div class="nav-right">
            <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $contact_phone)); ?>" class="nav-phone">
                <?php echo wohnegruen_get_icon('phone'); ?>
                <span><?php echo esc_html($contact_phone); ?></span>
            </a>
            <a href="<?php echo esc_url($nav_cta_link); ?>" class="btn btn-primary">
                <?php echo esc_html($nav_cta_text); ?>
            </a>
        </div>

        <!-- Hamburger Menu -->
        <button class="hamburger" id="hamburger" aria-label="Menü öffnen" aria-expanded="false" aria-controls="mobile-menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</nav>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobile-menu" role="navigation" aria-label="Hauptmenü mobil">
    <div class="mobile-menu-items">
        <?php
        if (has_nav_menu('primary')) :
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container' => false,
                'items_wrap' => '%3$s',
                'walker' => new wohnegruen_Mobile_Nav_Walker(),
            ));
        endif; ?>
    </div>
    <a href="<?php echo esc_url($nav_cta_link); ?>" class="btn btn-primary">
        <?php echo esc_html($nav_cta_text); ?>
    </a>
</div>

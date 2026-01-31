<?php
/**
 * Block: Terrase Overview (Terrassen page with calling cards)
 * Shows Nature and Pure as preview cards that link to individual pages
 */

// Get all fields
$hero_title = get_field('terrase_hero_title');
$hero_subtitle = get_field('terrase_hero_subtitle');
$hero_image = get_field('terrase_hero_image');
$intro_title = get_field('terrase_intro_title');
$intro_content = get_field('terrase_intro_content');

// Nature and Pure terrase selection
$nature_terrase = get_field('terrase_nature_model');
$pure_terrase = get_field('terrase_pure_model');

$block_id = 'terrase-overview-' . $block['id'];
?>

<div class="terrase-overview-page" id="<?php echo esc_attr($block_id); ?>">

    <!-- Hero Section -->
    <section class="terrase-hero" <?php if ($hero_image): ?>style="background-image: url('<?php echo esc_url($hero_image['url']); ?>');"<?php endif; ?>>
        <div class="container">
            <div class="hero-content">
                <?php if ($hero_title): ?>
                    <h1><?php echo esc_html($hero_title); ?></h1>
                <?php endif; ?>
                <?php if ($hero_subtitle): ?>
                    <p class="hero-subtitle"><?php echo esc_html($hero_subtitle); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Intro Section -->
    <?php if ($intro_title || $intro_content): ?>
    <section class="terrase-intro section-padding">
        <div class="container">
            <div class="intro-content">
                <?php if ($intro_title): ?>
                    <h2><?php echo esc_html($intro_title); ?></h2>
                <?php endif; ?>
                <?php if ($intro_content): ?>
                    <div class="intro-text">
                        <?php echo wp_kses_post($intro_content); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Calling Cards Section -->
    <?php if ($nature_terrase || $pure_terrase): ?>
    <section class="terrase-cards-section section-padding">
        <div class="container">

            <div class="calling-cards-grid">

                <!-- Nature Card -->
                <?php if ($nature_terrase):
                    $nature_title = get_the_title($nature_terrase->ID);
                    $nature_subtitle = get_field('terrase_hero_subtitle', $nature_terrase->ID);
                    $nature_sizes = get_field('terrase_size_variants', $nature_terrase->ID);
                    $nature_link = get_permalink($nature_terrase->ID);
                    $nature_image = '';

                    // Get image from hero or featured image
                    $hero_img = get_field('terrase_hero_image', $nature_terrase->ID);
                    if ($hero_img && isset($hero_img['url'])) {
                        $nature_image = $hero_img['url'];
                    } elseif (has_post_thumbnail($nature_terrase->ID)) {
                        $nature_image = get_the_post_thumbnail_url($nature_terrase->ID, 'large');
                    }
                ?>
                <div class="calling-card">
                    <div class="card-image">
                        <?php if ($nature_image): ?>
                            <img src="<?php echo esc_url($nature_image); ?>"
                                 alt="<?php echo esc_attr($nature_title); ?>"
                                 loading="lazy">
                        <?php endif; ?>
                        <div class="card-badge">Nature</div>
                    </div>

                    <div class="card-content">
                        <h3 class="card-title"><?php echo esc_html($nature_title); ?></h3>

                        <?php if ($nature_subtitle): ?>
                            <p class="card-subtitle"><?php echo esc_html($nature_subtitle); ?></p>
                        <?php endif; ?>

                        <!-- Quick Specs -->
                        <?php if ($nature_sizes && is_array($nature_sizes) && count($nature_sizes) > 0): ?>
                            <div class="card-specs">
                                <div class="spec-item">
                                    <span class="spec-label">Verfügbare Größen:</span>
                                    <span class="spec-value"><?php echo count($nature_sizes); ?> Varianten</span>
                                </div>
                                <?php
                                // Show first size variant
                                if (isset($nature_sizes[0]['variant_name'])):
                                ?>
                                    <div class="spec-item">
                                        <span class="spec-label">Ab:</span>
                                        <span class="spec-value"><?php echo esc_html($nature_sizes[0]['variant_name']); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <a href="<?php echo esc_url($nature_link); ?>" class="card-button">
                            Mehr erfahren
                            <span class="button-arrow">→</span>
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Pure Card -->
                <?php if ($pure_terrase):
                    $pure_title = get_the_title($pure_terrase->ID);
                    $pure_subtitle = get_field('terrase_hero_subtitle', $pure_terrase->ID);
                    $pure_sizes = get_field('terrase_size_variants', $pure_terrase->ID);
                    $pure_link = get_permalink($pure_terrase->ID);
                    $pure_image = '';

                    // Get image from hero or featured image
                    $hero_img = get_field('terrase_hero_image', $pure_terrase->ID);
                    if ($hero_img && isset($hero_img['url'])) {
                        $pure_image = $hero_img['url'];
                    } elseif (has_post_thumbnail($pure_terrase->ID)) {
                        $pure_image = get_the_post_thumbnail_url($pure_terrase->ID, 'large');
                    }
                ?>
                <div class="calling-card">
                    <div class="card-image">
                        <?php if ($pure_image): ?>
                            <img src="<?php echo esc_url($pure_image); ?>"
                                 alt="<?php echo esc_attr($pure_title); ?>"
                                 loading="lazy">
                        <?php endif; ?>
                        <div class="card-badge">Pure</div>
                    </div>

                    <div class="card-content">
                        <h3 class="card-title"><?php echo esc_html($pure_title); ?></h3>

                        <?php if ($pure_subtitle): ?>
                            <p class="card-subtitle"><?php echo esc_html($pure_subtitle); ?></p>
                        <?php endif; ?>

                        <!-- Quick Specs -->
                        <?php if ($pure_sizes && is_array($pure_sizes) && count($pure_sizes) > 0): ?>
                            <div class="card-specs">
                                <div class="spec-item">
                                    <span class="spec-label">Verfügbare Größen:</span>
                                    <span class="spec-value"><?php echo count($pure_sizes); ?> Varianten</span>
                                </div>
                                <?php
                                // Show first size variant
                                if (isset($pure_sizes[0]['variant_name'])):
                                ?>
                                    <div class="spec-item">
                                        <span class="spec-label">Ab:</span>
                                        <span class="spec-value"><?php echo esc_html($pure_sizes[0]['variant_name']); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <a href="<?php echo esc_url($pure_link); ?>" class="card-button">
                            Mehr erfahren
                            <span class="button-arrow">→</span>
                        </a>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </section>
    <?php endif; ?>

</div>

<style>
/* TERRASE OVERVIEW PAGE - PROFESSIONAL CALLING CARDS DESIGN */
.terrase-overview-page {
    width: 100%;
    margin: 0;
    padding: 0;
    margin-block-start: 0;
    margin-block-end: 0;
    padding-block-start: 0;
    padding-block-end: 0;
}

.terrase-hero {
    min-height: var(--hero-min-height);
    margin-top: 0;
    margin-block-start: 0;
    padding-top: 0;
    padding-block-start: 0;
}

.section-padding {
    padding: 60px 0;
}

.container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Hero Section */
.terrase-hero {
    position: relative;
    min-height: var(--hero-min-height);
    display: flex;
    align-items: center;
    background-size: cover;
    background-position: center;
    background-color: var(--color-primary);
}

.terrase-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(44, 140, 79, 0.5);
}

.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    color: white;
    max-width: 800px;
    margin: 0 auto;
}

.hero-content h1 {
    font-size: var(--hero-title-size);
    margin-bottom: 20px;
    font-weight: 800;
    color: var(--color-white);
}

@media (max-width: 767px) {
    .hero-content h1 {
        font-size: var(--hero-title-size-mobile);
    }
}

.hero-subtitle {
    font-size: 1.25rem;
    opacity: 0.95;
    color: var(--color-white);
}

/* Intro Section */
.terrase-intro {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

.intro-content {
    max-width: 900px;
    margin: 0 auto;
    text-align: center;
}

.intro-content h2 {
    font-size: 2.5rem;
    color: var(--color-primary);
    margin-bottom: 24px;
    font-weight: 700;
}

.intro-text {
    font-size: 1.125rem;
    color: var(--color-text-secondary);
    line-height: 1.8;
}

/* Calling Cards Section */
.terrase-cards-section {
    background: #ffffff;
    padding-top: 40px;
}

.calling-cards-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 40px;
    max-width: 900px;
    margin: 0 auto;
}

.calling-card {
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}

.calling-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
}

.card-image {
    position: relative;
    aspect-ratio: 4 / 3;
    overflow: hidden;
    background: var(--color-background);
}

.card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.calling-card:hover .card-image img {
    transform: scale(1.05);
}

.card-badge {
    position: absolute;
    top: 16px;
    right: 16px;
    background: var(--color-primary);
    color: white;
    padding: 6px 16px;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.card-content {
    padding: 24px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.card-title {
    font-size: 1.5rem;
    color: var(--color-primary);
    margin: 0 0 12px 0;
    font-weight: 700;
}

.card-subtitle {
    font-size: 0.95rem;
    color: var(--color-text-secondary);
    margin: 0 0 20px 0;
    line-height: 1.6;
}

.card-specs {
    margin-bottom: 20px;
    padding: 16px;
    background: var(--color-background);
    border-radius: 12px;
    border-left: 3px solid var(--color-primary);
}

.spec-item {
    display: flex;
    justify-content: space-between;
    padding: 6px 0;
    font-size: 0.9rem;
}

.spec-item:not(:last-child) {
    border-bottom: 1px solid #e5e7eb;
}

.spec-label {
    font-weight: 600;
    color: var(--color-text-secondary);
}

.spec-value {
    font-weight: 700;
    color: var(--color-text-primary);
}

.card-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 24px;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    color: white;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 700;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    margin-top: auto;
    box-shadow: 0 3px 12px rgba(var(--color-primary-rgb), 0.2);
}

.card-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(var(--color-primary-rgb), 0.3);
}

.button-arrow {
    font-size: 1.2rem;
    transition: transform 0.3s ease;
}

.card-button:hover .button-arrow {
    transform: translateX(4px);
}

/* Responsive Design */
@media (max-width: 1023px) {
    .calling-cards-grid {
        grid-template-columns: 1fr;
        gap: 40px;
    }
}

@media (max-width: 767px) {
    .hero-content h1 {
        font-size: 2.5rem;
    }

    .intro-content h2 {
        font-size: 2rem;
    }

    .section-padding {
        padding: 60px 0;
    }

    .calling-cards-grid {
        gap: 30px;
    }

    .card-content {
        padding: 20px;
    }

    .card-title {
        font-size: 1.35rem;
    }

    .card-subtitle {
        font-size: 0.9rem;
    }
}

@media (max-width: 479px) {
    .hero-content h1 {
        font-size: 2rem;
    }

    .section-padding {
        padding: 40px 0;
    }

    .card-content {
        padding: 16px;
    }

    .card-title {
        font-size: 1.25rem;
    }

    .card-button {
        padding: 10px 20px;
        font-size: 0.9rem;
    }

    .card-specs {
        padding: 12px;
    }

    .spec-item {
        font-size: 0.85rem;
    }
}
</style>

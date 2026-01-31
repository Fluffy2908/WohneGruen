<?php
/**
 * Block: Home Complete (All-in-One for Homepage)
 * Complete homepage with all sections in one block with LIVE PREVIEW
 */

// Get all fields
$hero_title = get_field('home_hero_title');
$hero_subtitle = get_field('home_hero_subtitle');
$hero_button_text = get_field('home_hero_button_text');
$hero_button_link = get_field('home_hero_button_link');
$hero_background = get_field('home_hero_background');

$features_title = get_field('home_features_title');
$features_subtitle = get_field('home_features_subtitle');
$features = get_field('home_features');

$about_title = get_field('home_about_title');
$about_subtitle = get_field('home_about_subtitle');
$about_features = get_field('home_about_features');
$about_image = get_field('home_about_image');
$about_badge_number = get_field('home_about_badge_number');
$about_badge_text = get_field('home_about_badge_text');

$models_title = get_field('home_models_title');
$models_subtitle = get_field('home_models_subtitle');
$selected_models = get_field('home_selected_models');

$cta_title = get_field('home_cta_title');
$cta_subtitle = get_field('home_cta_subtitle');
$cta_button_text = get_field('home_cta_button_text');
$cta_button_link = get_field('home_cta_button_link');

$block_id = 'home-complete-' . $block['id'];
?>

<div class="home-complete-page" id="<?php echo esc_attr($block_id); ?>">

    <!-- Hero Section -->
    <?php if ($hero_title || $hero_subtitle || $hero_button_text): ?>
    <section class="home-hero" style="background-image: url('<?php echo esc_url($hero_background['url'] ?? ''); ?>');">
        <div class="container">
            <div class="hero-content">
                <?php if ($hero_title): ?>
                    <h1><?php echo esc_html($hero_title); ?></h1>
                <?php endif; ?>

                <?php if ($hero_subtitle): ?>
                    <p class="hero-subtitle"><?php echo esc_html($hero_subtitle); ?></p>
                <?php endif; ?>

                <?php if ($hero_button_text && $hero_button_link): ?>
                    <a href="<?php echo esc_url($hero_button_link); ?>" class="btn btn-primary btn-lg">
                        <?php echo esc_html($hero_button_text); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Features Section -->
    <?php if ($features && is_array($features)): ?>
    <section class="home-features section-padding">
        <div class="container">
            <?php if ($features_title || $features_subtitle): ?>
            <div class="section-header text-center">
                <?php if ($features_title): ?>
                    <h2><?php echo esc_html($features_title); ?></h2>
                <?php endif; ?>
                <?php if ($features_subtitle): ?>
                    <p><?php echo esc_html($features_subtitle); ?></p>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <div class="features-grid">
                <?php foreach ($features as $feature): ?>
                    <div class="feature-card">
                        <?php if (isset($feature['icon'])): ?>
                            <div class="feature-icon">
                                <?php echo wohnegruen_get_icon($feature['icon']); ?>
                            </div>
                        <?php endif; ?>
                        <h3><?php echo esc_html($feature['title']); ?></h3>
                        <p><?php echo esc_html($feature['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- About Section -->
    <?php if ($about_title || $about_subtitle || $about_features || $about_image): ?>
    <section class="home-about section-padding">
        <div class="container">
            <div class="about-grid">
                <!-- Image with Badge (Left - 55%) -->
                <div class="about-image-wrapper">
                    <?php if ($about_image): ?>
                        <img src="<?php echo esc_url($about_image['url']); ?>"
                             alt="<?php echo esc_attr($about_image['alt'] ?: 'Über WohneGrün'); ?>">
                        <?php if ($about_badge_number || $about_badge_text): ?>
                            <div class="about-badge">
                                <div class="badge-number"><?php echo esc_html($about_badge_number ?: '15+'); ?></div>
                                <div class="badge-text"><?php echo esc_html($about_badge_text ?: 'Jahre Erfahrung'); ?></div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- Text Content (Right - 45%) -->
                <div class="about-content">
                    <?php if ($about_title): ?>
                        <h2><?php echo esc_html($about_title); ?></h2>
                    <?php endif; ?>
                    <?php if ($about_subtitle): ?>
                        <p class="about-subtitle"><?php echo esc_html($about_subtitle); ?></p>
                    <?php endif; ?>
                    <?php if ($about_features && is_array($about_features)): ?>
                        <ul class="about-features-list">
                            <?php foreach ($about_features as $feature): ?>
                                <li>
                                    <span class="feature-check"><?php echo wohnegruen_get_icon('check'); ?></span>
                                    <span><?php echo esc_html($feature['text']); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Models Section -->
    <?php if ($selected_models && is_array($selected_models)): ?>
    <section class="home-models section-padding bg-light">
        <div class="container">
            <?php if ($models_title || $models_subtitle): ?>
            <div class="section-header text-center">
                <?php if ($models_title): ?>
                    <h2><?php echo esc_html($models_title); ?></h2>
                <?php endif; ?>
                <?php if ($models_subtitle): ?>
                    <p><?php echo esc_html($models_subtitle); ?></p>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <div class="models-grid">
                <?php foreach ($selected_models as $model_item):
                    $model = $model_item['model'];
                    $description = $model_item['description'];

                    $featured_image = get_the_post_thumbnail_url($model->ID, 'large');
                    if (!$featured_image) {
                        // Fallback to first color variant exterior image
                        $colors = get_field('mobilhaus_color_variants', $model->ID);
                        if ($colors && isset($colors[0]['exterior_image']['url'])) {
                            $featured_image = $colors[0]['exterior_image']['url'];
                        }
                    }
                ?>
                    <div class="model-card">
                        <?php if ($featured_image): ?>
                            <div class="model-image">
                                <img src="<?php echo esc_url($featured_image); ?>"
                                     alt="<?php echo esc_attr($model->post_title); ?>"
                                     loading="lazy">
                            </div>
                        <?php endif; ?>
                        <div class="model-content">
                            <h3><?php echo esc_html($model->post_title); ?></h3>
                            <?php if ($description): ?>
                                <p class="model-description"><?php echo esc_html($description); ?></p>
                            <?php endif; ?>
                            <a href="<?php echo get_permalink($model->ID); ?>" class="btn btn-primary btn-compact">
                                Mehr erfahren
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- CTA Section -->
    <section class="home-cta section-padding">
        <div class="container">
            <div class="cta-banner">
                <?php if ($cta_title): ?>
                    <h2><?php echo esc_html($cta_title); ?></h2>
                <?php endif; ?>
                <?php if ($cta_subtitle): ?>
                    <p><?php echo esc_html($cta_subtitle); ?></p>
                <?php endif; ?>
                <?php if ($cta_button_text && $cta_button_link): ?>
                    <a href="<?php echo esc_url($cta_button_link); ?>" class="btn btn-primary btn-lg">
                        <?php echo esc_html($cta_button_text); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>

</div>

<style>
/* Home Complete Styles */
.home-complete-page {
    width: 100%;
}

.home-hero {
    min-height: var(--hero-min-height);
}

.section-padding {
    padding: 60px 0;
}

.container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 var(--spacing-lg);
}

/* Hero */
.home-hero {
    min-height: var(--hero-min-height);
    display: flex;
    align-items: center;
    background-size: cover;
    background-position: center;
    position: relative;
}

.hero-content {
    position: relative;
    z-index: 1;
    color: var(--color-white);
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
}

.hero-content h1 {
    font-size: var(--hero-title-size);
    margin-bottom: var(--spacing-lg);
    color: var(--color-white);
}

.hero-subtitle {
    font-size: var(--font-size-xl);
    margin-bottom: var(--spacing-2xl);
    color: var(--color-white);
}

/* Features */
.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: var(--spacing-2xl);
}

.feature-card {
    background: var(--color-white);
    padding: var(--spacing-2xl);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-card);
    text-align: center;
    transition: var(--transition);
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-card-hover);
}

.feature-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto var(--spacing-lg);
    color: var(--color-primary);
}

.feature-icon svg {
    width: 100%;
    height: 100%;
}

.feature-card h3 {
    color: var(--color-primary);
    margin-bottom: var(--spacing-md);
}

/* About Section */
.home-about {
    background: var(--color-white);
}

.about-grid {
    display: grid;
    grid-template-columns: 55fr 45fr;
    gap: var(--spacing-3xl);
    align-items: center;
}

.about-image-wrapper {
    position: relative;
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
}

.about-image-wrapper img {
    width: 100%;
    height: auto;
    display: block;
}

.about-badge {
    position: absolute;
    bottom: 20px;
    right: 20px;
    background: var(--color-primary);
    color: white;
    padding: 12px 20px;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
    width: auto;
    min-width: 120px;
}

.badge-number {
    font-size: 1.5rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 2px;
}

.badge-text {
    font-size: 0.75rem;
    font-weight: 600;
    opacity: 0.95;
    line-height: 1.2;
    white-space: nowrap;
}

.about-content h2 {
    font-size: var(--font-size-3xl);
    color: var(--color-primary);
    margin-bottom: var(--spacing-md);
    line-height: 1.3;
}

.about-subtitle {
    font-size: var(--font-size-lg);
    color: var(--color-text-secondary);
    margin-bottom: var(--spacing-xl);
    line-height: 1.6;
}

.about-features-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.about-features-list li {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: var(--spacing-md);
    font-size: var(--font-size-md);
    color: var(--color-text-secondary);
    line-height: 1.6;
}

.feature-check {
    flex-shrink: 0;
    width: 24px;
    height: 24px;
    background: var(--color-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-top: 2px;
}

.feature-check svg {
    width: 14px;
    height: 14px;
}

/* Models */
.models-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    max-width: 900px;
    margin: 0 auto;
}

.model-card {
    background: var(--color-white);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: var(--transition);
    display: flex;
    flex-direction: column;
}

.model-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
}

.model-image {
    position: relative;
    aspect-ratio: 16 / 9;
    overflow: hidden;
    background: var(--color-background);
}

.model-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.model-card:hover .model-image img {
    transform: scale(1.05);
}

.model-content {
    padding: 24px;
    text-align: center;
}

.model-content h3 {
    color: var(--color-primary);
    margin-bottom: 8px;
    font-size: 1.5rem;
    font-weight: 700;
}

.model-description {
    font-size: 0.95rem;
    color: var(--color-text-secondary);
    margin-bottom: 16px;
    line-height: 1.5;
}

/* CTA */
.cta-banner {
    text-align: center;
    padding: 40px 30px;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    border-radius: 20px;
    color: var(--color-white);
    max-width: 900px;
    margin: 0 auto;
}

.cta-banner h2 {
    color: var(--color-white);
    font-size: 1.75rem;
    margin-bottom: 12px;
    font-weight: 700;
}

.cta-banner p {
    font-size: 1rem;
    margin-bottom: 20px;
    opacity: 0.95;
}

.cta-banner .btn {
    background: var(--color-white);
    color: var(--color-primary);
    padding: 8px 16px !important;
    font-size: 0.85rem !important;
}

.cta-banner .btn:hover {
    background: var(--color-background);
    transform: translateY(-2px);
}

/* Button styles inherited from global style.css */

/* Section Header */
.section-header {
    margin-bottom: var(--spacing-3xl);
}

.section-header.text-center {
    text-align: center;
}

.section-header h2 {
    font-size: var(--font-size-3xl);
    color: var(--color-primary);
    margin-bottom: var(--spacing-md);
}

.section-header p {
    font-size: var(--font-size-lg);
    color: var(--color-text-secondary);
}

.bg-light {
    background: var(--color-background);
}

/* Responsive */
@media (max-width: 767px) {
    .container {
        padding: 0 var(--spacing-md);
    }

    .hero-content h1 {
        font-size: var(--hero-title-size-mobile);
    }

    .features-grid,
    .models-grid {
        grid-template-columns: 1fr;
    }

    .about-grid {
        grid-template-columns: 1fr;
        gap: var(--spacing-2xl);
    }

    .about-image-wrapper {
        order: 2;
        overflow: visible;
    }

    .about-content {
        order: 1;
    }

    .about-badge {
        bottom: 16px;
        right: 16px;
        padding: 14px 20px;
        min-width: 120px;
        display: block;
        visibility: visible;
        opacity: 1;
        z-index: 10;
    }

    .badge-number {
        font-size: 1.5rem;
    }

    .badge-text {
        font-size: 0.75rem;
    }

    .about-content h2 {
        font-size: var(--font-size-2xl);
    }

    .about-subtitle {
        font-size: var(--font-size-md);
    }

    .section-padding {
        padding: var(--spacing-2xl) 0;
    }
}

/* Compact button style */
.btn-compact {
    padding: 12px 24px !important;
    font-size: 0.95rem !important;
}
</style>

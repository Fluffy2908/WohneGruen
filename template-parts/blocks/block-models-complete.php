<?php
/**
 * Block: Models Complete (Modelle page with calling cards)
 * Shows Nature and Pure as preview cards that link to individual pages
 */
// Get all fields
$hero_title = get_field('models_hero_title');
$hero_subtitle = get_field('models_hero_subtitle');
$hero_image = get_field('models_hero_image');
$intro_title = get_field('models_intro_title');
$intro_content = get_field('models_intro_content');
// Nature and Pure model selection
$nature_model = get_field('models_nature_model');
$pure_model = get_field('models_pure_model');
$block_id = 'models-complete-' . $block['id'];
?>

<div class="models-complete-page" id="<?php echo esc_attr($block_id); ?>">

    <!-- Hero Section -->
    <section class="models-hero" <?php if ($hero_image): ?>style="background-image: url('<?php echo esc_url($hero_image['url']); ?>');"<?php endif; ?>>
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
    <section class="models-intro section-padding">
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
    <?php if ($nature_model || $pure_model): ?>
    <section class="models-cards-section section-padding">
        <div class="container">

            <div class="calling-cards-grid">

                <!-- Nature Card -->
                <?php if ($nature_model):
                    $nature_title = get_the_title($nature_model->ID);
                    $nature_subtitle = get_field('mobilhaus_hero_subtitle', $nature_model->ID);
                    $nature_colors = get_field('mobilhaus_color_variants', $nature_model->ID);
                    $nature_specs = get_field('mobilhaus_specifications', $nature_model->ID);
                    $nature_link = get_permalink($nature_model->ID);
                    $nature_image = '';
                    if ($nature_colors && isset($nature_colors[0]['exterior_image']['url'])) {
                        $nature_image = $nature_colors[0]['exterior_image']['url'];
                    } elseif (has_post_thumbnail($nature_model->ID)) {
                        $nature_image = get_the_post_thumbnail_url($nature_model->ID, 'large');
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
                        <?php if ($nature_specs && is_array($nature_specs) && count($nature_specs) > 0): ?>
                            <div class="card-specs">
                                <?php
                                $specs_to_show = array_slice($nature_specs, 0, 3);
                                foreach ($specs_to_show as $spec):
                                ?>
                                    <div class="spec-item">
                                        <span class="spec-label"><?php echo esc_html($spec['label']); ?>:</span>
                                        <span class="spec-value"><?php echo esc_html($spec['value']); ?></span>
                                    </div>
                                <?php endforeach; ?>
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
                <?php if ($pure_model):
                    $pure_title = get_the_title($pure_model->ID);
                    $pure_subtitle = get_field('mobilhaus_hero_subtitle', $pure_model->ID);
                    $pure_colors = get_field('mobilhaus_color_variants', $pure_model->ID);
                    $pure_specs = get_field('mobilhaus_specifications', $pure_model->ID);
                    $pure_link = get_permalink($pure_model->ID);
                    $pure_image = '';
                    if ($pure_colors && isset($pure_colors[0]['exterior_image']['url'])) {
                        $pure_image = $pure_colors[0]['exterior_image']['url'];
                    } elseif (has_post_thumbnail($pure_model->ID)) {
                        $pure_image = get_the_post_thumbnail_url($pure_model->ID, 'large');
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
                        <?php if ($pure_specs && is_array($pure_specs) && count($pure_specs) > 0): ?>
                            <div class="card-specs">
                                <?php
                                $specs_to_show = array_slice($pure_specs, 0, 3);
                                foreach ($specs_to_show as $spec):
                                ?>
                                    <div class="spec-item">
                                        <span class="spec-label"><?php echo esc_html($spec['label']); ?>:</span>
                                        <span class="spec-value"><?php echo esc_html($spec['value']); ?></span>
                                    </div>
                                <?php endforeach; ?>
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
/* MODELS COMPLETE PAGE - PROFESSIONAL CALLING CARDS DESIGN */
.models-complete-page {
    width: 100%;
    margin: 0;
    padding: 0;
    margin-block-start: 0;
    margin-block-end: 0;
    padding-block-start: 0;
    padding-block-end: 0;
}

.models-hero {
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

.section-title {
    font-size: 2.5rem;
    color: var(--color-primary);
    margin-bottom: 60px;
    text-align: center;
    font-weight: 700;
}

/* Hero Section */
.models-hero {
    position: relative;
    min-height: var(--hero-min-height);
    display: flex;
    align-items: center;
    background-size: cover;
    background-position: center;
    background-color: var(--color-primary);
}

.models-hero::before {
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
.models-intro {
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
.models-cards-section {
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

    .section-title {
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

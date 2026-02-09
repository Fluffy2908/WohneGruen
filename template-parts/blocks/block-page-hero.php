<?php
/**
 * Block: Page Hero
 *
 * Simple hero section for inner pages with background image and title
 */

$background_image = get_field('page_hero_background');
$title = get_field('page_hero_title');
$subtitle = get_field('page_hero_subtitle');

if (empty($title)) {
    echo '<div class="acf-block-placeholder">Fügen Sie einen Titel in den Block-Einstellungen hinzu</div>';
    return;
}

// Use ACF background image if set, otherwise fall back to featured image
$bg_url = '';
if (!empty($background_image)) {
    $bg_url = esc_url($background_image['url']);
} else {
    // Try to get featured image from current post/page
    $featured_image_id = get_post_thumbnail_id();
    if ($featured_image_id) {
        $featured_image = wp_get_attachment_image_src($featured_image_id, 'full');
        if ($featured_image) {
            $bg_url = esc_url($featured_image[0]);
        }
    }
}

$block_id = isset($block['anchor']) ? $block['anchor'] : 'page-hero-' . uniqid();
?>

<section class="page-hero-section" id="<?php echo esc_attr($block_id); ?>" <?php if ($bg_url): ?>data-bg-image="<?php echo esc_attr($bg_url); ?>"<?php endif; ?>>
    <div class="page-hero-overlay"></div>
    <div class="container">
        <div class="page-hero-content">
            <h1><?php echo esc_html($title); ?></h1>
            <?php if (!empty($subtitle)): ?>
                <p class="page-hero-subtitle"><?php echo esc_html($subtitle); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
.page-hero-section {
    position: relative;
    min-height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-color: var(--color-primary);
    padding: 100px 20px;
}

.page-hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(var(--color-primary-rgb), 0.85) 0%, rgba(var(--color-primary-rgb), 0.75) 100%);
    z-index: 1;
}

.page-hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    color: #ffffff;
    max-width: 900px;
    margin: 0 auto;
}

.page-hero-content h1 {
    font-size: 3.5rem;
    font-weight: 700;
    margin: 0 0 20px 0;
    line-height: 1.2;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.page-hero-subtitle {
    font-size: 1.5rem;
    font-weight: 400;
    margin: 0;
    opacity: 0.95;
    line-height: 1.5;
}

/* Responsive */
@media (max-width: 768px) {
    .page-hero-section {
        min-height: 300px;
        padding: 80px 20px;
    }

    .page-hero-content h1 {
        font-size: 2.5rem;
    }

    .page-hero-subtitle {
        font-size: 1.2rem;
    }
}

@media (max-width: 480px) {
    .page-hero-section {
        min-height: 250px;
        padding: 60px 20px;
    }

    .page-hero-content h1 {
        font-size: 2rem;
    }

    .page-hero-subtitle {
        font-size: 1rem;
    }
}
</style>

<script>
// Apply background image from data attribute (safer than inline style)
document.addEventListener('DOMContentLoaded', function() {
    const heroSection = document.querySelector('#<?php echo esc_js($block_id); ?>');
    if (heroSection && heroSection.dataset.bgImage) {
        heroSection.style.backgroundImage = 'url(' + heroSection.dataset.bgImage + ')';
    }
});
</script>

<?php
/**
 * Template Name: Datenschutz
 * Privacy policy page template
 */

get_header();

// Get featured image or use fallback
$hero_image_url = '';
$featured_image_id = get_post_thumbnail_id();
if ($featured_image_id) {
    $featured_image = wp_get_attachment_image_src($featured_image_id, 'full');
    if ($featured_image) {
        $hero_image_url = esc_url($featured_image[0]);
    }
}

// Fallback to default image if no featured image is set
if (empty($hero_image_url)) {
    $hero_image_url = get_template_directory_uri() . '/assets/images/wohnegruen-mobilhaus-exterior-3.jpg';
}
?>

<!-- Privacy Hero Section -->
<section id="main-content" class="hero-section hero-small">
    <div class="hero-background">
        <img src="<?php echo esc_url($hero_image_url); ?>" alt="WohneGruen Datenschutz" loading="eager">
        <div class="hero-overlay"></div>
    </div>
    <div class="container">
        <div class="hero-content">
            <h1 class="animate-slide-up">Datenschutzerklärung</h1>
            <p class="hero-text animate-slide-up">Informationen gemäß DSGVO</p>
        </div>
    </div>
</section>

<style>
.hero-overlay {
    position: absolute;
    inset: 0;
    background: rgba(44, 140, 79, 0.5);
    z-index: 1;
}

.hero-content {
    position: relative;
    z-index: 2;
}

.hero-content h1 {
    color: #ffffff;
}

.hero-text {
    color: #ffffff;
}
</style>

<!-- Privacy Content Section -->
<section class="legal-section section-padding">
    <div class="container">
        <div class="legal-content">
            <h2>Datenschutzerklärung</h2>

            <?php if (get_field('datenschutz_custom_content')) : ?>
                <?php echo wp_kses_post(get_field('datenschutz_custom_content')); ?>
            <?php else : ?>
                <p><em>Bitte fügen Sie den Datenschutz-Inhalt im WordPress-Backend unter "Zusätzliche Datenschutz-Inhalte" ein.</em></p>
            <?php endif; ?>

            <p class="legal-update">
                <small>Stand dieser Datenschutzerklärung: <?php echo date('d.m.Y'); ?></small>
            </p>
        </div>
    </div>
</section>

<?php get_footer(); ?>

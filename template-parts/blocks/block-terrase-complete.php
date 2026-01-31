<?php
/**
 * Block: Complete Terrase Presentation
 * Professional design for terrace detail pages
 */

// Get all field data
$hero_title = get_field('terrase_hero_title') ?: get_the_title();
$hero_subtitle = get_field('terrase_hero_subtitle');
$hero_image = get_field('terrase_hero_image');
$description_title = get_field('terrase_description_title');
$description_text = get_field('terrase_description_text');
$size_variants = get_field('terrase_size_variants');
$style_schemes = get_field('terrase_style_schemes');
$features = get_field('terrase_features');

$block_id = isset($block['anchor']) ? $block['anchor'] : 'terrase-' . $block['id'];

// Get hero background image
$hero_bg_image = '';
if ($hero_image && isset($hero_image['url'])) {
    $hero_bg_image = $hero_image['url'];
} elseif (has_post_thumbnail()) {
    $hero_bg_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
}
?>

<article class="terrase-complete-page" id="<?php echo esc_attr($block_id); ?>">

    <!-- HERO SECTION: Background Image + Green Filter + Centered Headline -->
    <section class="terrase-hero-new" style="background-image: url('<?php echo esc_url($hero_bg_image); ?>');">
        <div class="container">
            <div class="hero-content-center">
                <?php if ($hero_title): ?>
                    <h1 class="hero-headline"><?php echo esc_html($hero_title); ?></h1>
                <?php endif; ?>
                <?php if ($hero_subtitle): ?>
                    <p class="hero-subtitle-text"><?php echo esc_html($hero_subtitle); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- DESCRIPTION BANNER: Full Width with Text -->
    <?php if ($description_title || $description_text): ?>
    <section class="description-banner section-padding">
        <div class="container">
            <?php if ($description_title): ?>
                <h2 class="banner-title"><?php echo esc_html($description_title); ?></h2>
            <?php endif; ?>
            <?php if ($description_text): ?>
                <div class="banner-text">
                    <?php echo wp_kses_post($description_text); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- FEATURES SECTION (if available) -->
    <?php if ($features && is_array($features) && count($features) > 0): ?>
    <section class="features-section section-padding">
        <div class="container">
            <h2 class="section-title">Besondere Merkmale</h2>
            <div class="features-grid">
                <?php foreach ($features as $feature): ?>
                    <div class="feature-card">
                        <?php if (!empty($feature['icon'])): ?>
                            <span class="dashicons <?php echo esc_attr($feature['icon']); ?>"></span>
                        <?php endif; ?>
                        <h3><?php echo esc_html($feature['title']); ?></h3>
                        <?php if (!empty($feature['description'])): ?>
                            <p><?php echo esc_html($feature['description']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- SIZE VARIANTS SECTION: Tabbed Design with Specs + Images -->
    <?php if ($size_variants && is_array($size_variants) && count($size_variants) > 0): ?>
    <section class="size-variants-section section-padding">
        <div class="container">
            <h2 class="section-title">Größenvarianten & Technische Daten</h2>

            <!-- Size Variant Tabs -->
            <?php if (count($size_variants) > 1): ?>
            <div class="size-variant-tabs">
                <?php foreach ($size_variants as $index => $variant): ?>
                    <button
                        class="size-variant-tab <?php echo $index === 0 ? 'active' : ''; ?>"
                        onclick="switchSizeVariant(<?php echo $index; ?>, '<?php echo esc_js($block_id); ?>')">
                        <?php echo esc_html($variant['variant_name']); ?>
                    </button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Size Variant Content -->
            <?php foreach ($size_variants as $var_index => $variant): ?>
            <div class="size-variant-content"
                 id="variant-<?php echo esc_attr($block_id); ?>-<?php echo $var_index; ?>"
                 style="<?php echo $var_index === 0 ? '' : 'display: none;'; ?>">

                <div class="details-grid">
                    <!-- Left: Specifications Text -->
                    <div class="details-text">
                        <?php if (!empty($variant['specifications']) && is_array($variant['specifications'])): ?>
                            <h3>Technische Daten - <?php echo esc_html($variant['variant_name']); ?></h3>
                            <dl class="specs-list">
                                <?php foreach ($variant['specifications'] as $spec): ?>
                                    <div class="spec-row">
                                        <dt><?php echo esc_html($spec['label']); ?></dt>
                                        <dd><?php echo esc_html($spec['value']); ?></dd>
                                    </div>
                                <?php endforeach; ?>
                            </dl>
                        <?php endif; ?>
                    </div>

                    <!-- Right: Variant Image -->
                    <?php if (!empty($variant['variant_image']['url'])): ?>
                    <div class="details-image">
                        <img src="<?php echo esc_url($variant['variant_image']['url']); ?>"
                             alt="<?php echo esc_attr($variant['variant_name']); ?>"
                             loading="lazy">
                    </div>
                    <?php endif; ?>
                </div>

            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>


    <!-- STYLE & DESIGN SCHEMES -->
    <?php if ($style_schemes && is_array($style_schemes) && count($style_schemes) > 0): ?>
    <section class="style-schemes-section section-padding">
        <div class="container">
            <h2 class="section-title">Stil & Design Optionen</h2>
            <p class="section-subtitle">Wählen Sie aus verschiedenen hochwertigen Material- und Stilkombinationen</p>

            <?php foreach ($style_schemes as $scheme_index => $scheme): ?>
                <div class="scheme-block">
                    <!-- Scheme Header: Text LEFT, Material Palette RIGHT -->
                    <div class="scheme-header-grid">
                        <div class="scheme-text">
                            <h3><?php echo esc_html($scheme['scheme_name']); ?></h3>
                            <?php if (isset($scheme['scheme_description']) && !empty($scheme['scheme_description'])): ?>
                                <p class="scheme-desc"><?php echo esc_html($scheme['scheme_description']); ?></p>
                            <?php endif; ?>
                        </div>

                        <?php if (isset($scheme['color_palette_image']['url'])): ?>
                            <div class="palette-preview">
                                <img src="<?php echo esc_url($scheme['color_palette_image']['url']); ?>"
                                     alt="Palette <?php echo esc_attr($scheme['scheme_name']); ?>"
                                     loading="lazy">
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Gallery Grid -->
                    <?php if (!empty($scheme['gallery']) && is_array($scheme['gallery'])): ?>
                    <div class="style-gallery">
                        <?php foreach ($scheme['gallery'] as $img_index => $image): ?>
                            <div class="gallery-item"
                                 onclick="openLightbox(<?php echo $scheme_index; ?>, <?php echo $img_index; ?>)">
                                <img src="<?php echo esc_url($image['sizes']['medium'] ?? $image['url']); ?>"
                                     alt="<?php echo esc_attr($scheme['scheme_name'] . ' - Ansicht ' . ($img_index + 1)); ?>"
                                     loading="lazy">
                                <div class="gallery-overlay">
                                    <span class="zoom-icon">🔍</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Lightbox -->
    <div id="lightbox-<?php echo esc_attr($block_id); ?>" class="lightbox" onclick="closeLightbox()">
        <button class="lightbox-close" onclick="closeLightbox()">&times;</button>
        <button class="lightbox-prev" onclick="event.stopPropagation(); navigateLightbox(-1)">‹</button>
        <img class="lightbox-content" id="lightbox-img" src="" alt="">
        <button class="lightbox-next" onclick="event.stopPropagation(); navigateLightbox(1)">›</button>
        <div class="lightbox-counter" id="lightbox-counter"></div>
    </div>
    <?php endif; ?>

</article>

<style>
/* TERRASE COMPLETE PAGE - PROFESSIONAL DESIGN */
.terrase-complete-page {
    width: 100%;
    margin: 0;
    padding: 0;
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
    margin-bottom: 16px;
    text-align: center;
    font-weight: 700;
}

.section-subtitle {
    font-size: 1.125rem;
    color: var(--color-text-secondary);
    text-align: center;
    margin-bottom: 60px;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
}

/* Hero Section */
.terrase-hero-new {
    position: relative;
    min-height: var(--hero-min-height);
    display: flex;
    align-items: center;
    justify-content: center;
    background-size: cover;
    background-position: center;
    background-color: var(--color-primary);
    margin: 0;
    margin-block-start: 0;
    padding-top: 0;
    padding-block-start: 0;
}

.terrase-hero-new::before {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(44, 140, 79, 0.6);
}

.hero-content-center {
    position: relative;
    z-index: 2;
    text-align: center;
    color: white;
    max-width: 900px;
    padding: 40px 20px;
}

.hero-headline {
    font-size: var(--hero-title-size);
    margin-bottom: 20px;
    font-weight: 800;
    color: var(--color-white);
    line-height: 1.2;
}

@media (max-width: 767px) {
    .hero-headline {
        font-size: var(--hero-title-size-mobile);
    }
}

.hero-subtitle-text {
    font-size: 1.25rem;
    opacity: 0.95;
    line-height: 1.6;
    color: var(--color-white);
}

/* Description Banner */
.description-banner {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

.banner-title {
    font-size: 2rem;
    color: var(--color-primary);
    margin-bottom: 24px;
    text-align: center;
    font-weight: 700;
}

.banner-text {
    max-width: 900px;
    margin: 0 auto;
    font-size: 1.125rem;
    line-height: 1.8;
    color: var(--color-text-secondary);
}

.banner-text p {
    margin-bottom: 16px;
}

/* Features Section */
.features-section {
    background: #ffffff;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

.feature-card {
    background: var(--color-background);
    padding: 30px;
    border-radius: 16px;
    text-align: center;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.feature-card:hover {
    border-color: var(--color-primary);
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
}

.feature-card .dashicons {
    font-size: 48px;
    width: 48px;
    height: 48px;
    color: var(--color-primary);
    margin-bottom: 16px;
}

.feature-card h3 {
    font-size: 1.25rem;
    color: var(--color-primary);
    margin-bottom: 12px;
    font-weight: 700;
}

.feature-card p {
    font-size: 0.95rem;
    color: var(--color-text-secondary);
    line-height: 1.6;
}

/* Size Variants Section */
.size-variants-section {
    background: #ffffff;
}

.size-variant-tabs {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-bottom: 40px;
    flex-wrap: wrap;
}

.size-variant-tab {
    padding: 12px 24px;
    background: var(--color-background);
    border: 2px solid var(--color-background);
    color: var(--color-text-secondary);
    font-weight: 600;
    font-size: 1rem;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.size-variant-tab:hover {
    border-color: var(--color-primary);
}

.size-variant-tab.active {
    background: var(--color-primary);
    border-color: var(--color-primary);
    color: white;
}

.size-variant-content {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.details-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: start;
}

@media (max-width: 991px) {
    .details-grid {
        grid-template-columns: 1fr;
        gap: 40px;
    }
}

.details-text h3 {
    font-size: 1.75rem;
    color: var(--color-primary);
    margin-bottom: 24px;
    font-weight: 700;
}

.specs-list {
    background: var(--color-background);
    padding: 30px;
    border-radius: 16px;
    border-left: 4px solid var(--color-primary);
}

.spec-row {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #e5e7eb;
}

.spec-row:last-child {
    border-bottom: none;
}

.spec-row dt {
    font-weight: 600;
    color: var(--color-text-secondary);
}

.spec-row dd {
    font-weight: 700;
    color: var(--color-text-primary);
    margin: 0;
}

.details-image img {
    width: 100%;
    height: auto;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

/* Style Schemes Section */
.style-schemes-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

.scheme-block {
    margin-bottom: 80px;
    padding: 60px 0;
    background: transparent;
    border-radius: 0;
}

.scheme-block:last-child {
    margin-bottom: 0;
}

.scheme-header-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 40px;
    margin-bottom: 40px;
    align-items: center;
}

@media (max-width: 991px) {
    .scheme-header-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
}

.scheme-text h3 {
    font-size: 2rem;
    color: var(--color-primary);
    margin-bottom: 16px;
    font-weight: 700;
}

.scheme-desc {
    font-size: 1.125rem;
    color: var(--color-text-secondary);
    line-height: 1.8;
}

.palette-preview {
    text-align: center;
}

.palette-preview img {
    max-width: 100%;
    height: auto;
    border-radius: 12px;
}

.style-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.gallery-item {
    position: relative;
    aspect-ratio: 4 / 3;
    overflow: hidden;
    border-radius: 12px;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.gallery-item:hover {
    transform: scale(1.02);
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.gallery-overlay {
    position: absolute;
    inset: 0;
    background: rgba(44, 140, 79, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-item:hover .gallery-overlay {
    opacity: 1;
}

.zoom-icon {
    font-size: 3rem;
}

/* Lightbox */
.lightbox {
    display: none;
    position: fixed;
    z-index: 9999;
    inset: 0;
    background: rgba(0, 0, 0, 0.95);
    align-items: center;
    justify-content: center;
}

.lightbox.active {
    display: flex;
}

.lightbox-content {
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
}

.lightbox-close,
.lightbox-prev,
.lightbox-next {
    position: absolute;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: none;
    font-size: 3rem;
    cursor: pointer;
    padding: 10px 20px;
    transition: background 0.3s ease;
}

.lightbox-close:hover,
.lightbox-prev:hover,
.lightbox-next:hover {
    background: rgba(255, 255, 255, 0.3);
}

.lightbox-close {
    top: 20px;
    right: 40px;
}

.lightbox-prev {
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
}

.lightbox-next {
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
}

.lightbox-counter {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    color: white;
    font-size: 1.125rem;
    background: rgba(0, 0, 0, 0.5);
    padding: 8px 16px;
    border-radius: 20px;
}

/* Responsive Design */
@media (max-width: 767px) {
    .section-title {
        font-size: 2rem;
    }

    .section-subtitle {
        font-size: 1rem;
        margin-bottom: 40px;
    }

    .banner-title {
        font-size: 1.75rem;
    }

    .banner-text {
        font-size: 1rem;
    }

    .features-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .feature-card {
        padding: 24px;
    }

    .style-gallery {
        grid-template-columns: 1fr;
        gap: 16px;
    }

    .lightbox-prev,
    .lightbox-next {
        font-size: 2rem;
        padding: 8px 16px;
    }

    .lightbox-close {
        font-size: 2.5rem;
        right: 20px;
        top: 10px;
    }
}

@media (max-width: 479px) {
    .section-padding {
        padding: 40px 0;
    }

    .scheme-block {
        padding: 40px 0;
    }

    .details-text h3 {
        font-size: 1.5rem;
    }

    .scheme-text h3 {
        font-size: 1.75rem;
    }
}
</style>

<script>
// Switch Size Variant
function switchSizeVariant(index, blockId) {
    const contents = document.querySelectorAll(`[id^="variant-${blockId}-"]`);
    const tabs = document.querySelectorAll('.size-variant-tab');

    contents.forEach((content, i) => {
        content.style.display = i === index ? 'block' : 'none';
    });

    tabs.forEach((tab, i) => {
        if (i === index) {
            tab.classList.add('active');
        } else {
            tab.classList.remove('active');
        }
    });
}

// Lightbox functionality
let currentSchemeIndex = 0;
let currentImageIndex = 0;
let schemesData = <?php echo json_encode($style_schemes ?: []); ?>;

function openLightbox(schemeIndex, imageIndex) {
    currentSchemeIndex = schemeIndex;
    currentImageIndex = imageIndex;
    updateLightboxImage();
    document.getElementById('lightbox-<?php echo esc_js($block_id); ?>').classList.add('active');
}

function closeLightbox() {
    document.getElementById('lightbox-<?php echo esc_js($block_id); ?>').classList.remove('active');
}

function navigateLightbox(direction) {
    const currentScheme = schemesData[currentSchemeIndex];
    if (!currentScheme || !currentScheme.gallery) return;

    currentImageIndex += direction;

    if (currentImageIndex < 0) {
        currentImageIndex = currentScheme.gallery.length - 1;
    } else if (currentImageIndex >= currentScheme.gallery.length) {
        currentImageIndex = 0;
    }

    updateLightboxImage();
}

function updateLightboxImage() {
    const currentScheme = schemesData[currentSchemeIndex];
    if (!currentScheme || !currentScheme.gallery) return;

    const image = currentScheme.gallery[currentImageIndex];
    document.getElementById('lightbox-img').src = image.url;
    document.getElementById('lightbox-counter').textContent =
        `${currentImageIndex + 1} / ${currentScheme.gallery.length}`;
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    const lightbox = document.getElementById('lightbox-<?php echo esc_js($block_id); ?>');
    if (lightbox && lightbox.classList.contains('active')) {
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') navigateLightbox(-1);
        if (e.key === 'ArrowRight') navigateLightbox(1);
    }
});
</script>

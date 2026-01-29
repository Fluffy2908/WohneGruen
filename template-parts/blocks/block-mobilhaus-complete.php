<?php
/**
 * Block: Complete Mobilhaus Presentation
 * NEW DESIGN: Hero with background + Color buttons + Banner + Text/Image sections
 */

// Get all field data
$hero_title = get_field('mobilhaus_hero_title') ?: get_the_title();
$hero_subtitle = get_field('mobilhaus_hero_subtitle');
$color_variants = get_field('mobilhaus_color_variants');
$description_title = get_field('mobilhaus_description_title');
$description_text = get_field('mobilhaus_description_text');
$size_variants = get_field('mobilhaus_size_variants');
$interior_schemes = get_field('mobilhaus_interior_schemes');

$block_id = isset($block['anchor']) ? $block['anchor'] : 'mobilhaus-' . $block['id'];

// Get hero background image (use first color variant's image or featured image)
$hero_bg_image = '';
if ($color_variants && isset($color_variants[0]['exterior_image']['url'])) {
    $hero_bg_image = $color_variants[0]['exterior_image']['url'];
} elseif (has_post_thumbnail()) {
    $hero_bg_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
}
?>

<article class="mobilhaus-complete-page" id="<?php echo esc_attr($block_id); ?>">

    <!-- HERO SECTION: Background Image + Green Filter + Centered Headline -->
    <section class="mobilhaus-hero-new" style="background-image: url('<?php echo esc_url($hero_bg_image); ?>');">
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

    <!-- COLOR SELECTION BUTTONS + EXTERIOR IMAGE -->
    <?php if ($color_variants && is_array($color_variants)): ?>
    <section class="color-selection-section section-padding">
        <div class="container">
            <h2 class="section-title">Wählen Sie Ihre Farbvariante</h2>

            <!-- Big Color Buttons -->
            <div class="big-color-buttons">
                <?php foreach ($color_variants as $index => $variant): ?>
                    <button
                        class="big-color-btn <?php echo $index === 0 ? 'active' : ''; ?>"
                        data-color-index="<?php echo $index; ?>"
                        onclick="switchExteriorColor(<?php echo $index; ?>)">
                        <span class="color-btn-text"><?php echo esc_html($variant['color_name']); ?></span>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Exterior Image Display -->
            <div class="exterior-image-display">
                <?php foreach ($color_variants as $index => $variant): ?>
                    <img
                        class="exterior-img <?php echo $index === 0 ? 'active' : ''; ?>"
                        data-color-index="<?php echo $index; ?>"
                        src="<?php echo esc_url($variant['exterior_image']['url']); ?>"
                        alt="<?php echo esc_attr($hero_title . ' - ' . $variant['color_name']); ?>"
                        loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>">
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- DESCRIPTION BANNER: Full Width with Text -->
    <?php if ($description_title || $description_text): ?>
    <section class="description-banner">
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

    <!-- SIZE VARIANTS SECTION: Tabbed Design with Specs + Images -->
    <?php if ($size_variants && is_array($size_variants) && count($size_variants) > 0): ?>
    <section class="size-variants-section section-padding">
        <div class="container">
            <h2 class="section-title">Technische Daten & Layout-Optionen</h2>

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
                            <h3>Technische Daten</h3>
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

                    <!-- Right: Layout Image Carousel -->
                    <?php if (!empty($variant['description_layouts']) && is_array($variant['description_layouts']) && count($variant['description_layouts']) > 0): ?>
                    <div class="details-image-carousel">
                        <?php if (count($variant['description_layouts']) > 1): ?>
                            <button class="layout-nav layout-prev"
                                    onclick="navigateLayout('<?php echo esc_js($block_id); ?>', <?php echo $var_index; ?>, -1)"
                                    aria-label="Vorheriges Layout">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="15 18 9 12 15 6"></polyline>
                                </svg>
                            </button>
                        <?php endif; ?>

                        <div class="layout-images-container">
                            <?php foreach ($variant['description_layouts'] as $idx => $layout): ?>
                                <div class="layout-image-wrapper"
                                     id="layout-<?php echo esc_attr($block_id); ?>-<?php echo $var_index; ?>-<?php echo $idx; ?>"
                                     style="<?php echo $idx === 0 ? '' : 'display: none;'; ?>">
                                    <img class="layout-image"
                                         src="<?php echo esc_url($layout['normal_image']['url']); ?>"
                                         alt="<?php echo esc_attr($layout['layout_name'] ?: 'Layout ' . ($idx + 1)); ?>"
                                         loading="lazy">

                                    <?php if (isset($layout['layout_name']) && !empty($layout['layout_name'])): ?>
                                        <div class="layout-label"><?php echo esc_html($layout['layout_name']); ?></div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php if (count($variant['description_layouts']) > 1): ?>
                            <button class="layout-nav layout-next"
                                    onclick="navigateLayout('<?php echo esc_js($block_id); ?>', <?php echo $var_index; ?>, 1)"
                                    aria-label="Nächstes Layout">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </button>
                        <?php endif; ?>

                        <!-- Reverse Button -->
                        <button class="layout-reverse-btn"
                                onclick="toggleLayoutReverse('<?php echo esc_js($block_id); ?>', <?php echo $var_index; ?>)">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="1 4 1 10 7 10"></polyline>
                                <polyline points="23 20 23 14 17 14"></polyline>
                                <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path>
                            </svg>
                            <span class="reverse-text">Gespiegelt anzeigen</span>
                        </button>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Grundrisse for this variant -->
                <?php if (!empty($variant['floor_plans']) && is_array($variant['floor_plans']) && count($variant['floor_plans']) > 0): ?>
                <div class="variant-floor-plans">
                    <h3>Grundrisse</h3>
                    <div class="floor-plans-grid">
                        <?php foreach ($variant['floor_plans'] as $plan_index => $plan): ?>
                            <div class="floor-plan-item">
                                <?php if (!empty($plan['title'])): ?>
                                    <h4><?php echo esc_html($plan['title']); ?></h4>
                                <?php endif; ?>
                                <?php if (!empty($plan['description'])): ?>
                                    <p><?php echo esc_html($plan['description']); ?></p>
                                <?php endif; ?>
                                <div class="floor-plan-images">
                                    <img class="floor-plan-image active"
                                         id="floor-plan-<?php echo esc_attr($block_id); ?>-<?php echo $var_index; ?>-<?php echo $plan_index; ?>"
                                         src="<?php echo esc_url($plan['normal_plan']['url']); ?>"
                                         alt="<?php echo esc_attr($plan['title'] ?: 'Grundriss'); ?>"
                                         loading="lazy">
                                    <button class="floor-plan-toggle"
                                            onclick="toggleFloorPlan('<?php echo esc_js($block_id); ?>', <?php echo $var_index; ?>, <?php echo $plan_index; ?>, '<?php echo esc_url($plan['normal_plan']['url']); ?>', '<?php echo esc_url($plan['mirrored_plan']['url']); ?>')">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="1 4 1 10 7 10"></polyline>
                                            <polyline points="23 20 23 14 17 14"></polyline>
                                            <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path>
                                        </svg>
                                        <span class="toggle-text">Gespiegelt anzeigen</span>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>


    <!-- INTERIOR COLOR SCHEMES -->
    <?php if ($interior_schemes && is_array($interior_schemes)): ?>
    <section class="interior-schemes-section section-padding">
        <div class="container">
            <h2 class="section-title">Innenausstattung & Farbschemata</h2>
            <p class="section-subtitle">Wählen Sie aus verschiedenen hochwertigen Material- und Farbkombinationen</p>

            <?php foreach ($interior_schemes as $scheme_index => $scheme): ?>
                <div class="scheme-block">
                    <!-- Scheme Header: Text LEFT, Color Palette RIGHT -->
                    <div class="scheme-header-grid">
                        <div class="scheme-text">
                            <h3><?php echo esc_html($scheme['scheme_name']); ?></h3>
                            <?php if (isset($scheme['scheme_description'])): ?>
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
                    <div class="interior-gallery">
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
/* NEW PROFESSIONAL DESIGN */
.mobilhaus-complete-page {
    width: 100%;
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
    margin-bottom: 40px;
    text-align: center;
    font-weight: 700;
}

.section-subtitle {
    text-align: center;
    font-size: 1.125rem;
    color: var(--color-text-secondary);
    margin-bottom: 60px;
}

/* HERO SECTION: Background Image + Green Filter + Centered Text */
.mobilhaus-hero-new {
    position: relative;
    min-height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.mobilhaus-hero-new::before {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(44, 140, 79, 0.5);
}

.hero-content-center {
    position: relative;
    z-index: 2;
    text-align: center;
    color: white;
    max-width: 800px;
    padding: 40px 20px;
}

.hero-headline {
    font-size: 4rem;
    font-weight: 800;
    margin: 0 0 20px 0;
    letter-spacing: -0.02em;
    color: var(--color-white);
}

.hero-subtitle-text {
    font-size: 1.5rem;
    margin: 0;
    opacity: 0.95;
    color: var(--color-white);
}

/* COLOR SELECTION SECTION */
.color-selection-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

.big-color-buttons {
    display: flex;
    gap: 30px;
    justify-content: center;
    margin-bottom: 60px;
    flex-wrap: wrap;
}

.big-color-btn {
    padding: 24px 60px;
    background: #ffffff;
    border: 4px solid #e5e7eb;
    border-radius: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    min-width: 200px;
}

.big-color-btn:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
    border-color: var(--color-primary);
}

.big-color-btn.active {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    border-color: var(--color-primary);
    box-shadow: 0 12px 40px rgba(var(--color-primary-rgb), 0.3);
}

.big-color-btn.active .color-btn-text {
    color: white;
}

.color-btn-text {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--color-text-primary);
}

/* Exterior Image Display */
.exterior-image-display {
    position: relative;
    max-width: 1000px;
    margin: 0 auto;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
    aspect-ratio: 16 / 10;
}

.exterior-img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0;
    transition: opacity 0.5s ease;
}

.exterior-img.active {
    opacity: 1;
    z-index: 1;
}

/* DESCRIPTION BANNER: Full Width */
.description-banner {
    background: var(--color-primary);
    color: white;
    padding: 80px 20px;
    text-align: center;
}

.banner-title {
    font-size: 3rem;
    margin: 0 0 30px 0;
    font-weight: 700;
}

.banner-text {
    font-size: 1.25rem;
    line-height: 1.8;
    max-width: 1000px;
    margin: 0 auto;
}

.banner-text p {
    margin-bottom: 20px;
}

/* SIZE VARIANTS SECTION: Tabbed Design */
.size-variants-section {
    background: #ffffff;
}

.size-variant-tabs {
    display: flex;
    gap: 20px;
    justify-content: center;
    margin-bottom: 60px;
    flex-wrap: wrap;
}

.size-variant-tab {
    padding: 18px 40px;
    background: #ffffff;
    border: 3px solid #e5e7eb;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--color-text-primary);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.size-variant-tab:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
    border-color: var(--color-primary);
}

.size-variant-tab.active {
    background: var(--color-primary);
    border-color: var(--color-primary);
    color: white;
    box-shadow: 0 6px 20px rgba(var(--color-primary-rgb), 0.3);
}

.size-variant-content {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Variant Floor Plans */
.variant-floor-plans {
    margin-top: 60px;
    padding-top: 40px;
    border-top: 2px solid #e5e7eb;
}

.variant-floor-plans h3 {
    font-size: 2rem;
    color: var(--color-primary);
    margin-bottom: 32px;
    font-weight: 700;
}

.floor-plans-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 40px;
}

.floor-plan-item h4 {
    font-size: 1.25rem;
    color: var(--color-primary);
    margin-bottom: 8px;
}

.floor-plan-item p {
    color: var(--color-text-secondary);
    margin-bottom: 16px;
}

.floor-plan-images {
    position: relative;
}

.floor-plan-image {
    width: 100%;
    height: auto;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    transition: opacity 0.3s ease;
}

.floor-plan-toggle {
    margin-top: 16px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: var(--color-primary);
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
}

.floor-plan-toggle:hover {
    background: var(--color-primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(var(--color-primary-rgb), 0.3);
}

/* DETAILS GRID: Text LEFT, Image RIGHT */
.details-section,
.size-variants-section {
    background: #ffffff;
}

.details-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: start;
}

.details-text h3 {
    font-size: 2rem;
    color: var(--color-primary);
    margin-bottom: 32px;
    font-weight: 700;
}

.specs-list {
    display: grid;
    gap: 20px;
}

.spec-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    padding: 20px;
    background: var(--color-background);
    border-radius: 12px;
    border-left: 4px solid var(--color-primary);
}

.spec-row dt {
    font-weight: 600;
    color: var(--color-text-secondary);
    font-size: 1.125rem;
}

.spec-row dd {
    font-weight: 700;
    color: var(--color-text-primary);
    text-align: right;
    font-size: 1.125rem;
}

/* Layout Image Carousel */
.details-image-carousel {
    position: relative;
    border-radius: 24px;
    overflow: visible;
}

.layout-images-container {
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 12px 48px rgba(0, 0, 0, 0.1);
    background: #f8f9fa;
}

.layout-image-wrapper {
    position: relative;
    width: 100%;
}

.layout-image {
    width: 100%;
    height: auto;
    display: block;
    transition: opacity 0.3s ease;
}

.layout-label {
    position: absolute;
    top: 16px;
    left: 16px;
    background: rgba(var(--color-primary-rgb), 0.9);
    color: white;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
}

.layout-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.95);
    border: none;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
    z-index: 10;
}

.layout-nav:hover {
    background: var(--color-primary);
    color: white;
    transform: translateY(-50%) scale(1.1);
}

.layout-prev {
    left: -20px;
}

.layout-next {
    right: -20px;
}

.layout-reverse-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: var(--color-primary);
    color: white;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    font-size: 0.95rem;
    font-weight: 600;
    margin-top: 16px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(var(--color-primary-rgb), 0.2);
}

.layout-reverse-btn:hover {
    background: var(--color-primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(var(--color-primary-rgb), 0.3);
}

.layout-reverse-btn svg {
    width: 20px;
    height: 20px;
}

/* Legacy support */
.details-image {
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 12px 48px rgba(0, 0, 0, 0.1);
}

.details-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* GRUNDRISS SECTION */
.grundriss-section {
    background: var(--color-background);
}

/* Floor Plan Container - Two Column Layout (Desktop/Tablet) */
.floor-plan-container {
    display: grid;
    grid-template-columns: 350px 1fr;
    gap: 32px;
    align-items: start;
}

/* Left Sidebar - Selector Buttons */
.floor-plan-sidebar {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.floor-plan-selector-btn {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px;
    background: #ffffff;
    border: 3px solid transparent;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    text-align: left;
    width: 100%;
}

.floor-plan-selector-btn:hover {
    transform: translateX(4px);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
}

.floor-plan-selector-btn.active {
    border-color: var(--color-primary);
    background: rgba(44, 140, 79, 0.05);
    box-shadow: 0 4px 16px rgba(var(--color-primary-rgb), 0.2);
}

.selector-number {
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--color-primary);
    color: white;
    border-radius: 50%;
    font-weight: 700;
    font-size: 1.125rem;
}

.floor-plan-selector-btn.active .selector-number {
    background: var(--color-primary-dark);
}

.selector-info h4 {
    color: var(--color-primary);
    font-size: 1rem;
    font-weight: 700;
    margin: 0 0 4px 0;
}

.selector-info p {
    color: var(--color-text-secondary);
    font-size: 0.875rem;
    margin: 0;
    line-height: 1.4;
}

/* Right - Floor Plan Viewer */
.floor-plan-viewer {
    background: #ffffff;
    border-radius: 20px;
    padding: 32px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.floor-plan-display {
    display: block;
}

.floor-plan-image-container {
    border-radius: 12px;
    overflow: hidden;
    background: #f8f9fa;
    margin-bottom: 24px;
}

.floor-plan-image {
    width: 100%;
    height: auto;
    display: block;
    transition: opacity 0.3s ease;
}

.floor-plan-controls {
    display: flex;
    justify-content: center;
}

.reverse-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 28px;
    background: #ffffff;
    border: 2px solid var(--color-primary);
    border-radius: 12px;
    color: var(--color-primary);
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.reverse-btn:hover {
    background: var(--color-primary);
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(var(--color-primary-rgb), 0.3);
}

.reverse-icon {
    font-size: 1.25rem;
}

/* Button styles inherited from global style.css */

/* INTERIOR SCHEMES */
.interior-schemes-section {
    background: #ffffff;
}

.scheme-block {
    margin-bottom: 80px;
    padding: 60px;
    background: var(--color-background);
    border-radius: 24px;
}

/* Scheme Header Grid: Text LEFT, Color Palette RIGHT */
.scheme-header-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
    margin-bottom: 50px;
}

.scheme-text h3 {
    font-size: 2.5rem;
    color: var(--color-primary);
    margin-bottom: 16px;
    font-weight: 700;
}

.scheme-desc {
    font-size: 1.125rem;
    color: var(--color-text-secondary);
    line-height: 1.6;
}

.palette-preview {
    border-radius: 0;
    overflow: visible;
    box-shadow: none;
    background: transparent;
}

.palette-preview img {
    width: 100%;
    height: auto;
    display: block;
}

.interior-gallery {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
}

.gallery-item {
    position: relative;
    aspect-ratio: 4 / 3;
    border-radius: 16px;
    overflow: hidden;
    cursor: pointer;
    background: #f8f9fa;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.gallery-item:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.gallery-item:hover img {
    transform: scale(1.1);
}

.gallery-overlay {
    position: absolute;
    inset: 0;
    background: rgba(var(--color-primary-rgb), 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

.gallery-item:hover .gallery-overlay {
    opacity: 1;
}

.zoom-icon {
    font-size: 3rem;
    color: white;
}

/* Lightbox */
.lightbox {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.95);
    z-index: 10000;
    align-items: center;
    justify-content: center;
}

.lightbox-close {
    position: absolute;
    top: 30px;
    right: 40px;
    font-size: 50px;
    color: white;
    background: none;
    border: none;
    cursor: pointer;
    z-index: 10001;
}

.lightbox-content {
    max-width: 90vw;
    max-height: 90vh;
    width: auto;
    height: auto;
    object-fit: contain;
    border-radius: 8px;
}

.lightbox-prev,
.lightbox-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.2);
    border: none;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 2rem;
    color: white;
    z-index: 10001;
}

.lightbox-prev {
    left: 40px;
}

.lightbox-next {
    right: 40px;
}

.lightbox-counter {
    position: absolute;
    bottom: 40px;
    left: 50%;
    transform: translateX(-50%);
    color: white;
    font-size: 1.125rem;
    background: rgba(0, 0, 0, 0.5);
    padding: 8px 24px;
    border-radius: 50px;
}

/* Responsive Design */
@media (max-width: 1023px) {
    .details-grid,
    .scheme-header-grid,
    .interior-gallery {
        grid-template-columns: 1fr;
        gap: 40px;
    }

    .interior-gallery {
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .scheme-text {
        text-align: center;
    }
}

@media (max-width: 767px) {
    .hero-headline {
        font-size: 2.5rem;
    }

    .banner-title {
        font-size: 2rem;
    }

    .section-title {
        font-size: 2rem;
    }

    .interior-gallery {
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .big-color-buttons {
        flex-direction: column;
        gap: 16px;
    }

    .big-color-btn {
        width: 100%;
    }

    .scheme-block {
        padding: 30px;
    }

    /* Mobile: Stack floor plan layout */
    .floor-plan-container {
        grid-template-columns: 1fr;
        gap: 24px;
    }

    .floor-plan-sidebar {
        order: 2;
    }

    .floor-plan-viewer {
        order: 1;
        padding: 20px;
    }

    .floor-plan-selector-btn {
        padding: 12px;
    }

    .selector-number {
        width: 36px;
        height: 36px;
        font-size: 1rem;
    }

    .selector-info h4 {
        font-size: 0.9rem;
    }

    .selector-info p {
        font-size: 0.8rem;
    }
}

@media (max-width: 479px) {
    .hero-headline {
        font-size: 2rem;
    }

    .interior-gallery {
        grid-template-columns: 1fr;
    }

    .lightbox-close {
        top: 15px;
        right: 15px;
        font-size: 35px;
    }

    .lightbox-prev,
    .lightbox-next {
        width: 45px;
        height: 45px;
        font-size: 1.5rem;
    }

    .lightbox-prev {
        left: 10px;
    }

    .lightbox-next {
        right: 10px;
    }
}
</style>

<script>
// Store gallery data with FULL SIZE images for lightbox
window.interiorGallery = <?php echo json_encode(array_map(function($scheme) {
    return array_map(function($img) {
        // Use full size for lightbox quality
        return isset($img['url']) ? $img['url'] : '';
    }, $scheme['gallery'] ?? []);
}, $interior_schemes ?? [])); ?>;

// Store size variant data
window.sizeVariants = <?php echo json_encode(array_map(function($variant) {
    return array(
        'name' => $variant['variant_name'] ?? '',
        'layouts' => array_map(function($layout) {
            return array(
                'normal' => $layout['normal_image']['url'] ?? '',
                'mirrored' => $layout['mirrored_image']['url'] ?? '',
                'name' => $layout['layout_name'] ?? ''
            );
        }, $variant['description_layouts'] ?? [])
    );
}, $size_variants ?? [])); ?>;

window.currentScheme = 0;
window.currentImage = 0;
window.currentVariantIndex = 0;
window.variantStates = {}; // Track layout index and reversed state per variant

// Color selection
function switchExteriorColor(colorIndex) {
    const buttons = document.querySelectorAll('.big-color-btn');
    const images = document.querySelectorAll('.exterior-img');

    buttons.forEach(btn => btn.classList.remove('active'));
    buttons[colorIndex].classList.add('active');

    images.forEach(img => {
        img.classList.toggle('active', img.dataset.colorIndex == colorIndex);
    });
}

// Floor plan gallery selector
const floorPlanStates = {};

function selectFloorPlan(index, blockId) {
    // Update active state on selector buttons
    const buttons = document.querySelectorAll('.floor-plan-selector-btn');
    buttons.forEach((btn, idx) => {
        if (idx === index) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });

    // Show selected floor plan display
    const displays = document.querySelectorAll('.floor-plan-display');
    displays.forEach((display, idx) => {
        display.style.display = idx === index ? 'block' : 'none';
    });

    // Reset mirrored state for new selection
    if (!floorPlanStates[blockId]) {
        floorPlanStates[blockId] = {};
    }
    floorPlanStates[blockId][index] = false;
}

// Floor plan toggle (normal <-> mirrored)
function toggleGrundrissView(blockId, planIndex, normalUrl, mirroredUrl) {
    if (!floorPlanStates[blockId]) {
        floorPlanStates[blockId] = {};
    }

    const img = document.getElementById('grundriss-img-' + blockId + '-' + planIndex);
    const btn = event.target.closest('.grundriss-toggle');

    const currentState = floorPlanStates[blockId][planIndex] || false;
    const newState = !currentState;
    floorPlanStates[blockId][planIndex] = newState;

    img.style.opacity = '0';

    setTimeout(() => {
        img.src = newState ? mirroredUrl : normalUrl;
        img.style.opacity = '1';
        btn.querySelector('.toggle-text').textContent = newState ? 'Normal anzeigen' : 'Gespiegelt anzeigen';
    }, 200);
}

// Toggle floor plan within variant (normal <-> mirrored)
function toggleFloorPlan(blockId, variantIndex, planIndex, normalUrl, mirroredUrl) {
    const stateKey = blockId + '-' + variantIndex + '-' + planIndex;
    if (!floorPlanStates[stateKey]) {
        floorPlanStates[stateKey] = false;
    }

    const img = document.getElementById('floor-plan-' + blockId + '-' + variantIndex + '-' + planIndex);
    const btn = event.target.closest('.floor-plan-toggle');

    const newState = !floorPlanStates[stateKey];
    floorPlanStates[stateKey] = newState;

    img.style.opacity = '0.5';

    setTimeout(() => {
        img.src = newState ? mirroredUrl : normalUrl;
        img.style.opacity = '1';
        if (btn) {
            const textEl = btn.querySelector('.toggle-text');
            if (textEl) {
                textEl.textContent = newState ? 'Normal anzeigen' : 'Gespiegelt anzeigen';
            }
        }
    }, 200);
}

// Size Variant Switching
function switchSizeVariant(variantIndex, blockId) {
    window.currentVariantIndex = variantIndex;

    // Update tab active states
    const tabs = document.querySelectorAll('.size-variant-tab');
    tabs.forEach((tab, idx) => {
        tab.classList.toggle('active', idx === variantIndex);
    });

    // Update content visibility
    const contents = document.querySelectorAll('.size-variant-content');
    contents.forEach((content, idx) => {
        content.style.display = idx === variantIndex ? 'block' : 'none';
    });
}

// Description Layout Navigation (per variant)
function navigateLayout(blockId, variantIndex, direction) {
    const variant = window.sizeVariants[variantIndex];
    if (!variant || !variant.layouts || variant.layouts.length <= 1) return;

    // Initialize state for this variant if needed
    if (!window.variantStates[variantIndex]) {
        window.variantStates[variantIndex] = { layoutIndex: 0, reversed: false };
    }

    const state = window.variantStates[variantIndex];

    // Update index
    state.layoutIndex += direction;
    if (state.layoutIndex < 0) {
        state.layoutIndex = variant.layouts.length - 1;
    } else if (state.layoutIndex >= variant.layouts.length) {
        state.layoutIndex = 0;
    }

    // Hide all layouts for this variant
    const allWrappers = document.querySelectorAll(`[id^="layout-${blockId}-${variantIndex}-"]`);
    allWrappers.forEach(wrapper => wrapper.style.display = 'none');

    // Show current layout
    const currentWrapper = document.getElementById(`layout-${blockId}-${variantIndex}-${state.layoutIndex}`);
    if (currentWrapper) {
        currentWrapper.style.display = 'block';

        // Update image based on reversed state
        const img = currentWrapper.querySelector('.layout-image');
        const layout = variant.layouts[state.layoutIndex];
        img.src = state.reversed ? layout.mirrored : layout.normal;
    }
}

// Toggle Layout Reverse (Normal <-> Mirrored) per variant
function toggleLayoutReverse(blockId, variantIndex) {
    const variant = window.sizeVariants[variantIndex];
    if (!variant || !variant.layouts || variant.layouts.length === 0) return;

    // Initialize state for this variant if needed
    if (!window.variantStates[variantIndex]) {
        window.variantStates[variantIndex] = { layoutIndex: 0, reversed: false };
    }

    const state = window.variantStates[variantIndex];
    state.reversed = !state.reversed;

    // Get current layout wrapper and image
    const currentWrapper = document.getElementById(`layout-${blockId}-${variantIndex}-${state.layoutIndex}`);
    if (!currentWrapper) return;

    const img = currentWrapper.querySelector('.layout-image');
    const btn = event.target.closest('.layout-reverse-btn');
    const layout = variant.layouts[state.layoutIndex];

    // Fade out
    img.style.opacity = '0';

    setTimeout(() => {
        // Switch image
        img.src = state.reversed ? layout.mirrored : layout.normal;

        // Fade in
        img.style.opacity = '1';

        // Update button text
        btn.querySelector('.reverse-text').textContent = state.reversed ? 'Normal anzeigen' : 'Gespiegelt anzeigen';
    }, 300);
}

// Lightbox
function openLightbox(schemeIndex, imageIndex) {
    window.currentScheme = schemeIndex;
    window.currentImage = imageIndex;

    const lightbox = document.getElementById('lightbox-<?php echo esc_js($block_id); ?>');
    const img = document.getElementById('lightbox-img');
    const counter = document.getElementById('lightbox-counter');

    const schemeImages = window.interiorGallery[schemeIndex];
    img.src = schemeImages[imageIndex];
    counter.textContent = `${imageIndex + 1} / ${schemeImages.length}`;

    lightbox.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox-<?php echo esc_js($block_id); ?>').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function navigateLightbox(direction) {
    const schemeImages = window.interiorGallery[window.currentScheme];

    window.currentImage += direction;

    if (window.currentImage < 0) {
        window.currentImage = schemeImages.length - 1;
    } else if (window.currentImage >= schemeImages.length) {
        window.currentImage = 0;
    }

    const img = document.getElementById('lightbox-img');
    const counter = document.getElementById('lightbox-counter');

    img.src = schemeImages[window.currentImage];
    counter.textContent = `${window.currentImage + 1} / ${schemeImages.length}`;
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    const lightbox = document.getElementById('lightbox-<?php echo esc_js($block_id); ?>');
    if (lightbox && lightbox.style.display === 'flex') {
        if (e.key === 'Escape') closeLightbox();
        else if (e.key === 'ArrowLeft') navigateLightbox(-1);
        else if (e.key === 'ArrowRight') navigateLightbox(1);
    }
});
</script>

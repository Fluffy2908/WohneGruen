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
$terrase_section = get_field('mobilhaus_terrase_section');
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
                                    <div class="layout-image-clickable"
                                         onclick="openLayoutLightbox('<?php echo esc_js($block_id); ?>', <?php echo $var_index; ?>, <?php echo $idx; ?>)">
                                        <img class="layout-image"
                                             src="<?php echo esc_url($layout['normal_image']['url']); ?>"
                                             alt="<?php echo esc_attr($layout['layout_name'] ?: 'Layout ' . ($idx + 1)); ?>"
                                             loading="lazy">
                                        <div class="layout-hover-overlay">
                                            <span class="zoom-icon">🔍</span>
                                        </div>
                                    </div>

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

                <!-- PDF Download Button -->
                <?php if (!empty($variant['pdf_download'])):
                    $pdf_button_text = !empty($variant['pdf_button_text']) ? $variant['pdf_button_text'] : 'PDF herunterladen';
                ?>
                <div class="variant-pdf-download">
                    <a href="<?php echo esc_url($variant['pdf_download']['url']); ?>"
                       class="pdf-download-btn"
                       download
                       target="_blank">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <line x1="12" y1="15" x2="12" y2="3"></line>
                        </svg>
                        <p><?php echo esc_html($pdf_button_text); ?></p>
                    </a>
                </div>
                <?php endif; ?>

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
                                <div class="floor-plan-images-wrapper">
                                    <!-- Clickable image container -->
                                    <div class="floor-plan-image-box clickable" onclick="openFloorPlanLightbox('<?php echo esc_js($block_id); ?>', <?php echo $var_index; ?>, <?php echo $plan_index; ?>)">
                                        <img class="floor-plan-image active"
                                             id="floor-plan-<?php echo esc_attr($block_id); ?>-<?php echo $var_index; ?>-<?php echo $plan_index; ?>"
                                             src="<?php echo esc_url($plan['normal_plan']['url']); ?>"
                                             alt="<?php echo esc_attr($plan['title'] ?: 'Grundriss'); ?> - Klicken zum Vergrößern"
                                             loading="lazy">
                                        <div class="floor-plan-hover-overlay">
                                            <span class="zoom-icon">🔍</span>
                                        </div>
                                    </div>
                                    <!-- Toggle button -->
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

    <!-- TERRACE OPTIONS SECTION -->
    <?php if ($terrase_section && isset($terrase_section['enable_terrase']) && $terrase_section['enable_terrase']):
        $terrase_title = !empty($terrase_section['terrase_title']) ? $terrase_section['terrase_title'] : 'Terrassen Optionen';
        $terrase_subtitle = !empty($terrase_section['terrase_subtitle']) ? $terrase_section['terrase_subtitle'] : 'Hochwertige Terrassenoptionen passend zu Ihrem Mobilhaus';
        $anthrazit_sizes = isset($terrase_section['terrase_anthrazit_sizes']) ? $terrase_section['terrase_anthrazit_sizes'] : array();
        $weiss_sizes = isset($terrase_section['terrase_weiss_sizes']) ? $terrase_section['terrase_weiss_sizes'] : array();
    ?>
    <section class="mobilhaus-terrase-section section-padding">
        <div class="container">
            <h2 class="section-title"><?php echo esc_html($terrase_title); ?></h2>
            <p class="section-subtitle"><?php echo esc_html($terrase_subtitle); ?></p>

            <!-- Terrace content will be shown/hidden based on selected house color -->
            <div id="terrase-content-<?php echo esc_attr($block_id); ?>">

                <!-- Anthrazit Terraces -->
                <div class="terrase-color-section" data-terrase-color="anthrazit" style="display: none;">
                    <?php if ($anthrazit_sizes && is_array($anthrazit_sizes) && count($anthrazit_sizes) > 0): ?>

                    <!-- Size Buttons -->
                    <div class="terrase-size-buttons">
                        <?php foreach ($anthrazit_sizes as $size_index => $size): ?>
                            <button class="terrase-size-btn <?php echo $size_index === 0 ? 'active' : ''; ?>"
                                    data-size-index="<?php echo $size_index; ?>"
                                    onclick="switchTerraseSize(<?php echo $size_index; ?>, 'anthrazit', '<?php echo esc_js($block_id); ?>')">
                                <?php echo esc_html($size['size_name']); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>

                    <!-- Size Contents -->
                    <?php foreach ($anthrazit_sizes as $size_index => $size): ?>
                    <div class="terrase-size-content"
                         id="terrase-size-anthrazit-<?php echo $size_index; ?>-<?php echo esc_attr($block_id); ?>"
                         style="<?php echo $size_index === 0 ? '' : 'display: none;'; ?>">

                        <?php if (isset($size['orientations']) && is_array($size['orientations']) && count($size['orientations']) > 0): ?>

                        <!-- Orientation Buttons -->
                        <div class="terrase-orientation-buttons">
                            <?php foreach ($size['orientations'] as $or_index => $orientation): ?>
                                <button class="terrase-orientation-btn <?php echo $or_index === 0 ? 'active' : ''; ?>"
                                        data-orientation-index="<?php echo $or_index; ?>"
                                        onclick="switchTerraseOrientation(<?php echo $size_index; ?>, <?php echo $or_index; ?>, 'anthrazit', '<?php echo esc_js($block_id); ?>')">
                                    <?php echo esc_html($orientation['orientation_name']); ?>
                                </button>
                            <?php endforeach; ?>
                        </div>

                        <!-- Orientation Galleries -->
                        <?php foreach ($size['orientations'] as $or_index => $orientation): ?>
                        <div class="terrase-orientation-content"
                             id="terrase-orientation-anthrazit-<?php echo $size_index; ?>-<?php echo $or_index; ?>-<?php echo esc_attr($block_id); ?>"
                             style="<?php echo $or_index === 0 ? '' : 'display: none;'; ?>">
                            <?php if (isset($orientation['gallery']) && is_array($orientation['gallery'])): ?>
                            <div class="terrase-gallery-grid">
                                <?php foreach ($orientation['gallery'] as $img_index => $image): ?>
                                    <div class="terrase-gallery-item"
                                         onclick="openMobilhausTerraseLightbox(<?php echo $size_index; ?>, <?php echo $or_index; ?>, <?php echo $img_index; ?>, 'anthrazit', '<?php echo esc_js($block_id); ?>')">
                                        <img src="<?php echo esc_url($image['sizes']['medium'] ?? $image['url']); ?>"
                                             alt="<?php echo esc_attr($size['size_name'] . ' - ' . $orientation['orientation_name'] . ' - Bild ' . ($img_index + 1)); ?>"
                                             loading="lazy">
                                        <div class="terrase-gallery-overlay">
                                            <span class="zoom-icon">🔍</span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>

                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>

                    <?php endif; ?>
                </div>

                <!-- Weiß Terraces -->
                <div class="terrase-color-section" data-terrase-color="weiss" style="display: none;">
                    <?php if ($weiss_sizes && is_array($weiss_sizes) && count($weiss_sizes) > 0): ?>

                    <!-- Size Buttons -->
                    <div class="terrase-size-buttons">
                        <?php foreach ($weiss_sizes as $size_index => $size): ?>
                            <button class="terrase-size-btn <?php echo $size_index === 0 ? 'active' : ''; ?>"
                                    data-size-index="<?php echo $size_index; ?>"
                                    onclick="switchTerraseSize(<?php echo $size_index; ?>, 'weiss', '<?php echo esc_js($block_id); ?>')">
                                <?php echo esc_html($size['size_name']); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>

                    <!-- Size Contents -->
                    <?php foreach ($weiss_sizes as $size_index => $size): ?>
                    <div class="terrase-size-content"
                         id="terrase-size-weiss-<?php echo $size_index; ?>-<?php echo esc_attr($block_id); ?>"
                         style="<?php echo $size_index === 0 ? '' : 'display: none;'; ?>">

                        <?php if (isset($size['orientations']) && is_array($size['orientations']) && count($size['orientations']) > 0): ?>

                        <!-- Orientation Buttons -->
                        <div class="terrase-orientation-buttons">
                            <?php foreach ($size['orientations'] as $or_index => $orientation): ?>
                                <button class="terrase-orientation-btn <?php echo $or_index === 0 ? 'active' : ''; ?>"
                                        data-orientation-index="<?php echo $or_index; ?>"
                                        onclick="switchTerraseOrientation(<?php echo $size_index; ?>, <?php echo $or_index; ?>, 'weiss', '<?php echo esc_js($block_id); ?>')">
                                    <?php echo esc_html($orientation['orientation_name']); ?>
                                </button>
                            <?php endforeach; ?>
                        </div>

                        <!-- Orientation Galleries -->
                        <?php foreach ($size['orientations'] as $or_index => $orientation): ?>
                        <div class="terrase-orientation-content"
                             id="terrase-orientation-weiss-<?php echo $size_index; ?>-<?php echo $or_index; ?>-<?php echo esc_attr($block_id); ?>"
                             style="<?php echo $or_index === 0 ? '' : 'display: none;'; ?>">
                            <?php if (isset($orientation['gallery']) && is_array($orientation['gallery'])): ?>
                            <div class="terrase-gallery-grid">
                                <?php foreach ($orientation['gallery'] as $img_index => $image): ?>
                                    <div class="terrase-gallery-item"
                                         onclick="openMobilhausTerraseLightbox(<?php echo $size_index; ?>, <?php echo $or_index; ?>, <?php echo $img_index; ?>, 'weiss', '<?php echo esc_js($block_id); ?>')">
                                        <img src="<?php echo esc_url($image['sizes']['medium'] ?? $image['url']); ?>"
                                             alt="<?php echo esc_attr($size['size_name'] . ' - ' . $orientation['orientation_name'] . ' - Bild ' . ($img_index + 1)); ?>"
                                             loading="lazy">
                                        <div class="terrase-gallery-overlay">
                                            <span class="zoom-icon">🔍</span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>

                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>

                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>

    <!-- Terrace Lightbox -->
    <div id="terrase-lightbox-<?php echo esc_attr($block_id); ?>" class="terrase-lightbox" onclick="closeMobilhausTerraseLightbox('<?php echo esc_js($block_id); ?>')">
        <button class="terrase-lightbox-close" onclick="closeMobilhausTerraseLightbox('<?php echo esc_js($block_id); ?>')">&times;</button>
        <button class="terrase-lightbox-prev" onclick="event.stopPropagation(); navigateMobilhausTerraseLightbox(-1, '<?php echo esc_js($block_id); ?>')">‹</button>
        <img class="terrase-lightbox-content" id="terrase-lightbox-img-<?php echo esc_attr($block_id); ?>" src="" alt="">
        <button class="terrase-lightbox-next" onclick="event.stopPropagation(); navigateMobilhausTerraseLightbox(1, '<?php echo esc_js($block_id); ?>')">›</button>
        <div class="terrase-lightbox-counter" id="terrase-lightbox-counter-<?php echo esc_attr($block_id); ?>"></div>
    </div>
    <?php endif; ?>

    <!-- Floor Plan Lightbox -->
    <div id="floor-plan-lightbox-<?php echo esc_attr($block_id); ?>" class="floor-plan-lightbox" onclick="closeFloorPlanLightbox('<?php echo esc_js($block_id); ?>')">
        <button class="floor-plan-lightbox-close" onclick="closeFloorPlanLightbox('<?php echo esc_js($block_id); ?>')">&times;</button>
        <img class="floor-plan-lightbox-content" id="floor-plan-lightbox-img-<?php echo esc_attr($block_id); ?>" src="" alt="">
        <div class="floor-plan-lightbox-info">
            <div class="floor-plan-lightbox-title" id="floor-plan-lightbox-title-<?php echo esc_attr($block_id); ?>"></div>
            <button class="floor-plan-lightbox-toggle" id="floor-plan-lightbox-toggle-<?php echo esc_attr($block_id); ?>" onclick="event.stopPropagation(); toggleFloorPlanLightboxView('<?php echo esc_js($block_id); ?>')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="1 4 1 10 7 10"></polyline>
                    <polyline points="23 20 23 14 17 14"></polyline>
                    <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path>
                </svg>
                <span class="floor-plan-toggle-text">Gespiegelt anzeigen</span>
            </button>
        </div>
    </div>

    <!-- Layout Lightbox -->
    <div id="layout-lightbox-<?php echo esc_attr($block_id); ?>" class="floor-plan-lightbox" onclick="closeLayoutLightbox('<?php echo esc_js($block_id); ?>')">
        <button class="floor-plan-lightbox-close" onclick="closeLayoutLightbox('<?php echo esc_js($block_id); ?>')">&times;</button>
        <img class="floor-plan-lightbox-content" id="layout-lightbox-img-<?php echo esc_attr($block_id); ?>" src="" alt="">
        <div class="floor-plan-lightbox-info">
            <div class="floor-plan-lightbox-title" id="layout-lightbox-title-<?php echo esc_attr($block_id); ?>"></div>
            <button class="floor-plan-lightbox-toggle" id="layout-lightbox-toggle-<?php echo esc_attr($block_id); ?>" onclick="event.stopPropagation(); toggleLayoutLightboxView('<?php echo esc_js($block_id); ?>')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="1 4 1 10 7 10"></polyline>
                    <polyline points="23 20 23 14 17 14"></polyline>
                    <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path>
                </svg>
                <span class="floor-plan-toggle-text">Gespiegelt anzeigen</span>
            </button>
        </div>
    </div>

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

.floor-plan-images-wrapper {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.floor-plan-image-box {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.floor-plan-image-box.clickable {
    cursor: pointer;
}

.floor-plan-image-box.clickable:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}

.floor-plan-image {
    width: 100%;
    height: auto;
    display: block;
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.floor-plan-image-box.clickable:hover .floor-plan-image {
    transform: scale(1.02);
}

.floor-plan-hover-overlay {
    position: absolute;
    inset: 0;
    background: rgba(var(--color-primary-rgb), 0.85);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

/* Only show hover effect on devices that support hover (desktop) */
@media (hover: hover) {
    .floor-plan-image-box:hover .floor-plan-hover-overlay {
        opacity: 1;
    }
}

.floor-plan-hover-overlay .zoom-icon {
    font-size: 3rem;
    color: white;
}

.floor-plan-toggle {
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

/* Floor Plan Lightbox */
.floor-plan-lightbox {
    display: none;
    position: fixed;
    z-index: 9999;
    inset: 0;
    background: rgba(0, 0, 0, 0.95);
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

.floor-plan-lightbox.active {
    display: flex;
}

.floor-plan-lightbox-content {
    max-width: 90%;
    max-height: 75vh;
    object-fit: contain;
    transition: opacity 0.3s ease;
}

.floor-plan-lightbox-close {
    position: absolute;
    top: 20px;
    right: 40px;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: none;
    font-size: 3rem;
    cursor: pointer;
    padding: 10px 20px;
    transition: background 0.3s ease;
    line-height: 1;
    z-index: 10000;
}

.floor-plan-lightbox-close:hover {
    background: rgba(255, 255, 255, 0.3);
}

.floor-plan-lightbox-info {
    position: absolute;
    bottom: 40px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
    max-width: 90%;
}

.floor-plan-lightbox-title {
    color: white;
    font-size: 1.25rem;
    font-weight: 600;
    background: rgba(0, 0, 0, 0.6);
    padding: 12px 24px;
    border-radius: 8px;
    text-align: center;
}

.floor-plan-lightbox-toggle {
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
    font-size: 1rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(var(--color-primary-rgb), 0.3);
}

.floor-plan-lightbox-toggle:hover {
    background: var(--color-primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(var(--color-primary-rgb), 0.4);
}

.floor-plan-lightbox-toggle svg {
    width: 20px;
    height: 20px;
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

.layout-image-clickable {
    position: relative;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.layout-image-clickable:hover {
    transform: translateY(-4px);
}

.layout-image {
    width: 100%;
    height: auto;
    display: block;
    transition: opacity 0.3s ease;
}

.layout-hover-overlay {
    position: absolute;
    inset: 0;
    background: rgba(var(--color-primary-rgb), 0.85);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

/* Only show hover effect on devices that support hover (desktop) */
@media (hover: hover) {
    .layout-image-clickable:hover .layout-hover-overlay {
        opacity: 1;
    }
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
    padding: 60px 0;
    background: transparent;
    border-radius: 0;
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
    overflow: hidden;
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

/* Only show hover effect on devices that support hover (desktop) */
@media (hover: hover) {
    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }
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
    background: #ffffff;
    border: 2px solid var(--color-primary);
    width: 50px;
    height: 50px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 1.5rem;
    color: var(--color-primary);
    z-index: 10001;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.lightbox-prev:hover,
.lightbox-next:hover,
.lightbox-prev:active,
.lightbox-next:active {
    background: var(--color-primary);
    color: #ffffff;
    transform: translateY(-50%) scale(1.05);
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

/* PDF Download Button */
.variant-pdf-download {
    margin: 40px 0;
    text-align: center;
}

.pdf-download-btn {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 18px 36px;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    color: white;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    font-size: 1.125rem;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 6px 20px rgba(var(--color-primary-rgb), 0.3);
}

.pdf-download-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(var(--color-primary-rgb), 0.4);
}

.pdf-download-btn svg {
    flex-shrink: 0;
}

.pdf-download-btn p {
    margin: 0;
    color: white;
    font-size: 1.125rem;
    font-weight: 700;
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
        font-size: 2rem;
    }

    .banner-title {
        font-size: 2rem;
    }

    .section-title {
        font-size: 2rem;
    }

    /* Interior schemes section - unified grayish background on mobile */
    .interior-schemes-section .section-title {
        background: #f8f9fa;
        padding: 20px 20px 12px 20px;
        border-radius: 12px 12px 0 0;
        margin-left: -20px;
        margin-right: -20px;
        padding-left: 40px;
        padding-right: 40px;
        margin-bottom: 0;
    }

    .interior-schemes-section .section-subtitle {
        background: #f8f9fa;
        padding: 8px 20px 20px 20px;
        border-radius: 0 0 12px 12px;
        margin-left: -20px;
        margin-right: -20px;
        padding-left: 40px;
        padding-right: 40px;
        margin-bottom: 40px;
    }

    /* Adjust scheme color names (h3) - smaller than h2, bigger than p */
    .scheme-text h3 {
        font-size: 1.6rem;
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
        font-size: 1.75rem;
    }

    /* Adjust scheme color names on very small screens */
    .scheme-text h3 {
        font-size: 1.4rem;
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
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
    }

    .lightbox-prev {
        left: 15px;
    }

    .lightbox-next {
        right: 15px;
    }
}

/* TERRACE SECTION */
.mobilhaus-terrase-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

.terrase-size-buttons,
.terrase-orientation-buttons {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-bottom: 30px;
    flex-wrap: wrap;
}

.terrase-size-btn,
.terrase-orientation-btn {
    padding: 12px 24px;
    background: white;
    border: 2px solid #e5e7eb;
    color: var(--color-text-secondary);
    font-weight: 600;
    font-size: 1rem;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.terrase-size-btn:hover,
.terrase-orientation-btn:hover {
    border-color: var(--color-primary);
    color: var(--color-primary);
}

.terrase-size-btn.active,
.terrase-orientation-btn.active {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    border-color: var(--color-primary);
    color: white;
}

.terrase-gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    animation: fadeIn 0.3s ease;
}

.terrase-gallery-item {
    position: relative;
    aspect-ratio: 4 / 3;
    overflow: hidden;
    border-radius: 12px;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.terrase-gallery-item:hover {
    transform: scale(1.02);
}

.terrase-gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.terrase-gallery-overlay {
    position: absolute;
    inset: 0;
    background: rgba(44, 140, 79, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

/* Only show hover effect on devices that support hover (desktop) */
@media (hover: hover) {
    .terrase-gallery-item:hover .terrase-gallery-overlay {
        opacity: 1;
    }
}

.terrase-gallery-overlay .zoom-icon {
    font-size: 3rem;
}

/* Terrace Lightbox */
.terrase-lightbox {
    display: none;
    position: fixed;
    z-index: 9999;
    inset: 0;
    background: rgba(0, 0, 0, 0.95);
    align-items: center;
    justify-content: center;
}

.terrase-lightbox.active {
    display: flex;
}

.terrase-lightbox-content {
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
}

.terrase-lightbox-close {
    position: absolute;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: none;
    font-size: 3rem;
    cursor: pointer;
    padding: 10px 20px;
    transition: background 0.3s ease;
}

.terrase-lightbox-prev,
.terrase-lightbox-next {
    position: absolute;
    background: #ffffff;
    border: 2px solid var(--color-primary);
    color: var(--color-primary);
    width: 50px;
    height: 50px;
    border-radius: 50%;
    font-size: 1.5rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.terrase-lightbox-close:hover {
    background: rgba(255, 255, 255, 0.3);
}

.terrase-lightbox-prev:hover,
.terrase-lightbox-next:hover,
.terrase-lightbox-prev:active,
.terrase-lightbox-next:active {
    background: var(--color-primary);
    color: #ffffff;
    transform: translateY(-50%) scale(1.05);
}

.terrase-lightbox-close {
    top: 20px;
    right: 40px;
}

.terrase-lightbox-prev {
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
}

.terrase-lightbox-next {
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
}

.terrase-lightbox-counter {
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

@media (max-width: 767px) {
    .terrase-gallery-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }

    .terrase-size-buttons,
    .terrase-orientation-buttons {
        gap: 10px;
    }

    .terrase-size-btn,
    .terrase-orientation-btn {
        padding: 10px 20px;
        font-size: 0.95rem;
    }

    .terrase-lightbox-prev,
    .terrase-lightbox-next {
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
    }

    .terrase-lightbox-prev {
        left: 15px;
    }

    .terrase-lightbox-next {
        right: 15px;
    }

    .terrase-lightbox-close {
        font-size: 2.5rem;
        right: 20px;
        top: 10px;
    }

    .floor-plan-lightbox-content {
        max-width: 95%;
        max-height: 70vh;
    }

    .floor-plan-lightbox-close {
        font-size: 2.5rem;
        right: 20px;
        top: 10px;
    }

    .floor-plan-lightbox-info {
        bottom: 20px;
        gap: 12px;
    }

    .floor-plan-lightbox-title {
        font-size: 1rem;
        padding: 10px 20px;
    }

    .floor-plan-lightbox-toggle {
        padding: 10px 20px;
        font-size: 0.9rem;
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

// Floor Plan Lightbox Data
window['floorPlansData_<?php echo esc_js($block_id); ?>'] = <?php echo json_encode(array_map(function($variant) {
    if (empty($variant['floor_plans']) || !is_array($variant['floor_plans'])) {
        return [];
    }
    return array_map(function($plan) {
        return array(
            'title' => $plan['title'] ?? '',
            'description' => $plan['description'] ?? '',
            'normal' => $plan['normal_plan']['url'] ?? '',
            'mirrored' => $plan['mirrored_plan']['url'] ?? ''
        );
    }, $variant['floor_plans']);
}, $size_variants ?? [])); ?>;

window['floorPlanLightboxState_<?php echo esc_js($block_id); ?>'] = {
    variantIndex: 0,
    planIndex: 0,
    isReversed: false
};

// Color selection
function switchExteriorColor(colorIndex) {
    const buttons = document.querySelectorAll('.big-color-btn');
    const images = document.querySelectorAll('.exterior-img');

    buttons.forEach(btn => btn.classList.remove('active'));
    buttons[colorIndex].classList.add('active');

    images.forEach(img => {
        img.classList.toggle('active', img.dataset.colorIndex == colorIndex);
    });

    // Update terrace display to match selected house color
    window['currentColorIndex_<?php echo esc_js($block_id); ?>'] = colorIndex;
    if (typeof window.updateTerraceColorDisplay === 'function') {
        window.updateTerraceColorDisplay('<?php echo esc_js($block_id); ?>');
    }
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

    // Terrace lightbox keyboard navigation
    const terraseLightbox = document.getElementById('terrase-lightbox-<?php echo esc_js($block_id); ?>');
    if (terraseLightbox && terraseLightbox.classList.contains('active')) {
        if (e.key === 'Escape') window.closeMobilhausTerraseLightbox('<?php echo esc_js($block_id); ?>');
        else if (e.key === 'ArrowLeft') window.navigateMobilhausTerraseLightbox(-1, '<?php echo esc_js($block_id); ?>');
        else if (e.key === 'ArrowRight') window.navigateMobilhausTerraseLightbox(1, '<?php echo esc_js($block_id); ?>');
    }

    // Floor Plan lightbox keyboard navigation
    const floorPlanLightbox = document.getElementById('floor-plan-lightbox-<?php echo esc_js($block_id); ?>');
    if (floorPlanLightbox && floorPlanLightbox.classList.contains('active')) {
        if (e.key === 'Escape') closeFloorPlanLightbox('<?php echo esc_js($block_id); ?>');
    }

    // Layout lightbox keyboard navigation
    const layoutLightbox = document.getElementById('layout-lightbox-<?php echo esc_js($block_id); ?>');
    if (layoutLightbox && layoutLightbox.classList.contains('active')) {
        if (e.key === 'Escape') closeLayoutLightbox('<?php echo esc_js($block_id); ?>');
    }
});

// Touch swipe support for mobile
let touchStartX = 0;
let touchEndX = 0;
let touchStartY = 0;
let touchEndY = 0;

function handleSwipe(elementId, leftCallback, rightCallback) {
    const element = document.getElementById(elementId);
    if (!element) return;

    element.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
        touchStartY = e.changedTouches[0].screenY;
    }, { passive: true });

    element.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        touchEndY = e.changedTouches[0].screenY;

        const deltaX = touchEndX - touchStartX;
        const deltaY = touchEndY - touchStartY;

        // Only trigger swipe if horizontal movement is greater than vertical
        if (Math.abs(deltaX) > Math.abs(deltaY)) {
            // Swipe threshold: 50 pixels
            if (deltaX > 50) {
                // Swipe right
                if (rightCallback) rightCallback();
            } else if (deltaX < -50) {
                // Swipe left
                if (leftCallback) leftCallback();
            }
        }
    }, { passive: true });
}

// Add swipe support to interior schemes lightbox
handleSwipe('lightbox-<?php echo esc_js($block_id); ?>',
    function() { navigateLightbox(1); },  // Swipe left = next image
    function() { navigateLightbox(-1); }  // Swipe right = previous image
);

// Add swipe support to terrace lightbox
handleSwipe('terrase-lightbox-<?php echo esc_js($block_id); ?>',
    function() { window.navigateMobilhausTerraseLightbox(1, '<?php echo esc_js($block_id); ?>'); },
    function() { window.navigateMobilhausTerraseLightbox(-1, '<?php echo esc_js($block_id); ?>'); }
);

// ========== FLOOR PLAN LIGHTBOX FUNCTIONS ==========

// Open Floor Plan Lightbox
function openFloorPlanLightbox(blockId, variantIndex, planIndex) {
    const floorPlans = window['floorPlansData_' + blockId];
    if (!floorPlans || !floorPlans[variantIndex] || !floorPlans[variantIndex][planIndex]) {
        return;
    }

    const plan = floorPlans[variantIndex][planIndex];
    const state = window['floorPlanLightboxState_' + blockId];

    // Update state
    state.variantIndex = variantIndex;
    state.planIndex = planIndex;

    // Get current view from the floor plan toggle state
    const stateKey = blockId + '-' + variantIndex + '-' + planIndex;
    state.isReversed = floorPlanStates[stateKey] || false;

    // Update lightbox content
    const lightbox = document.getElementById('floor-plan-lightbox-' + blockId);
    const img = document.getElementById('floor-plan-lightbox-img-' + blockId);
    const title = document.getElementById('floor-plan-lightbox-title-' + blockId);
    const toggleBtn = document.getElementById('floor-plan-lightbox-toggle-' + blockId);

    img.src = state.isReversed ? plan.mirrored : plan.normal;
    title.textContent = plan.title || 'Grundriss';

    if (toggleBtn) {
        const toggleText = toggleBtn.querySelector('.floor-plan-toggle-text');
        if (toggleText) {
            toggleText.textContent = state.isReversed ? 'Normal anzeigen' : 'Gespiegelt anzeigen';
        }
    }

    lightbox.classList.add('active');
    document.body.style.overflow = 'hidden';
}

// Close Floor Plan Lightbox
function closeFloorPlanLightbox(blockId) {
    const lightbox = document.getElementById('floor-plan-lightbox-' + blockId);
    lightbox.classList.remove('active');
    document.body.style.overflow = 'auto';
}

// Toggle Floor Plan Lightbox View (Normal <-> Mirrored)
function toggleFloorPlanLightboxView(blockId) {
    const state = window['floorPlanLightboxState_' + blockId];
    const floorPlans = window['floorPlansData_' + blockId];

    if (!floorPlans || !floorPlans[state.variantIndex] || !floorPlans[state.variantIndex][state.planIndex]) {
        return;
    }

    const plan = floorPlans[state.variantIndex][state.planIndex];
    const img = document.getElementById('floor-plan-lightbox-img-' + blockId);
    const toggleBtn = document.getElementById('floor-plan-lightbox-toggle-' + blockId);

    // Toggle state
    state.isReversed = !state.isReversed;

    // Update floor plan state to sync with main view
    const stateKey = blockId + '-' + state.variantIndex + '-' + state.planIndex;
    floorPlanStates[stateKey] = state.isReversed;

    // Fade out
    img.style.opacity = '0.5';

    setTimeout(function() {
        // Switch image
        img.src = state.isReversed ? plan.mirrored : plan.normal;

        // Fade in
        img.style.opacity = '1';

        // Update button text
        if (toggleBtn) {
            const toggleText = toggleBtn.querySelector('.floor-plan-toggle-text');
            if (toggleText) {
                toggleText.textContent = state.isReversed ? 'Normal anzeigen' : 'Gespiegelt anzeigen';
            }
        }

        // Also update the main floor plan view if visible
        const mainImg = document.getElementById('floor-plan-' + blockId + '-' + state.variantIndex + '-' + state.planIndex);
        if (mainImg) {
            mainImg.src = state.isReversed ? plan.mirrored : plan.normal;
        }
    }, 300);
}

// ========== LAYOUT LIGHTBOX FUNCTIONS ==========

// Store layout lightbox state
window['layoutLightboxState_<?php echo esc_js($block_id); ?>'] = {
    variantIndex: 0,
    layoutIndex: 0,
    isReversed: false
};

// Open Layout Lightbox
function openLayoutLightbox(blockId, variantIndex, layoutIndex) {
    const variant = window.sizeVariants[variantIndex];
    if (!variant || !variant.layouts || !variant.layouts[layoutIndex]) {
        return;
    }

    const layout = variant.layouts[layoutIndex];
    const state = window['layoutLightboxState_' + blockId];

    // Update state
    state.variantIndex = variantIndex;
    state.layoutIndex = layoutIndex;

    // Get current reversed state from variantStates
    if (!window.variantStates[variantIndex]) {
        window.variantStates[variantIndex] = { layoutIndex: 0, reversed: false };
    }
    state.isReversed = window.variantStates[variantIndex].reversed || false;

    // Update lightbox content
    const lightbox = document.getElementById('layout-lightbox-' + blockId);
    const img = document.getElementById('layout-lightbox-img-' + blockId);
    const title = document.getElementById('layout-lightbox-title-' + blockId);
    const toggleBtn = document.getElementById('layout-lightbox-toggle-' + blockId);

    img.src = state.isReversed ? layout.mirrored : layout.normal;
    title.textContent = layout.name || 'Layout ' + (layoutIndex + 1);

    if (toggleBtn) {
        const toggleText = toggleBtn.querySelector('.floor-plan-toggle-text');
        if (toggleText) {
            toggleText.textContent = state.isReversed ? 'Normal anzeigen' : 'Gespiegelt anzeigen';
        }
    }

    lightbox.classList.add('active');
    document.body.style.overflow = 'hidden';
}

// Close Layout Lightbox
function closeLayoutLightbox(blockId) {
    const lightbox = document.getElementById('layout-lightbox-' + blockId);
    lightbox.classList.remove('active');
    document.body.style.overflow = 'auto';
}

// Toggle Layout Lightbox View (Normal <-> Mirrored)
function toggleLayoutLightboxView(blockId) {
    const state = window['layoutLightboxState_' + blockId];
    const variant = window.sizeVariants[state.variantIndex];

    if (!variant || !variant.layouts || !variant.layouts[state.layoutIndex]) {
        return;
    }

    const layout = variant.layouts[state.layoutIndex];
    const img = document.getElementById('layout-lightbox-img-' + blockId);
    const toggleBtn = document.getElementById('layout-lightbox-toggle-' + blockId);

    // Toggle state
    state.isReversed = !state.isReversed;

    // Sync with main view state
    if (!window.variantStates[state.variantIndex]) {
        window.variantStates[state.variantIndex] = { layoutIndex: 0, reversed: false };
    }
    window.variantStates[state.variantIndex].reversed = state.isReversed;

    // Fade out
    img.style.opacity = '0.5';

    setTimeout(function() {
        // Switch image
        img.src = state.isReversed ? layout.mirrored : layout.normal;

        // Fade in
        img.style.opacity = '1';

        // Update button text
        if (toggleBtn) {
            const toggleText = toggleBtn.querySelector('.floor-plan-toggle-text');
            if (toggleText) {
                toggleText.textContent = state.isReversed ? 'Normal anzeigen' : 'Gespiegelt anzeigen';
            }
        }

        // Also update the main layout view if visible
        const mainImg = document.querySelector(`#layout-${blockId}-${state.variantIndex}-${state.layoutIndex} .layout-image`);
        if (mainImg) {
            mainImg.src = state.isReversed ? layout.mirrored : layout.normal;
        }
    }, 300);
}

// ========== TERRACE FUNCTIONS ==========

// Store terrace data
<?php if ($terrase_section && isset($terrase_section['enable_terrase']) && $terrase_section['enable_terrase']): ?>
window['terraseData_anthrazit_<?php echo esc_js($block_id); ?>'] = <?php echo json_encode($anthrazit_sizes ?: []); ?>;
window['terraseData_weiss_<?php echo esc_js($block_id); ?>'] = <?php echo json_encode($weiss_sizes ?: []); ?>;
window['currentTerraseSizeIndex_<?php echo esc_js($block_id); ?>'] = 0;
window['currentTerraseOrientationIndex_<?php echo esc_js($block_id); ?>'] = 0;
window['currentTerraseImageIndex_<?php echo esc_js($block_id); ?>'] = 0;
window['currentTerraseColor_<?php echo esc_js($block_id); ?>'] = '';

// Store color variants for terrace color matching
window['colorVariants_<?php echo esc_js($block_id); ?>'] = <?php echo json_encode($color_variants ?: []); ?>;
window['currentColorIndex_<?php echo esc_js($block_id); ?>'] = 0;
<?php endif; ?>

// Switch terrace size
window.switchTerraseSize = function(sizeIndex, color, blockId) {
    const sizeContents = document.querySelectorAll(`[id^="terrase-size-${color}-"][id$="-${blockId}"]`);
    const sizeBtns = document.querySelectorAll(`[data-terrase-color="${color}"] .terrase-size-btn`);

    sizeBtns.forEach(btn => btn.classList.remove('active'));
    if (sizeBtns[sizeIndex]) {
        sizeBtns[sizeIndex].classList.add('active');
    }

    sizeContents.forEach((content, i) => {
        content.style.display = i === sizeIndex ? 'block' : 'none';
    });

    window['currentTerraseSizeIndex_' + blockId] = sizeIndex;
    window['currentTerraseOrientationIndex_' + blockId] = 0; // Reset orientation
};

// Switch terrace orientation
window.switchTerraseOrientation = function(sizeIndex, orientationIndex, color, blockId) {
    const sizeContent = document.getElementById(`terrase-size-${color}-${sizeIndex}-${blockId}`);
    if (!sizeContent) return;

    const orientationContents = sizeContent.querySelectorAll(`[id^="terrase-orientation-${color}-${sizeIndex}-"]`);
    const orientationBtns = sizeContent.querySelectorAll('.terrase-orientation-btn');

    orientationBtns.forEach(btn => btn.classList.remove('active'));
    if (orientationBtns[orientationIndex]) {
        orientationBtns[orientationIndex].classList.add('active');
    }

    orientationContents.forEach((content, i) => {
        content.style.display = i === orientationIndex ? 'block' : 'none';
    });

    window['currentTerraseOrientationIndex_' + blockId] = orientationIndex;
};

// Open terrace lightbox
window.openMobilhausTerraseLightbox = function(sizeIndex, orientationIndex, imageIndex, color, blockId) {
    const data = window['terraseData_' + color + '_' + blockId];
    if (!data || !data[sizeIndex]) return;

    const size = data[sizeIndex];
    if (!size.orientations || !size.orientations[orientationIndex]) return;

    const orientation = size.orientations[orientationIndex];
    const image = orientation.gallery[imageIndex];

    window['currentTerraseSizeIndex_' + blockId] = sizeIndex;
    window['currentTerraseOrientationIndex_' + blockId] = orientationIndex;
    window['currentTerraseImageIndex_' + blockId] = imageIndex;
    window['currentTerraseColor_' + blockId] = color;

    const img = document.getElementById('terrase-lightbox-img-' + blockId);
    const counter = document.getElementById('terrase-lightbox-counter-' + blockId);
    const lightbox = document.getElementById('terrase-lightbox-' + blockId);

    // Show loading state
    img.style.opacity = '0.3';
    img.classList.add('loading');

    // Preload image before showing
    const preloadImg = new Image();
    preloadImg.onload = function() {
        img.src = image.url;
        img.style.opacity = '1';
        img.classList.remove('loading');
        // Preload adjacent images for faster navigation
        preloadAdjacentTerraceImages(sizeIndex, orientationIndex, imageIndex, color, blockId);
    };
    preloadImg.src = image.url;

    counter.textContent = `${imageIndex + 1} / ${orientation.gallery.length}`;
    lightbox.classList.add('active');
    document.body.style.overflow = 'hidden';
};

// Close terrace lightbox
window.closeMobilhausTerraseLightbox = function(blockId) {
    document.getElementById('terrase-lightbox-' + blockId).classList.remove('active');
    document.body.style.overflow = 'auto';
};

// Navigate terrace lightbox
window.navigateMobilhausTerraseLightbox = function(direction, blockId) {
    const color = window['currentTerraseColor_' + blockId];
    const sizeIndex = window['currentTerraseSizeIndex_' + blockId];
    const orientationIndex = window['currentTerraseOrientationIndex_' + blockId];
    let imageIndex = window['currentTerraseImageIndex_' + blockId];

    const data = window['terraseData_' + color + '_' + blockId];
    const size = data[sizeIndex];
    const orientation = size.orientations[orientationIndex];
    const gallery = orientation.gallery;

    imageIndex += direction;
    if (imageIndex < 0) imageIndex = gallery.length - 1;
    if (imageIndex >= gallery.length) imageIndex = 0;

    window['currentTerraseImageIndex_' + blockId] = imageIndex;

    const img = document.getElementById('terrase-lightbox-img-' + blockId);
    const counter = document.getElementById('terrase-lightbox-counter-' + blockId);

    // Show loading state
    img.style.opacity = '0.3';
    img.classList.add('loading');

    // Preload before showing
    const preloadImg = new Image();
    preloadImg.onload = function() {
        img.src = gallery[imageIndex].url;
        img.style.opacity = '1';
        img.classList.remove('loading');
        // Preload adjacent images for faster navigation
        preloadAdjacentTerraceImages(sizeIndex, orientationIndex, imageIndex, color, blockId);
    };
    preloadImg.src = gallery[imageIndex].url;

    counter.textContent = `${imageIndex + 1} / ${gallery.length}`;
};

// Preload adjacent terrace images for faster navigation
function preloadAdjacentTerraceImages(sizeIndex, orientationIndex, currentIndex, color, blockId) {
    const data = window['terraseData_' + color + '_' + blockId];
    if (!data || !data[sizeIndex]) return;

    const size = data[sizeIndex];
    if (!size.orientations || !size.orientations[orientationIndex]) return;

    const gallery = size.orientations[orientationIndex].gallery;
    if (!gallery) return;

    // Preload next image
    const nextIndex = currentIndex >= gallery.length - 1 ? 0 : currentIndex + 1;
    if (gallery[nextIndex]) {
        const nextImg = new Image();
        nextImg.src = gallery[nextIndex].url;
    }

    // Preload previous image
    const prevIndex = currentIndex <= 0 ? gallery.length - 1 : currentIndex - 1;
    if (gallery[prevIndex]) {
        const prevImg = new Image();
        prevImg.src = gallery[prevIndex].url;
    }
}

// Update terrace display based on selected house color
window.updateTerraceColorDisplay = function(blockId) {
    const currentColorIndex = window['currentColorIndex_' + blockId];
    const colorVariants = window['colorVariants_' + blockId];

    const terraseSections = document.querySelectorAll('#terrase-content-' + blockId + ' .terrase-color-section');

    // If no color variants or invalid index, default to showing anthrazit
    if (!colorVariants || colorVariants.length === 0 || currentColorIndex === undefined || !colorVariants[currentColorIndex]) {
        terraseSections.forEach(section => {
            section.style.display = section.getAttribute('data-terrase-color') === 'anthrazit' ? 'block' : 'none';
        });
        return;
    }

    const currentHouseColor = colorVariants[currentColorIndex].color_name.toLowerCase();

    terraseSections.forEach(section => {
        const terraseColor = section.getAttribute('data-terrase-color');

        let shouldShow = false;

        // Match anthrazit: look for anthrazit, anthracite, grau, gray, dark
        if (terraseColor === 'anthrazit') {
            shouldShow = currentHouseColor.includes('anthrazit') ||
                        currentHouseColor.includes('anthracite') ||
                        currentHouseColor.includes('grau') ||
                        currentHouseColor.includes('gray') ||
                        currentHouseColor.includes('dunkel') ||
                        currentHouseColor.includes('dark') ||
                        currentColorIndex === 0; // Fallback: if it's the first color, assume it's anthrazit
        }

        // Match weiss: look for weiß, weiss, white, hell, light
        if (terraseColor === 'weiss') {
            shouldShow = currentHouseColor.includes('weiß') ||
                        currentHouseColor.includes('weiss') ||
                        currentHouseColor.includes('white') ||
                        currentHouseColor.includes('hell') ||
                        currentHouseColor.includes('light');
        }

        section.style.display = shouldShow ? 'block' : 'none';
    });
};

// Initialize terrace display on page load
<?php if ($terrase_section && isset($terrase_section['enable_terrase']) && $terrase_section['enable_terrase']): ?>
// Initialize on DOM ready and also with timeout as fallback
document.addEventListener('DOMContentLoaded', function() {
    window.updateTerraceColorDisplay('<?php echo esc_js($block_id); ?>');
});

// Fallback timeout
setTimeout(function() {
    window.updateTerraceColorDisplay('<?php echo esc_js($block_id); ?>');
}, 200);
<?php endif; ?>
</script>

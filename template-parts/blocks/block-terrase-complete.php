<?php
/**
 * Block: Complete Terrase Presentation
 * Interactive design with Color → Orientation/Size → Gallery system
 */

// Get all field data
$terrase_type = get_field('terrase_type');
$hero_title = get_field('terrase_hero_title') ?: get_the_title();
$hero_subtitle = get_field('terrase_hero_subtitle');
$hero_image = get_field('terrase_hero_image');
$description_title = get_field('terrase_description_title');
$description_text = get_field('terrase_description_text');
$tech_specs = get_field('terrase_tech_specs');
$tech_description = get_field('terrase_tech_description');
$color_variants = get_field('terrase_color_variants');

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

    <!-- HERO SECTION -->
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

    <!-- DESCRIPTION BANNER -->
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

    <!-- TECHNICAL DATA SECTION -->
    <?php if ($tech_specs || $tech_description): ?>
    <section class="technical-section section-padding">
        <div class="container">
            <h2 class="section-title">Technische Daten</h2>
            <div class="tech-grid">
                <!-- Left: Specifications -->
                <?php if ($tech_specs && is_array($tech_specs)): ?>
                <div class="tech-specs-column">
                    <dl class="specs-list">
                        <?php foreach ($tech_specs as $spec): ?>
                            <div class="spec-row">
                                <dt><?php echo esc_html($spec['label']); ?></dt>
                                <dd><?php echo esc_html($spec['value']); ?></dd>
                            </div>
                        <?php endforeach; ?>
                    </dl>
                </div>
                <?php endif; ?>

                <!-- Right: Description -->
                <?php if ($tech_description): ?>
                <div class="tech-description-column">
                    <div class="tech-description-text">
                        <?php echo wp_kses_post($tech_description); ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- COLOR & GALLERY SECTION -->
    <?php if ($color_variants && is_array($color_variants) && count($color_variants) > 0): ?>
    <section class="terrase-gallery-section section-padding">
        <div class="container">
            <h2 class="section-title">Farbvarianten & Galerie</h2>

            <!-- COLOR BUTTONS -->
            <div class="color-buttons-row">
                <?php foreach ($color_variants as $color_index => $color): ?>
                    <button
                        class="terrase-color-btn <?php echo $color_index === 0 ? 'active' : ''; ?>"
                        data-color-index="<?php echo $color_index; ?>"
                        onclick="switchTerraseColor(<?php echo $color_index; ?>, '<?php echo esc_js($block_id); ?>')">
                        <span class="color-btn-text"><?php echo esc_html($color['color_name']); ?></span>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- COLOR CONTENT AREAS -->
            <?php foreach ($color_variants as $color_index => $color): ?>
            <div class="terrase-color-content"
                 id="color-content-<?php echo esc_attr($block_id); ?>-<?php echo $color_index; ?>"
                 style="<?php echo $color_index === 0 ? '' : 'display: none;'; ?>">

                <?php if ($terrase_type === 'nature'): ?>
                    <!-- NATURE: Direct Orientation Buttons -->
                    <?php
                    $orientations = isset($color['nature_orientations']) ? $color['nature_orientations'] : array();
                    if ($orientations && is_array($orientations) && count($orientations) > 0):
                    ?>
                    <div class="orientation-buttons-row">
                        <?php foreach ($orientations as $or_index => $orientation): ?>
                            <button
                                class="terrase-orientation-btn <?php echo $or_index === 0 ? 'active' : ''; ?>"
                                data-orientation-index="<?php echo $or_index; ?>"
                                onclick="switchOrientation(<?php echo $color_index; ?>, <?php echo $or_index; ?>, '<?php echo esc_js($block_id); ?>')">
                                <?php echo esc_html($orientation['orientation_name']); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>

                    <!-- Orientation Galleries for Nature -->
                    <?php foreach ($orientations as $or_index => $orientation): ?>
                    <div class="orientation-gallery-content"
                         id="orientation-<?php echo esc_attr($block_id); ?>-<?php echo $color_index; ?>-<?php echo $or_index; ?>"
                         style="<?php echo $or_index === 0 ? '' : 'display: none;'; ?>">
                        <?php if (isset($orientation['gallery']) && is_array($orientation['gallery'])): ?>
                        <div class="terrase-gallery-grid">
                            <?php foreach ($orientation['gallery'] as $img_index => $image): ?>
                                <div class="gallery-item"
                                     onclick="openTerraseLight box(<?php echo $color_index; ?>, <?php echo $or_index; ?>, <?php echo $img_index; ?>, '<?php echo esc_js($block_id); ?>')">
                                    <img src="<?php echo esc_url($image['sizes']['medium'] ?? $image['url']); ?>"
                                         alt="<?php echo esc_attr($color['color_name'] . ' - ' . $orientation['orientation_name'] . ' - Bild ' . ($img_index + 1)); ?>"
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
                    <?php endif; ?>

                <?php elseif ($terrase_type === 'pure'): ?>
                    <!-- PURE: Size Buttons → Orientation Buttons -->
                    <?php
                    $sizes = isset($color['pure_sizes']) ? $color['pure_sizes'] : array();
                    if ($sizes && is_array($sizes) && count($sizes) > 0):
                    ?>
                    <div class="size-buttons-row">
                        <?php foreach ($sizes as $size_index => $size): ?>
                            <button
                                class="terrase-size-btn <?php echo $size_index === 0 ? 'active' : ''; ?>"
                                data-size-index="<?php echo $size_index; ?>"
                                onclick="switchSize(<?php echo $color_index; ?>, <?php echo $size_index; ?>, '<?php echo esc_js($block_id); ?>')">
                                <?php echo esc_html($size['size_name']); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>

                    <!-- Size Content Areas -->
                    <?php foreach ($sizes as $size_index => $size): ?>
                    <div class="size-content"
                         id="size-content-<?php echo esc_attr($block_id); ?>-<?php echo $color_index; ?>-<?php echo $size_index; ?>"
                         style="<?php echo $size_index === 0 ? '' : 'display: none;'; ?>">

                        <?php
                        $orientations = isset($size['orientations']) ? $size['orientations'] : array();
                        if ($orientations && is_array($orientations) && count($orientations) > 0):
                        ?>
                        <div class="orientation-buttons-row">
                            <?php foreach ($orientations as $or_index => $orientation): ?>
                                <button
                                    class="terrase-orientation-btn <?php echo $or_index === 0 ? 'active' : ''; ?>"
                                    data-orientation-index="<?php echo $or_index; ?>"
                                    onclick="switchPureOrientation(<?php echo $color_index; ?>, <?php echo $size_index; ?>, <?php echo $or_index; ?>, '<?php echo esc_js($block_id); ?>')">
                                    <?php echo esc_html($orientation['orientation_name']); ?>
                                </button>
                            <?php endforeach; ?>
                        </div>

                        <!-- Orientation Galleries for Pure -->
                        <?php foreach ($orientations as $or_index => $orientation): ?>
                        <div class="orientation-gallery-content"
                             id="pure-orientation-<?php echo esc_attr($block_id); ?>-<?php echo $color_index; ?>-<?php echo $size_index; ?>-<?php echo $or_index; ?>"
                             style="<?php echo $or_index === 0 ? '' : 'display: none;'; ?>">
                            <?php if (isset($orientation['gallery']) && is_array($orientation['gallery'])): ?>
                            <div class="terrase-gallery-grid">
                                <?php foreach ($orientation['gallery'] as $img_index => $image): ?>
                                    <div class="gallery-item"
                                         onclick="openPureLightbox(<?php echo $color_index; ?>, <?php echo $size_index; ?>, <?php echo $or_index; ?>, <?php echo $img_index; ?>, '<?php echo esc_js($block_id); ?>')">
                                        <img src="<?php echo esc_url($image['sizes']['medium'] ?? $image['url']); ?>"
                                             alt="<?php echo esc_attr($color['color_name'] . ' - ' . $size['size_name'] . ' - ' . $orientation['orientation_name'] . ' - Bild ' . ($img_index + 1)); ?>"
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
                        <?php endif; ?>

                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>

                <?php endif; ?>

            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Lightbox -->
    <div id="lightbox-<?php echo esc_attr($block_id); ?>" class="lightbox" onclick="closeTerraseLightbox('<?php echo esc_js($block_id); ?>')">
        <button class="lightbox-close" onclick="closeTerraseLightbox('<?php echo esc_js($block_id); ?>')">&times;</button>
        <button class="lightbox-prev" onclick="event.stopPropagation(); navigateTerraseLightbox(-1, '<?php echo esc_js($block_id); ?>')">‹</button>
        <img class="lightbox-content" id="lightbox-img-<?php echo esc_attr($block_id); ?>" src="" alt="">
        <button class="lightbox-next" onclick="event.stopPropagation(); navigateTerraseLightbox(1, '<?php echo esc_js($block_id); ?>')">›</button>
        <div class="lightbox-counter" id="lightbox-counter-<?php echo esc_attr($block_id); ?>"></div>
    </div>
    <?php endif; ?>

</article>

<style>
/* TERRASE COMPLETE PAGE */
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
    margin-bottom: 40px;
    text-align: center;
    font-weight: 700;
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

/* Technical Section */
.technical-section {
    background: #ffffff;
}

.tech-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    max-width: 1200px;
    margin: 0 auto;
}

@media (max-width: 991px) {
    .tech-grid {
        grid-template-columns: 1fr;
        gap: 40px;
    }
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

.tech-description-column {
    display: flex;
    align-items: center;
}

.tech-description-text {
    font-size: 1.125rem;
    line-height: 1.8;
    color: var(--color-text-secondary);
}

.tech-description-text p {
    margin-bottom: 16px;
}

/* Gallery Section */
.terrase-gallery-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

/* Color Buttons */
.color-buttons-row {
    display: flex;
    justify-content: center;
    gap: 16px;
    margin-bottom: 40px;
    flex-wrap: wrap;
}

.terrase-color-btn {
    padding: 14px 32px;
    background: white;
    border: 3px solid var(--color-background);
    color: var(--color-text-primary);
    font-weight: 700;
    font-size: 1.125rem;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.terrase-color-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
}

.terrase-color-btn.active {
    background: var(--color-primary);
    border-color: var(--color-primary);
    color: white;
}

/* Size Buttons (Pure) */
.size-buttons-row {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-bottom: 30px;
    flex-wrap: wrap;
}

.terrase-size-btn {
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

.terrase-size-btn:hover {
    border-color: var(--color-primary);
}

.terrase-size-btn.active {
    background: var(--color-primary);
    border-color: var(--color-primary);
    color: white;
}

/* Orientation Buttons */
.orientation-buttons-row {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-bottom: 40px;
    flex-wrap: wrap;
}

.terrase-orientation-btn {
    padding: 12px 28px;
    background: white;
    border: 2px solid #e5e7eb;
    color: var(--color-text-secondary);
    font-weight: 600;
    font-size: 1rem;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.terrase-orientation-btn:hover {
    border-color: var(--color-primary);
    color: var(--color-primary);
}

.terrase-orientation-btn.active {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    border-color: var(--color-primary);
    color: white;
}

/* Gallery Grid */
.terrase-gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
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

/* Responsive */
@media (max-width: 767px) {
    .section-title {
        font-size: 2rem;
    }

    .banner-title {
        font-size: 1.75rem;
    }

    .terrase-gallery-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }

    .color-buttons-row,
    .size-buttons-row,
    .orientation-buttons-row {
        gap: 10px;
    }

    .terrase-color-btn {
        padding: 12px 24px;
        font-size: 1rem;
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
}
</style>

<script>
// Global data storage
let terraseData_<?php echo esc_js($block_id); ?> = <?php echo json_encode($color_variants ?: []); ?>;
let terraseType_<?php echo esc_js($block_id); ?> = '<?php echo esc_js($terrase_type); ?>';
let currentColorIndex_<?php echo esc_js($block_id); ?> = 0;
let currentSizeIndex_<?php echo esc_js($block_id); ?> = 0;
let currentOrientationIndex_<?php echo esc_js($block_id); ?> = 0;
let currentImageIndex_<?php echo esc_js($block_id); ?> = 0;

// Switch Color
function switchTerraseColor(colorIndex, blockId) {
    const colorContents = document.querySelectorAll(`[id^="color-content-${blockId}-"]`);
    const colorBtns = document.querySelectorAll(`[data-color-index]`);

    colorContents.forEach((content, i) => {
        content.style.display = i === colorIndex ? 'block' : 'none';
    });

    colorBtns.forEach((btn, i) => {
        if (i === colorIndex) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });

    window['currentColorIndex_' + blockId] = colorIndex;
}

// Switch Orientation (Nature)
function switchOrientation(colorIndex, orientationIndex, blockId) {
    const orientationContents = document.querySelectorAll(`[id^="orientation-${blockId}-${colorIndex}-"]`);
    const orientationBtns = document.querySelectorAll(`#color-content-${blockId}-${colorIndex} .terrase-orientation-btn`);

    orientationContents.forEach((content, i) => {
        content.style.display = i === orientationIndex ? 'block' : 'none';
    });

    orientationBtns.forEach((btn, i) => {
        if (i === orientationIndex) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });

    window['currentOrientationIndex_' + blockId] = orientationIndex;
}

// Switch Size (Pure)
function switchSize(colorIndex, sizeIndex, blockId) {
    const sizeContents = document.querySelectorAll(`[id^="size-content-${blockId}-${colorIndex}-"]`);
    const sizeBtns = document.querySelectorAll(`#color-content-${blockId}-${colorIndex} .terrase-size-btn`);

    sizeContents.forEach((content, i) => {
        content.style.display = i === sizeIndex ? 'block' : 'none';
    });

    sizeBtns.forEach((btn, i) => {
        if (i === sizeIndex) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });

    window['currentSizeIndex_' + blockId] = sizeIndex;
}

// Switch Orientation (Pure)
function switchPureOrientation(colorIndex, sizeIndex, orientationIndex, blockId) {
    const orientationContents = document.querySelectorAll(`[id^="pure-orientation-${blockId}-${colorIndex}-${sizeIndex}-"]`);
    const orientationBtns = document.querySelectorAll(`#size-content-${blockId}-${colorIndex}-${sizeIndex} .terrase-orientation-btn`);

    orientationContents.forEach((content, i) => {
        content.style.display = i === orientationIndex ? 'block' : 'none';
    });

    orientationBtns.forEach((btn, i) => {
        if (i === orientationIndex) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });

    window['currentOrientationIndex_' + blockId] = orientationIndex;
}

// Open Lightbox (Nature)
function openTerraseLightbox(colorIndex, orientationIndex, imageIndex, blockId) {
    const data = window['terraseData_' + blockId];
    const color = data[colorIndex];
    const orientation = color.nature_orientations[orientationIndex];
    const image = orientation.gallery[imageIndex];

    window['currentColorIndex_' + blockId] = colorIndex;
    window['currentOrientationIndex_' + blockId] = orientationIndex;
    window['currentImageIndex_' + blockId] = imageIndex;

    document.getElementById('lightbox-img-' + blockId).src = image.url;
    document.getElementById('lightbox-counter-' + blockId).textContent = `${imageIndex + 1} / ${orientation.gallery.length}`;
    document.getElementById('lightbox-' + blockId).classList.add('active');
}

// Open Lightbox (Pure)
function openPureLightbox(colorIndex, sizeIndex, orientationIndex, imageIndex, blockId) {
    const data = window['terraseData_' + blockId];
    const color = data[colorIndex];
    const size = color.pure_sizes[sizeIndex];
    const orientation = size.orientations[orientationIndex];
    const image = orientation.gallery[imageIndex];

    window['currentColorIndex_' + blockId] = colorIndex;
    window['currentSizeIndex_' + blockId] = sizeIndex;
    window['currentOrientationIndex_' + blockId] = orientationIndex;
    window['currentImageIndex_' + blockId] = imageIndex;

    document.getElementById('lightbox-img-' + blockId).src = image.url;
    document.getElementById('lightbox-counter-' + blockId).textContent = `${imageIndex + 1} / ${orientation.gallery.length}`;
    document.getElementById('lightbox-' + blockId).classList.add('active');
}

// Close Lightbox
function closeTerraseLightbox(blockId) {
    document.getElementById('lightbox-' + blockId).classList.remove('active');
}

// Navigate Lightbox
function navigateTerraseLightbox(direction, blockId) {
    const data = window['terraseData_' + blockId];
    const terraseType = window['terraseType_' + blockId];
    const colorIndex = window['currentColorIndex_' + blockId];
    const orientationIndex = window['currentOrientationIndex_' + blockId];
    const sizeIndex = window['currentSizeIndex_' + blockId];
    let imageIndex = window['currentImageIndex_' + blockId];

    let gallery;
    if (terraseType === 'nature') {
        const color = data[colorIndex];
        const orientation = color.nature_orientations[orientationIndex];
        gallery = orientation.gallery;
    } else {
        const color = data[colorIndex];
        const size = color.pure_sizes[sizeIndex];
        const orientation = size.orientations[orientationIndex];
        gallery = orientation.gallery;
    }

    imageIndex += direction;
    if (imageIndex < 0) imageIndex = gallery.length - 1;
    if (imageIndex >= gallery.length) imageIndex = 0;

    window['currentImageIndex_' + blockId] = imageIndex;

    document.getElementById('lightbox-img-' + blockId).src = gallery[imageIndex].url;
    document.getElementById('lightbox-counter-' + blockId).textContent = `${imageIndex + 1} / ${gallery.length}`;
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    const lightbox = document.getElementById('lightbox-<?php echo esc_js($block_id); ?>');
    if (lightbox && lightbox.classList.contains('active')) {
        if (e.key === 'Escape') closeTerraseLightbox('<?php echo esc_js($block_id); ?>');
        if (e.key === 'ArrowLeft') navigateTerraseLightbox(-1, '<?php echo esc_js($block_id); ?>');
        if (e.key === 'ArrowRight') navigateTerraseLightbox(1, '<?php echo esc_js($block_id); ?>');
    }
});
</script>

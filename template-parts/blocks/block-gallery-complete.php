<?php
/**
 * Block: Gallery Complete (All-in-One for Galerie page)
 * Hero + Toggle Buttons (Bilder / 3D Grundrisse) + Gallery Grid + Slider + 3D Floor Plans
 */
$hero_title = get_field('gallery_hero_title');
$hero_image = get_field('gallery_hero_image');
$show_filters = get_field('gallery_show_filters');
$categories = get_field('gallery_categories');
$block_id = 'gallery-' . $block['id'];
?>

<div class="gallery-complete-page" id="<?php echo esc_attr($block_id); ?>">

    <!-- Hero Section with Background Image -->
    <section class="gallery-hero" style="<?php if ($hero_image): ?>background-image: url('<?php echo esc_url($hero_image['url']); ?>');<?php endif; ?>">
        <div class="container">
            <div class="hero-content">
                <?php if ($hero_title): ?>
                    <h1><?php echo esc_html($hero_title); ?></h1>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- GALLERY SECTION -->
    <?php if ($categories && is_array($categories)): ?>
    <section class="gallery-section section-padding">
        <div class="container">

            <!-- Filter Buttons (Simple Text Only) -->
            <?php if ($show_filters && count($categories) > 1): ?>
            <div class="gallery-filters">
                <button class="filter-btn active" data-filter="all">
                    <span class="filter-label">Alle</span>
                </button>
                <?php foreach ($categories as $index => $category): ?>
                    <button class="filter-btn" data-filter="cat-<?php echo $index; ?>">
                        <span class="filter-label"><?php echo esc_html($category['category_name']); ?></span>
                    </button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Gallery Grid (ALL categorized images) -->
            <div class="gallery-grid">
                <?php
                $all_images = [];
                foreach ($categories as $cat_index => $category):
                    if (isset($category['images']) && is_array($category['images'])):
                        foreach ($category['images'] as $image):
                            $all_images[] = [
                                'image' => $image,
                                'category' => 'cat-' . $cat_index,
                                'category_name' => $category['category_name']
                            ];
                        endforeach;
                    endif;
                endforeach;

                // Show ALL images in grid (filterable by category)
                foreach ($all_images as $img_index => $item):
                    $image = $item['image'];
                ?>
                    <div class="gallery-item" data-category="<?php echo esc_attr($item['category']); ?>" data-image-index="<?php echo $img_index; ?>">
                        <img src="<?php echo esc_url($image['sizes']['large'] ?? $image['url']); ?>"
                             alt="<?php echo esc_attr($image['alt'] ?: $item['category_name']); ?>"
                             loading="lazy">
                        <div class="gallery-overlay">
                            <span class="zoom-icon">🔍</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Slider for Additional Uncategorized Images -->
            <?php
            $slider_images = get_field('gallery_slider_images');
            if (!empty($slider_images)):
            ?>
            <div class="gallery-slider-section" id="gallery-slider-section">
                <h3 class="slider-title">Weitere Bilder</h3>
                <div class="gallery-slider-wrapper">
                    <button class="slider-nav slider-prev" aria-label="Vorherige Bilder">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                    </button>

                    <div class="slider-track-container">
                        <div class="slider-track">
                            <?php
                            $base_index = count($all_images);
                            foreach ($slider_images as $slider_index => $image):
                                $global_index = $base_index + $slider_index;
                            ?>
                                <div class="slider-item" data-image-index="<?php echo $global_index; ?>">
                                    <img src="<?php echo esc_url($image['sizes']['medium'] ?? $image['url']); ?>"
                                         alt="<?php echo esc_attr($image['alt']); ?>"
                                         loading="lazy">
                                    <div class="gallery-overlay">
                                        <span class="zoom-icon">🔍</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <button class="slider-nav slider-next" aria-label="Nächste Bilder">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </button>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </section>
    <?php endif; ?>

    <!-- Lightbox (Full Screen Slider) -->
    <div id="gallery-lightbox" class="lightbox">
        <button class="lightbox-close">&times;</button>
        <button class="lightbox-prev">‹</button>
        <img class="lightbox-content" id="gallery-lightbox-img" src="" alt="">
        <button class="lightbox-next">›</button>
        <div class="lightbox-counter" id="gallery-lightbox-counter"></div>
    </div>

</div>

<style>
/* GALLERY COMPLETE - PROFESSIONAL TOGGLE DESIGN */
.gallery-complete-page {
    width: 100%;
    margin: 0;
    padding: 0;
    margin-block-start: 0;
    margin-block-end: 0;
    padding-block-start: 0;
    padding-block-end: 0;
}

.gallery-hero {
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

.text-center {
    text-align: center;
}

/* Hero with Background Image */
.gallery-hero {
    position: relative;
    min-height: var(--hero-min-height);
    display: flex;
    align-items: center;
    background-size: cover;
    background-position: center;
    background-color: var(--color-primary);
}

.gallery-hero::before {
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
    margin: 0;
    font-weight: 800;
    color: var(--color-white);
}

@media (max-width: 767px) {
    .hero-content h1 {
        font-size: var(--hero-title-size-mobile);
    }
}

/* BILDER SECTION - Gallery Filters (Simple Text, No Icons) */
.bilder-section {
    background: #ffffff;
    padding: 60px 0;
}

.gallery-filters {
    display: flex;
    gap: 16px;
    justify-content: center;
    margin-bottom: 60px;
    flex-wrap: wrap;
}

.filter-btn {
    display: inline-flex;
    align-items: center;
    padding: 14px 32px;
    background: #ffffff;
    border: 2px solid #e5e7eb;
    border-radius: 50px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1rem;
    font-weight: 600;
    color: var(--color-text-primary);
}

.filter-btn:hover {
    border-color: var(--color-primary);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.filter-btn.active {
    background: var(--color-primary);
    border-color: var(--color-primary);
    color: white;
}

/* Gallery Grid - First 9 Images */
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    margin-bottom: 80px;
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

/* Gallery Slider Section */
.gallery-slider-section {
    margin-top: 60px;
}

.slider-title {
    font-size: 1.75rem;
    color: var(--color-primary);
    margin-bottom: 30px;
    text-align: center;
    font-weight: 700;
}

.gallery-slider-wrapper {
    position: relative;
    padding: 0 60px;
}

.slider-track-container {
    overflow: hidden;
    border-radius: 12px;
}

.slider-track {
    display: flex;
    gap: 20px;
    transition: transform 0.4s ease;
    overflow-x: auto;
    scroll-behavior: smooth;
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.slider-track::-webkit-scrollbar {
    display: none;
}

.slider-item {
    flex: 0 0 calc(33.333% - 14px);
    aspect-ratio: 4 / 3;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    background: #f8f9fa;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    position: relative;
}

.slider-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.slider-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Only show hover effect on devices that support hover (desktop) */
@media (hover: hover) {
    .slider-item:hover .gallery-overlay {
        opacity: 1;
    }
}

.slider-nav {
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
    color: var(--color-primary);
}

.slider-nav:hover {
    background: var(--color-primary);
    color: white;
    transform: translateY(-50%) scale(1.1);
}

.slider-prev {
    left: 0;
}

.slider-next {
    right: 0;
}

/* 3D GRUNDRISSE SECTION */
.threed-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

.threed-intro {
    max-width: 900px;
    margin: 0 auto 60px auto;
}

.threed-intro h2 {
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

.floorplans-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 40px;
}

.floorplan-card {
    background: #ffffff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

.floorplan-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
}

.card-header {
    padding: 24px;
    background: var(--color-background);
    border-bottom: 3px solid var(--color-primary);
}

.card-header h3 {
    font-size: 1.5rem;
    color: var(--color-primary);
    margin: 0 0 8px 0;
    font-weight: 700;
}

.card-description {
    font-size: 0.95rem;
    color: var(--color-text-secondary);
    margin: 0;
    line-height: 1.5;
}

.card-content-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    padding: 24px;
}

.tech-data h4 {
    font-size: 1.125rem;
    color: var(--color-primary);
    margin: 0 0 16px 0;
    font-weight: 600;
}

.specs-list {
    display: grid;
    gap: 12px;
}

.spec-row {
    display: flex;
    justify-content: space-between;
    padding: 10px;
    background: var(--color-background);
    border-radius: 8px;
    border-left: 3px solid var(--color-primary);
}

.spec-row dt {
    font-weight: 600;
    color: var(--color-text-secondary);
    font-size: 0.9rem;
}

.spec-row dd {
    font-weight: 700;
    color: var(--color-text-primary);
    font-size: 0.9rem;
}

.plan-preview {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.plan-preview img {
    width: 100%;
    height: auto;
    border-radius: 12px;
    background: var(--color-background);
    transition: opacity 0.3s ease;
}

.toggle-mirror-btn {
    padding: 10px 16px;
    background: transparent;
    border: 2px solid var(--color-primary);
    border-radius: 8px;
    color: var(--color-primary);
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.toggle-mirror-btn:hover {
    background: var(--color-primary);
    color: white;
    transform: translateY(-2px);
}

/* Lightbox (Full Screen Slider) - Clean Design Like Interior Schemes */
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
    transition: color 0.3s ease;
}

.lightbox-close:hover {
    color: #bbb;
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
    bottom: 100px;
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
    transform: scale(1.05);
}

.lightbox-prev {
    left: 50%;
    transform: translateX(-70px);
}

.lightbox-next {
    left: 50%;
    transform: translateX(20px);
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
@media (max-width: 1200px) {
    .floorplans-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 32px;
    }
}

@media (max-width: 1023px) {
    .gallery-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .slider-item {
        flex: 0 0 calc(50% - 10px);
    }

    .gallery-slider-wrapper {
        padding: 0 50px;
    }

    .slider-nav {
        width: 40px;
        height: 40px;
    }

    .lightbox-prev,
    .lightbox-next {
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
    }

    .lightbox-prev {
        left: 20px;
    }

    .lightbox-next {
        right: 20px;
    }
}

@media (max-width: 767px) {
    .hero-content h1 {
        font-size: 1.25rem;
    }

    .big-toggle-buttons {
        flex-direction: column;
        gap: 16px;
    }

    .big-toggle-btn {
        width: 100%;
        padding: 20px;
    }

    /* Mobile Lightbox */
    .lightbox-content {
        max-width: 95vw;
        max-height: 85vh;
    }

    .lightbox-close {
        top: 10px;
        right: 15px;
        font-size: 40px;
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

    .lightbox-counter {
        font-size: 1rem;
        bottom: 20px;
        padding: 6px 18px;
    }

    .toggle-btn-text {
        font-size: 1.5rem;
    }

    .gallery-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }

    .floorplans-grid {
        grid-template-columns: 1fr;
        gap: 24px;
    }

    .card-content-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }

    .card-header h3 {
        font-size: 1.25rem;
    }

    .threed-intro h2 {
        font-size: 2rem;
    }

    .slider-item {
        flex: 0 0 calc(100% - 10px);
    }

    .gallery-slider-wrapper {
        padding: 0 45px;
    }

    .slider-nav {
        width: 36px;
        height: 36px;
    }

    .slider-nav svg {
        width: 18px;
        height: 18px;
    }

    .slider-title {
        font-size: 1.5rem;
    }
}
</style>

<script>
// Store all images for lightbox - categorized images + slider images
window.galleryImages = [
    <?php
    // Add all categorized images
    foreach ($all_images as $item) {
        echo '"' . esc_js($item['image']['url']) . '",';
    }
    // Add slider images
    if (!empty($slider_images)) {
        foreach ($slider_images as $image) {
            echo '"' . esc_js($image['url']) . '",';
        }
    }
    ?>
];

window.currentImage = 0;
window.sliderPosition = 0;

// DOMContentLoaded - Initialize all event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterBtns = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');
    const sliderItems = document.querySelectorAll('.slider-item');
    const sliderSection = document.getElementById('gallery-slider-section');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.dataset.filter;

            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            // Filter gallery grid items (categorized images)
            galleryItems.forEach(item => {
                if (filter === 'all' || item.dataset.category === filter) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });

            // Slider items are always visible (they're uncategorized)
            // No filtering needed for slider items

            // Reset slider position
            window.sliderPosition = 0;
            const track = document.querySelector('.slider-track');
            if (track) {
                track.scrollLeft = 0;
            }
        });
    });

    // Attach lightbox click handlers to gallery items
    galleryItems.forEach(item => {
        item.addEventListener('click', function() {
            const imageIndex = parseInt(this.dataset.imageIndex);
            openLightbox(imageIndex);
        });
    });

    // Attach lightbox click handlers to slider items
    sliderItems.forEach(item => {
        item.addEventListener('click', function() {
            const imageIndex = parseInt(this.dataset.imageIndex);
            openLightbox(imageIndex);
        });
    });

    // Attach slider navigation handlers
    const sliderPrevBtn = document.querySelector('.slider-prev');
    const sliderNextBtn = document.querySelector('.slider-next');

    if (sliderPrevBtn) {
        sliderPrevBtn.addEventListener('click', function() {
            moveGallerySlider(-1);
        });
    }

    if (sliderNextBtn) {
        sliderNextBtn.addEventListener('click', function() {
            moveGallerySlider(1);
        });
    }

    // Attach lightbox button handlers
    const lightbox = document.getElementById('gallery-lightbox');
    const lightboxClose = lightbox.querySelector('.lightbox-close');
    const lightboxPrev = lightbox.querySelector('.lightbox-prev');
    const lightboxNext = lightbox.querySelector('.lightbox-next');

    if (lightbox) {
        lightbox.addEventListener('click', closeLightbox);
    }

    if (lightboxClose) {
        lightboxClose.addEventListener('click', closeLightbox);
    }

    if (lightboxPrev) {
        lightboxPrev.addEventListener('click', function(e) {
            e.stopPropagation();
            navigateLightbox(-1);
        });
    }

    if (lightboxNext) {
        lightboxNext.addEventListener('click', function(e) {
            e.stopPropagation();
            navigateLightbox(1);
        });
    }
});

// Slider navigation
function moveGallerySlider(direction) {
    const track = document.querySelector('.slider-track');
    if (!track) return;

    const visibleItems = Array.from(document.querySelectorAll('.slider-item')).filter(item => item.style.display !== 'none');
    if (visibleItems.length === 0) return;

    const itemWidth = visibleItems[0].offsetWidth + 20;
    const containerWidth = track.parentElement.offsetWidth;
    const scrollAmount = Math.floor(containerWidth / itemWidth) * itemWidth;

    window.sliderPosition += direction * scrollAmount;

    const maxScroll = track.scrollWidth - track.offsetWidth;
    window.sliderPosition = Math.max(0, Math.min(window.sliderPosition, maxScroll));

    track.scrollTo({
        left: window.sliderPosition,
        behavior: 'smooth'
    });
}

// Lightbox functions
function openLightbox(imageIndex) {
    window.currentImage = imageIndex;

    const lightbox = document.getElementById('gallery-lightbox');
    const img = document.getElementById('gallery-lightbox-img');
    const counter = document.getElementById('gallery-lightbox-counter');

    img.src = window.galleryImages[imageIndex];
    counter.textContent = `${imageIndex + 1} / ${window.galleryImages.length}`;

    lightbox.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('gallery-lightbox').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function navigateLightbox(direction) {
    window.currentImage += direction;

    if (window.currentImage < 0) {
        window.currentImage = window.galleryImages.length - 1;
    } else if (window.currentImage >= window.galleryImages.length) {
        window.currentImage = 0;
    }

    const img = document.getElementById('gallery-lightbox-img');
    const counter = document.getElementById('gallery-lightbox-counter');

    img.src = window.galleryImages[window.currentImage];
    counter.textContent = `${window.currentImage + 1} / ${window.galleryImages.length}`;
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    const lightbox = document.getElementById('gallery-lightbox');
    if (lightbox && lightbox.style.display === 'flex') {
        if (e.key === 'Escape') closeLightbox();
        else if (e.key === 'ArrowLeft') navigateLightbox(-1);
        else if (e.key === 'ArrowRight') navigateLightbox(1);
    }
});

// Touch swipe support for mobile
(function() {
    let touchStartX = 0;
    let touchEndX = 0;
    let touchStartY = 0;
    let touchEndY = 0;

    const lightbox = document.getElementById('gallery-lightbox');
    if (!lightbox) return;

    lightbox.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
        touchStartY = e.changedTouches[0].screenY;
    }, { passive: true });

    lightbox.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        touchEndY = e.changedTouches[0].screenY;

        const deltaX = touchEndX - touchStartX;
        const deltaY = touchEndY - touchStartY;

        // Only trigger swipe if horizontal movement is greater than vertical
        if (Math.abs(deltaX) > Math.abs(deltaY)) {
            // Swipe threshold: 50 pixels
            if (deltaX > 50) {
                // Swipe right = previous image
                navigateLightbox(-1);
            } else if (deltaX < -50) {
                // Swipe left = next image
                navigateLightbox(1);
            }
        }
    }, { passive: true });
})();
</script>

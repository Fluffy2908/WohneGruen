<?php
/**
 * ACF Pro Blocks Registration for Gutenberg
 *
 * This file registers all ACF all-in-one blocks with LIVE PREVIEW.
 * Each block is designed for a specific page type.
 */

if (!defined('ABSPATH')) exit;

/**
 * Register ACF Blocks (All-in-One with Live Preview)
 */
function wohnegruen_register_acf_blocks() {
    // Check if ACF function exists
    if (!function_exists('acf_register_block_type')) {
        error_log('WohneGrün: acf_register_block_type function not found!');
        return;
    }

    error_log('WohneGrün: Registering all-in-one ACF blocks with live preview...');

    // Block Category
    $category = 'wohnegruen';

    // 1. HOME PAGE COMPLETE BLOCK
    acf_register_block_type(array(
        'name'              => 'wohnegruen-home-complete',
        'title'             => __('Homepage Komplett', 'wohnegruen'),
        'description'       => __('Alles-in-einem Block für Homepage: Hero, Features, Modelle, CTA - mit Live-Vorschau.', 'wohnegruen'),
        'render_template'   => 'template-parts/blocks/block-home-complete.php',
        'category'          => $category,
        'icon'              => 'admin-home',
        'keywords'          => array('home', 'homepage', 'komplett', 'complete', 'live'),
        'supports'          => array(
            'align' => array('full', 'wide'),
            'anchor' => true,
            'jsx' => true,
            'mode' => false,
        ),
        'mode'              => 'auto',
        'post_types'        => array('page'),
        'enqueue_assets'    => function() {},
    ));

    // 2. ABOUT PAGE COMPLETE BLOCK (Über uns)
    acf_register_block_type(array(
        'name'              => 'wohnegruen-about-complete',
        'title'             => __('Über uns Komplett', 'wohnegruen'),
        'description'       => __('Alles-in-einem Block für Über uns Seite: Hero, Geschichte, Werte, Team - mit Live-Vorschau.', 'wohnegruen'),
        'render_template'   => 'template-parts/blocks/block-about-complete.php',
        'category'          => $category,
        'icon'              => 'admin-users',
        'keywords'          => array('about', 'über uns', 'komplett', 'complete', 'live'),
        'supports'          => array(
            'align' => array('full', 'wide'),
            'anchor' => true,
            'jsx' => true,
            'mode' => false,
        ),
        'mode'              => 'auto',
        'post_types'        => array('page'),
        'enqueue_assets'    => function() {},
    ));

    // 3. CONTACT PAGE COMPLETE BLOCK (Kontakt)
    acf_register_block_type(array(
        'name'              => 'wohnegruen-contact-complete',
        'title'             => __('Kontakt Komplett', 'wohnegruen'),
        'description'       => __('Alles-in-einem Block für Kontakt Seite: Hero, Formular, Info, Karte - mit Live-Vorschau.', 'wohnegruen'),
        'render_template'   => 'template-parts/blocks/block-contact-complete.php',
        'category'          => $category,
        'icon'              => 'email-alt',
        'keywords'          => array('contact', 'kontakt', 'komplett', 'complete', 'live'),
        'supports'          => array(
            'align' => array('full', 'wide'),
            'anchor' => true,
            'jsx' => true,
            'mode' => false,
        ),
        'mode'              => 'auto',
        'post_types'        => array('page'),
        'enqueue_assets'    => function() {},
    ));

    // 4. GALLERY PAGE COMPLETE BLOCK (Galerie)
    acf_register_block_type(array(
        'name'              => 'wohnegruen-gallery-complete',
        'title'             => __('Galerie Komplett', 'wohnegruen'),
        'description'       => __('Alles-in-einem Block für Galerie Seite: Hero, Filter, Lightbox - mit Live-Vorschau.', 'wohnegruen'),
        'render_template'   => 'template-parts/blocks/block-gallery-complete.php',
        'category'          => $category,
        'icon'              => 'images-alt2',
        'keywords'          => array('gallery', 'galerie', 'komplett', 'complete', 'live'),
        'supports'          => array(
            'align' => array('full', 'wide'),
            'anchor' => true,
            'jsx' => true,
            'mode' => false,
        ),
        'mode'              => 'auto',
        'post_types'        => array('page'),
        'enqueue_assets'    => function() {},
    ));

    // 5. MODELS PAGE COMPLETE BLOCK (Modelle Listing)
    acf_register_block_type(array(
        'name'              => 'wohnegruen-models-complete',
        'title'             => __('Modelle Komplett', 'wohnegruen'),
        'description'       => __('Alles-in-einem Block für Modelle Seite: Hero, Filter, Modellkarten - mit Live-Vorschau.', 'wohnegruen'),
        'render_template'   => 'template-parts/blocks/block-models-complete.php',
        'category'          => $category,
        'icon'              => 'grid-view',
        'keywords'          => array('models', 'modelle', 'listing', 'komplett', 'complete', 'live'),
        'supports'          => array(
            'align' => array('full', 'wide'),
            'anchor' => true,
            'jsx' => true,
            'mode' => false,
        ),
        'mode'              => 'auto',
        'post_types'        => array('page'),
        'enqueue_assets'    => function() {},
    ));

    // 6. MOBILHAUS COMPLETE BLOCK (For individual mobilhaus posts)
    acf_register_block_type(array(
        'name'              => 'wohnegruen-mobilhaus-complete',
        'title'             => __('Mobilhaus Komplett', 'wohnegruen'),
        'description'       => __('Alles-in-einem Block für Mobilhaus-Seiten: Hero, Farbauswahl, Beschreibung, Grundriss, Innenausstattung (Hosekra-Stil) - mit Live-Vorschau.', 'wohnegruen'),
        'render_template'   => 'template-parts/blocks/block-mobilhaus-complete.php',
        'category'          => $category,
        'icon'              => 'admin-multisite',
        'keywords'          => array('mobilhaus', 'komplett', 'hosekra', 'modell', 'complete', 'live'),
        'supports'          => array(
            'align' => array('full', 'wide'),
            'anchor' => true,
            'mode' => false,
            'jsx' => true,
        ),
        'mode'              => 'auto',
        'post_types'        => array('mobilhaus'),
        'enqueue_style'     => false,
        'enqueue_assets'    => function() {},
    ));

    error_log('WohneGrün: Successfully registered 6 all-in-one ACF blocks with live preview');
}
add_action('acf/init', 'wohnegruen_register_acf_blocks', 5);
add_action('init', 'wohnegruen_register_acf_blocks', 20);

/**
 * Register ACF Options Pages
 */
function wohnegruen_register_acf_options_pages() {
    if (!function_exists('acf_add_options_page')) {
        return;
    }

    // Navigation Options Page
    acf_add_options_page(array(
        'page_title' => 'Navigation',
        'menu_title' => 'Navigation',
        'menu_slug' => 'acf-options-navigation',
        'capability' => 'edit_posts',
        'parent_slug' => 'themes.php',
        'position' => false,
        'icon_url' => false,
    ));

    // Contact Info Options Page
    acf_add_options_page(array(
        'page_title' => 'Kontaktdaten',
        'menu_title' => 'Kontaktdaten',
        'menu_slug' => 'acf-options-kontakt',
        'capability' => 'edit_posts',
        'parent_slug' => 'themes.php',
        'position' => false,
        'icon_url' => false,
    ));

    // Footer Options Page
    acf_add_options_page(array(
        'page_title' => 'Footer',
        'menu_title' => 'Footer',
        'menu_slug' => 'acf-options-footer',
        'capability' => 'edit_posts',
        'parent_slug' => 'themes.php',
        'position' => false,
        'icon_url' => false,
    ));
}
add_action('acf/init', 'wohnegruen_register_acf_options_pages');

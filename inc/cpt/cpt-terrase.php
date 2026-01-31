<?php
/**
 * Custom Post Type: Terrase
 */

if (!defined('ABSPATH')) exit;

/**
 * Register Custom Post Type: Terrase
 */
function wohnegruen_register_terrase_cpt() {
    $labels = array(
        'name'                  => 'Terrassen',
        'singular_name'         => 'Terrasse',
        'menu_name'             => 'Terrassen',
        'add_new'               => 'Neu hinzufügen',
        'add_new_item'          => 'Neue Terrasse hinzufügen',
        'edit_item'             => 'Terrasse bearbeiten',
        'new_item'              => 'Neue Terrasse',
        'view_item'             => 'Terrasse ansehen',
        'search_items'          => 'Terrassen durchsuchen',
        'not_found'             => 'Keine Terrassen gefunden',
        'not_found_in_trash'    => 'Keine Terrassen im Papierkorb',
        'all_items'             => 'Alle Terrassen',
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'terrassen'),
        'capability_type'     => 'post',
        'has_archive'         => false,
        'hierarchical'        => false,
        'menu_position'       => 6,
        'menu_icon'           => 'dashicons-admin-multisite',
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest'        => true,
    );

    register_post_type('terrase', $args);
}
add_action('init', 'wohnegruen_register_terrase_cpt');

/**
 * Flush rewrite rules on theme activation
 */
function wohnegruen_terrase_rewrite_flush() {
    wohnegruen_register_terrase_cpt();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'wohnegruen_terrase_rewrite_flush');

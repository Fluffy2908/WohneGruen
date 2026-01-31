<?php
/**
 * WohneGrün Theme Functions - CLEAN & PROFESSIONAL
 * Version: 2.0.0
 */

if (!defined('ABSPATH')) exit;

// Core theme setup
require_once get_template_directory() . '/inc/theme.php';

// Enqueue scripts and styles (CLEAN - only style.css + main.js)
require_once get_template_directory() . '/inc/enqueue.php';

// Custom Post Type: Mobilhaus
require_once get_template_directory() . '/inc/cpt/cpt-mobilhaus.php';

// Custom Post Type: Terrase
require_once get_template_directory() . '/inc/cpt/cpt-terrase.php';

// ACF Blocks Registration (7 complete blocks)
require_once get_template_directory() . '/inc/acf.php';

// Contact Form Handler
require_once get_template_directory() . '/inc/contact-handler.php';

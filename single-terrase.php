<?php
/**
 * Single Terrase Template
 * CLEAN - Uses Gutenberg blocks only
 */

get_header();
?>

<main id="main-content" class="single-terrase-page">
    <?php
    while (have_posts()) :
        the_post();
        the_content(); // Shows Gutenberg blocks including terrase-complete
    endwhile;
    ?>
</main>

<?php get_footer(); ?>

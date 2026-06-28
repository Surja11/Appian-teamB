<?php get_header(); ?>

<main id="primary" class="site-main">

<?php while (have_posts()): the_post(); ?>

    <?php get_template_part('blocks/project-detail-leadspace'); ?>
    <?php get_template_part('blocks/project-detail-content'); ?>

<?php endwhile; ?>

</main><!-- #main -->

<?php get_footer(); ?>
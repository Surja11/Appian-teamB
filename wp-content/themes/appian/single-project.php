<?php get_header(); ?>

<?php while (have_posts()): the_post(); ?>

    <?php get_template_part('blocks/project-detail-leadspace'); ?>
    <?php get_template_part('blocks/project-detail-content'); ?>

<?php endwhile; ?>

<?php get_footer(); ?>
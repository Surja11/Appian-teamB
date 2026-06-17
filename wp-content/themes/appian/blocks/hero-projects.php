<?php

/**
 * Hero Projects
 * blocks/hero-projects.php
 */

$hero_projects = get_field('hero_projects');
$section_title = $hero_projects['section_title'];
$hero_projects_list = $hero_projects['hero_projects_list'];
$featured_image = $hero_projects['featured_image'];

if (!$hero_projects) {
    return;
}

if (!empty($section_title) || !empty($hero_projects_list) || !empty($featured_image)):
?>

    <section class="hero-projects">
        <div class="container">

            <?php if (!empty($section_title)) : ?>
                <div class="hero-projects__title-block">
                    <h2 class="hero-projects__title h2"><?php echo esc_html($section_title); ?></h2>
                    <picture>
                        <source
                            media="(min-width: 1200px)"
                            srcset="<?php echo get_template_directory_uri(); ?>/resources/images/divider.svg">
                        <img
                            src="<?php echo get_template_directory_uri(); ?>/resources/images/divider-small.svg"
                            alt="">
                    </picture>
                </div>
            <?php endif; ?>

            <div class="hero-projects__cards">
                <?php
                $all_cards = $hero_projects_list;
                $total_cards = count($all_cards);

                for ($i = 0; $i < $total_cards; $i++) {
                    $card = $all_cards[$i];

                    if (!empty($card['project_title']) || !empty($card['project_category']) || !empty($card['category_short']) || !empty($card['project_subtitle']) || !empty($card['project_image']) || !empty($card['page_link'])) {
                        set_query_var('card', $card);
                        get_template_part('template-parts/hero-project-card');

                        if ($i === 3 && !empty($featured_image)) : ?>
                            <div class="hero-projects__feature-image" aria-labelledby="Featured Image" style="background-image: url('<?php echo esc_url($featured_image['url']); ?>');">
                            </div>
                <?php endif;
                    }
                }
                ?>
            </div>

        </div>
    </section>

<?php endif; ?>
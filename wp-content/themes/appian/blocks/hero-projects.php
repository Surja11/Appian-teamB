<?php

$hero_projects = get_field('hero_projects');
$section_title = $hero_projects['section_title']  ?? '';
$featured_image = $hero_projects['featured_image'] ?? null;
$featured_image_position = (int)($hero_projects['featured_image_position'] ?? 1);
$selected_projects = $hero_projects['selected_projects'];

if (!$hero_projects || empty($selected_projects)) {
    return;
}


$selected_ids = array_slice(array_map(fn($project) => is_object($project) ? $project->ID : (int)$project, $selected_projects), 0, 10);


$projects = new WP_Query([
    'post_type' => 'project',
    'posts_per_page' => 10,
    'post_status' => 'publish',
    'post__in' => $selected_ids,
    'order_by' => 'post__in'
]);

if (!empty($section_title) || $projects->have_posts() || !empty($featured_image)):
?>

    <section class="hero-projects">
        <div class="container">

            <?php if (!empty($section_title)): ?>
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
                $i = 1;
                $total = $projects->post_count;

                while ($projects->have_posts()): $projects->the_post();
                    $post_id= get_the_ID();
                    $project_details = get_field('project_details', $post_id);

                    $card = [
                        'project_title'=> get_the_title($post_id),
                        'project_category' => $project_details['project_category'] ?? '',
                        'project_subtitle' => $project_details['project_subtitle'] ?? '',
                        'project_image'=> $project_details['project_card_image'] ?? null,
                        'page_link'=> get_permalink($post_id),
                        'featured_post'=> false,
                    ];

                    set_query_var('card', $card);
                    if ($featured_image_position%4==0){
                        $featured_image_position--;
                    }

                    if ($i === $featured_image_position && !empty($featured_image)): ?>
                        <div class="hero-projects__feature-image"
                            style="background-image: url('<?php echo esc_url($featured_image['url']); ?>');">
                        </div>
                    <?php endif;

                    get_template_part('template-parts/hero-project-card');

                    $i++;
                endwhile;
                wp_reset_postdata();
                if (!empty($featured_image) && $featured_image_position > $total): ?>
                    <div class="hero-projects__feature-image"
                        style="background-image: url('<?php echo esc_url($featured_image['url']); ?>');">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

<?php endif; ?>
<?php
/**
 * Hero Projects
 * blocks/hero-projects.php
 */

$hero_projects      = get_field('hero_projects');
$section_title      = $hero_projects['section_title'];
$hero_projects_list = $hero_projects['hero_projects_list'];
$featured_image     = $hero_projects['featured_image'];

if (!$hero_projects) {
    return;
}

if (!empty($section_title) || !empty($hero_projects_list) || !empty($featured_image)):

//making row 2 get the featured image and two cards in desktop view.
$hero_cards  = $hero_projects_list;
$row1_cards = array_splice($hero_cards, 0, 4);
if(empty($featured_image)){
    $row2_cards = array_splice($hero_cards, 0, 4);
}
else{
$row2_cards = array_splice($hero_cards, 0, 2);
}
$remaining  = !empty($hero_cards) ? array_chunk($hero_cards, 4) : [];

$hero_projects_collection = array_merge([$row1_cards, $row2_cards], $remaining);

?>

<section class="hero-projects">
    <div class="hero-projects__inner">

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

        <?php foreach ($hero_projects_collection as $row_index => $hero_project_cards) :
            $row_number = $row_index + 1;

            if (empty($hero_project_cards)) continue;

            
        ?>
            <div class="hero-projects__cards hero-projects__cards--row-<?php echo $row_number; ?>">

                <?php if ($row_number === 2 && !empty($featured_image)) : ?>
                    <div class="hero-projects__feature-image" aria-labelledby="Featured Image" style="background-image: url('<?php echo esc_url($featured_image['url']); ?>');">
                        
                    </div>
                <?php endif; ?>


                
                <?php 
            
                foreach ($hero_project_cards as $card) :
                    if (!empty($card['project_title'])||!empty($card['project_category'])||!empty($card['category_short'])||!empty($card['project_subtitle'])||!empty($card['project_image'])||!empty($card['page_link'])) {
                    set_query_var('card', $card);
                    get_template_part('template-parts/hero-project-card');
                    }
                endforeach; ?>

            </div>

        <?php endforeach; ?>

    </div>
</section>

<?php endif; ?>
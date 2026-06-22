<?php

$our_projects = get_field('our_projects');
if (!$our_projects) {
    $our_projects = get_field('hero_projects');
}

// proper null checking
$section_title = isset($our_projects['section_title']) ? $our_projects['section_title'] : '';
$our_projects_list = isset($our_projects['hero_projects_list']) ? $our_projects['hero_projects_list'] : 
                    (isset($our_projects['our_projects_list']) ? $our_projects['our_projects_list'] : array());
$featured_image = isset($our_projects['featured_image']) ? $our_projects['featured_image'] : null;

if (!is_array($our_projects_list)) {
    $our_projects_list = array();
}

if (!$our_projects) {
    return;
}

if (!empty($section_title) || !empty($our_projects_list) || !empty($featured_image)):
?>

    <section class="our-projects">
        <div class="container d-flex flex-column align-items-center">

            <?php if (!empty($section_title)) : ?>
                <div class="our-projects__title-block d-flex flex-column align-items-center mb-10 mb-md-15">
                    <h2 class="our-projects__title h2 text-center mb-4"><?php echo esc_html($section_title); ?></h2>
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

            <!-- Filter Section -->
            <div class="our-projects__filter w-100 mb-10 mb-md-15">
                <div class="our-projects__filter-line-top mb-4"></div>
                
                <div class="our-projects__filter-header d-flex justify-content-between align-items-center w-100 d-md-none">
                    <span class="our-projects__filter-label body-small">Filter by:</span>
                    <span class="our-projects__filter-current body-small">All Projects</span>
                </div>
                
                <div class="our-projects__filter-line-bottom mt-4 mb-4"></div>
                
                <!-- Filter items -->
                <div class="our-projects__filter-items d-none d-md-flex align-items-center justify-content-center flex-wrap gap-8">
                    <button class="our-projects__filter-item body-small-all active border-0 bg-transparent p-0">All Projects</button>
                    <button class="our-projects__filter-item body-small border-0 bg-transparent p-0">Renovation</button>
                    <button class="our-projects__filter-item body-small border-0 bg-transparent p-0">Waterproofing</button>
                    <button class="our-projects__filter-item body-small border-0 bg-transparent p-0">Plumbing</button>
                    <button class="our-projects__filter-item body-small border-0 bg-transparent p-0">Electrical</button>
                    <button class="our-projects__filter-item body-small border-0 bg-transparent p-0">HVAC</button>
                    <button class="our-projects__filter-item body-small border-0 bg-transparent p-0">Roofing</button>
                </div>
            </div>

            <div class="our-projects__cards d-grid w-100 gap-3 mb-23 mb-md-3 mb-xl-5">
                <?php
                if (!empty($our_projects_list) && is_array($our_projects_list)) {
                    $all_cards = $our_projects_list;
                    $total_cards = count($all_cards);

                    for ($i = 0; $i < $total_cards; $i++) {
                        $card = $all_cards[$i];

                        if (!empty($card['project_title']) || !empty($card['project_category']) || !empty($card['category_short']) || !empty($card['project_subtitle']) || !empty($card['project_image']) || !empty($card['page_link'])) {
                            set_query_var('card', $card);
                            get_template_part('template-parts/hero-project-card');

                            if ($i === 3 && !empty($featured_image) && isset($featured_image['url'])) : ?>
                                <div class="our-projects__feature-image" aria-labelledby="Featured Image" style="background-image: url('<?php echo esc_url($featured_image['url']); ?>');">
                                </div>
                    <?php endif;
                        }
                    }
                } else {
                    for ($i = 0; $i < 6; $i++) {
                        $sample_card = array(
                            'project_category' => 'Sample Category',
                            'category_short' => 'SC',
                            'project_title' => 'Sample Project ' . ($i + 1),
                            'project_subtitle' => 'Sample project description',
                            'project_image' => array('url' => ''),
                            'page_link' => '#'
                        );
                        set_query_var('card', $sample_card);
                        get_template_part('template-parts/hero-project-card');
                    }
                }
                ?>
            </div>

            <!-- Pagination Section -->
            <div class="our-projects__pagination d-flex align-items-center justify-content-center gap-1 mt-20 mb-25 mt-md-20 mb-md-16">
                <button class="our-projects__pagination-arrow our-projects__pagination-arrow--prev d-flex align-items-center justify-content-center bg-transparent border-0 p-0" aria-label="Previous page">
                    <img src="<?php echo get_template_directory_uri(); ?>/resources/images/icon-chevron-down.svg" alt="Previous">
                </button>
                <div class="our-projects__pagination-numbers d-flex align-items-center gap-1">
                    <button class="our-projects__pagination-number button-text d-flex align-items-center justify-content-center text-center active px-4 py-0 bg-white border border-light rounded-1">1</button>
                    <button class="our-projects__pagination-number button-text d-flex align-items-center justify-content-center text-center px-4 py-0 bg-white border border-light rounded-1">2</button>
                    <button class="our-projects__pagination-number button-text d-flex align-items-center justify-content-center text-center px-4 py-0 bg-white border border-light rounded-1">3</button>
                    <button class="our-projects__pagination-number button-text d-flex align-items-center justify-content-center text-center px-4 py-0 bg-white border border-light rounded-1">4</button>
                    <button class="our-projects__pagination-number button-text d-flex align-items-center justify-content-center text-center px-4 py-0 bg-white border border-light rounded-1">5</button>
                </div>
                <button class="our-projects__pagination-arrow our-projects__pagination-arrow--next d-flex align-items-center justify-content-center bg-transparent border-0 p-0" aria-label="Next page">
                    <img src="<?php echo get_template_directory_uri(); ?>/resources/images/icon-chevron-down.svg" alt="Next">
                </button>
            </div>

        </div>
    </section>

<?php endif; ?>
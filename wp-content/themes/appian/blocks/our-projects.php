<?php

$our_projects = get_field('our_projects');

if (!$our_projects) {
    return;
}

// Extract field values
$section_title = $our_projects['section_title'] ?? '';
$our_projects_list = $our_projects['our_projects_list'] ?? array();
$enable_filters = $our_projects['enable_filters'] ?? true;
$enable_pagination = $our_projects['enable_pagination'] ?? true;
$projects_per_page = $our_projects['projects_per_page'] ?? 6;

if (!is_array($our_projects_list)) {
    $our_projects_list = array();
}

$processed_projects = array();
foreach ($our_projects_list as $project_item) {
    if (isset($project_item['project']) && $project_item['project']) {
        $project_post = $project_item['project'];
        $project_details = get_field('project_details', $project_post->ID);
        
        $processed_project = array(
            'project_title' => $project_post->post_title,
            'project_category' => $project_details['project_category'] ?? '',
            'category_short' => '',
            'project_subtitle' => $project_details['project_subtitle'] ?? '',
            'project_image' => $project_details['project_card_image'] ?? null,
            'page_link' => get_permalink($project_post->ID),
            'featured_post' => $project_details['featured_post'] ?? false,
        );
        
        $processed_projects[] = $processed_project;
    }
}

// Calculate pagination
$total_projects = count($processed_projects);
$total_pages = $enable_pagination ? ceil($total_projects / $projects_per_page) : 1;

$projects_to_show = $processed_projects;

if (!empty($section_title) || !empty($processed_projects)):
?>

    <section class="our-projects" 
             data-enable-pagination="<?php echo $enable_pagination ? 'true' : 'false'; ?>"
             data-projects-per-page="<?php echo esc_attr($projects_per_page); ?>"
             data-total-pages="<?php echo esc_attr($total_pages); ?>"
             data-total-projects="<?php echo esc_attr($total_projects); ?>">
        <div class="container d-flex flex-column align-items-center">

            <?php if (!empty($section_title)) : ?>
                <div class="our-projects__title-block d-flex flex-column align-items-center">
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

            <?php if ($enable_filters) : ?>
            <!-- Filter Section -->
            <div class="our-projects__filter w-100">
                <div class="our-projects__filter-line-top mb-4"></div>
                
                <div class="our-projects__filter-header d-flex align-items-center w-100 d-md-none">
                    <span class="our-projects__filter-label body-medium me-auto">Filter by:</span>
                    <div class="our-projects__filter-dropdown position-relative">
                        <button class="our-projects__filter-current btn-text d-flex align-items-center justify-content-between bg-transparent border-0 p-0" id="mobileFilterToggle">
                            <span class="our-projects__filter-selected">All Projects</span>
                            <img src="<?php echo get_template_directory_uri(); ?>/resources/images/icon-chevron-down.svg" alt="Dropdown" class="our-projects__filter-arrow ms-2" style="width: 12px; height: 12px; transition: transform 0.3s ease;">
                        </button>
                        <div class="our-projects__filter-dropdown-menu position-absolute top-100 bg-white border rounded-1 shadow-sm d-none" style="z-index: 10; right: 0; left: auto; min-width: 160px; width: auto;">
                            <button class="our-projects__filter-option d-block w-100 text-start border-0 bg-transparent body-small-all active" data-value="all">All Projects</button>
                            <button class="our-projects__filter-option d-block w-100 text-start border-0 bg-transparent body-small" data-value="renovation">Renovation</button>
                            <button class="our-projects__filter-option d-block w-100 text-start border-0 bg-transparent body-small" data-value="waterproofing">Waterproofing</button>
                            <button class="our-projects__filter-option d-block w-100 text-start border-0 bg-transparent body-small" data-value="plumbing">Plumbing</button>
                            <button class="our-projects__filter-option d-block w-100 text-start border-0 bg-transparent body-small" data-value="electrical">Electrical</button>
                            <button class="our-projects__filter-option d-block w-100 text-start border-0 bg-transparent body-small" data-value="hvac">HVAC</button>
                            <button class="our-projects__filter-option d-block w-100 text-start border-0 bg-transparent body-small" data-value="roofing">Roofing</button>
                        </div>
                    </div>
                </div>
                
                <div class="our-projects__filter-line-bottom mt-4"></div>
                
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
            <?php endif; ?>

            <div class="our-projects__cards d-grid w-100 gap-3 mb-23 mb-md-3 mb-xl-5">
                <?php
                if (!empty($projects_to_show)) {
                    foreach ($projects_to_show as $card) {
                        if (!empty($card['project_title']) || !empty($card['project_category']) || !empty($card['category_short']) || !empty($card['project_subtitle']) || !empty($card['project_image']) || !empty($card['page_link'])) {
                            set_query_var('card', $card);
                            get_template_part('template-parts/hero-project-card');
                        }
                    }
                } else {
                    // Fallback message
                    echo '<p class="text-center">No projects have been selected for display.</p>';
                }
                ?>
            </div>

            <?php if ($enable_pagination && $total_pages > 1) : ?>
            <!-- Pagination Section -->
            <div class="our-projects__pagination d-flex align-items-center justify-content-center gap-md-1 mt-20 mb-25 mt-md-15">
                <button class="our-projects__pagination-arrow our-projects__pagination-arrow--prev d-flex align-items-center justify-content-center bg-transparent border-0 p-0" aria-label="Previous page" data-direction="prev" disabled>
                    <img src="<?php echo get_template_directory_uri(); ?>/resources/images/icon-chevron.svg" alt="Previous">
                </button>
                <div class="our-projects__pagination-numbers d-flex align-items-center gap-md-1">
                    <?php for ($i = 1; $i <= min($total_pages, 5); $i++) : ?>
                        <button class="our-projects__pagination-number btn-text d-flex align-items-center justify-content-center text-center px-4 py-0 bg-white border border-light rounded-1 <?php echo $i === 1 ? 'active' : ''; ?>" 
                                data-page="<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </button>
                    <?php endfor; ?>
                    
                    <?php if ($total_pages > 5) : ?>
                        <span class="our-projects__pagination-ellipsis">...</span>
                        <button class="our-projects__pagination-number btn-text d-flex align-items-center justify-content-center text-center px-4 py-0 bg-white border border-light rounded-1" 
                                data-page="<?php echo $total_pages; ?>">
                            <?php echo $total_pages; ?>
                        </button>
                    <?php endif; ?>
                </div>
                <button class="our-projects__pagination-arrow our-projects__pagination-arrow--next d-flex align-items-center justify-content-center bg-transparent border-0 p-0" aria-label="Next page" data-direction="next" <?php echo $total_pages <= 1 ? 'disabled' : ''; ?>>
                    <img src="<?php echo get_template_directory_uri(); ?>/resources/images/icon-chevron.svg" alt="Next">
                </button>
            </div>
            <?php endif; ?>

        </div>
    </section>

<?php endif; ?>
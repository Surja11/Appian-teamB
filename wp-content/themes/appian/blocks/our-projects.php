<?php

$our_projects = get_field('our_projects');

if (!$our_projects) {
    return;
}

$section_title = $our_projects['section_title'] ?? '';
$enable_filters = $our_projects['enable_filters'] ?? true;
$enable_pagination = $our_projects['enable_pagination'] ?? true;
$projects_per_page = $our_projects['projects_per_page'] ?? 6;

$selected_projects = $our_projects['select_project_items'] ?? [];

$all_project_ids = !empty($selected_projects)
    ? array_map(fn($p) => $p->ID, $selected_projects)
    : [];

$all_cats_in_use = [];
foreach ($all_project_ids as $pid) {
    $details = get_field('project_details', $pid);
    $cat = $details['project_category'] ?? '';
    if ($cat && !in_array($cat, $all_cats_in_use)) {
        $all_cats_in_use[] = $cat;
    }
}


$category_order = ['Renovation', 'Waterproofing', 'Plumbing', 'Electrical', 'HVAC', 'Roofing'];

$unique_categories = array_values(array_filter($category_order, fn($cat) => in_array($cat, $all_cats_in_use)));

foreach ($all_cats_in_use as $cat) {
    if (!in_array($cat, $unique_categories)) {
        $unique_categories[] = $cat;
    }
}
if (empty($section_title) && empty($all_project_ids)) return;
?>

<section class="our-projects"
    data-enable-pagination="<?php echo $enable_pagination ? 'true' : 'false'; ?>"
    data-projects-per-page="<?php echo esc_attr($projects_per_page); ?>"
    data-selected-ids="<?php echo esc_attr( implode(',', $all_project_ids) ); ?>"
    data-enable-filters="<?php echo $enable_filters ? 'true' : 'false'; ?>">
    <div class="container d-flex flex-column align-items-center">

        <?php if (!empty($section_title)) : ?>
            <div class="our-projects__title-block d-flex flex-column align-items-center">
                <h2 class="our-projects__title h2 text-center appian-section__title position-relative"><?php echo esc_html($section_title); ?></h2>
            </div>
        <?php endif; ?>

        <?php if ($enable_filters) : ?>
            <div class="our-projects__filter w-100">
                <div class="our-projects__filter-line-top mb-4"></div>

                <div class="our-projects__filter-header d-flex align-items-center w-100 d-md-none">
                    <span class="our-projects__filter-label body-medium me-auto">Filter by:</span>
                    <div class="our-projects__filter-dropdown position-relative">
                        <button class="our-projects__filter-current btn-text d-flex align-items-center justify-content-between bg-transparent border-0 p-0 "
                            id="mobileFilterToggle">
                            <span class="our-projects__filter-selected pe-none">All Projects</span>
                            <img src="<?php echo get_template_directory_uri(); ?>/resources/images/icon-chevron-down.svg"
                                alt="" class="our-projects__filter-arrow ms-2"
                                style="width:12px;height:12px;transition:transform 0.3s ease;">
                        </button>
                        <div class="our-projects__filter-dropdown-menu position-absolute top-100 bg-white border rounded-1 shadow-sm d-none"
                            style="z-index:10;right:0;left:auto;min-width:160px;width:auto;">
                            <button class="our-projects__filter-option d-block w-100 text-start border-0 bg-transparent body-small-all active"
                                data-value="all">All Projects</button>
                            <?php foreach ($unique_categories as $cat) : ?>
                                <button class="our-projects__filter-option d-block w-100 text-start border-0 bg-transparent body-small"
                                    data-value="<?php echo esc_attr(strtolower($cat)); ?>">
                                    <?php echo esc_html($cat); ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="our-projects__filter-line-bottom mt-4"></div>

                <div class="our-projects__filter-items d-none d-md-flex align-items-center justify-content-center flex-wrap gap-8">
                    <button class="our-projects__filter-item body-small-all active border-0 bg-transparent p-0"
                        data-value="all">All Projects</button>
                    <?php foreach ($unique_categories as $cat) : ?>
                        <button class="our-projects__filter-item body-small border-0 bg-transparent p-0"
                            data-value="<?php echo esc_attr(strtolower($cat)); ?>">
                            <?php echo esc_html($cat); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>


        <div class="our-projects__cards w-100 d-flex flex-column align-items-center"
            id="projects-grid">

        </div>

    </div>
</section>
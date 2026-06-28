<?php

function our_projects_enqueue_scripts()
{
    wp_enqueue_script(
        'our-projects',
        get_template_directory_uri() . '/resources/scripts/modules/our-projects.js',
        array(),
        filemtime(get_template_directory() . '/resources/scripts/modules/our-projects.js'),
        true
    );

    wp_localize_script('our-projects', 'projectsAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'=> wp_create_nonce('projects_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'our_projects_enqueue_scripts');


function our_projects_filter()
{
    check_ajax_referer('projects_nonce', 'nonce');

    $filter = isset($_POST['filter'])   ? strtolower(sanitize_text_field($_POST['filter'])) : 'all';
    $page = isset($_POST['page'])     ? absint($_POST['page']) : 1;
    $per_page = isset($_POST['per_page']) ? absint($_POST['per_page']) : 6;

  
    $selected_ids = [];
    if (!empty($_POST['selected_ids'])) {
        $selected_ids = array_filter(
            array_map('absint', explode(',', sanitize_text_field($_POST['selected_ids'])))
        );
    }

    $base = [
        'post_type'=> 'project',
        'post_status' => 'publish',
        'numberposts' => -1,
        'fields'=> 'ids',
        'orderby'=> 'date',
        'order'=> 'DESC',
    ];

   
    if (!empty($selected_ids)) {
        $base['post__in'] = $selected_ids;
    }

    $cat_filter = [];
    if ($filter !== 'all') {
        $cat_filter = [[
            'key'=> 'project_details_project_category',
            'value'=> $filter,
            'compare' => '=',
        ]];
    }

    $featured_ids = get_posts(array_merge($base, [
        'meta_query' => array_merge($cat_filter, [
            ['key' => 'project_details_featured_post', 'value' => '1'],
        ]),
    ]));

    $regular_ids = get_posts(array_merge($base, [
        'meta_query' => array_merge($cat_filter, [[
            'relation' => 'OR',
            ['key' => 'project_details_featured_post', 'value' => '1', 'compare' => '!='],
            ['key' => 'project_details_featured_post', 'compare' => 'NOT EXISTS'],
        ]]),
    ]));

    $all_ids= array_merge($featured_ids, $regular_ids);
    $total= count($all_ids);
    $total_pages = $per_page > 0 ? ceil($total / $per_page) : 1;
    $paged_ids = array_slice($all_ids, ($page - 1) * $per_page, $per_page);

    echo '<div class="our-projects__cards-inner d-grid w-100 gap-3">';

    if (!empty($paged_ids)) :
        $query = new WP_Query([
            'post_type'=> 'project',
            'post__in'=> $paged_ids,
            'orderby'=> 'post__in',
            'posts_per_page' => $per_page,
        ]);

        while ($query->have_posts()) : $query->the_post();
            $post_id= get_the_ID();
            $project_details = get_field('project_details', $post_id);

            $card = [
                'project_title'=> get_the_title($post_id),
                'project_category' => $project_details['project_category'] ?? '',
                'project_subtitle' => $project_details['project_subtitle'] ?? '',
                'project_image'=> $project_details['project_card_image'] ?? null,
                'page_link'=> get_permalink($post_id),
                'featured_post'=> $project_details['featured_post'] ?? false,
            ];

            set_query_var('card', $card);
            get_template_part('template-parts/hero-project-card');
        endwhile;
        wp_reset_postdata();

    else :
        echo '<p class="our-projects__no-results text-center w-100">No projects found.</p>';
    endif;

    echo '</div>';

    if ($total_pages > 1) :
        $visible = 5;
        $start= max(1, $page - floor($visible / 2));
        $end= min($total_pages, $start + $visible - 1);

        if ($end - $start + 1 < $visible) {
            $start = max(1, $end - $visible + 1);
        }

        $is_first = $page <= 1;
        $is_last  = $page >= $total_pages;
        ?>

        <div class="our-projects__pagination d-flex align-items-center justify-content-center mt-20 mt-md-15 mb-20 mb-lg-0">

            <button class="our-projects__pagination-arrow our-projects__pagination-arrow--prev d-flex align-items-center justify-content-center bg-transparent border-0 p-0"
                    data-page="<?php echo max(1, $page - 1); ?>"
                    aria-label="Previous page"
                    <?php echo $is_first ? 'disabled' : ''; ?>>
                <img src="<?php echo get_template_directory_uri(); ?>/resources/images/icon-chevron.svg" alt="">
            </button>

            <div class="our-projects__pagination-numbers d-flex align-items-center gap-md-1">

                <?php if ($start > 1) : ?>
                    <button class="our-projects__pagination-number btn-text d-flex align-items-center justify-content-center text-center px-4 py-0 bg-white border border-light rounded-1"
                            data-page="1">1</button>
                    <span class="our-projects__pagination-ellipsis">...</span>
                <?php endif; ?>

                <?php for ($i = $start; $i <= $end; $i++) : ?>
                    <button class="our-projects__pagination-number btn-text d-flex align-items-center justify-content-center text-center px-4 py-0 bg-white border border-light rounded-1 <?php echo $i === $page ? 'active' : ''; ?>"
                            data-page="<?php echo $i; ?>">
                        <?php echo $i; ?>
                    </button>
                <?php endfor; ?>

                <?php if ($end < $total_pages) : ?>
                    <span class="our-projects__pagination-ellipsis">...</span>
                    <button class="our-projects__pagination-number btn-text d-flex align-items-center justify-content-center text-center px-4 py-0 bg-white border border-light rounded-1"
                            data-page="<?php echo $total_pages; ?>">
                        <?php echo $total_pages; ?>
                    </button>
                <?php endif; ?>

            </div>

            <button class="our-projects__pagination-arrow our-projects__pagination-arrow--next d-flex align-items-center justify-content-center bg-transparent border-0 p-0"
                    data-page="<?php echo min($total_pages, $page + 1); ?>"
                    aria-label="Next page"
                    <?php echo $is_last ? 'disabled' : ''; ?>>
                <img src="<?php echo get_template_directory_uri(); ?>/resources/images/icon-chevron.svg" alt="">
            </button>

        </div>

    <?php endif;

    wp_die();
}
add_action('wp_ajax_our_projects_filter', 'our_projects_filter');
add_action('wp_ajax_nopriv_our_projects_filter', 'our_projects_filter');
<?php
function create_project_details_cpt()
{
    $labels = array(
        'name' => 'Projects',
        'singular_name' => 'Project',
        'menu_name' => 'Projects',
        'add_new' => 'Add New Project',
        'edit_item' => 'Edit Project',
        'view_item' => 'View Project',
        'all_items' => 'All Projects',
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'rewrite' => ['slug'=>'project'],
        'supports' => ['title'],
        'has_archive' => false,
        'menu_icon' => 'dashicons-email-alt',
    );
    register_post_type('project', $args);
}
add_action('init', 'create_project_details_cpt');

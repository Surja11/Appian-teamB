<?php
/**
 * History Custom Post Type
 */

function create_history_details_cpt()
{
    $labels = array(
        'name' => 'History',
        'singular_name' => 'History Item',
        'menu_name' => 'History',
        'add_new' => 'Add New History Item',
        'add_new_item' => 'Add New History Item',
        'edit_item' => 'Edit History Item',
        'view_item' => 'View History Item',
        'all_items' => 'All History Items',
    );
    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'rewrite' => ['slug' => 'history'],
        'supports' => ['title', 'editor'],
        'has_archive' => false,
        'menu_icon' => 'dashicons-calendar-alt',
        'menu_position' => 6,
        'show_in_rest' => false,
    );
    
    register_post_type('history', $args);
}
add_action('init', 'create_history_details_cpt');
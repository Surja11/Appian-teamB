<?php
function create_contact_submission_post_type()
{
    $labels = array(
        'name' => 'Contact Submissions',
        'singular_name' => 'Contact Submission',
        'menu_name' => 'Contact Submissions',
        'add_new' => 'Add New Submission',
        'edit_item' => 'Edit Submission',
        'view_item' => 'View Submission',
        'all_items' => 'All Submissions',
    );
    $args = array(
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'rewrite' => false,
        'supports' => array('title', 'custom-fields'),
        'has_archive' => false,
        'menu_icon' => 'dashicons-email-alt',
    );
    register_post_type('contact_submission', $args);
}
add_action('init', 'create_contact_submission_post_type');

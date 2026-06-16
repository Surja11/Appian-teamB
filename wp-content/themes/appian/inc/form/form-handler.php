<?php
add_action('wp_ajax_submit_form_action', 'handle_form_submission');
add_action('wp_ajax_nopriv_submit_form_action', 'handle_form_submission');

function handle_form_submission()
{

    if (!wp_verify_nonce($_POST['contact_lead_nonce'], 'submit_contact_lead')) {
        wp_send_json_error(['message' => 'Security check failed.']);
    }

    // sanitizing all incoming data
    $first_name = sanitize_text_field($_POST['first-name'] ?? '');
    $last_name = sanitize_text_field($_POST['last-name'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $phone = sanitize_text_field($_POST['phone-number'] ?? '');
    $move_in_date = sanitize_text_field($_POST['move-in-date'] ?? '');
    $unit_type = sanitize_text_field($_POST['unit-type'] ?? '');
    $room_type = sanitize_text_field($_POST['room-type'] ?? '');

    // creating the CPT post
    $post_id = wp_insert_post(
        array(
            'post_title' => $first_name . ' ' . $last_name,
            'post_type' => 'contact_submission',
            'post_status' => 'publish',
        )
    );

    if (is_wp_error($post_id)) {
        wp_send_json_error('Failed to create submission.');
    }

    //updating fields in the CPT
    update_field('submitted_contact_data', array(
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'phone_number' => $phone,
        'move_in_date' => $move_in_date,
        'unit_type' => $unit_type,
    ), $post_id);
    // sending email
    $to = get_option('admin_email');
    $subject = 'New Contact Form Submission';
    $message = "You have a new contact form submission:\n\n"
        . "Name: $first_name $last_name\n"
        . "Email: $email\n"
        . "Phone: $phone\n"
        . "Move-In Date: $move_in_date\n"
        . "Unit Type: $unit_type\n"
        . "Room Type: $room_type\n";

    $headers = array('Content-Type: text/plain; charset=UTF-8');
    $mail_sent = wp_mail($to, $subject, $message, $headers);

    if (!$mail_sent) {
        wp_send_json_error('Failed to send email. Please try again later.');
    }

    wp_send_json_success("Thank you, $first_name $last_name! Your contact is recorded.");
}

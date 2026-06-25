<?php
$leadspace = get_field('contact_leadspace');
$lead_image = $leadspace['lead_image'];
$lead_title = $leadspace['leadspace_title'];

if (empty($leadspace)){
    return;
}

if(!empty($lead_image)||!empty($lead_title)):
    if (!empty($lead_image['url'])) {
    add_action('wp_head', function() use ($lead_image) {
        echo '<link rel="preload" as="image" href="' . esc_url($lead_image['url']) . '" fetchpriority="high">';
    }, 1); 
}


?>

<section class="contact-leadspace-container pb-10 pt-10  pt-lg-25 pb-lg-25 d-flex align-items-end position-relative overflow-hidden">

    
    
    <img src="<?php echo esc_url($lead_image['url']) ?>" alt="<?php echo esc_html($lead_image['alt'])?>" class="position-absolute z-n1 top-0 start-0 w-100 h-100 object-fit-cover" loading="eager" fetchpriority="high">
    
    <div class="contact-leadspace-container__overlay position-absolute inset-0 w-100 h-100 z-3 top-0 start-0"></div>
    
    <div class="container position-relative z-3 contact-leadspace-container__text">
        <h1 class="display-1 text-capitalize contact-leadspace-container__heading">
            <?php echo esc_html($lead_title); ?>
        </h1>
    </div>
    
</section>

<?php endif; ?>
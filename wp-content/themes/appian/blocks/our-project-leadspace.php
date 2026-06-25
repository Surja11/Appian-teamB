<?php
$leadspace = get_field('our_project_leadspace');
$lead_video = $leadspace['lead_video'];
$lead_title = $leadspace['leadspace_text'];
$video_poster =  $leadspace['poster'];

if (empty($leadspace)){
    return;
}

if(!empty($lead_video)||!empty($lead_title)):

?>

<section class="our-project-leadspace-container pb-10 pt-10  pt-lg-25 pb-lg-25 d-flex align-items-end position-relative overflow-hidden">

     <?php if ( $lead_video ) : ?>
            <video autoplay muted loop playsinline class="our-project-leadspace-container__video position-absolute top-0 start-0 w-100 h-100 object-fit-cover" preload="auto"
            poster="<?php echo $video_poster ? esc_url($video_poster['url']) : ''; ?>"
            >               
                 <source src="<?php echo esc_url($lead_video['url']); ?>" type="video/mp4">
                Your browser does not support the HTML video tag.
            </video>
            <?php endif; ?>
    
    <div class="our-project-leadspace-container__overlay position-absolute inset-0 w-100 h-100 z-3 top-0 start-0"></div>
    
    <div class="container position-relative z-3 our-project-leadspace-container__text">
        <h1 class="display-1 text-capitalize
        our-project-leadspace-container__heading">
            <?php echo esc_html($lead_title); ?>
        </h1>
    </div>
    
</section>

<?php endif; ?>
<?php

$caption   = get_field('caption');
$main_text = get_field('main_text');
$cta_link  = get_field('cta_link');

$link_url    = '';
$link_title  = '';
$link_target = '_self';

if ( $cta_link && is_array( $cta_link ) ) {
    $link_url    = esc_url( $cta_link['url'] );
    $link_title  = esc_html( $cta_link['title'] );
    $link_target = !empty( $cta_link['target'] ) ? esc_attr( $cta_link['target'] ) : '_self';
}

?>
<!-- section for text content  with cta. using grid structure from bootstrap for styling that alighns content to right -->
<section class="cta-content container px-7 px-md-20">
    <div class="row g-6">

<!-- used ps-0 for removing the padding for lg screens which is set by the grid gutters which is set by the grid gutters in bootstrap -->
    <div class="col col-lg-7 offset-lg-4 ps-lg-0 pe-lg-0 cta-content-column">

     <!-- caption of the section styled via caption-1 utility as given in styleguide-->
        <p class="cta-content__caption caption-1">
                <?php echo esc_html( $caption ); ?>
            </p>

             <!-- text content with CTA button -->
            <div class="cta-content__body d-flex flex-column gap-12 pt-3 pt-lg-8">
                <h5 class="cta-content__text m-0">
                    <?php 
                    echo wp_kses_post( $main_text ); 
                    ?>
                </h5>

                <a href="<?php echo $link_url; ?>" 
                   target="<?php echo $link_target; ?>" 
                   <?php echo $link_target === '_blank' ? 'rel="noopener noreferrer"' : ''; ?>
                   class="btn btn-primary btn--cta" 
                   aria-label="<?php echo esc_attr( $link_title ); ?>">
                   
                    <span class="btn--cta__text"><?php echo $link_title; ?></span>
                    <div class="btn--cta__icon-container">
                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 8.41406H15M8 15.4141L15 8.41406L8 1.41406" stroke="#ffffff" stroke-width="2" stroke-miterlimit="5.75877" stroke-linecap="square" />
                        </svg>
                    </div>
                </a>
            </div>
        </div>

    </div>
</section>

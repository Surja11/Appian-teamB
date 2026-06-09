<?php
$partners = get_field( 'partners' );

$valid_partners = array();
if ( ! empty( $partners ) && is_array( $partners ) ) {
    foreach ( $partners as $row ) {
        if ( ! empty( $row['partner_logo'] ) ) {
            $valid_partners[] = $row;
        }
    }
}

if ( ! empty( $valid_partners ) ) :
?>

<section class="our-partner pt-12 pt-xl-20 " aria-labelledby="Our Partners Section">

    <div class="our-partner__heading d-flex flex-column justify-content-center align-items-center ">
        <h2 class="mb-4">Our partner</h2>
        <picture>
            <source media="(min-width: 1200px)" srcset="<?php echo get_template_directory_uri(); ?>/resources/images/divider.svg">
            <img src="<?php echo get_template_directory_uri(); ?>/resources/images/divider-small.svg" alt="divider line">
        </picture>
    </div>

   

    <div class="our-partner__partner-collection">
        <div class="row g-0"">

            <?php foreach ( $valid_partners as $partner ) :
                $logo = $partner['partner_logo']; 
            ?>

            <div class="our-partner__single-partner  col-6 col-xl-3">
                <div class="our-partner__img-container">
                    <img
                        src="<?php echo esc_url( $logo['url'] ); ?>"
                        alt="<?php echo esc_attr( $logo['alt'] ); ?>"
                        <?php if ( ! empty( $logo['width'] ) ) : ?>width="<?php echo esc_attr( $logo['width'] ); ?>"<?php endif; ?>
                        <?php if ( ! empty( $logo['height'] ) ) : ?>height="<?php echo esc_attr( $logo['height'] ); ?>"<?php endif; ?>
                    >
                </div>
            </div>

            <?php endforeach; ?>

            <div class="our-partner__single-partner our-partner__single-partner--cta  col-6 col-xl-3">
                <button class="btn btn-tertiary">View All Partners</button>
            </div>

        </div>
    </div>

   

</section>

<?php endif;?>

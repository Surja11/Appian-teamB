<?php
/**
 * Home Leadspace Block - Backend (ACF Fields)
 */

$eyebrow_text = get_field('eyebrow_text');
$heading_main = get_field('heading_main');
$heading_sub  = get_field('heading_sub');
$video        = get_field('video');
$video_url    = $video ? esc_url( $video['url'] ) : '';

?>

<?php if ( $eyebrow_text || $heading_main || $heading_sub || $video_url ) : ?>
<section class="home-leadspace w-100 overflow-hidden">

<!-- outer ellipse -->
    <div class="home-leadspace__outer-ellipse">

    <!-- the scrolling arc -->
        <span class="home-leadspace__scroll-ellipse"></span>

        <!-- inner ellipse -->
        <div class="home-leadspace__inner-ellipse">
            <?php if ( $video_url ) : ?>
            <video autoplay muted loop playsinline class="home-leadspace__video" preload="auto">
                <source src="<?php echo $video_url; ?>" type="video/mp4">
                Your browser does not support the HTML video tag.
            </video>
            <?php endif; ?>

            <!-- overlay -->
            <div class="home-leadspace__overlay position-absolute inset-0"></div>


            <!-- text content -->
            <div class="home-leadspace__text-content d-flex flex-column position-absolute">
                <?php if ( $eyebrow_text ) : ?>
                <div class="home-leadspace__eyebrow">
                    <span class="body body-small-all text-capitalize">
                        <?php echo esc_html( $eyebrow_text ); ?>
                    </span>
                </div>
                <?php endif; ?>
                <div class="home-leadspace__text-body">
                    <?php if ( $heading_main ) : ?>
                    <h1 class="display-1 text-capitalize display-1--mobile-view">
                        <?php echo esc_html( $heading_main ); ?>
                    </h1>
                    <?php endif; ?>
                    <?php if ( $heading_sub ) : ?>
                    <h1 class="h3 m-0">
                        <?php echo esc_html( $heading_sub ); ?>
                    </h1>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
    </div>

</section>
<?php endif; ?>

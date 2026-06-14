<?php

get_header();

$eyebrow    = get_field( '404_eyebrow', 'options' ) ?: __( '404 Error', 'outside-traineeship-biolerplate' );
$title      = get_field( '404_title', 'options' ) ?: __( 'Page Not Found', 'outside-traineeship-biolerplate' );
$desc       = get_field( '404_description', 'options' ) ?: __( 'Sorry, we couldn\'t locate that page. It might have been relocated, removed, or perhaps it was never here.', 'outside-traineeship-biolerplate' );
$btn_text   = get_field( '404_button_text', 'options' ) ?: __( 'Go to Homepage', 'outside-traineeship-biolerplate' );
$bg_image   = get_field( '404_background_image', 'options' );

if ( ! $bg_image ) {
    $bg_image = get_template_directory_uri() . '/resources/images/page-not-found.jpg';
}
?>

<main id="primary" class="site-main">

    <section class="error-404" style="background-image: url('<?php echo esc_url( $bg_image ); ?>');">
        <div class="error-404__inner">
            
            <p class="error-404__eyebrow caption-1">
                <?php echo esc_html( $eyebrow ); ?>
            </p>
            
            <h1 class="error-404__title display-2">
                <?php echo esc_html( $title ); ?>
            </h1>
            
            <p class="error-404__description subheading-3">
                <?php echo esc_html( $desc ); ?>
            </p>
            
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="error-404__btn btn-text">
                <span><?php echo esc_html( $btn_text ); ?></span>
                <span class="error-404__btn-arrow">
                    <?php 
                    $svg_path = get_theme_file_path( '/resources/images/icon-arrow-right.svg' );
                    if ( file_exists( $svg_path ) ) {
                        include $svg_path;
                    }
                    ?>
                </span>
            </a>
            
        </div>
    </section>

</main>

<?php
get_footer();
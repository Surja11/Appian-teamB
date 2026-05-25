<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Outside_Traineeship_Biolerplate
 */
?>

<footer id="colophon" class="site-footer custom-footer">
    <div class="container">
        <div class="row">

            <!-- ① Address + Contact + LinkedIn — first on mobile, middle on desktop -->
            <div class="col-12 col-md-4 footer-col footer-col--address order-md-2">
                <p class="footer-heading caption-3">ADDRESS</p>
                <p class="body body-medium">
                    Heffron Company, Inc.<br>
                    4940 Nicholson Ct Ste 100,<br>
                    Kensington, MD 20895
                </p>

                <p class="footer-heading caption-3 mt-8">CONTACT</p>
                <p class="body body-medium">
                    Phone: (301) 816-2088<br>
                    info@heffroncompany.com
                </p>

                <div class="mt-8">
                    <a href="#" target="_blank" rel="noopener noreferrer" class="linkedin-icon" aria-label="LinkedIn">
                        <?php
                        $linkedin = get_template_directory() . '/resources/images/icon-linkedin.svg';
                        if ( file_exists( $linkedin ) ) {
                            echo file_get_contents( $linkedin );
                        }
                        ?>
                    </a>
                </div>
            </div>

            <!-- ② Explore — second on mobile, last on desktop -->
            <div class="col-12 col-md-4 footer-col footer-col--last order-md-3">
                <p class="footer-heading caption-3">EXPLORE</p>
                <ul class="list-unstyled footer-links">
                    <li><a href="#" class="subheading-1">Our Projects</a></li>
                    <li><a href="#" class="subheading-1">Construction</a></li>
                    <li><a href="#" class="subheading-1">Service Department</a></li>
                    <li><a href="#" class="subheading-1">Fab Shop</a></li>
                    <li><a href="#" class="subheading-1">Sustainability</a></li>
                </ul>
            </div>

            <!-- ③ Subscribe + Logo — last on mobile, first on desktop -->
            <div class="col-12 col-md-4 footer-col footer-col--subscribe order-md-1">
                <!-- Mobile: subscribe first, logo last. Desktop: SCSS flex order pulls logo up -->
                <p class="footer-heading caption-3">SUBSCRIBE</p>
                <div class="footer-subscribe">
                    <input
                        type="email"
                        class="footer-subscribe__input"
                        placeholder="Email *"
                        aria-label="Email address"
                    >
                    <button
                        class="footer-subscribe__btn"
                        type="button"
                        aria-label="Subscribe"
                    >
                        <span aria-hidden="true">→</span>
                    </button>
                </div>
                <img
                    src="<?php echo esc_url( get_template_directory_uri() . '/resources/images/logo-appian.svg' ); ?>"
                    alt="Appian"
                    class="footer-logo"
                >
            </div>

        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
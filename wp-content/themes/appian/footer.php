<?php
/**
 * The template for displaying the footer
 *
 * @package Outside_Traineeship_Biolerplate
 */
?>

<footer id="colophon" class="site-footer custom-footer">
    <div class="container">
        <div class="footer-row">

            <!-- ① Address + Contact + LinkedIn — first on mobile, middle on desktop -->
            <div class="footer-col footer-col--address">

                <div class="footer-address-block">
                    <p class="footer-heading">ADDRESS</p>
                    <p class="footer-body-text">
                        Heffron Company, Inc.<br>
                        4940 Nicholson Ct Ste 100,<br>
                        Kensington, MD 20895
                    </p>
                </div>

                <div class="footer-contact-block">
                    <p class="footer-heading">CONTACT</p>
                    <p class="footer-body-text">
                        Phone: (301) 816-2088<br>
                        info@heffroncompany.com
                    </p>
                </div>

                <div class="footer-linkedin">
                    <a href="#" target="_blank" rel="noopener noreferrer" class="linkedin-icon" aria-label="LinkedIn">
                        <?php
                        $linkedin = get_template_directory() . '/resources/images/icon-linkedin.svg';
                        if ( file_exists( $linkedin ) ) echo file_get_contents( $linkedin );
                        ?>
                    </a>
                </div>

            </div>

            <!-- ② Explore — second on mobile, last on desktop -->
            <div class="footer-col footer-col--explore">
                <div class="footer-links-block">
                    <p class="footer-heading">EXPLORE</p>
                    <ul class="list-unstyled footer-links">
                        <li><a href="#">Our Projects</a></li>
                        <li><a href="#">Construction</a></li>
                        <li><a href="#">Service Department</a></li>
                        <li><a href="#">Fab Shop</a></li>
                        <li><a href="#">Sustainability</a></li>
                    </ul>
                </div>
            </div>

            <!-- ③ Subscribe + Logo — last on mobile, first on desktop -->
            <div class="footer-col footer-col--subscribe">
                <p class="footer-heading">SUBSCRIBE</p>
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
                        <?php
                        // Figma: arrow icon 14*14px — use icon-arrow-right.svg from style guide
                        $arrow = get_template_directory() . '/resources/images/icon-arrow-right.svg';
                        if ( file_exists( $arrow ) ) {
                            echo file_get_contents( $arrow );
                        } else {
                            // Fallback: inline SVG arrow matching Figma design (14*14)
                            echo '<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 7H13M13 7L7 1M13 7L7 13" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>';
                        }
                        ?>
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
<?php
// getting the footer field from option pages
$footer  = get_field('footer', 'option');

// for easy access of values, assigning the keys of footer to variable, since their values are also maps itself
$address = $footer['address'] ?? [];
$contact = $footer['contact'] ?? [];
$phone   = $footer['contact']['phone_number'] ?? [];
$explore = $footer['explore'] ?? [];
$logo    = $footer['logo'] ?? null;
?>


<!-- html for footer -->
<footer id="colophon" class="site-footer custom-footer">

    <div class="container">

        <div class="row">

            <!-- html for address and contact details  -->
            <div class="col-12 col-md-4 footer-col footer-col--address order-md-2">

            <!-- address details -->

            <!-- if all the subfields of address are empty don't render address at all -->
                <?php if (!empty($address['address_title']) || !empty($address['company_name']) || !empty($address['street_address']) ||!empty($address['city']) ||!empty($address['state_abbrevation']) || !empty($address['zip'])) : ?>

                    <!-- address heading -->
                    <p class="footer-heading caption-3">
                        <?php echo esc_html($address['address_title']); ?>
                    </p>

                    <!-- if not empty show company name -->
                    <p class="body body-medium">
                        <?php if (!empty($address['company_name'])) : ?>
                            <?php echo esc_html($address['company_name']); ?><br>
                        <?php endif; ?>

                        <!-- if not empty show company street address -->
                        <?php if (!empty($address['street_address'])) : ?>
                            <?php echo esc_html($address['street_address']); ?>,<br>
                        <?php endif; ?>

                        <!-- if city provided, show city and comma on the side -->
                        <?php if (!empty($address['city'])) : ?>
                            <?php echo esc_html($address['city']); ?>,
                        <?php endif?>
                        <!-- if state provided, showing it -->
                        <?php if (!empty($address['state_abbrevation'])) : ?>
                            <?php echo esc_html($address['state_abbrevation']); ?>
                        <?php endif?>
                        <!-- if zip provided, showing it -->
                        <?php if (!empty($address['zip'])) : ?>
                            <?php echo esc_html($address['zip']); ?>
                        <?php endif; ?>
                    </p>
                <?php endif; ?>


                <!--contact details -->

                <!-- if none of the contact details are provided, skipping this container -->
                <?php if (!empty($contact['contact_title']) || !empty($phone['phone_number']) || !empty($contact['email'])) : ?>
                    <!-- showing the contact heading -->
                    <p class="footer-heading caption-3 mt-8">
                        <?php echo esc_html($contact['contact_title']); ?>
                    </p>
                    <!-- showing the contact body which contains phone number label and phone number and mail address-->
                    <p class="body body-medium">

                        <!-- only showing phone number label if phone number is actually present -->
                        <?php if (!empty($phone['phone_number'])) : ?>
                            <?php echo esc_html($phone['phone_eyebrow']); ?>:
                            <?php echo esc_html($phone['phone_number']); ?><br>
                        <?php endif; ?>

                        <!-- shhowing email if provided -->
                        <?php if (!empty($contact['email'])) : ?>
                            <?php echo esc_html($contact['email']); ?>
                        <?php endif; ?>
                    </p>
                <?php endif; ?>


                <!-- linkedin url -->
                <?php if (!empty($footer['linkedin_url'])) : ?>
                    <div class="mt-8">
                        <a href="<?php echo esc_url($footer['linkedin_url']); ?>"
                            target="_blank" rel="noopener noreferrer"
                            class="linkedin-icon" aria-label="LinkedIn">
                            <?php
                            $linkedin_svg = get_template_directory() . '/resources/images/icon-linkedin.svg';
                            if (file_exists($linkedin_svg)) echo file_get_contents($linkedin_svg);
                            ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>  


            <!-- explore contianer -->
            <div class="col-12 col-md-4 footer-col footer-col--last order-md-3">

                <?php if (!empty($explore['explore_title'])) : ?>
                    <p class="footer-heading caption-3"><?php echo esc_html($explore['explore_title']); ?></p>
                <?php endif; ?>

                <?php if (!empty($explore['explore_items'])) : ?>
                    <ul class="list-unstyled footer-links">
                        <?php foreach ($explore['explore_items'] as $item) : ?>
                            <li>
                                <a href="<?php echo esc_url($item['explore_link'] ?? '#'); ?>" class="subheading-1">
                                    <?php echo esc_html($item['explore_label']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>


            <!-- subscribe section -->
            <div class="col-12 col-md-4 footer-col footer-col--subscribe order-md-1">
                <?php if (!empty($footer['subscribe'])) : ?>
                    <p class="footer-heading caption-3"><?php echo esc_html($footer['subscribe']); ?></p>
                <?php endif; ?>

                <div class="footer-subscribe">
                    <input type="email" class="footer-subscribe__input" placeholder="Email *" aria-label="Email address">
                    <button class="footer-subscribe__btn" type="button" aria-label="Subscribe">
                        <span aria-hidden="true">→</span>
                    </button>
                </div>

                <?php if (!empty($footer['thank_you_msg'])) : ?>
                    <p class="thank-you-msg" style="display:none;"><?php echo esc_html($footer['thank_you_msg']); ?></p>
                <?php endif; ?>

                <!--logo section -->
                <?php if (!empty($logo['url'])) : ?>
                    <img
                        src="<?php echo esc_url($logo['url']); ?>"
                        alt="<?php echo esc_attr($logo['alt'] ?? ''); ?>"
                        class="footer-logo">
                <?php endif; ?>
            </div>

        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>
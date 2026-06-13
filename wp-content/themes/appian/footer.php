<?php
$footer  = get_field('footer', 'option');

$address = $footer['address'] ?? [];
$contact = $footer['contact'] ?? [];
$phone   = $contact['phone_number'] ?? '';
$fax     = $contact['fax_number'] ?? [];
$explore = $footer['explore'] ?? [];
$logo    = $footer['logo'] ?? null;
?>

<footer class="custom-footer">
    <div class="row-wrapper container">
        <div class="row custom-footer__row">

            <div class="col-12 col-lg-4 custom-footer__col custom-footer__col--brand">

                <?php if (!empty($logo['url'])) : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="custom-footer__logo" aria-label="Go to homepage">
                        <img
                            src="<?php echo esc_url($logo['url']); ?>"
                            alt="<?php echo esc_attr($logo['alt'] ?? 'Logo'); ?>">
                    </a>
                <?php endif; ?>

                <div class="custom-footer__subscribe">
                    <?php if (!empty($footer['subscribe'])) : ?>
                        <label class="custom-footer__label" for="footer-email">
                            <?php echo esc_html($footer['subscribe']); ?>
                        </label>
                    <?php endif; ?>

                    <form class="custom-footer__form" novalidate>
                        <div class="custom-footer__input-group">
                            <input
                                id="footer-email"
                                type="email"
                                class="custom-footer__input"
                                placeholder="Email *"
                                aria-label="Email address for subscription"
                                required>
                            <button class="custom-footer__submit" type="submit" aria-label="Submit subscription">
                               <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M5 12H19M13 18L19 12L13 6" stroke="white" stroke-width="2" stroke-miterlimit="5.75877" stroke-linecap="square"/>
</svg>

                            </button>
                        </div>
                    </form>

                    <div class="custom-footer__input-error caption-3 pt-3" role="alert"></div>
                    <p class="custom-footer__thank-you"><?php echo !empty($footer['thank_you_msg']) ? esc_html($footer['thank_you_msg']) : 'THANK YOU FOR SUBSCRIPTION'; ?></p>
                </div>

            </div>

            <div class="col-12 col-lg-4 custom-footer__col custom-footer__col--contact">

                <?php if (!empty($address['address_title']) || !empty($address['company_name']) || !empty($address['street_address'])) : ?>
                    <div class="custom-footer__section custom-footer__section--address">
                        <span class="custom-footer__label">
                            <?php echo esc_html($address['address_title'] ?? 'Address'); ?>
                        </span>
                        <address class="custom-footer__text">
                            <?php if (!empty($address['company_name'])) : ?>
                                <?php echo esc_html($address['company_name']); ?><br>
                            <?php endif; ?>
                            <?php echo esc_html($address['street_address'] ?? ''); ?><br>
                            <?php echo esc_html($address['city'] ?? ''); ?>,
                            <?php echo esc_html($address['state_abbrevation'] ?? ''); ?>
                            <?php echo esc_html($address['zip'] ?? ''); ?>
                        </address>
                    </div>
                <?php endif; ?>

                <div class="custom-footer__section custom-footer__section--contact-info">
                    <span class="custom-footer__label">
                        <?php echo esc_html($contact['contact_title'] ?? 'Contact'); ?>
                    </span>
                    <p class="custom-footer__text">
                        <?php
                        $phone_label = $phone['phone_eyebrow'] ?? 'Phone';
                        $phone_str   = is_array($phone) ? ($phone['phone_number'] ?? '') : '';
                        if (!empty($phone_str)) :
                            $clean_phone  = preg_replace('/[^0-9]/', '', $phone_str);
                            $phone_output = strlen($clean_phone) === 10
                                ? '(' . substr($clean_phone, 0, 3) . ') ' . substr($clean_phone, 3, 3) . '-' . substr($clean_phone, 6)
                                : $phone_str;
                        ?>
                            <a href="tel:<?php echo esc_attr($clean_phone); ?>">
                                <?php echo esc_html($phone_label); ?>: <?php echo esc_html($phone_output); ?>
                            </a><br>
                        <?php endif; ?>

                        <?php
                        $fax_label  = $fax['fax_eyebrow'] ?? 'Fax';
                        $fax_number = is_array($fax) ? ($fax['fax_number'] ?? '') : '';
                        if (!empty($fax_number)) :
                            $clean_fax  = preg_replace('/[^0-9]/', '', $fax_number);
                            $fax_output = strlen($clean_fax) === 10
                                ? '(' . substr($clean_fax, 0, 3) . ') ' . substr($clean_fax, 3, 3) . '-' . substr($clean_fax, 6)
                                : $fax_number;
                        ?>
                            <a href="tel:<?php echo esc_attr($clean_fax); ?>">
                                <?php echo esc_html($fax_label); ?>: <?php echo esc_html($fax_output); ?>
                            </a><br>
                        <?php endif; ?>

                        <?php if (!empty($contact['email'])) : ?>
                            <a href="mailto:<?php echo esc_attr($contact['email']); ?>">
                                <?php echo esc_html($contact['email']); ?>
                            </a>
                        <?php endif; ?>
                    </p>
                </div>

                <?php if (!empty($footer['linkedin_url'])) : ?>
                    <a href="<?php echo esc_url($footer['linkedin_url']); ?>"
                       target="_blank" rel="noopener noreferrer"
                       class="custom-footer__social"
                       aria-label="Visit our LinkedIn page">
                        <img
                            src="<?php echo esc_url(get_template_directory_uri() . '/resources/images/icon-linkedin.svg'); ?>"
                            alt="LinkedIn"
                            width="24"
                            height="24">
                    </a>
                <?php endif; ?>

            </div>

            <?php if (!empty($explore['explore_items'])) : ?>
                <div class="col-12 col-lg-4 custom-footer__col custom-footer__col--nav">

                    <?php if (!empty($explore['explore_title'])) : ?>
                        <span class="custom-footer__label" id="footer-nav-label">
                            <?php echo esc_html($explore['explore_title']); ?>
                        </span>
                    <?php endif; ?>

                    <nav aria-labelledby="footer-nav-label">
                        <ul class="custom-footer__menu">
                            <?php foreach ($explore['explore_items'] as $item) : ?>
                                <li>
                                    <a href="<?php echo esc_url($item['explore_link']['url'] ?? '#'); ?>"
                                       <?php if (!empty($item['explore_link']['target'])) : ?>
                                           target="<?php echo esc_attr($item['explore_link']['target']); ?>"
                                       <?php endif; ?>
                                       class="custom-footer__link subheading-0">
                                        <?php echo esc_html($item['explore_label']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </nav>

                </div>
            <?php endif; ?>

        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
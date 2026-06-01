<?php
// getting the footer field from option pages
$footer  = get_field('footer', 'option');

// assigning the keys of footer to variables for clean access
$address = $footer['address'] ?? [];
$contact = $footer['contact'] ?? [];
$phone   = $contact['phone_number'] ?? ''; 
$explore = $footer['explore'] ?? [];
$logo    = $footer['logo'] ?? null;
?>

<footer id="colophon" class="site-footer custom-footer" role="contentinfo">
    <div class="container">
        <div class="row">

            <div class="col-12 col-md-4 footer-col footer-col--subscribe">
                <div class="footer-left-layout-engine">
                    
                    <?php if (!empty($logo['url'])) : ?>
                        <div class="footer-logo-wrapper">
                            <a href="<?php echo esc_url(home_url('/')); ?>" aria-label="Go to homepage">
                                <img
                                    src="<?php echo esc_url($logo['url']); ?>"
                                    alt="<?php echo esc_attr($logo['alt'] ?? 'Company Logo'); ?>"
                                    class="footer-logo">
                            </a>
                        </div>
                    <?php endif; ?>

                    <section class="footer-subscribe-wrapper" aria-label="Newsletter Subscription">
                        <?php if (!empty($footer['subscribe'])) : ?>
                            <p class="footer-heading label-text"><?php echo esc_html($footer['subscribe']); ?></p>
                        <?php endif; ?>

                        <div class="footer-subscribe">
                            <input type="email" class="footer-subscribe__input" placeholder="Email *" aria-label="Email address for subscription">
                            <button class="footer-subscribe__btn" type="button" aria-label="Submit subscription">
                                <svg class="subscribe-arrow-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </button>
                        </div>

                        <p class="thank-you-msg"><?php echo !empty($footer['thank_you_msg']) ? esc_html($footer['thank_you_msg']) : 'THANK YOU FOR SUBSCRIPTION'; ?></p>
                    </section>

                </div>
            </div>  

            <div class="col-12 col-md-4 footer-col footer-col--address">
                
                <?php if (!empty($address['address_title']) || !empty($address['company_name']) || !empty($address['street_address']) || !empty($address['city']) || !empty($address['state_abbrevation']) || !empty($address['zip'])) : ?>
                    <section class="footer-address-block" aria-label="<?php echo esc_attr($address['address_title']); ?>">
                        <p class="footer-heading">
                            <?php echo esc_html($address['address_title']); ?>
                        </p>

                        <p class="footer-content-serif">
                            <?php if (!empty($address['company_name'])) : ?>
                                <?php echo esc_html($address['company_name']); ?><br>
                            <?php endif; ?>

                            <?php if (!empty($address['street_address'])) : ?>
                                <?php echo rtrim(esc_html($address['street_address']), ','); ?><br>
                            <?php endif; ?>

                            <?php echo esc_html($address['city'] ?? ''); ?>, <?php echo esc_html($address['state_abbrevation'] ?? ''); ?> <?php echo esc_html($address['zip'] ?? ''); ?>
                        </p>
                    </section>
                <?php endif; ?>

                <section class="footer-contact-block" aria-label="Contact Information">
                    <p class="footer-heading">
                        <?php echo esc_html(!empty($contact['contact_title']) ? $contact['contact_title'] : 'CONTACT'); ?>
                    </p>
                    
                    <p class="footer-content-serif">
                        <?php 
                        // Safe extraction & output for Phone
                        $phone_str = is_array($phone) ? ($phone['phone_number'] ?? $phone['value'] ?? '') : $phone;
                        if (!empty($phone_str)) : 
                            $clean_phone = preg_replace('/[^0-9]/', '', $phone_str);
                            if (strlen($clean_phone) == 10) {
                                $phone_output = '(' . substr($clean_phone, 0, 3) . ') ' . substr($clean_phone, 3, 3) . '-' . substr($clean_phone, 6);
                            } else {
                                $phone_output = $phone_str;
                            }
                        ?>
                            Phone: <a href="tel:<?php echo esc_attr($clean_phone); ?>" class="footer-interactive-link">
                                <?php echo esc_html($phone_output); ?>
                            </a><br>
                        <?php endif; ?>

                        Fax: (301)-816-2177<br>

                        <?php if (!empty($contact['email'])) : ?>
                            <a href="mailto:<?php echo esc_attr($contact['email']); ?>" class="footer-interactive-link">
                                <?php echo esc_html($contact['email']); ?>
                            </a>
                        <?php endif; ?>
                    </p>
                </section>

                <div class="linkedin-wrapper">
                    <a href="<?php echo !empty($footer['linkedin_url']) ? esc_url($footer['linkedin_url']) : '#'; ?>"
                        target="_blank" rel="noopener noreferrer"
                        class="linkedin-link" aria-label="Visit our LinkedIn page">
                        <svg class="linkedin-icon-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path fill="#101922" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                    </a>
                </div>
            </div>  

            <nav class="col-12 col-md-4 footer-col footer-col--last" aria-label="Footer Navigation Links">
                <?php if (!empty($explore['explore_title'])) : ?>
                    <p class="footer-heading"><?php echo esc_html($explore['explore_title']); ?></p>
                <?php endif; ?>

                <?php if (!empty($explore['explore_items'])) : ?>
                    <ul class="list-unstyled footer-links">
                        <?php foreach ($explore['explore_items'] as $item) : ?>
                            <li>
                                <a href="<?php echo esc_url($item['explore_link'] ?? '#'); ?>" class="explore-link">
                                    <?php echo esc_html($item['explore_label']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </nav>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var subscribeBtn = document.querySelector('.footer-subscribe__btn');
            var subscribeWrapper = document.querySelector('.footer-subscribe-wrapper');
            var emailInput = document.querySelector('.footer-subscribe__input');

            if (subscribeBtn && subscribeWrapper && emailInput) {
                subscribeBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (emailInput.value.trim() !== "" && emailInput.checkValidity()) {
                        subscribeWrapper.classList.add('is-submitted');
                    } else {
                        emailInput.reportValidity();
                    }
                });
            }
        });
    </script>
</footer>

<?php wp_footer(); ?>
</body>
</html>
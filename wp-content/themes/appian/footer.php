<?php
$footer  = get_field('footer', 'option');

$address = $footer['address'] ?? [];
$contact = $footer['contact'] ?? [];
$phone  = $contact['phone_number'] ?? '';
$fax = $contact['fax_number'] ?? [];
$explore = $footer['explore'] ?? [];
$logo = $footer['logo'] ?? null;
?>

<footer id="colophon" class="site-footer custom-footer" role="contentinfo">
    <div class="footer-blueprint-container">
        <div class="footer-blueprint-row">

            <div class="footer-col footer-col--subscribe">
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

                        <form class="footer-subscribe" novalidate>
                            <input
                                type="email"
                                class="footer-subscribe__input"
                                placeholder="Email *"
                                aria-label="Email address for subscription"
                                required>
                            <button class="footer-subscribe__btn" type="submit" aria-label="Submit subscription">
                                <svg class="subscribe-arrow-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </button>
                        </form>

                        <p class="thank-you-msg"><?php echo !empty($footer['thank_you_msg']) ? esc_html($footer['thank_you_msg']) : 'THANK YOU FOR SUBSCRIPTION'; ?></p>
                    </section>

                </div>
            </div>

            <div class="footer-col footer-col--address">
                <div class="footer-middle-layout-engine">

                    <div class="footer-info-group">
                        <?php if (!empty($address['address_title']) || !empty($address['company_name']) || !empty($address['street_address']) || !empty($address['city']) || !empty($address['state_abbrevation']) || !empty($address['zip'])) : ?>
                            <section class="footer-address-block" aria-label="<?php echo esc_attr($address['address_title'] ?? 'Address'); ?>">
                                <p class="footer-heading">
                                    <?php echo esc_html($address['address_title'] ?? 'Address'); ?>
                                </p>

                                <div class="footer-content-serif">
                                    <?php if (!empty($address['company_name'])) : ?>
                                        <p class="company-name"><?php echo esc_html($address['company_name']); ?></p>
                                    <?php endif; ?>

                                    <p class="fax-text-muted">
                                        <?php if (!empty($address['street_address'])) : ?>
                                            <?php echo rtrim(esc_html($address['street_address']), ','); ?>,
                                        <?php endif; ?>
                                        <?php echo esc_html($address['city'] ?? ''); ?>, <?php echo esc_html($address['state_abbrevation'] ?? ''); ?> <?php echo esc_html($address['zip'] ?? ''); ?>
                                    </p>
                                </div>
                            </section>
                        <?php endif; ?>

                        <section class="footer-contact-block" aria-label="Contact Information">
                            <p class="footer-heading">
                                <?php echo esc_html(!empty($contact['contact_title']) ? $contact['contact_title'] : 'CONTACT'); ?>
                            </p>

                            <div class="footer-content-serif">
                                <?php
                                $phone_label = $phone['phone_eyebrow'] ?? 'Phone';
                                $phone_str = is_array($phone) ? ($phone['phone_number'] ?? '') : '';

                                if (!empty($phone_str)) :
                                    $clean_phone = preg_replace('/[^0-9]/', '', $phone_str);

                                    if (strlen($clean_phone) === 10) {
                                        $phone_output = '(' . substr($clean_phone, 0, 3) . ') ' . substr($clean_phone, 3, 3) . '-' . substr($clean_phone, 6);
                                    } else {
                                        $phone_output = $phone_str;
                                    }
                                ?>
                                    <p>
                                        <?php echo esc_html($phone_label); ?>:
                                        <a href="tel:<?php echo esc_attr($clean_phone); ?>" class="footer-interactive-link">
                                            <?php echo esc_html($phone_output); ?>
                                        </a>
                                    </p>
                                <?php endif; ?>

                                <?php
                                $fax_label = $fax['fax_eyebrow'] ?? 'Fax';
                                $fax_number = is_array($fax) ? ($fax['fax_number'] ?? '') : '';

                                if (!empty($fax_number)) :
                                    $clean_fax = preg_replace('/[^0-9]/', '', $fax_number);

                                    if (strlen($clean_fax) === 10) {
                                        $fax_output = '(' . substr($clean_fax, 0, 3) . ') ' . substr($clean_fax, 3, 3) . '-' . substr($clean_fax, 6);
                                    } else {
                                        $fax_output = $fax_number;
                                    }
                                ?>
                                    <!-- <p> cjhdcldsbhc -->
                                        <?php echo esc_html($fax_label); ?>:
                                        <a href="fax:<?php echo esc_attr($clean_fax); ?>"
                                            class="fax-text-muted footer-interactive-link">
                                            <?php echo esc_html($fax_output); ?>
                                        </a>
                                    </p>
                                <?php endif; ?>


        <?php if (!empty($contact['email'])) : ?>
            <p>
                <a href="mailto:<?php echo esc_attr($contact['email']); ?>" class="footer-interactive-link footer-email-link">
                    <?php echo esc_html($contact['email']); ?>
                </a>
            </p>
        <?php endif; ?>
    </div>
</section>
                    </div>

                    <div class="linkedin-wrapper">
                        <a href="<?php echo !empty($footer['linkedin_url']) ? esc_url($footer['linkedin_url']) : '#'; ?>"
                            target="_blank" rel="noopener noreferrer"
                            class="linkedin-link" aria-label="Visit our LinkedIn page">
                            <img
                                src="<?php echo esc_url(get_template_directory_uri() . '/resources/images/icon-linkedin.svg'); ?>"
                                alt="LinkedIn"
                                class="linkedin-icon-svg">
                        </a>
                    </div>

                    <div class="footer-layout-absorber"></div>
                </div>
            </div>

            <nav class="footer-col footer-col--last" aria-label="Footer Navigation Links">
                <div class="footer-right-layout-engine">
                    <?php if (!empty($explore['explore_title'])) : ?>
                        <p class="footer-heading"><?php echo esc_html($explore['explore_title']); ?></p>
                    <?php endif; ?>

                    <?php if (!empty($explore['explore_items'])) : ?>
                        <ul class="footer-links">
                            <?php foreach ($explore['explore_items'] as $item) : ?>
                                <li>
                                    <a href="<?php echo esc_url($item['explore_link'] ?? '#'); ?>" class="explore-link">
                                        <?php echo esc_html($item['explore_label']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </nav>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var subscribeForm = document.querySelector('.footer-subscribe');
            var subscribeWrapper = document.querySelector('.footer-subscribe-wrapper');
            var emailInput = document.querySelector('.footer-subscribe__input');

            var submittedEmails = ['test@heffroncompany.com', 'admin@heffroncompany.com'];

            if (subscribeForm && subscribeWrapper && emailInput) {
                subscribeForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    var emailValue = emailInput.value.trim().toLowerCase();

                    if (emailValue === "") {
                        alert("Error: Email field is required.");
                        emailInput.focus();
                        return;
                    }

                    if (!emailInput.checkValidity()) {
                        emailInput.reportValidity();
                        return;
                    }

                    var emailParts = emailValue.split('@');
                    var localPart = emailParts[0] || "";

                    if (localPart.length > 64) {
                        alert("Error: The local part of the email address (before the @ symbol) cannot exceed 64 characters.");
                        emailInput.focus();
                        return;
                    }

                    // Validate the complete email address limit (RFC specification)
                    if (emailValue.length > 254) {
                        alert("Error: The total email address cannot exceed 254 characters.");
                        emailInput.focus();
                        return;
                    }

                    if (submittedEmails.indexOf(emailValue) !== -1) {
                        alert("Error: This email address is already subscribed.");
                        emailInput.focus();
                        return;
                    }

                    submittedEmails.push(emailValue);
                    subscribeWrapper.classList.add('is-submitted');
                });
            }
        });
    </script>
</footer>

<?php wp_footer(); ?>
</body>

</html>
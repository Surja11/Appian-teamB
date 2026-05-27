<?php
$footer   = get_field('footer', 'option');
$address  = $footer['address'] ?? [];
$contact  = $footer['contact'] ?? [];
$explore  = $footer['explore'] ?? [];
$logo     = $footer['logo'] ?? null;

$phone_data = $contact['phone_number'] ?? [];
$fax_data   = $contact['fax_number'] ?? []; 

// Custom formatting helper functions
function format_custom_phone($number) {
    $clean = preg_replace('/[^0-9]/', '', $number);
    if (strlen($clean) === 10) {
        return '(' . substr($clean, 0, 3) . ') ' . substr($clean, 3, 3) . '-' . substr($clean, 6);
    }
    return $number;
}

function format_custom_fax($number) {
    $clean = preg_replace('/[^0-9]/', '', $number);
    if (strlen($clean) === 10) {
        return '(' . substr($clean, 0, 3) . ') -' . substr($clean, 3, 3) . '-' . substr($clean, 6);
    }
    return '(301) -816-2177'; 
}

// BULLETPROOF: Resolve if ACF fields are returning a Link Array or a clean String URL
$raw_linkedin = $contact['linkedin_url'] ?? $footer['linkedin_url'] ?? '';
$linkedin_url = '';

if (!empty($raw_linkedin)) {
    if (is_array($raw_linkedin) && isset($raw_linkedin['url'])) {
        $linkedin_url = $raw_linkedin['url'];
    } elseif (is_string($raw_linkedin)) {
        $linkedin_url = $raw_linkedin;
    }
}

// ULTIMATE FALLBACK: If your ACF field configuration is empty or broken, default to a safe value
if (empty($linkedin_url)) {
    $linkedin_url = 'https://www.linkedin.com';
}
?>

<footer id="colophon" class="site-footer custom-footer">

    <div class="site-footer__inner">

        <div class="site-footer__col site-footer__col--brand">

            <?php if (!empty($logo['url'])) : ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="site-footer__logo" aria-label="Home">
                    <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt'] ?? ''); ?>" />
                </a>
            <?php endif; ?>

            <div class="site-footer__subscribe">

                <div class="site-footer__subscribe-default">
                    <?php if (!empty($footer['subscribe'])) : ?>
                        <label class="site-footer__label c3">
                            <?php echo esc_html($footer['subscribe']); ?>
                        </label>
                    <?php endif; ?>

                    <form class="site-footer__form">
                        <div class="site-footer__input-group">
                            <input
                                type="email"
                                class="site-footer__input body"
                                placeholder="Email *"
                                aria-label="Email address">
                            <button type="button" class="site-footer__submit js-footer-subscribe" aria-label="Subscribe">
                                <img src="<?php echo get_template_directory_uri(); ?>/resources/images/icon-arrow-right.svg"
                                    alt="" aria-hidden="true" />
                            </button>
                        </div>
                    </form>
                </div>

                <div class="site-footer__subscribe-thankyou" hidden>
                    <span class="site-footer__label c3">
                        THANK YOU FOR SUBSCRIPTION
                    </span>
                </div>

            </div>

        </div>

        <div class="site-footer__col site-footer__col--contact">
            
            <div class="site-footer__contact-content">

                <div class="site-footer__section site-footer__section--address">
                    <?php if (!empty($address['address_title'])) : ?>
                        <span class="c3 site-footer__label">
                            <?php echo esc_html($address['address_title']); ?>
                        </span>
                    <?php endif; ?>

                    <address class="sh3 site-footer__text">
                        <?php if (!empty($address['company_name'])) : ?>
                            <?php echo esc_html($address['company_name']); ?><br>
                        <?php endif; ?>

                        <?php if (!empty($address['street_address'])) : ?>
                            <?php echo esc_html($address['street_address']); ?><br>
                        <?php endif; ?>

                        <?php
                        $csz = [];
                        if (!empty($address['city']))               $csz[] = $address['city'];
                        if (!empty($address['state_abbrevation']))  $csz[] = $address['state_abbrevation'];
                        if (!empty($address['zip']))                $csz[] = $address['zip'];
                        if (!empty($csz)) echo esc_html(implode(' ', $csz));
                        ?>
                    </address>
                </div>

                <div class="site-footer__section site-footer__section--contact-info">
                    <?php if (!empty($contact['contact_title'])) : ?>
                        <span class="c3 site-footer__label">
                            <?php echo esc_html($contact['contact_title']); ?>
                        </span>
                    <?php endif; ?>

                    <p class="sh3 site-footer__text">
                        <?php if (!empty($phone_data['phone_number'])) : ?>
                            Phone: <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone_data['phone_number'])); ?>">
                                <?php echo esc_html(format_custom_phone($phone_data['phone_number'])); ?>
                            </a><br>
                        <?php endif; ?>

                        <?php if (!empty($fax_data['fax_number'])) : ?>
                            Fax: <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $fax_data['fax_number'])); ?>">
                                <?php echo esc_html(format_custom_fax($fax_data['fax_number'])); ?>
                            </a><br>
                        <?php else: ?>
                            Fax: <a href="tel:3018162177">
                                (301) -816-2177
                            </a><br>
                        <?php endif; ?>

                        <?php if (!empty($contact['email'])) : ?>
                            <a href="mailto:<?php echo esc_attr($contact['email']); ?>">
                                <?php echo esc_html($contact['email']); ?>
                            </a>
                        <?php endif; ?>
                    </p>
                </div>

                <?php if (!empty($linkedin_url)) : ?>
                    <a class="site-footer__social"
                       href="<?php echo esc_url($linkedin_url); ?>"
                       target="_blank"
                       rel="noopener noreferrer"
                       aria-label="LinkedIn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="site-footer__social-icon">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                    </a>
                <?php endif; ?>

            </div>

        </div>

        <div class="site-footer__col site-footer__col--nav">

            <?php if (!empty($explore['explore_title'])) : ?>
                <span class="c3 site-footer__label">
                    <?php echo esc_html($explore['explore_title']); ?>
                </span>
            <?php endif; ?>

            <?php if (!empty($explore['explore_items'])) : ?>
                <ul class="site-footer__menu">
                    <?php foreach ($explore['explore_items'] as $item) : ?>
                        <li>
                            <a class="site-footer__link"
                               href="<?php echo esc_url($item['explore_link'] ?? '#'); ?>">
                                <?php echo esc_html($item['explore_label']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

        </div>

    </div>

</footer>

<script>
document.querySelector('.js-footer-subscribe')?.addEventListener('click', function () {
    const input = document.querySelector('.site-footer__input');
    if (input?.value && input.checkValidity()) {
        const subscribe = this.closest('.site-footer__subscribe');
        subscribe.querySelector('.site-footer__subscribe-default').hidden = true;
        subscribe.querySelector('.site-footer__subscribe-thankyou').hidden = false;
    }
});
</script>
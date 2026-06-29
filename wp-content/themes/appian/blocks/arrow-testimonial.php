<?php

$testimonial = get_field('arrow_testimonial');

if ($testimonial) {
    $person_image_desktop = $testimonial['person_image_desktop'] ?? null;
    $person_image_mobile  = $testimonial['person_image_mobile']  ?? null;
    $arrow_color = $testimonial['arrow_color'] ?? '#ea483b';
    $person_name = $testimonial['person_name'] ?? '';
    $person_title = $testimonial['person_title'] ?? '';
    $person_company = $testimonial['person_company'] ?? '';
    $quote = $testimonial['quote'] ?? '';
    $bg_color = $testimonial['bg_color']             ?? '#ea483b';
} else {
    $person_image_desktop = get_field('person_image_desktop');
    $person_image_mobile  = get_field('person_image_mobile');
    $arrow_color = get_field('arrow_color')  ?: '#ea483b';
    $person_name = get_field('person_name');
    $person_title = get_field('person_title');
    $person_company = get_field('person_company');
    $quote = get_field('quote');
    $bg_color = get_field('bg_color') ?: '#ea483b';
} 

$person_image_mobile = $person_image_mobile ?: $person_image_desktop;

$arrow_svg = file_get_contents(get_template_directory() . '/resources/images/testimonial-arrow.svg');
$arrow_svg = str_replace('fill="#F3BABC"', 'fill="currentColor"', $arrow_svg);
?>

<section class="c-testimonial overflow-visible">

    <div class="c-testimonial__colored-bg position-relative w-100 z-1" style="background-color: <?php echo esc_attr($bg_color); ?>;"></div>

    <?php if ($person_image_desktop || $person_image_mobile) :
        $desktop_url = $person_image_desktop ? esc_url($person_image_desktop['url']) : '';
        $desktop_alt = $person_image_desktop ? esc_attr($person_image_desktop['alt']) : '';
        $mobile_url  = $person_image_mobile  ? esc_url($person_image_mobile['url'])  : $desktop_url;
        $mobile_alt  = $person_image_mobile  ? esc_attr($person_image_mobile['alt'])  : $desktop_alt;
    ?>
        <div class="c-testimonial__person-wrap position-relative z-2 w-100 d-flex flex-column align-items-center">

            <picture>
                <?php if ($person_image_desktop) : ?>
                    <source media="(min-width: 768px)" srcset="<?php echo $desktop_url; ?>">
                <?php endif; ?>
                <img
                    src="<?php echo $mobile_url; ?>"
                    alt="<?php echo $mobile_alt; ?>"
                    class="c-testimonial__person-img d-block object-fit-cover" loading="lazy" />
            </picture>

            <?php if ($person_name || $person_title || $person_company) : ?>
                <div class="c-testimonial__label-wrap position-absolute d-flex flex-column justify-content-center align-items-center z-3 flex-md-column-reverse">

                    <p class="c-testimonial__name body body-large text-center">
                        <?php if ($person_name) : ?>
                            <?php echo esc_html($person_name); ?>
                            <?php if ($person_title || $person_company) : ?>,<?php endif; ?>
                        <?php endif; ?>
                        <?php if ($person_title) : ?>
                            <?php echo esc_html($person_title); ?>
                        <?php endif; ?>
                        <?php if ($person_company) : ?>
                            <?php echo esc_html($person_company); ?>
                        <?php endif; ?>
                    </p>
                    <span
                        class="c-testimonial__arrow"
                        style="color: <?php echo esc_attr($arrow_color); ?>;"
                        aria-hidden="true">
                        <?php echo $arrow_svg; ?>
                    </span>
                </div>
            <?php endif; ?>

        </div>
    <?php endif; ?>

    <?php if ($quote) : ?>
        <div class="c-testimonial__quote-wrap position-relative z-3">
            <blockquote
                class="c-testimonial__quote d-flex flex-column justify-content-center align-items-center"
                style="background-image: url('<?php echo get_template_directory_uri(); ?>/resources/images/testimonial-arrow-background.png');">
                <p class="c-testimonial__quote-text body body-large">
                    <?php echo wp_kses_post($quote); ?>
                </p>
            </blockquote>
        </div>
    <?php endif; ?>

</section>
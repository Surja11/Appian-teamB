<?php

$testimonial = get_field('arrow_testimonial');

if ($testimonial) {
    $person_image = $testimonial['person_image'] ?? null;
    $person_name = $testimonial['person_name'] ?? '';
    $person_title = $testimonial['person_title'] ?? '';
    $person_company = $testimonial['person_company'] ?? '';
    $quote = $testimonial['quote'] ?? '';
    $bg_color = $testimonial['bg_color'] ?? '#ea483b';
    $arrow_color = $testimonial['arrow_color'] ?? '#ea483b';
} else {
    $person_image = get_field('person_image');
    $person_name = get_field('person_name');
    $person_title = get_field('person_title');
    $person_company = get_field('person_company');
    $quote = get_field('quote');
    $bg_color = get_field('bg_color') ?: '#ea483b';
    $arrow_color = get_field('arrow_color') ?: '#ea483b';
}

$arrow_svg = file_get_contents(get_template_directory() . '/resources/images/testimonial-arrow.svg');
$arrow_svg = str_replace('fill="#F3BABC"', 'fill="currentColor"', $arrow_svg);
?>

<section class="c-testimonial overflow-visible">

    <div class="c-testimonial__colored-bg position-relative w-100 z-1" style="background-color: <?php echo esc_attr($bg_color); ?>;"></div>

    <?php if ($person_image) : ?>
        <div class="c-testimonial__person-wrap position-relative z-2 w-100 d-flex flex-column align-items-center">


            <img
                src="<?php echo esc_url($person_image['url']); ?>"
                alt="<?php echo esc_attr($person_image['alt']); ?>"
                class="c-testimonial__person-img d-block object-fit-cover " />


            <?php if ($person_name || $person_title || $person_company) : ?>
                <div class="c-testimonial__label-wrap position-absolute d-flex flex-column justify-content-center align-items-center z-3 flex-md-column-reverse">

                    <p class="c-testimonial__name body body-large text-center">
                        <?php if ($person_name) : ?>
                            <?php echo esc_html($person_name); ?>
                            <?php if ($person_title || $person_company) : ?>,<?php endif; ?>
                        <?php endif; ?>
                        <?php if ($person_title) : ?>
                            <?php echo esc_html($person_title); ?>
                            <?php if ($person_company) : ?><?php endif; ?>
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
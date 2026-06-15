<?php
/**
 * Arrow Testimonial
 * blocks/arrow-testimonial.php
 */

$testimonial = get_field('arrow_testimonial');

if ($testimonial) {
    $person_image   = $testimonial['person_image'] ?? null;
    $person_name    = $testimonial['person_name'] ?? '';
    $person_title   = $testimonial['person_title'] ?? '';
    $person_company = $testimonial['person_company'] ?? '';
    $quote          = $testimonial['quote'] ?? '';
    $bg_color       = $testimonial['bg_color'] ?? 'primary';
    $arrow_color    = $testimonial['arrow_color'] ?? 'primary';
} else {
    $person_image   = get_field('person_image');
    $person_name    = get_field('person_name');
    $person_title   = get_field('person_title');
    $person_company = get_field('person_company');
    $quote          = get_field('quote');
    $bg_color       = get_field('bg_color') ?: 'primary';
    $arrow_color    = get_field('arrow_color') ?: 'primary';
}

$arrow_svg = file_get_contents(get_template_directory() . '/resources/images/testimonial-arrow.svg');
$arrow_svg = str_replace('fill="#F3BABC"', 'fill="currentColor"', $arrow_svg);
?>

<section class="c-testimonial">

    <div class="c-testimonial__colored-bg bg-<?php echo esc_attr($bg_color); ?>"></div>

    <?php if ($person_image) : ?>
    <div class="c-testimonial__person-wrap">

        <img
            src="<?php echo esc_url($person_image['url']); ?>"
            alt="<?php echo esc_attr($person_image['alt']); ?>"
            class="c-testimonial__person-img"
        />

        <?php if ($person_name || $person_title || $person_company) : ?>
        <div class="c-testimonial__label-wrap">
            <p class="c-testimonial__name">
                <?php if ($person_name) : ?>
                    <?php echo esc_html($person_name); ?>
                    <?php if ($person_title || $person_company) : ?>,<br><?php endif; ?>
                <?php endif; ?>
                <?php if ($person_title) : ?>
                    <?php echo esc_html($person_title); ?>
                    <?php if ($person_company) : ?><br><?php endif; ?>
                <?php endif; ?>
                <?php if ($person_company) : ?>
                    <?php echo esc_html($person_company); ?>
                <?php endif; ?>
            </p>
            <span
                class="c-testimonial__arrow text-<?php echo esc_attr($arrow_color); ?>"
                aria-hidden="true"
            >
                <?php echo $arrow_svg; ?>
            </span>
        </div>
        <?php endif; ?>

    </div>
    <?php endif; ?>

    <?php if ($quote) : ?>
    <div class="c-testimonial__quote-wrap">
        <blockquote
            class="c-testimonial__quote"
            style="background-image: url('<?php echo get_template_directory_uri(); ?>/resources/images/testimonial-arrow-background.png');"
        >
            <p class="c-testimonial__quote-text">
                <?php echo wp_kses_post($quote); ?>
            </p>
        </blockquote>
    </div>
    <?php endif; ?>

</section>
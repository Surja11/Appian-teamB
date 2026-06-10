<?php
$logo_1       = get_field('testimonial_logo_1');
$logo_2       = get_field('testimonial_logo_2');
$testimonials = get_field('testimonials');

if (empty($testimonials) || !is_array($testimonials)) return;

$total = count($testimonials);

if (!function_exists('testimonial_render_logo')) :
function testimonial_render_logo($image) {
    if (empty($image)) return;
    $file_path = get_attached_file($image['ID']);
    if ($file_path && file_exists($file_path) && pathinfo($file_path, PATHINFO_EXTENSION) === 'svg') {
        echo file_get_contents($file_path);
        return;
    }
    echo '<img src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '">';
}
endif;
?>

<section class="testimonial-section">

    <!-- MOBILE: shown only below lg -->
    <div class="testimonial-card d-lg-none position-relative">
        <div class="testimonial-line"></div>

        <div class="swiper testimonial-swiper-mobile">
            <div class="swiper-wrapper">
                <?php foreach ($testimonials as $slide) : ?>
                <div class="swiper-slide">
                    <div class="quote-icon-wrapper">
                        <?php include get_template_directory() . '/resources/images/icon-quote.svg'; ?>
                    </div>
                    <h5>"<?php echo wp_kses_post($slide['quote']); ?>"</h5>
                    <div class="author-meta">
                        <h4 class="caption-2"><?php echo esc_html($slide['author_name']); ?></h4>
                        <p class="caption-2"><?php echo esc_html($slide['author_company']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="slider-controls d-flex">
            <button class="slider-btn btn-prev-mobile" aria-label="Previous slide">
                <img src="<?php echo get_template_directory_uri(); ?>/resources/images/icon-arrow-left.svg" alt="" width="14" height="14">
            </button>
            <button class="slider-btn btn-next-mobile" aria-label="Next slide">
                <img src="<?php echo get_template_directory_uri(); ?>/resources/images/icon-arrow-right.svg" alt="" width="14" height="14">
            </button>
        </div>
    </div>

    <!-- DESKTOP: shown only at lg and above -->
    <div class="container d-none d-lg-block">
        <div class="row">

            <div class="col-lg-6 testimonial-left">
                <div class="testimonial-logo">
                    <?php testimonial_render_logo($logo_1); ?>
                    <?php testimonial_render_logo($logo_2); ?>
                </div>
                <div class="testimonial-line"></div>
            </div>

            <div class="col-lg-6 testimonial-right">
                <div class="swiper testimonial-swiper-desktop">
                    <div class="swiper-wrapper">
                        <?php foreach ($testimonials as $slide) : ?>
                        <div class="swiper-slide">
                            <div class="quote-icon-wrapper">
                                <?php include get_template_directory() . '/resources/images/icon-quote.svg'; ?>
                            </div>
                            <h5>"<?php echo wp_kses_post($slide['quote']); ?>"</h5>
                            <div class="author-meta">
                                <h4 class="caption-2"><?php echo esc_html($slide['author_name']); ?></h4>
                                <p class="caption-2"><?php echo esc_html($slide['author_company']); ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="slider-progress d-flex">
                    <span class="progress-current">01</span>
                    <div class="progress-bar-wrapper">
                        <div class="progress-bar-fill"></div>
                    </div>
                    <span class="progress-total"><?php echo str_pad($total, 2, '0', STR_PAD_LEFT); ?></span>
                </div>
            </div>

        </div>
    </div>

</section>
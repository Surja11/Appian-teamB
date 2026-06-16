<?php
$testimonials = get_field('testimonials');

if (empty($testimonials) || !is_array($testimonials)) return;

$total = count($testimonials);

if (!function_exists('testimonial_render_logo')) :
function testimonial_render_logo($image, $class = '') {
    if (empty($image)) return;
    $file_path = get_attached_file($image['ID']);
    $extra_class = $class ? ' class="' . esc_attr($class) . '"' : '';
    
    if ($file_path && file_exists($file_path) && pathinfo($file_path, PATHINFO_EXTENSION) === 'svg') {
        echo '<div' . $extra_class . '>' . file_get_contents($file_path) . '</div>';
        return;
    }
    echo '<img src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '"' . $extra_class . '>';
}
endif;
?>

<section class="testimonial-section">
    <div class="container">
        <div class="testimonial-wrapper">
            
            <div class="swiper testimonial-swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($testimonials as $slide) : ?>
                    <div class="swiper-slide" role="tabpanel" aria-label="Testimonial slide">
                        <div class="testimonial-inner">
                            
                            <div class="testimonial-line-col d-lg-none">
                                <div class="testimonial-line"></div>
                            </div>
                            
                            <div class="testimonial-left-block d-none d-lg-block">
                                <div class="testimonial-logo-wrapper">
                                    <?php
                                    if (!empty($slide['title_logo'])) { testimonial_render_logo($slide['title_logo'], 'logo-title'); }
                                    if (!empty($slide['icon_logo']))  { testimonial_render_logo($slide['icon_logo'],  'logo-icon');  }
                                    ?>
                                </div>
                                <div class="testimonial-slide-divider"></div>
                            </div>
                            
                            <div class="testimonial-content">
                                <div class="quote-icon-wrapper">
                                    <?php include get_template_directory() . '/resources/images/icon-quote.svg'; ?>
                                </div>
                                <h5><?php echo wp_kses_post($slide['quote']); ?></h5>
                                <div class="author-meta">
                                    <span class="caption-2 d-block"><?php echo esc_html($slide['author_name']); ?></span>
                                    <span class="body-small-all d-block text-neutral-200"><?php echo esc_html($slide['author_company']); ?></span>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="slider-controls d-lg-none">
                <button class="btn btn-primary btn-slider-nav btn-prev" aria-label="Previous slide">
                    <img src="<?php echo get_template_directory_uri(); ?>/resources/images/icon-arrow-left.svg" alt="" width="14" height="14">
                </button>
                <button class="btn btn-primary btn-slider-nav btn-next" aria-label="Next slide">
                    <img src="<?php echo get_template_directory_uri(); ?>/resources/images/icon-arrow-right.svg" alt="" width="14" height="14">
                </button>
            </div>
        </div>
        <div class="slider-progress-wrapper d-none d-lg-flex justify-content-end">
            <div class="slider-progress d-flex align-items-center">
                <span class="progress-current body-large">01</span>
                <div class="progress-bar-wrapper">
                    <div class="progress-bar-fill"></div>
                </div>
                <span class="progress-total body-large"><?php echo str_pad($total, 2, '0', STR_PAD_LEFT); ?></span>
            </div>
        </div>
    </div>
</section>
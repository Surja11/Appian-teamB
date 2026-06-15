<?php

$marquee_heading = get_field('marquee_heading') ?: __('Trusted By', 'outside-traineeship-biolerplate');
?>

<section class="logo-marquee overflow-hidden pt-6 pb-6">
    <div class="logo-marquee__track">
        <div class="logo-marquee__inner d-flex align-items-center">
            <div class="logo-marquee__container d-flex flex-nowrap flex-shrink-0 align-items-center gap-4 gap-lg-18 pe-4 pe-lg-20">
                
                <?php if (!empty($marquee_heading)) : ?>
                    <h5 class="mb-0 text-nowrap flex-shrink-0"><?php echo esc_html($marquee_heading); ?></h5>
                <?php endif; ?>

                <div class="logo-container d-flex align-items-center justify-content-center flex-shrink-0 gap-4 gap-lg-20">
                    <?php if (have_rows('logo_loop')) : ?>
                        <?php while (have_rows('logo_loop')) : the_row(); 
                            $source_type = get_sub_field('logo_source_type');
                            $image_src   = '';
                            $image_alt   = get_sub_field('logo_alt_text') ?: '';

                            if ($source_type === 'upload') {
                                $image_array = get_sub_field('logo_image_file');
                                if (!empty($image_array)) {
                                    $image_src = $image_array['url'];
                                    if (empty($image_alt)) {
                                        $image_alt = !empty($image_array['alt']) ? $image_array['alt'] : $image_array['title'];
                                    }
                                }
                            } else {
                                $image_src = get_sub_field('logo_image_url');
                            }

                            if (empty($image_src)) {
                                continue;
                            }
                        ?>
                            <div class="logo-item d-flex align-items-center justify-content-center">
                                <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                            </div>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <div class="logo-item d-flex align-items-center justify-content-center">
                            <span style="opacity: 0.5; font-size: 0.85rem;"><?php esc_html_e('[Add logos in the sidebar]', 'outside-traineeship-biolerplate'); ?></span>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</section>
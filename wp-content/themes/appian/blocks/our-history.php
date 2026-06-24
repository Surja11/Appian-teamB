<?php

$history_items = get_field( 'history_items' );

if ( ! function_exists( 'our_history_get_excerpt' ) ) :
    function our_history_get_excerpt( $html_content, $word_limit = 999 ) {
        $plain = wp_strip_all_tags( $html_content );
        return $plain;
    }
endif;
?>

<?php if ( $history_items ) : ?> 
<section id="our-history-block" class="our-history-block position-relative w-100 overflow-hidden bg-white h-auto my-0 mx-auto">
    <div class="our-history-block__overlay position-absolute top-0 start-0 end-0 bottom-0"></div>
    <div class="our-history-block__texture position-absolute top-0 start-0 end-0 bottom-0" style="background-image: url('/wp-content/themes/appian/resources/images/bg-texture.png'); background-repeat: repeat; opacity: 0.3; pointer-events: none; z-index: 1;"></div>
    
    <div class="our-history__header text-center w-100 mx-auto">
        <h2 class="our-history__title h2 position-relative">Our History</h2>
    </div>

    <div class="our-history__timeline w-100 p-0">
        <div class="timeline-scroll-container overflow-auto">
            <div class="timeline-cards-wrapper d-flex flex-column flex-sm-row align-items-center align-items-sm-start">
                
                <?php foreach ( (array) $history_items as $index => $item ) :
                    // Safely extract data with fallbacks
                    $year    = !empty( $item['title'] ) ? esc_html( $item['title'] ) : '';
                    $content = !empty( $item['content'] ) ? $item['content'] : '';
                    $image   = !empty( $item['feature_image'] ) ? $item['feature_image'] : null;
                    $img_url = $image ? esc_url( $image['url'] ) : '';
                    $img_alt = $image && !empty( $image['alt'] ) ? esc_attr( $image['alt'] ) : ($year ? esc_attr( $year ) : 'History image');
                    $excerpt = $content ? our_history_get_excerpt( $content ) : '';
                    $gallery = !empty( $item['image_gallery'] ) ? $item['image_gallery'] : [];
                    
                    // Skip completely empty items
                    if (empty($year) && empty($content) && empty($img_url) && empty($gallery)) {
                        continue;
                    }
                    
                    // Generate unique ID for modal
                    $unique_id = $year ? $year : 'item-' . ($index + 1);
                ?>

                <!-- History Item <?php echo $year ? $year : 'Item ' . ($index + 1); ?> -->
                <div class="history-card mb-16 mb-sm-0 border-0 overflow-hidden shadow-none position-relative cursor-pointer bg-transparent flex-shrink-0 h-auto p-0 focus-ring-0" 
                     data-year="<?php echo esc_attr($unique_id); ?>" 
                     tabindex="0" 
                     role="button" 
                     aria-label="View details for <?php echo $year ? esc_attr($year) : 'history item'; ?>">
                    
                    <!-- Year/Title - Only show if exists -->
                    <?php if ( $year ) : ?>
                    <div class="history-card__year body-xlarge mb-6 text-start text-md-start d-flex align-items-center justify-content-start justify-content-md-start position-relative bg-transparent top-0 start-0 z-3"><?php echo $year; ?></div>
                    <?php endif; ?>
                    
                    <!-- Image Section - Only show if image exists -->
                    <?php if ( $img_url ) : ?>
                    <div class="history-card__image-wrapper position-relative overflow-hidden w-100">
                        <img src="<?php echo $img_url; ?>" 
                             alt="<?php echo $img_alt; ?>" 
                             class="history-card__image w-100 h-100 object-fit-cover d-block" />
                    </div>
                    <?php endif; ?>

                    <!-- Gallery Section - Only show if gallery exists -->
                    <?php if ( !empty( $gallery ) ) : ?>
                    <div class="history-card__gallery d-none">
                        <?php foreach ( $gallery as $gallery_image ) : ?>
                            <?php if ( !empty( $gallery_image['url'] ) ) : ?>
                            <div class="history-card__gallery-item">
                                <img src="<?php echo esc_url( $gallery_image['url'] ); ?>"
                                     alt="<?php echo !empty( $gallery_image['alt'] ) ? esc_attr( $gallery_image['alt'] ) : esc_attr( $year ); ?>"
                                     class="history-card__gallery-image w-100 h-100 object-fit-cover" />
                            </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Content Section - Only show if content exists -->
                    <?php if ( $content ) : ?>
                    <div class="history-card__content pt-6 pt-md-8 bg-transparent d-sm-flex flex-sm-column h-sm-100">
                        <p class="history-card__excerpt body mb-10 mb-md-5 d-block">
                            <?php echo esc_html( $excerpt ); ?>
                        </p>
                        <!-- Hidden full content for modal -->
                        <div class="history-card__full-content d-none">
                            <?php echo wp_kses_post( $content ); ?>
                        </div>
                        <button class="btn btn-link btn-primary history-card__read-more body-xsmall d-md-none text-decoration-none border-0 cursor-pointer text-start overflow-hidden bg-transparent text-nowrap" 
                                data-history-id="<?php echo esc_attr($unique_id); ?>"
                                >
                            Continue Reading
                        </button>
                        <button class="btn btn-link btn-primary history-card__read-more body-small d-none d-md-inline text-decoration-none border-0 cursor-pointer text-start overflow-hidden bg-transparent text-nowrap" 
                                data-history-id="<?php echo esc_attr($unique_id); ?>"
                                >
                            Continue Reading
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
                 
                <?php if ( $index < count( $history_items ) - 1 ) : ?>
                <div class="timeline-divider d-none d-sm-block flex-shrink-0" aria-hidden="true"></div>
                <?php endif; ?>

                <?php endforeach; ?>

            </div>
        </div>

        <div class="our-history__navigation mt-8 mb-8 mt-md-12 mb-md-20 gap-4 d-none d-sm-flex justify-content-start align-items-center w-100 mx-auto ps-6 ps-sm-10 ps-md-15 ps-lg-20 ps-xl-20 pe-6 pe-sm-10 pe-md-15 pe-lg-20 pe-xl-20">
            <button class="btn-nav btn-primary history-nav--prev border-0 cursor-pointer d-flex align-items-center justify-content-center" type="button" aria-label="Previous timeline entries">
                <?php include get_template_directory() . '/resources/images/icon-arrow-left.svg'; ?>
            </button>
            <button class="btn-nav btn-primary history-nav--next border-0 cursor-pointer d-flex align-items-center justify-content-center" type="button" aria-label="Next timeline entries">
                <?php include get_template_directory() . '/resources/images/icon-arrow-right.svg'; ?>
            </button>
        </div>
    </div>

    <?php get_template_part('template-parts/history-modal'); ?>

</section>
<?php endif; ?>
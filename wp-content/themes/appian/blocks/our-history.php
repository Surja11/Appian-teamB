<?php

$history_items = get_field( 'history_items' );

if ( ! function_exists( 'our_history_get_excerpt' ) ) :
    function our_history_get_excerpt( $html_content, $word_limit = 55 ) {
        $plain = wp_strip_all_tags( $html_content );
        $words = explode( ' ', trim( $plain ) );
        if ( count( $words ) <= $word_limit ) {
            return $plain;
        }
        return implode( ' ', array_slice( $words, 0, $word_limit ) ) . '…';
    }
endif;
?>

<?php if ( $history_items ) : ?> 
<section id="our-history-block" class="our-history-block">
    <div class="our-history-block__overlay"></div>
    
    <div class="our-history__header text-center">
        <h2 class="our-history__title">Our History</h2>
    </div>

    <div class="our-history__timeline">
        <div class="timeline-scroll-container">
            <div class="timeline-cards-wrapper">
                
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
                <div class="history-card" data-year="<?php echo esc_attr($unique_id); ?>">
                    
                    <!-- Year/Title - Only show if exists -->
                    <?php if ( $year ) : ?>
                    <div class="history-card__year"><?php echo $year; ?></div>
                    <?php endif; ?>
                    
                    <!-- Image Section - Only show if image exists -->
                    <?php if ( $img_url ) : ?>
                    <div class="history-card__image-wrapper">
                        <img src="<?php echo $img_url; ?>" 
                             alt="<?php echo $img_alt; ?>" 
                             class="history-card__image" />
                    </div>
                    <?php endif; ?>

                    <!-- Gallery Section - Only show if gallery exists -->
                    <?php if ( !empty( $gallery ) ) : ?>
                    <div class="history-card__gallery">
                        <?php foreach ( $gallery as $gallery_image ) : ?>
                            <?php if ( !empty( $gallery_image['url'] ) ) : ?>
                            <div class="history-card__gallery-item">
                                <img src="<?php echo esc_url( $gallery_image['url'] ); ?>"
                                     alt="<?php echo !empty( $gallery_image['alt'] ) ? esc_attr( $gallery_image['alt'] ) : esc_attr( $year ); ?>"
                                     class="history-card__gallery-image" />
                            </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Content Section - Only show if content exists -->
                    <?php if ( $content ) : ?>
                    <div class="history-card__content">
                        <p class="history-card__excerpt">
                            <?php echo esc_html( $excerpt ); ?>
                        </p>
                        <!-- Hidden full content for modal -->
                        <div class="history-card__full-content" style="display: none;">
                            <?php echo wp_kses_post( $content ); ?>
                        </div>
                        <button class="btn btn-link history-card__read-more" 
                                data-history-id="<?php echo esc_attr($unique_id); ?>"
                                >
                            Continue Reading
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
                 
                <?php if ( $index < count( $history_items ) - 1 ) : ?>
                <div class="timeline-divider" aria-hidden="true"></div>
                <?php endif; ?>

                <?php endforeach; ?>

            </div>
        </div>

        <div class="our-history__navigation">
            <button class="btn-nav btn-nav--arrow history-nav--prev" type="button" aria-label="Previous timeline entries">
                <?php include get_template_directory() . '/resources/images/icon-arrow-left.svg'; ?>
            </button>
            <button class="btn-nav btn-nav--arrow history-nav--next" type="button" aria-label="Next timeline entries">
                <?php include get_template_directory() . '/resources/images/icon-arrow-right.svg'; ?>
            </button>
        </div>
    </div>

    <?php get_template_part('template-parts/history-modal'); ?>

</section>
<?php endif; ?>
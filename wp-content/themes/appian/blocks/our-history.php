<?php
/**
 * Our History Block - Backend (ACF Field Group Registration)
 *
 * Registers an ACF field group with a repeater field containing:
 * - title 
 * - content 
 * - feature_image 
 *
 * The repeater rows map directly to the history cards below.
 */

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


// Fetch ACF repeater rows (works in block, template-part, or shortcode) 
$history_items = get_field( 'history_items' );


?>

<?php
/**
 * Our History Block  - Frontend
 */
?>
<?php if ( $history_items ) : ?> 

<section id="our-history-block" class="our-history-block">
    <!-- Section Header -->
    <div class="our-history__header text-center">
        <h2 class="our-history__title">Our History</h2>
    </div>

    <!-- History Timeline -->
    <div class="our-history__timeline">
        <div class="timeline-scroll-container">
            <div class="timeline-cards-wrapper">
                
                <?php foreach ( (array) $history_items as $index => $item ) :

                    $year    = esc_html( $item['title'] );
                    $content = $item['content'];
                    $image   = $item['feature_image'];
                    $img_url = $image ? esc_url( $image['url'] )  : '';
                    $img_alt = $image ? esc_attr( $image['alt'] ) : esc_attr( $year );
                    $excerpt = our_history_get_excerpt( $content );
                    $gallery = ! empty( $item['image_gallery'] ) ? $item['image_gallery'] : [];

                ?>

                <!-- History Item <?php echo $year; ?> -->
                 <?php if ( $year ) : ?>
                <div class="history-card" data-year="<?php echo $year; ?>">
                    <?php endif; ?>
                    <div class="history-card__year"><?php echo $year; ?></div>
                    <div class="history-card__image-wrapper">
                        <?php if ( $img_url ) : ?>
                        <img src="<?php echo $img_url; ?>" 
                             alt="<?php echo $img_alt; ?>" 
                             class="history-card__image" />
                        <?php endif; ?>
                    </div>

                     <?php if ( ! empty( $gallery ) ) : ?>
                    <div class="history-card__gallery">
                        <?php foreach ( $gallery as $gallery_image ) : ?>
                        <div class="history-card__gallery-item">
                            <img src="<?php echo esc_url( $gallery_image['url'] ); ?>"
                                 alt="<?php echo ! empty( $gallery_image['alt'] ) ? esc_attr( $gallery_image['alt'] ) : esc_attr( $year ); ?>"
                                 class="history-card__gallery-image" />
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

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
                                data-history-id="<?php echo $year; ?>"
                                data-bs-toggle="modal" 
                                data-bs-target="#historyModal">
                            Continue Reading
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
                 
                <?php if ( $index < count( $history_items ) - 1 ) : ?>
                <!-- Divider Line <?php echo $index + 1; ?> -->
                <div class="timeline-divider" aria-hidden="true"></div>
                <?php endif; ?>

                <?php endforeach; ?>

            </div>
        </div>

        <!-- Navigation Arrows -->
        <div class="our-history__navigation">
            <button class="btn-nav btn-nav--arrow history-nav--prev" type="button" aria-label="Previous timeline entries">
                <?php include get_template_directory() . '/resources/images/icon-arrow-left.svg'; ?>
            </button>
            <button class="btn-nav btn-nav--arrow history-nav--next" type="button" aria-label="Next timeline entries">
                <?php include get_template_directory() . '/resources/images/icon-arrow-right.svg'; ?>
            </button>
        </div>
    </div>

    <!-- Include History Modal Template -->
    <?php get_template_part('template-parts/history-modal'); ?>

</section>
<?php endif; ?>

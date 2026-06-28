<section class="project-detail">
    <div class="project-detail__container container pt-16 pb-16 pt-lg-30 pb-lg-30 d-flex flex-column gap-8 gap-lg-16">
        
        <?php 
       
        if( have_rows('project_features') ):
            
     
            while ( have_rows('project_features') ) : the_row(); ?>

                <?php 
            
                if( get_row_layout() == 'text_block' ): 
                    $heading = get_sub_field('heading');
                    $content = get_sub_field('content');
                ?>
                    <div class="row">
                        <div class="project-detail__feature-block col-12 col-lg-7 offset-lg-4">
                            <div class="project-detail__feature-wrapper ps-lg-3 d-flex flex-column">
                                <?php if( $heading ): ?>
                                    <h4 class="mb-0"><?php echo esc_html($heading); ?></h4>
                                <?php endif; ?>
                                
                                <?php if( $content ): ?>
                                    <div class="body body-large">
                                        <?php echo wp_kses_post($content); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                <?php 
           
                elseif( get_row_layout() == 'image_block' ): 
                    $image = get_sub_field('image');
                ?>
                    <?php if( $image ): ?>
                        <div class="row">
                            <div class="project-detail__feature-block col-12 col-lg-11">
                                <?php echo wp_get_attachment_image($image, 'full', false, array('class' => 'img-fluid')); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                <?php endif; ?>

            <?php 
            endwhile;
        else :
            if (is_admin()) : ?>
                <div class="p-4 text-center border dashed">
                    <p class="mb-0"><strong>Project Detail Content Block</strong></p>
                    <small>Click this block and use the sidebar or block panel to add Text or Image elements.</small>
                </div>
            <?php endif;
        endif; 
        ?>

    </div>
</section>
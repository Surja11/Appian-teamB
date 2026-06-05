<section class="testimonial-section">

    <!-- MOBILE: shown only below lg -->
    <div class="testimonial-card d-lg-none position-relative">
        <div class="testimonial-line"></div>

        <div class="swiper testimonial-swiper-mobile">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="quote-icon-wrapper">
                        <?php include get_template_directory() . '/resources/images/icon-quote.svg'; ?>
                    </div>

                    <h5>
                        "We owe Heffron a debt of thanks. Our project has been, to me, the epitome of a real partnership between client and consultant. Your commitment to teamwork and your 'esprit de corps' have made it a pleasure to have you as part of our management team."
                    </h5>

                    <div class="author-meta">
                        <h4 class="caption-2">Philip Broadley</h4>
                        <p class="caption-2">AstraZeneca</p>
                    </div>
                </div>
               
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
                    <?php include get_template_directory() . '/resources/images/logo-vector.svg'; ?>
                    <?php include get_template_directory() . '/resources/images/logo-vector-2.svg'; ?>
                </div>
                <div class="testimonial-line"></div>
            </div>

            <div class="col-lg-6 testimonial-right">
                <div class="swiper testimonial-swiper-desktop">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="quote-icon-wrapper">
                                <?php include get_template_directory() . '/resources/images/icon-quote.svg'; ?>
                            </div>

                            <h5>
                                "We owe Heffron a debt of thanks. Our project has been, to me, the epitome of a real partnership between client and consultant. Your commitment to teamwork and your 'esprit de corps' have made it a pleasure to have you as part of our management team."
                            </h5>

                            <div class="author-meta">
                                <h4 class="caption-2">Philip Broadley</h4>
                                <p class="caption-2">AstraZeneca</p>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div class="slider-progress d-flex">
                    <span class="progress-current">01</span>
                    <div class="progress-bar-wrapper">
                        <div class="progress-bar-fill"></div>
                    </div>
                    <span class="progress-total">04</span>
                </div>
            </div>

        </div>
    </div>

</section>

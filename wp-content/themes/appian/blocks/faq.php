<?php
$cta_caption = get_field('faq_cta_caption') ?: __('How will we achieve this?', 'outside-traineeship-biolerplate');
$cta_text= get_field('faq_cta_text') ?: __('We achieve this by following a structured and transparent construction process...', 'outside-traineeship-biolerplate');
$cta_button  = get_field('faq_cta_button');
?>

<section class="faq-section container pt-20 pb-39 pt-lg-20 pb-lg-20">
  <div class="faq-section__wrapper ms-md-auto me-md-auto">
    <header>
      <div class="faq-heading d-flex flex-column justify-content-center align-items-center">
        <h2 class="mb-4">FAQ</h2>
        <picture>
          <source media="(min-width: 1200px)" srcset="<?php echo esc_url(get_template_directory_uri()); ?>/resources/images/divider.svg">
          <img src="<?php echo esc_url(get_template_directory_uri()); ?>/resources/images/divider-small.svg" alt="">
        </picture>
      </div>
    </header>

    <main class="pt-15 d-flex flex-column flex-lg-row gap-lg-20">
      <section class="cta-section d-flex flex-shrink-0 flex-column pb-20">
        <h3 class=" h5 cta-section__caption mb-0">
          <?php echo wp_kses_post($cta_caption); ?>
        </h3>

        <div class="cta-section__body d-flex flex-column">
          <div class="cta-section__text m-0 body body-small-all">
            <?php echo wp_kses_post($cta_text); ?>
          </div>
        </div>

        <?php if (!empty($cta_button) && isset($cta_button['url'])) : ?>
          <a href="<?php echo esc_url($cta_button['url']); ?>" target="<?php echo esc_attr($cta_button['target'] ?: '_self'); ?>" class="btn btn-primary">
            <span class="btn__cta-text"><?php echo esc_html($cta_button['title']); ?></span>
            <div class="btn__cta-icon-container">
              <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 8.41406H15M8 15.4141L15 8.41406L8 1.41406" stroke="#ffffff" stroke-width="2" stroke-miterlimit="5.75877" stroke-linecap="square" />
              </svg>
            </div>
          </a>
        <?php endif; ?>
      </section>

      <section class="faq flex-grow-1 min-w-0">
        <div class="accordion accordion-flush" id="accordionFlushExample">
          <?php if (have_rows('faq_loop')) : ?>
            <?php $count = 0; ?>
            <?php while (have_rows('faq_loop')) : the_row(); ?>
              <?php
              $question = get_sub_field('faq_questions');
              $answer= get_sub_field('faq_answer');
              $count++;
              $collapse_id = "flush-collapse-" . $count;
              ?>
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button <?php echo ($count === 1) ? '' : 'collapsed'; ?> subheading-3 pt-5 pb-5 pb-lg-6 pt-lg-6"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#<?php echo esc_attr($collapse_id); ?>"
                    aria-expanded="<?php echo ($count === 1) ? 'true' : 'false'; ?>"
                    aria-controls="<?php echo esc_attr($collapse_id); ?>">
                    <?php echo esc_html($question); ?>
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/resources/images/accordion-toggle.svg" alt="close button" class="accordion-chevron" />
                  </button>
                </h2>
                
                <div id="<?php echo esc_attr($collapse_id); ?>" class="accordion-collapse collapse <?php echo ($count === 1) ? 'show' : ''; ?>" data-bs-parent="#accordionFlushExample">
                  
                  <div class="accordion-body body body-small pt-2 pb-12 pb-lg-13">
                    <?php echo wp_kses_post($answer); ?>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          <?php endif; ?>
        </div>
      </section>
    </main>
  </div>
</section>
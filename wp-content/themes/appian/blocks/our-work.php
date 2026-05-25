<?php
$our_work_data   = get_field('our_work');
$section_heading = $our_work_data['our_work_header'];
$work_tabs       = $our_work_data['tab'];
?>

<section class="our-work-section">

    <h2 class="our-work-section__heading">
        <?php echo esc_html($section_heading); ?>
    </h2>

    <div class="our-work-section__tabs">
        <?php foreach ($work_tabs as $work_item) : ?>
            <button class="our-work-section__tab-btn">
                <?php echo esc_html($work_item['work-heading']); ?>
            </button>
        <?php endforeach; ?>
    </div>

    <?php foreach ($work_tabs as $work_item) : ?>
        <div class="our-work-section__content-wrapper">

            <div class="our-work-section__content">

                <div class="our-work-section__text">
                    <h3 class="our-work-section__title">
                        <?php echo esc_html($work_item['title']); ?>
                    </h3>

                    <p class="our-work-section__description">
                        <?php echo esc_html($work_item['content']); ?>
                    </p>
                </div>

                <div class="our-work-section__media">
                    <?php if (!empty($work_item['image'])) : ?>
                        <img
                            src="<?php echo esc_url($work_item['image']['url']); ?>"
                            alt="<?php echo esc_attr($work_item['image']['alt']); ?>"
                        >
                    <?php endif; ?>
                </div>

            </div>

        </div>
    <?php endforeach; ?>

</section>
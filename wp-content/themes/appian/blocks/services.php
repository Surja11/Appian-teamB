<?php

$services = get_field('services');
$active_departments = [];

if (!empty($services) && is_array($services) && isset($services['active_departments']) && is_array($services['active_departments'])) {
    $active_departments = $services['active_departments'];
}

if (!is_array($active_departments)) {
    $active_departments = [];
}

$valid_departments = array_filter($active_departments, function ($department) {
    if (!is_array($department)) {
        return false;
    }
    return !empty($department['department_eyebrow']) ||
           !empty($department['department_name']) ||
           (!empty($department['department_image']) && is_array($department['department_image'])) ||
           !empty($department['department_link']);
});

if (!empty($valid_departments)) :
?>

    <section id="services-block" class="services-block w-100 m-0 p-0 overflow-hidden">
        <div class="services-container d-flex flex-column flex-md-row w-100 gap-0">

            <?php foreach ($valid_departments as $index => $department) :
                $department_eyebrow = $department['department_eyebrow'] ?? '';
                $department_name    = $department['department_name'] ?? '';
                $department_image   = $department['department_image'] ?? null;
                $department_link    = $department['department_link'] ?? '';
            ?>

                <div class="service-card position-relative d-flex flex-column justify-content-between w-100 w-md-50 flex-grow-1 overflow-hidden">
                    
                    <div class="service-card__background position-absolute top-0 start-0 w-100 h-100">
                        <?php if (!empty($department_image) && is_array($department_image) && !empty($department_image['url'])) : ?>
                            <img src="<?php echo esc_url($department_image['url']); ?>"
                                 alt="<?php echo esc_attr($department_image['alt'] ?? ''); ?>"
                                 class="w-100 h-100 object-fit-cover" />
                        <?php endif; ?>
                        <div class="service-card__overlay position-absolute top-0 start-0 w-100 h-100"></div>
                    </div>

                    <div class="service-card__content text-white position-relative">
                        <div class="service-card__top-content d-flex d-md-none flex-column w-100">
                            <?php if (($index % 2) == 0) :?>
                                <?php if (!empty($department_name)) : ?>
                                    <h1 class="service-card__title text-wrap text-break mb-0">
                                        <?php echo str_replace(' ', '<br>', esc_html($department_name)); ?>
                                    </h1>
                                <?php endif; ?>
                                <?php if (!empty($department_eyebrow)) : ?>
                                    <div class="service-card__label caption-1 text-wrap text-break mb-0 service-card__label--mobile">
                                        <?php echo wp_kses_post($department_eyebrow); ?>
                                    </div>
                                <?php endif; ?>
                            <?php else :?>
                                <?php if (!empty($department_eyebrow)) : ?>
                                    <div class="service-card__label caption-1 text-wrap text-break mb-0">
                                        <?php echo wp_kses_post($department_eyebrow); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($department_name)) : ?>
                                    <h1 class="service-card__title text-wrap text-break mb-0">
                                        <?php echo str_replace(' ', '<br>', esc_html($department_name)); ?>
                                    </h1>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <div class="service-card__top-content d-none d-md-flex flex-column w-100">
                            <?php if (!empty($department_eyebrow)) : ?>
                                <div class="service-card__label caption-1 text-wrap text-break service-card__label--desktop">
                                    <?php echo wp_kses_post($department_eyebrow); ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($department_name)) : ?>
                                <h1 class="service-card__title text-wrap text-break mb-0">
                                    <?php echo str_replace(' ', '<br>', esc_html($department_name)); ?>
                                </h1>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (!empty($department_link)) : ?>
                        <a href="<?php echo esc_url($department_link); ?>" class="btn-nav">
                            <?php include get_template_directory() . '/resources/images/icon-arrow-right.svg'; ?>
                        </a>
                    <?php endif; ?>
                </div>

            <?php endforeach; ?>

        </div>
    </section>

<?php else : ?>
    <?php if (is_admin()) : ?>
        <div class="services-block__placeholder p-4 text-center border border-dashed text-secondary">
            <p class="fw-bold mb-1">Services Block Placeholder</p>
            <p class="small mb-0">Please populate valid department entries within the block configuration parameters.</p>
        </div>
    <?php endif; ?>
<?php endif; ?>
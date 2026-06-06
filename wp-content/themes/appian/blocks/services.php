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

    <section id="services-block" class="services-block p-0">
        <div class="services-container d-flex flex-column flex-md-row w-100">

            <?php foreach ($valid_departments as $index => $department) :

                $department_eyebrow = $department['department_eyebrow'] ?? '';
                $department_name    = $department['department_name'] ?? '';
                $department_image   = $department['department_image'] ?? null;
                $department_link    = $department['department_link'] ?? '';

            ?>

                <div class="service-card position-relative">
                    <div class="service-card__background position-absolute w-100 h-100">
                        <?php if (!empty($department_image) && is_array($department_image) && !empty($department_image['url'])) : ?>
                            <img src="<?php echo esc_url($department_image['url']); ?>"
                                alt="<?php echo esc_attr($department_image['alt'] ?? ''); ?>"
                                class="w-100 h-100" />
                        <?php endif; ?>
                        <div class="service-card__overlay position-absolute w-100 h-100"></div>
                    </div>

                    <div class="service-card__content text-white">
                        <div class="service-card__top-content d-flex">
                            <?php if (!empty($department_eyebrow)) : ?>
                                <div class="service-card__label caption-1">
                                    <?php echo wp_kses_post($department_eyebrow); ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($department_name)) : ?>
                                <h2 class="service-card__title h1">
                                    <?php echo esc_html($department_name); ?>
                                </h2>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (!empty($department_link)) : ?>
                        <a href="<?php echo esc_url($department_link); ?>" class="btn btn-primary btn--small">
                            <span></span>
                            <span><?php include get_template_directory() . '/resources/images/icon-arrow-right.svg'; ?></span>
                        </a>
                    <?php endif; ?>
                </div>

            <?php endforeach; ?>

        </div>
    </section>

<?php else : ?>
    <?php if (is_admin()) : ?>
        <div class="services-block__placeholder">
            <p><strong>Services Block</strong></p>
            <p>Please add services content in the block settings to display here.</p>
        </div>
    <?php endif; ?>
<?php endif; ?>
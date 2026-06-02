<?php

/**
 * Services Block Template - Frontend
 */

$services = get_field('services');
$active_departments = $services['active_departments'] ?? [];

//returns only those departments which has got content in them
$valid_departments = array_filter($active_departments, function ($department) {
    return !empty($department['department_eyebrow']) || !empty($department['department_name']) || !empty($department['department_image']) || !empty($department['department_link']);});



if (!empty($valid_departments)) :
?>

    <section id="services-block" class="services-block p-0 m-0">
        <div class="services-container d-flex flex-column flex-md-row w-100">


            <!-- gettting the data from repeater -->
            <?php foreach ($valid_departments as $index => $department) :

                $department_eyebrow = $department['department_eyebrow'];
                $department_name = $department['department_name'];
                $department_image = $department['department_image'];
                $department_link = $department['department_link'];

    
            ?>


                <!-- creating a card for each department -->
                <div class="service-card service-card--construction position-relative overflow-hidden">
                    <div class="service-card__background position-absolute w-100 h-100">
                        <img src="<?php echo esc_url($department_image['url']); ?>"
                            alt="<?php echo esc_url($department_image['alt']); ?>"
                            class="w-100 h-100" />
                        <div class="service-card__overlay position-absolute w-100 h-100"></div>
                    </div>

                    <div class="service-card__content h-100 text-white">
                        <div class="service-card__top-content d-flex flex-column">
                            <div class="service-card__label caption-1 order-2 order-md-1">
                                <?php echo wp_kses_post($department_eyebrow); ?>
                            </div>

                            <h2 class="service-card__title h1 order-1 order-md-2">
                                <?php
                                $words = explode(' ', trim($department_name));

                                foreach ($words as $single_word) {
                                    echo esc_html($single_word) . '<br>';
                                }
                                ?>
                            </h2>
                        </div>

                        <a href="<?php echo esc_url($department_link); ?>" class="btn btn-primary btn--small">
                            <span></span>
                            <span><?php include get_template_directory() . '/resources/images/icon-arrow-right.svg'; ?></span>
                        </a>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>
    </section>

<?php endif; ?>
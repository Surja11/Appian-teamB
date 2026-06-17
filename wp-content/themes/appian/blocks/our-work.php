<?php
$our_work = get_field('our_work');
$our_work_header = $our_work['our_work_header'] ?? '';
$tabs = $our_work['tab'] ?? [];

if (empty($tabs)) return;

$valid_tabs = array_values(array_filter($tabs, function ($tab) {
    $name = trim($tab['work-heading'] ?? '');
    $title = trim($tab['title'] ?? '');
    $content = trim($tab['content'] ?? '');
    $image  = $tab['image'] ?? null;
    $has_image = is_array($image) ? !empty($image['url']) : !empty($image);

    return !empty($name) && ($title || $content || $has_image);
}));


// chevron-right-icon for accordion
$chevron = '<svg class="our-work__chevron" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
<use xlink:href="#stroke0_4010_183" transform="translate(6.66811 12.1859) scale(0.00560224) rotate(-55.985)"/>
<use xlink:href="#stroke0_4010_183" transform="translate(7.23352 12.7001) scale(0.00560224) rotate(-53.4964)"/>
<use xlink:href="#stroke0_4010_183" transform="translate(9.36757 14.4706) scale(0.00560224) rotate(-147.59)"/>
<use xlink:href="#stroke0_4010_183" transform="translate(8.66942 12.873) scale(0.00560224) rotate(-9.18475)"/>
<use xlink:href="#stroke0_4010_183" transform="translate(10.5309 15.6117) scale(0.00560224) rotate(-148.407)"/>
<use xlink:href="#stroke0_4010_183" transform="translate(11.6294 15.9649) scale(0.00560224) rotate(-172.879)"/>
<use xlink:href="#stroke0_4010_183" transform="translate(11.1592 16.7499) scale(0.00560224) rotate(-126.278)"/>
<use xlink:href="#stroke0_4010_183" transform="translate(10.7215 15.5948) scale(0.00560224) rotate(-30.7502)"/>cd
<use xlink:href="#stroke0_4010_183" transform="translate(11.2424 15.5812) scale(0.00560224) rotate(-54.8274)"/>
<use xlink:href="#stroke0_4010_183" transform="translate(12.9746 13.5167) scale(0.00560224) rotate(34.4669)"/>
<use xlink:href="#stroke0_4010_183" transform="translate(13.625 15.6191) scale(0.00560224) rotate(-133.892)"/>
<use xlink:href="#stroke0_4010_183" transform="translate(15.639 13.678) scale(0.00560224) rotate(130.786)"/>
<use xlink:href="#stroke0_4010_183" transform="translate(15.1928 14.438) scale(0.00560224) rotate(-152.076)"/>
<use xlink:href="#stroke0_4010_183" transform="translate(16.0254 11.351) scale(0.00560224) rotate(67.8203)"/>
<use xlink:href="#stroke0_4010_183" transform="translate(14.7651 12.5324) scale(0.00560224) rotate(-71.3631)"/>
<defs>
<g id="stroke0_4010_183">
<path d="M8 12L12 16L16 12" fill="currentColor"/>
</g>
</defs>
</svg>';
?>

grgr
<!-- our work section -->
<section class="our-work pt-16 pb-16 ps-xl-10 pt-xl-27 pb-xl-27 d-flex flex-column justify-content-center">
    <!-- texture overlay that covers entire our-work section -->
    <div class="our-work__overlay"></div>
    <div class="container">
        <div class="our-work__wrapper ms-auto me-auto">
    <!-- our work heading with underline stroke -->
        <div class=" our-work__heading d-flex flex-column justify-content-center align-items-center">
            <h2 class="mb-4"><?php echo esc_html($our_work_header ?: 'Our Work'); ?></h2>
            <picture>
            <source
                media="(min-width: 1200px)"
                srcset="<?php echo get_template_directory_uri(); ?>/resources/images/divider.svg">
            <img
                src="<?php echo get_template_directory_uri(); ?>/resources/images/divider-small.svg"
                alt="">
            </picture>
        </div>



    <!-- tabs for large screens -->
    <div class="our-work__tabs-container">
        <ul class="our-work__tabs d-none d-xl-flex flex-wrap justify-content-center list-unstyled mb-0" id="ourWorkTabs" role="tablist">
            <?php foreach ($valid_tabs as $index => $tab) :
                $tab_id = 'tab' . ($index + 1);
                $is_active = ($index === 0);
                $tab_name = explode(' ', $tab['work-heading'])[0] ?? ('Tab ' . ($index + 1));
                if (empty($tab_name)) {
                    continue;
                }
            ?>
                <li class="our-work__tab-item" role="presentation">
                    <button
                        class="our-work__tab-link<?php echo $is_active ? ' active' : ''; ?> pt-4 pb-4 ps-6 pe-6"
                        id="<?php echo esc_attr($tab_id); ?>-tab"
                        data-tab-index="<?php echo $index; ?>"
                        type="button"
                        role="tab"
                        aria-controls="<?php echo esc_attr($tab_id); ?>-content"
                        aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>">
                        <?php echo esc_html($tab_name); ?>
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- tab content for large screens -->
    <div class="our-work__tab-content d-none d-xl-block" id="ourWorkTabContent">
        <!-- fetching repeater data from backend -->
        <?php foreach ($valid_tabs as $index => $tab) :
            $tab_id = 'tab' . ($index + 1);
            $is_active = ($index === 0);
            $title = $tab['title'] ?? '';
            $content = $tab['content'] ?? '';
            $image = $tab['image'] ?? null;
            $image_url = is_array($image) ? ($image['url'] ?? '') : $image;
            $image_alt = is_array($image) ? (empty($image['alt']) ? $title : $image['alt']) : $title;
            if (empty($title) && empty($content) && empty($image)) {
                continue;
            }
        ?>

            <div
                class="our-work__tab-pane<?php echo $is_active ? ' active' : ''; ?>"
                id="<?php echo esc_attr($tab_id); ?>-content"
                role="tabpanel"
                aria-labelledby="<?php echo esc_attr($tab_id); ?>-tab">
                <div class="our-work__tab-body pt-4 pb-5 p-xl-0 d-flex flex-row-reverse justify-content-center align-items-center">
                    <?php if ($image_url) : ?>
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                    <?php endif; ?>
                    <div class="our-work__tab-text d-flex flex-column ">
                        <?php if ($title) : ?><h3 class="pb-6 mb-0"><?php echo esc_html($title); ?></h3><?php endif; ?>
                        <?php if ($content) : ?><div class="body body-large pb-12"><?php echo wp_kses_post($content); ?></div><?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Accordion for mobile -->
    <div class="accordion d-xl-none pt-9" id="accordionExample">

        <!-- fetching from backend  -->
        <?php foreach ($valid_tabs as $index => $tab) :
            $collapse_id = 'collapse' . ($index + 1);
            $is_active = ($index === 0);
            $name = $tab['work-heading'] ?? ('Tab ' . ($index + 1));
            $title = $tab['title'] ?? '';
            $content = $tab['content'] ?? '';
            $image = $tab['image'] ?? null;
            $image_url = is_array($image) ? ($image['url'] ?? '') : $image;
            $image_alt = is_array($image) ? (empty($image['alt']) ? $title : $image['alt']) : $title;

            if (empty($name) || (empty($title) && empty($content) && empty($image))) {
                continue;
            }
        ?>
            <div class="accordion-item pb-6">
                <h2 class="accordion-header">
                    <button
                        class="accordion-button accordion__tab<?php echo $is_active ? '' : ' collapsed'; ?> ps-6 pe-6 d-flex justify-content-between align-items-center"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#<?php echo esc_attr($collapse_id); ?>"
                        aria-expanded="<?php echo $is_active ? 'true' : 'false'; ?>"
                        aria-controls="<?php echo esc_attr($collapse_id); ?>">
                        <?php echo esc_html($name); ?>

                        <?php echo $chevron; ?>


                    </button>
                </h2>
                <div
                    id="<?php echo esc_attr($collapse_id); ?>"
                    class="accordion-collapse collapse<?php echo $is_active ? ' show' : ''; ?>"
                    data-bs-parent="#accordionExample">
                    <div class="accordion__body pt-4 d-flex flex-column">
                        <?php if ($image_url) : ?>
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                        <?php endif; ?>
                        <div class="accordion__body-text d-flex flex-column">
                            <?php if ($title) : ?><h3 class="mb-0"><?php echo esc_html($title); ?></h3><?php endif; ?>
                            <?php if ($content) : ?><div class="body body-large"><?php echo wp_kses_post($content); ?></div><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
        </div>
    </div>
</section>
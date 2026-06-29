<?php
$partners_group = get_field('our_partners');
$partners_title = $partners_group['section_title'];
$partners = $partners_group['partners'];
$view_all = $partners_group['view_all_partners'];

$valid_partners = [];
if (!empty($partners) && is_array($partners)) {
    foreach ($partners as $row) {
        if (!empty($row['partner_image']) || !empty($row['partner_link'])) {
            $valid_partners[] = $row;
        }
    }
}



if (!empty($valid_partners)) :
?>
    <section class="our-partner-wrapper">
        <section class="our-partner" aria-labelledby="our-partners-heading">

            <div class="our-partner__heading">
                <h2 id="our-partners-heading " class="appian-section__title position-relative"><?php echo  esc_html($partners_title) ?></h2>
            </div>

            <div class="our-partner__grid-wrapper">
                <div class="our-partner__partner-grid">

                    <?php foreach ($valid_partners as $partner) :
                        $logo = $partner['partner_image'];
                        $link = $partner['partner_link'];
                    ?>
                        <div class="our-partner__single-partner">
                            <div class="our-partner__tick-wrapper"></div>
                            <div class="our-partner__img-container">
                                <?php if (!empty($link)) : ?>
                                    <a href="<?php echo esc_url($link); ?>">
                                        <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>" loading="lazy" height="300" width="300">
                                    </a>
                                <?php else : ?>
                                    <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>">
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div class="our-partner__single-partner our-partner__single-partner--cta">
                        <div class="our-partner__tick-wrapper"></div>
                        <a class="btn btn-tertiary" href="<?php echo esc_url($view_all) ?>">View All Partners</a>
                    </div>

                </div>
                <div class="our-partner__bottom-ticks"></div>
            </div>

        </section>
    </section>

<?php endif ?>
<?php
$partners = get_field('partners');

$valid_partners = [];
if (!empty($partners) && is_array($partners)) {
    foreach ($partners as $row) {
        if (!empty($row['partner_logo'])) {
            $valid_partners[] = $row;
        }
    }
}



if (!empty($valid_partners)) :
?>
<section class="our-partner-wrapper">
<section class="our-partner" aria-labelledby="our-partners-heading">

    <div class="our-partner__heading">
        <h2 id="our-partners-heading" class="mb-4">Our partner</h2>
        <picture>
            <source media="(min-width: 1200px)" srcset="<?php echo get_template_directory_uri(); ?>/resources/images/divider.svg">
            <img src="<?php echo get_template_directory_uri(); ?>/resources/images/divider-small.svg" alt="">
        </picture>
    </div>

    <div class="our-partner__grid-wrapper">
        <div class="our-partner__partner-grid">

            <?php foreach ($valid_partners as $partner) :
                $logo = $partner['partner_logo'];
            ?>
            <div class="our-partner__single-partner">
                <div class="our-partner__img-container">
                    <img
                        src="<?php echo esc_url($logo['url']); ?>"
                        alt="<?php echo esc_attr($logo['alt']); ?>"
                    >
                </div>
            </div>
            <?php endforeach; ?>

            <div class="our-partner__single-partner our-partner__single-partner--cta">
                <button class="btn btn-tertiary">View All Partners</button>
            </div>

        </div>
    </div>

</section>
</section>

<?php endif?>
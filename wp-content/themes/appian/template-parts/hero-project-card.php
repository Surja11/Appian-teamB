<?php
/**
 * Template Part: Hero Project Card
 * template-parts/hero-project-card.php
 */

$card           = get_query_var('card', []);
$category       = $card['project_category'] ?? '';
$category_short = $card['category_short'] ?? explode(' ', $category)[0];
$title          = $card['project_title'] ?? '';
$subtitle       = $card['project_subtitle'] ?? '';
$card_image     = $card['project_image'] ?? null;
$card_link      = $card['page_link'] ?? '#';
?>

<article class="hero-project-card">
    <a class="hero-project-card__link" href="<?php echo esc_url($card_link); ?>">

        <div class="hero-project-card__image-wrap" style="background-image: url('<?php echo esc_url($card_image['url']); ?>');"></div>
        <div class="hero-project-card__overlay"></div>
        <div class="hero-project-card__hover-overlay"></div>

        <div class="hero-project-card__category">
            <span class="hero-project-card__category-icon" aria-hidden="true">i</span>
            <span class="hero-project-card__category-text hero-project-card__category-text--full d-xl-none">
                <?php echo esc_html($category); ?>
            </span>
            <span class="hero-project-card__category-text hero-project-card__category-text--short d-none d-xl-block">
                <?php echo esc_html($category_short); ?>
            </span>
        </div>

        <div class="hero-project-card__content">
            <h3 class="hero-project-card__title"><?php echo esc_html($title); ?></h3>
            <?php if ($subtitle) : ?>
                <p class="hero-project-card__subtitle"><?php echo esc_html($subtitle); ?></p>
            <?php endif; ?>
        </div>

        <div class="hero-project-card__read-more">
            <img
                class="hero-project-card__arrow"
                src="<?php echo get_template_directory_uri(); ?>/resources/images/icon-arrow-right.svg"
                alt=""
                aria-hidden="true"
                width="24"
                height="24"
            >
            <span class="hero-project-card__read-more-text">read more</span>
        </div>

    </a>
</article>
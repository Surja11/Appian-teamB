<?php
/**
 Hero Projects
 blocks/hero-projects.php
 */
?>

<section class="hero-projects">
    <div class="hero-projects__inner">

            <div class="hero-projects__title-block">
                <h2 class="hero-projects__title h2">Hero Projects</h2>
                <div class="hero-projects__divider">
                    <img src="<?php echo get_template_directory_uri(); ?>/resources/images/divider.svg" alt="" aria-hidden="true" width="230" height="9">
                </div>
            </div>

            <?php
            $cards_row1 = [
                ['category' => 'Renovation & Remodeling | Waterproofing & Solutions', 'category_short' => 'Renovation',    'title' => 'Modern Building Solutions',         'subtitle' => 'Smart designs built efficiently'],
                ['category' => 'Plumbing & Electrical | Steel Structure Works',        'category_short' => 'Plumbing',       'title' => 'Trusted Construction Experts',       'subtitle' => ''],
                ['category' => 'HVAC Installation | Building Maintenance',             'category_short' => 'Waterproofing',  'title' => 'Quality Craftsmanship Delivered',    'subtitle' => 'Precision in every project'],
                ['category' => 'Roofing Services | Steel Structure Works',             'category_short' => 'HVAC',           'title' => 'Professional Construction Services', 'subtitle' => 'Skilled work with excellence'],
            ];

            $cards_row2 = [
                ['category' => 'HVAC Installation | Painting & Finishing',                   'category_short' => 'Roofing',       'title' => 'Future Ready Structures Solutions', 'subtitle' => 'Modern spaces for tomorrow'],
                ['category' => 'Waterproofing & Solutions | Architecture & Design',          'category_short' => 'Waterproofing', 'title' => 'Strong Foundation Experts',        'subtitle' => 'Building strength from ground'],
            ];

            $cards_row3 = [
                ['category' => 'Smart Home Installation | Turnkey Construction',      'category_short' => 'Electrical', 'title' => 'Reliable Project Management',   'subtitle' => 'Organized planning from start'],
                ['category' => 'Plumbing & Electrical | Steel Structure Works',       'category_short' => 'Renovation', 'title' => 'Innovative Structural Designs', 'subtitle' => 'Creative solutions for buildings'],
                ['category' => 'Renovation & Remodeling | Concrete & Masonry',        'category_short' => 'Plumbing',   'title' => 'Complete Building Services',    'subtitle' => 'End-to-end construction support'],
                ['category' => 'Waterproofing & Solutions | Architecture & Design',   'category_short' => 'HVAC',       'title' => 'Excellence In Construction',    'subtitle' => 'Commitment to superior results'],
            ];
            ?>

            <div class="hero-projects__cards hero-projects__cards--row-1">
                <?php foreach ($cards_row1 as $card) : ?>
                    <?php set_query_var('card', $card); get_template_part('template-parts/hero-project-card'); ?>
                <?php endforeach; ?>
            </div>

            <div class="hero-projects__cards hero-projects__cards--row-2">
                <div class="hero-projects__feature-image"></div>
                <?php foreach ($cards_row2 as $card) : ?>
                    <?php set_query_var('card', $card); get_template_part('template-parts/hero-project-card'); ?>
                <?php endforeach; ?>
            </div>

            <div class="hero-projects__cards hero-projects__cards--row-3">
                <?php foreach ($cards_row3 as $card) : ?>
                    <?php set_query_var('card', $card); get_template_part('template-parts/hero-project-card'); ?>
                <?php endforeach; ?>
            </div>

        </div>
</section>
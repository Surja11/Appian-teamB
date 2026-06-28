<div class="header">
  <nav class="navbar nav-text">
  <div class="navbar__top">
    <div class="navbar__logo-container">
      <a href="<?php echo esc_url(home_url('/')); ?>" aria-label="Go to homepage">
        <?php
        $logo_field = get_field('header_logo', 'option');
       
        if ( is_array($logo_field) ) {
            $logo_id  = $logo_field['ID'] ?? $logo_field['id'] ?? null;
            $logo_url = $logo_field['url'] ?? '';
            $logo_alt = $logo_field['alt'] ?? 'website logo icon';
        } else {
            $logo_id  = $logo_field ?: null;
            $logo_url = '';
            $logo_alt = 'website logo icon';
        }

        if ( $logo_id ) :
            echo wp_get_attachment_image( $logo_id, 'full', false, array( 'class' => 'navbar__logo' ) );
        elseif ( $logo_url ) :
        ?>
          <img src="<?php echo esc_url( $logo_url ); ?>" class="navbar__logo" alt="<?php echo esc_attr( $logo_alt ); ?>" />
        <?php endif; ?>
      </a>
    </div>

    <button
      class="navbar__icon-container"
      aria-label="Open menu"
      aria-expanded="false"
      aria-controls="navbar-main">
      <img
        src="<?php echo esc_url(get_template_directory_uri()); ?>/resources/images/icon-hamburger.svg"
        class="navbar__icon navbar__icon--open"
        alt="hamburger icon" />
      <img
        src="<?php echo esc_url(get_template_directory_uri()); ?>/resources/images/icon-close.svg"
        class="navbar__icon navbar__icon--close"
        alt="cross icon" />
    </button>
  </div>

    <div class="navbar__main" id="navbar-main">
      <?php

      if (has_nav_menu('primary-menu')) {
        wp_nav_menu(array(
          'theme_location' => 'primary-menu',
          'container'=> false,
          'menu_class'=> 'navbar__list',
          'fallback_cb'=> false,
          'walker'=> new Appian_BEM_Walker()
        ));
      }
      ?>
    </div>
    

    <?php
    $linkedin= get_field('linkedin_url', 'option');
    $emergency_label = get_field('emergency_label', 'option');
    $phone= get_field('phone_number', 'option');
    $clean_phone= preg_replace('/[^0-9]/', '', $phone);
    $valid_phone= $phone && strlen($clean_phone) >= 7;
    ?>

    <?php if ( $linkedin || $emergency_label || $valid_phone ) : ?>
    <div class="navbar__extra">
      <?php if ( $linkedin ) : ?>
      <a
        href="<?php echo esc_url($linkedin); ?>"
        class="navbar__social"
        aria-label="Visit our LinkedIn page"
        target="_blank"
        rel="noopener noreferrer">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/resources/images/icon-linkedin.svg" alt="LinkedIn Profile" />
      </a>
      <?php endif; ?>

      <?php if ( $emergency_label || $valid_phone ) : ?>
      <div class="navbar__contact">
        <?php if ( $emergency_label ) : ?>
        <span class="navbar__contact-label">
          <?php echo esc_html($emergency_label); ?>
        </span>
        <?php endif; ?>

        <?php if ( $valid_phone ) : ?>
        <div class="navbar__contact-row">
          <div class="navbar__img-container">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/resources/images/icon-phone.svg" alt="" aria-hidden="true" />
          </div>
          <a href="tel:<?php echo esc_attr($clean_phone); ?>" aria-label="Call us at <?php echo esc_attr($phone); ?>">
            <?php echo esc_html($phone); ?>
          </a>
        </div>
        <?php endif; ?>
      </div>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </nav>
</div>
<div class="navbar-overlay" id="navbar-overlay" aria-hidden="true"></div>

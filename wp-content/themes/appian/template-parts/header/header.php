<div class="header">
  <nav class="navbar nav-text">
  <div class="navbar__top">
    <div class="navbar__logo-container">
      <a href="<?php echo esc_url(home_url('/')); ?>" aria-label="Go to homepage">
        <?php
        $logo_id = get_field('header_logo', 'option');
        if ($logo_id) :
          echo wp_get_attachment_image($logo_id, 'full', false, array('class' => 'navbar__logo'));
        else :
        ?>
          <img
            src="<?php echo esc_url(get_template_directory_uri()); ?>/resources/images/logo-appian.svg"
            class="navbar__logo"
            alt="website logo icon" />
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
          'container'      => false,
          'menu_class'     => 'navbar__list',
          'fallback_cb'    => false,
          'walker'         => new Appian_BEM_Walker()
        ));
      }
      ?>
    </div>
    <!-- test -->

    <!-- Extra Information Block (Dynamic with Field Fallbacks) -->
    <div class="navbar__extra">
      <?php
      $linkedin = get_field('linkedin_url', 'option');
      $linkedin_url = $linkedin ? $linkedin : '#';
      ?>
      <a
        href="<?php echo esc_url($linkedin_url); ?>"
        class="navbar__social"
        aria-label="Visit our LinkedIn page"
        target="_blank"
        rel="noopener noreferrer">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/resources/images/icon-linkedin.svg" alt="LinkedIn Profile" />
      </a>

      <div class="navbar__contact">
        <span class="navbar__contact-label">
          <?php
          $emergency_label = get_field('emergency_label', 'option');
          echo esc_html($emergency_label ? $emergency_label : '24/7 emergency services');
          ?>
        </span>
        <div class="navbar__contact-row">
          <div class="navbar__img-container">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/resources/images/icon-phone.svg" alt="" aria-hidden="true" />
          </div>
          <?php
          $phone = get_field('phone_number', 'option');

          // FIX: Clean the phone input string down to numeric characters only
          $clean_phone = preg_replace('/[^0-9]/', '', $phone);

          // FIX: Ensure the numeric value is long enough to actually represent a legitimate phone format (minimum 7 digits)
          if ($phone && strlen($clean_phone) >= 7) :
          ?>
            <a href="tel:<?php echo esc_attr($clean_phone); ?>" aria-label="Call us at <?php echo esc_attr($phone); ?>">
              <?php echo esc_html($phone); ?>
            </a>
          <?php else: ?>
            <!-- Hardcoded safe design backup to handle blank inputs or partial text values like "365" -->
            <a href="tel:3018162088" aria-label="Call us at (301) 816-2088">(301) 816-2088</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>
</div>
<div class="navbar-overlay" id="navbar-overlay" aria-hidden="true"></div>
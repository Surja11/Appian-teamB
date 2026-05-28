<div class="header">
  <nav class="navbar nav-text">

    <!-- Container for logo (Dynamic with Theme Fallback) -->
    <div class="navbar__logo-container">
      <a href="<?php echo esc_url(home_url('/')); ?>" aria-label="Go to homepage">
        <?php 
        $logo_id = get_field('header_logo', 'option');
        if ( $logo_id ) : 
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

    <!-- Mobile Hamburger Toggle Controls -->
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

    <!-- Main Navigation Area (Dynamic with Automatic HTML Fallback) -->
    <div class="navbar__main" id="navbar-main">
        <?php
        // Check if a menu is actually assigned to 'primary-menu'
        if ( has_nav_menu( 'primary-menu' ) ) {
            wp_nav_menu(array(
                'theme_location' => 'primary-menu',
                'container'      => false,
                'menu_class'     => 'navbar__list',
                'fallback_cb'    => false,
                'walker'         => new Appian_BEM_Walker()
            ));
        } else {
            // FALLBACK: Displays original design perfectly before a CMS menu is assigned
            ?>
            <ul class="navbar__list">
              <li class="navbar__item">
                <a href="#home" class="navbar__link">Home</a>
              </li>

              <li class="navbar__item">
                <a href="#our-projects" class="navbar__link">Our Projects</a>
              </li>

              <li class="navbar__item">
                <a href="#what-we-build" class="navbar__link">What we build</a>
              </li>

              <li class="navbar__item navbar__item--has-dropdown">
                <button
                  class="navbar__dropdown-trigger"
                  aria-expanded="false"
                  aria-controls="dropdown-construction">
                  <span class="navbar__link">Construction </span>
                  <img src="<?php echo esc_url(get_template_directory_uri()); ?>/resources/images/icon-chevron-down.svg" alt="arrow-down icon" />
                </button>
                <div class="navbar__dropdown bg-neutral-50" id="dropdown-construction">
                  <ul class="navbar__dropdown-list">
                    <li class="navbar__dropdown-item">
                      <a href="#pre-construcion" class="navbar__link">Pre-Construction</a>
                    </li>
                    <li class="navbar__dropdown-item">
                      <a href="#pre-construcion" class="navbar__link">Post-Construction</a>
                    </li>
                    <li class="navbar__dropdown-item">
                      <a href="#pre-construcion" class="navbar__link">Fab Shop</a>
                    </li>
                  </ul>
                </div>
              </li>

              <li class="navbar__item navbar__item--has-dropdown">
                <button
                  class="navbar__dropdown-trigger"
                  aria-expanded="false"
                  aria-controls="dropdown-service">
                  <span class="navbar__link">Service Department </span>
                  <img src="<?php echo esc_url(get_template_directory_uri()); ?>/resources/images/icon-chevron-down.svg" alt="arrow-down icon" />
                </button>
                <div class="navbar__dropdown bg-neutral-50" id="dropdown-service">
                  <ul class="navbar__dropdown-list">
                    <li class="navbar__dropdown-item">
                      <a href="#pre-construcion" class="navbar__link">Consulting Services</a>
                    </li>
                    <li class="navbar__dropdown-item">
                      <a href="#pre-construcion" class="navbar__link">Implementation Services</a>
                    </li>
                    <li class="navbar__dropdown-item">
                      <a href="#pre-construcion" class="navbar__link">Support & Maintenance</a>
                    </li>
                    <li class="navbar__dropdown-item">
                      <a href="#pre-construcion" class="navbar__link">Training & Optimization</a>
                    </li>
                  </ul>
                </div>
              </li>

              <li class="navbar__item">
                <a href="#contact" class="navbar__link">Contact</a>
              </li>
            </ul>
            <?php
        }
        ?>
    </div>

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
          if ( $phone && strlen($clean_phone) >= 7 ) :
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
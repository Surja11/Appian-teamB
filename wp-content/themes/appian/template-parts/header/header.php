<div class="header">
<nav class="navbar nav-text">

        <!-- container for logo -->
        <div class="navbar__logo-container">
          <a href="#" aria-label="Go to homepage">
            <img
              src="<?php echo get_template_directory_uri(); ?>/resources/images/logo-appian.svg"
              class="navbar__logo"
              alt="website logo icon"
            />
          </a>
        </div>

        <!-- button that contains icons opening and closing of hamburger -->
        <button
          class="navbar__icon-container navbar-collapse"
          aria-label="Open menu"
          aria-expanded="false"
          aria-controls="navbar-main"
        >
        <!-- open hamburger icon -->
          <img
            src="<?php echo get_template_directory_uri(); ?>/resources/images/icon-hamburger.svg"
            class="navbar__icon navbar__icon--open"
            alt="hamburger icon"
          />

          <!-- close icon -->
          <img
            src="<?php echo get_template_directory_uri(); ?>/resources/images/icon-close.svg"
            class="navbar__icon navbar__icon--close"
            alt="cross icon"
          />
        </button>

        <!-- main navbar -->
        <div class="navbar__main" id="navbar-main">
          <ul class="navbar__list">
            <li class="navbar__item">
              <a href="#home" class="navbar__link">Home</a>
            </li>

            <li class="navbar__item">
              <a href="#about" class="navbar__link">About Us</a>
            </li>

            <li class="navbar__item">
              <a href="#what-we-build" class="navbar__link">What we build</a>
            </li>

            <!-- menu item with dropdown, includes aria-expanded attribute that we manipulate through JavaScript -->
            <li class="navbar__item navbar__item--has-dropdown">
              <button
                class="navbar__dropdown-trigger"
                aria-expanded="false"
                aria-controls="dropdown-construction"
              >
                <span class="navbar__link">Construction </span>
                <img src="<?php echo get_template_directory_uri()?>/resources/images/icon-chevron-down.svg" alt="arrow-down icon" />
              </button>
              <div class="navbar__dropdown bg-neutral-50" id="dropdown-construction">
                <ul class="navbar__dropdown-list">
                  <li class="navbar__dropdown-item">
                    <a href="#pre-construcion" class="navbar__link">
                      Pre-Construction
                    </a>
                  </li>

                  <li class="navbar__dropdown-item">
                    <a href="#pre-construcion" class="navbar__link">
                      Post-Construction
                    </a>
                  </li>

                  <li class="navbar__dropdown-item">
                    <a href="#pre-construcion" class="navbar__link">
                      Fab Shop
                    </a>
                  </li>
                </ul>
              </div>
            </li>

            <!-- another dropdown menu item -->
            <li class="navbar__item navbar__item--has-dropdown">
              <button
                class="navbar__dropdown-trigger"
                aria-expanded="false"
                aria-controls="dropdown-service"
              >
                <span class="navbar__link">Service Department </span>
                <img src="<?php echo get_template_directory_uri()?>/resources/images/icon-chevron-down.svg" alt="arrow-down icon" />
              </button>
              <div class="navbar__dropdown bg-neutral-50" id="dropdown-service">
                <ul class="navbar__dropdown-list">
                  <li class="navbar__dropdown-item">
                    <a href="#pre-construcion" class="navbar__link">
                      Consulting Services
                    </a>
                  </li>

                  <li class="navbar__dropdown-item">
                    <a href="#pre-construcion" class="navbar__link">
                      Implementation Services
                    </a>
                  </li>

                  <li class="navbar__dropdown-item">
                    <a href="#pre-construcion" class="navbar__link">
                      Support & Maintenance
                    </a>
                  </li>

                  <li class="navbar__dropdown-item">
                    <a href="#pre-construcion" class="navbar__link">
                      Training and Optimization
                    </a>
                  </li>
                </ul>
              </div>
            </li>

            <li class="navbar__item">
              <a href="#contact" class="navbar__link">Contact</a>
            </li>
          </ul>
        </div>

        <!-- extra information like contact -->
        <div class="navbar__extra">
          <a
            href="#"
            class="navbar__social"
            aria-label="Visit our LinkedIn page"
            target="_blank">
            
            <img src="<?php echo get_template_directory_uri()?>/resources/images/icon-linkedin.svg" alt="" />
          </a>
          <div class="navbar__contact">
            <span>24/7 emergency contact</span>
            <div>
              <img src="<?php echo get_template_directory_uri()?>/resources/images/icon-phone.svg" alt="" aria-hidden="true" />
              <a href="tel:3018162088" aria-label="Call us at 301 816 2088"
                >(301) 816-2088</a
              >
            </div>
          </div>
        </div>
      </nav>
</div>
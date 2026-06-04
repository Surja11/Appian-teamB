<?php
/**
 * Our History Block  - Frontend
 */
?>

<section id="our-history-block" class="our-history-block">
    <!-- Section Header -->
    <div class="our-history__header text-center">
        <h2 class="our-history__title">Our History</h2>
    </div>

    <!-- History Timeline -->
    <div class="our-history__timeline">
        <div class="timeline-scroll-container">
            <div class="timeline-cards-wrapper">
                
                <!-- History Item 1922 -->
                <div class="history-card" data-year="1922">
                    <div class="history-card__year">1922</div>
                    <div class="history-card__image-wrapper">
                        <img src="/wp-content/themes/appian/resources/images/history-1922.png" 
                             alt="The Heffron Company founder in 1922" 
                             class="history-card__image" />
                    </div>
                    <div class="history-card__content">
                        <p class="history-card__excerpt">
                            Joseph Heffron continued to persevere and found enough work to keep his employees on the payroll, but the stress took a toll on his health. He was unable to solicit new business as he once had so he restructured the company to focus more on service work.
                        </p>
                        <button class="btn btn-link history-card__read-more" 
                                data-history-id="1922"
                                data-bs-toggle="modal" 
                                data-bs-target="#historyModal">
                            Continue Reading
                        </button>
                    </div>
                </div>

                <!-- Divider Line 1 -->
                <div class="timeline-divider" aria-hidden="true"></div>

                <!-- History Item 1928 -->
                <div class="history-card" data-year="1928">
                    <div class="history-card__year">1928</div>
                    <div class="history-card__image-wrapper">
                        <img src="/wp-content/themes/appian/resources/images/history-1928.png" 
                             alt="Company gathering in 1928" 
                             class="history-card__image" />
                    </div>
                    <div class="history-card__content">
                        <p class="history-card__excerpt">
                            The stock market crash had a tremendous impact on the company and Heffron himself. Known as a generous and sensitive man, Heffron signed a great number of promissory notes for employees to help them obtain loans during this time of financial difficulty. After the crash the banks came to Heffron to collect on the notes, At the same time, his business shrank to one-tenth the size it was before 1929. He devoted himself to finding a way to pay off the notes as well as his own debts so that the business could once again thrive. Although he had lost dozens of accounts in the crash. Heffron still had one good customer, Potomac Electric Power. His good record with the giant utility bought in just enough business to keep the company afloat during those dark days.
                        </p>
                        <!-- Hidden full content for modal -->
                        <div class="history-card__full-content" style="display: none;">
                            <p>The stock market crash had a tremendous impact on the company and Heffron himself. Known as a generous and sensitive man, Heffron signed a great number of promissory notes for employees to help them obtain loans during this time of financial difficulty. After the crash the banks came to Heffron to collect on the notes,</p>
                            <p>At the same time, his business shrank to one-tenth the size it was before 1929. He devoted himself to finding a way to pay off the notes as well as his own debts so that the business could once again thrive. Although he had lost dozens of accounts in the crash.</p>
                            <p>Heffron still had one good customer, Potomac Electric Power. His good record with the giant utility bought in just enough business to keep the company afloat during those dark days.</p>
                        </div>
                        <button class="btn btn-link history-card__read-more" 
                                data-history-id="1928"
                                data-bs-toggle="modal" 
                                data-bs-target="#historyModal">
                            Continue Reading
                        </button>
                    </div>
                </div>

                <!-- Divider Line 2 -->
                <div class="timeline-divider" aria-hidden="true"></div>

                <!-- History Item 1929 -->
                <div class="history-card" data-year="1929">
                    <div class="history-card__year">1929</div>
                    <div class="history-card__image-wrapper">
                        <img src="/wp-content/themes/appian/resources/images/history-1929.png" 
                             alt="Company facility in 1929" 
                             class="history-card__image" />
                    </div>
                    <div class="history-card__content">
                        <p class="history-card__excerpt">
                            Joseph Heffron continued to persevere and found enough work to keep his employees on the payroll, but the stress took a toll on his health. He was unable to solicit new business as he once had so he restructured the company to focus more on service work.
                        </p>
                        <button class="btn btn-link history-card__read-more" 
                                data-history-id="1929"
                                data-bs-toggle="modal" 
                                data-bs-target="#historyModal">
                            Continue Reading
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Navigation Arrows -->
        <div class="our-history__navigation">
            <button class="btn-nav btn-nav--arrow history-nav--prev" type="button" aria-label="Previous timeline entries">
                <?php include get_template_directory() . '/resources/images/icon-arrow-left.svg'; ?>
            </button>
            <button class="btn-nav btn-nav--arrow history-nav--next" type="button" aria-label="Next timeline entries">
                <?php include get_template_directory() . '/resources/images/icon-arrow-right.svg'; ?>
            </button>
        </div>
    </div>

    <!-- Include History Modal Template -->
    <?php get_template_part('template-parts/history-modal'); ?>

</section>
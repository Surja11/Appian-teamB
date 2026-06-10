<?php
?>

<div class="history-modal-overlay" id="history-modal-overlay" style="display: none;">
    <div class="history-modal">

        <button class="history-modal__close" aria-label="Close modal">
            <?php include get_template_directory() . '/resources/images/icon-close.svg'; ?>
        </button>

        <div class="history-modal__content">

            <div class="history-modal__image-section">
                <img id="history-modal-image" src="" alt="" class="history-modal__image">

                <div class="history-modal__nav">
                    <button class="history-modal__nav-btn history-modal__nav-btn--prev"
                            type="button"
                            aria-label="Previous image">
                        <?php include get_template_directory() . '/resources/images/icon-arrow-left.svg'; ?>
                    </button>
                    <button class="history-modal__nav-btn history-modal__nav-btn--next"
                            type="button"
                            aria-label="Next image">
                        <?php include get_template_directory() . '/resources/images/icon-arrow-right.svg'; ?>
                    </button>
                </div>
            </div>

            <div class="history-modal__text-section">

                <div class="history-modal__content-wrapper">
                    <div class="history-modal__mobile-nav">
                        <button class="history-modal__nav-btn history-modal__nav-btn--sm history-modal__nav-btn--prev"
                                type="button"
                                aria-label="Previous image">
                            <?php include get_template_directory() . '/resources/images/icon-arrow-left.svg'; ?>
                        </button>
                        <button class="history-modal__nav-btn history-modal__nav-btn--sm history-modal__nav-btn--next"
                                type="button"
                                aria-label="Next image">
                            <?php include get_template_directory() . '/resources/images/icon-arrow-right.svg'; ?>
                        </button>
                    </div>

                    <div id="history-modal-year" class="history-modal__year"></div>
                    <div id="history-modal-text" class="history-modal__text"></div>
                </div>

            </div>

        </div>
    </div>
</div>
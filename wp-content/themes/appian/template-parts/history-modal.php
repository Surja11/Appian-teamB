<?php
?>

<div class="history-modal-overlay position-fixed top-0 start-0 w-100 h-100 d-flex align-items-start align-items-md-center justify-content-center overflow-hidden pe-auto d-none" id="history-modal-overlay">
        <div class="history-modal position-relative overflow-hidden d-flex flex-column w-100 bg-white m-0">

        <button class="history-modal__close position-absolute border-0 cursor-pointer d-flex align-items-center justify-content-center bg-transparent p-0 pe-auto" aria-label="Close modal">
            <?php include get_template_directory() . '/resources/images/icon-close.svg'; ?>
        </button>

        <div class="history-modal__content d-flex flex-column flex-md-row w-100 h-100">

            <div class="history-modal__image-section position-relative overflow-hidden flex-shrink-0">
                <img id="history-modal-image" src="" alt="" class="history-modal__image w-100 h-100 object-fit-cover d-block bg-neutral-100">

                <div class="history-modal__nav position-absolute d-none d-md-flex align-items-center justify-content-between pe-none">
                    <button class="history-modal__nav-btn history-modal__nav-btn--prev border-0 cursor-pointer d-flex align-items-center justify-content-center flex-shrink-0 bg-primary text-white rounded-circle pe-auto"
                            type="button"
                            aria-label="Previous image">
                        <?php include get_template_directory() . '/resources/images/icon-arrow-left.svg'; ?>
                    </button>
                    <button class="history-modal__nav-btn history-modal__nav-btn--next border-0 cursor-pointer d-flex align-items-center justify-content-center flex-shrink-0 bg-primary text-white rounded-circle pe-auto"
                            type="button"
                            aria-label="Next image">
                        <?php include get_template_directory() . '/resources/images/icon-arrow-right.svg'; ?>
                    </button>
                </div>
            </div>

            <div class="history-modal__text-section overflow-hidden d-flex flex-column flex-1 justify-content-md-start">

                <div class="history-modal__content-wrapper w-100 d-flex flex-column flex-1">
                    <div class="history-modal__mobile-nav py-2 mb-8 gap-3 d-flex flex-row align-items-center d-md-none flex-shrink-0 position-sticky top-0 bg-white">
                        <button class="history-modal__nav-btn history-modal__nav-btn--sm history-modal__nav-btn--prev border-0 cursor-pointer d-flex align-items-center justify-content-center flex-shrink-0 bg-primary text-white rounded-circle pe-auto"
                                type="button"
                                aria-label="Previous image">
                            <?php include get_template_directory() . '/resources/images/icon-arrow-left.svg'; ?>
                        </button>
                        <button class="history-modal__nav-btn history-modal__nav-btn--sm history-modal__nav-btn--next border-0 cursor-pointer d-flex align-items-center justify-content-center flex-shrink-0 bg-primary text-white rounded-circle pe-auto"
                                type="button"
                                aria-label="Next image">
                            <?php include get_template_directory() . '/resources/images/icon-arrow-right.svg'; ?>
                        </button>
                    </div>
                    <div class="history-modal-text-wrapper w-100 overflow-auto">
                        <div class="history-modal-scrollable-content w-100 h-100 overflow-auto">
                            <div id="history-modal-year" class="history-modal__year mb-8 mb-md-10 text-start w-100 d-block"></div>
                            <div id="history-modal-text" class="history-modal__text body text-start pb-10 pb-md-0"></div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
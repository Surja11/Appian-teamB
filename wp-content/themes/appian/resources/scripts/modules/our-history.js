class OurHistoryModule {
    constructor() {
        this.scrollContainer = null;
        this.prevBtn = null;
        this.nextBtn = null;
        this.init();
    }

    init() {
        this.scrollContainer = document.querySelector('.timeline-scroll-container');
        this.prevBtn = document.querySelector('.history-nav--prev');
        this.nextBtn = document.querySelector('.history-nav--next');

        this.bindTimelineNavigation();
        this.updateButtonStates();

        if (this.scrollContainer) {
            this.scrollContainer.addEventListener('scroll', () => {
                this.updateButtonStates();
            });
        }
    }

    bindTimelineNavigation() {
        if (this.prevBtn && this.scrollContainer) {
            this.prevBtn.addEventListener('click', () => {
                this.scrollTimeline('prev');
            });
        }

        if (this.nextBtn && this.scrollContainer) {
            this.nextBtn.addEventListener('click', () => {
                this.scrollTimeline('next');
            });
        }
    }

    scrollTimeline(direction) {
        if (!this.scrollContainer) return;

        const scrollAmount = 400;
        const currentScroll = this.scrollContainer.scrollLeft;

        if (direction === 'prev') {
            this.scrollContainer.scrollTo({
                left: currentScroll - scrollAmount,
                behavior: 'smooth'
            });
        } else if (direction === 'next') {
            this.scrollContainer.scrollTo({
                left: currentScroll + scrollAmount,
                behavior: 'smooth'
            });
        }
    }

    updateButtonStates() {
        if (!this.scrollContainer || !this.prevBtn || !this.nextBtn) return;

        const scrollLeft = this.scrollContainer.scrollLeft;
        const maxScroll = this.scrollContainer.scrollWidth - this.scrollContainer.clientWidth;

        this.prevBtn.disabled = scrollLeft <= 0;
        this.nextBtn.disabled = scrollLeft >= maxScroll;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new OurHistoryModule();
});
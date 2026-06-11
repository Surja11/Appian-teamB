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
        
        // Update button states on window resize to handle responsive layout 
        window.addEventListener('resize', () => {
            // Use debounce to avoid excessive calls
            clearTimeout(this.resizeTimeout);
            this.resizeTimeout = setTimeout(() => {
                this.updateButtonStates();
            }, 250);
        });
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

        const scrollAmount = 550;
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
        
        // Add a small tolerance to handle rounding issues on different screen sizes
        const tolerance = 1;

        // Previous button - disable at start
        this.prevBtn.disabled = scrollLeft <= tolerance;
        
        // Next button - disable at end
        this.nextBtn.disabled = scrollLeft >= (maxScroll - tolerance);
        
        if (this.prevBtn.disabled) {
            this.prevBtn.classList.add('disabled');
        } else {
            this.prevBtn.classList.remove('disabled');
        }
        
        if (this.nextBtn.disabled) {
            this.nextBtn.classList.add('disabled');
        } else {
            this.nextBtn.classList.remove('disabled');
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new OurHistoryModule();
});
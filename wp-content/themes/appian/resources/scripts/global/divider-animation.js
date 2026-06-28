

class DividerAnimation {
    constructor() {
        this.observers = [];
        this.init();
    }

    init() {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.setup());
        } else {
            this.setup();
        }
    }

    setup() {
        this.createObserver();
        this.observeDividers();
        this.handleInitiallyVisible();
    }

    createObserver() {
        this.observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.animateElement(entry.target);
                    
                    this.observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.3,
            rootMargin: '0px 0px -50px 0px'
        });
    }

    observeDividers() {
        this.findAndAnimateDividers();
        
        this.setupMutationObserver();
    }

    handleInitiallyVisible() {
        setTimeout(() => {
            const allDividers = document.querySelectorAll('.divider-animate, .divider-animate-bg');
            
            allDividers.forEach(divider => {
                const rect = divider.getBoundingClientRect();
                const isVisible = (
                    rect.top < window.innerHeight && 
                    rect.bottom > 0 &&
                    rect.top > -50
                );
                
                if (isVisible && !divider.classList.contains('animate-in')) {
                    const delay = Math.random() * 300 + 200;
                    
                    setTimeout(() => {
                        this.animateElement(divider);
                        this.observer.unobserve(divider);
                    }, delay);
                }
            });
        }, 100);
    }

    findAndAnimateDividers() {
        const pictureElements = document.querySelectorAll('picture');
        
        pictureElements.forEach(picture => {
            const img = picture.querySelector('img[src*="divider"]');
            if (img) {
                picture.classList.add('divider-animate');
                this.observer.observe(picture);
            }
        });

        const historyTitles = document.querySelectorAll('.our-history__title');
        historyTitles.forEach(title => {
            title.classList.add('divider-animate-bg');
            this.observer.observe(title);
        });

        const explicitDividers = document.querySelectorAll('.divider-animate, .divider-animate-bg');
        explicitDividers.forEach(divider => {
            this.observer.observe(divider);
        });
    }

    setupMutationObserver() {
        const mutationObserver = new MutationObserver((mutations) => {
            mutations.forEach(mutation => {
                if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                    setTimeout(() => {
                        this.findAndAnimateDividers();
                    }, 100);
                }
            });
        });

        mutationObserver.observe(document.body, {
            childList: true,
            subtree: true
        });
    }

    animateElement(element) {
        if (element) {
            element.classList.add('animate-in');
        }
    }

    addDivider(element) {
        if (element && this.observer) {
            element.classList.add('divider-animate');
            this.observer.observe(element);
        }
    }
}

const dividerAnimation = new DividerAnimation();

window.DividerAnimation = dividerAnimation;
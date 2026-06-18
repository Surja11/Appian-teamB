class HistoryModalModule {
    constructor() {
        this.modal        = null;
        this.currentId    = null;
        this.currentImage = 0;
        this.imagesCache  = {};
        this.lastActiveElement = null;
        this.focusableElements = null;
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
        this.modal = document.getElementById('history-modal-overlay');

        if (this.modal && this.modal.parentElement !== document.body) {
            document.body.appendChild(this.modal);
        }

        this.bindEvents();
    }

    bindEvents() {
        // avoid null errors
        const readMoreBtns = document.querySelectorAll('.history-card__read-more');
        if (readMoreBtns) {
            readMoreBtns.forEach((btn, index) => {
                if (btn) {
                    const historyId = btn.getAttribute('data-history-id');
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        if (historyId) {
                            this.openModal(historyId);
                        }
                    });
                }
            });
        }

        const historyCards = document.querySelectorAll('.history-card');
        if (historyCards) {
            historyCards.forEach((card, index) => {
                if (card) {
                    const historyId = card.getAttribute('data-year');
                    
                    // Click event
                    card.addEventListener('click', (e) => {
                        if (e.target.closest('.history-card__read-more')) {
                            return;
                        }
                        if (historyId) {
                            this.openModal(historyId);
                        }
                    });
                    
                    // Keyboard event (Enter or Space)
                    card.addEventListener('keydown', (e) => {
                        if ((e.key === 'Enter' || e.key === ' ') && !e.target.closest('.history-card__read-more')) {
                            e.preventDefault();
                            if (historyId) {
                                this.openModal(historyId);
                            }
                        }
                    });
                }
            });
        }

        if (this.modal) {
            this.bindModalEvents();
        }
    }

    getHistoryData(historyId) {
        if (!historyId) {
            return null;
        }
        
        const card = document.querySelector(`.history-card[data-year="${historyId}"]`);
        if (!card) {
            return null;
        }

        const year        = card.querySelector('.history-card__year');
        const fullContent = card.querySelector('.history-card__full-content');
        const excerpt     = card.querySelector('.history-card__excerpt');

        let images = [];

        // Feature image
        const primaryImage = card.querySelector('.history-card__image');
        const primarySrc = primaryImage ? primaryImage.getAttribute('src') : null;
        if (primarySrc) {
            images.push(primarySrc);
        }

        // Gallery images
        const galleryImgs = card.querySelectorAll('.history-card__gallery-item img');
        if (galleryImgs) {
            galleryImgs.forEach(img => {
                if (img && img.src) {
                    images.push(img.src);
                }
            });
        }

        let content = '';
        let hasContent = false;
        
        if (fullContent && fullContent.innerHTML && fullContent.innerHTML.trim()) {
            content = fullContent.innerHTML.trim();
            hasContent = true;
        } else if (excerpt && excerpt.textContent && excerpt.textContent.trim()) {
            content = `<p>${excerpt.textContent.trim()}</p>`;
            hasContent = true;
        }

        const data = {
            year: year && year.textContent ? year.textContent.trim() : null,
            images,
            text: content,
            hasYear: !!(year && year.textContent),
            hasImages: images.length > 0,
            hasContent: hasContent
        };

        return data;
    }

    openModal(historyId) {
        if (!this.modal || !historyId) {
            return;
        }
        
        // Store currently focused element
        this.lastActiveElement = document.activeElement;
        
        this.currentId    = historyId;
        this.currentImage = 0;
        this.renderContent();
        
        this.modal.classList.remove('d-none');
        this.modal.classList.add('d-flex');
        document.body.style.overflow = 'hidden';

        const modalEl = this.modal.querySelector('.history-modal');
        if (modalEl) modalEl.scrollTop = 0;

        // Set up focus trapping and move focus to modal
        this.setupFocusTrapping();
        this.focusFirstElement();
    }

    renderContent() {
        const data = this.getHistoryData(this.currentId);
        if (!data) {
            return;
        }

        const modalImageSection = this.modal.querySelector('.history-modal__image-section');
        const modalImage = document.getElementById('history-modal-image');
        const modalYear  = document.getElementById('history-modal-year');
        const modalText  = document.getElementById('history-modal-text');

        // Hide entire image section if no images
        if (data.hasImages && modalImageSection) {
            modalImageSection.style.display = '';
            if (modalImage) {
                modalImage.style.transition = 'opacity 0.15s ease';
                modalImage.style.opacity = '0';
                
                // Assign new source and alt
                modalImage.src = data.images[this.currentImage] || '';
                modalImage.alt = `Historical image from ${data.year || 'history'}`;
                
                modalImage.onload = () => {
                    modalImage.style.opacity = '1';
                };
            }

            const closeBtn = this.modal.querySelector('.history-modal__close');
            if (closeBtn) {
                closeBtn.classList.remove('history-modal__close--no-image');
            }
            this.modal.classList.remove('history-modal--no-image');
        } else if (modalImageSection) {
            modalImageSection.style.display = 'none';
            const closeBtn = this.modal.querySelector('.history-modal__close');
            if (closeBtn) {
                closeBtn.classList.add('history-modal__close--no-image');
            }
            this.modal.classList.add('history-modal--no-image');
        }

        // Hide if no year
        if (data.hasYear && modalYear && data.year) {
            modalYear.textContent = data.year;
            modalYear.style.display = '';
        } else if (modalYear) {
            modalYear.style.display = 'none';
        }

        // Hide if no content
        if (data.hasContent && modalText && data.text) {
            modalText.innerHTML = data.text;
            modalText.style.display = '';
        } else if (modalText) {
            modalText.style.display = 'none';
        }

        this.updateNavState(data);
    }

    updateNavState(data) {
        if (!data) return;
        
        const isFirst     = this.currentImage === 0;
        const isLast      = this.currentImage >= data.images.length - 1;
        const hasMultiple = data.images.length > 1;

        const desktopNav = this.modal.querySelector('.history-modal__nav');
        const mobileNav  = this.modal.querySelector('.history-modal__mobile-nav');
        
        if (desktopNav) {
            desktopNav.style.display = hasMultiple ? '' : 'none';
        }
        if (mobileNav) {
            mobileNav.style.display = hasMultiple ? '' : 'none';
        }

        const prevBtns = this.modal.querySelectorAll('.history-modal__nav-btn--prev');
        const nextBtns = this.modal.querySelectorAll('.history-modal__nav-btn--next');
        
        if (prevBtns) {
            prevBtns.forEach(btn => {
                if (btn) btn.disabled = isFirst;
            });
        }
        
        if (nextBtns) {
            nextBtns.forEach(btn => {
                if (btn) btn.disabled = isLast;
            });
        }

        // Refresh focusable elements after navigation state changes
        this.setupFocusTrapping();
    }

    bindModalEvents() {
        if (!this.modal) {
            return;
        }
        
        // Click outside modal to close
        this.modal.addEventListener('click', (e) => {
            if (e.target === this.modal) {
                this.closeModal();
            }
        });

        // Close button
        const closeBtn = this.modal.querySelector('.history-modal__close');
        if (closeBtn) {
            closeBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.closeModal();
            });
        }

        // Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !this.modal.classList.contains('d-none')) {
                this.closeModal();
            }
        });

        // Tab key focus trapping
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Tab' && !this.modal.classList.contains('d-none')) {
                this.trapFocus(e);
            }
        });

        // Navigation buttons
        const prevBtns = this.modal.querySelectorAll('.history-modal__nav-btn--prev');
        const nextBtns = this.modal.querySelectorAll('.history-modal__nav-btn--next');
        
        if (prevBtns) {
            prevBtns.forEach(btn => {
                if (btn) {
                    btn.addEventListener('click', (e) => { 
                        e.stopPropagation(); 
                        this.navigateImage(-1); 
                    });
                }
            });
        }
        
        if (nextBtns) {
            nextBtns.forEach(btn => {
                if (btn) {
                    btn.addEventListener('click', (e) => { 
                        e.stopPropagation(); 
                        this.navigateImage(1); 
                    });
                }
            });
        }
    }

    navigateImage(direction) {
        const data = this.getHistoryData(this.currentId);
        if (!data) return;
        const next = this.currentImage + direction;
        if (next < 0 || next >= data.images.length) return;
        this.currentImage = next;
        this.renderContent();
    }

    closeModal() {
        if (!this.modal) {
            return;
        }
        
        this.modal.classList.remove('d-flex');
        this.modal.classList.add('d-none');
        document.body.style.overflow = '';
        
        this.currentId    = null;
        this.currentImage = 0;
        
        const modalImage = document.getElementById('history-modal-image');
        if (modalImage) {
            modalImage.style.opacity = '0';
            modalImage.src = '';
        }

        // Return focus to element that opened the modal
        if (this.lastActiveElement) {
            this.lastActiveElement.focus();
            this.lastActiveElement = null;
        }
    }

    setupFocusTrapping() {
        // Get all focusable elements within the modal
        const focusableSelectors = [
            'button:not([disabled])',
            '[href]',
            'input:not([disabled])',
            'select:not([disabled])',
            'textarea:not([disabled])',
            '[tabindex]:not([tabindex="-1"])'
        ];
        
        this.focusableElements = this.modal.querySelectorAll(focusableSelectors.join(', '));
    }

    focusFirstElement() {
        if (this.focusableElements && this.focusableElements.length > 0) {
            // Focus close button first
            const closeBtn = this.modal.querySelector('.history-modal__close');
            if (closeBtn) {
                closeBtn.focus();
            } else {
                this.focusableElements[0].focus();
            }
        }
    }

    trapFocus(e) {
        if (!this.focusableElements || this.focusableElements.length === 0) {
            return;
        }

        const firstElement = this.focusableElements[0];
        const lastElement = this.focusableElements[this.focusableElements.length - 1];

        if (e.shiftKey) {
            // Shift + Tab
            if (document.activeElement === firstElement) {
                e.preventDefault();
                lastElement.focus();
            }
        } else {
            // Tab
            if (document.activeElement === lastElement) {
                e.preventDefault();
                firstElement.focus();
            }
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // Add a small delay to ensure all elements are ready
    setTimeout(() => {
        new HistoryModalModule();
    }, 100);
});
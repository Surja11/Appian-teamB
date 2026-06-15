class HistoryModalModule {
    constructor() {
        this.modal        = null;
        this.currentId    = null;
        this.currentImage = 0;
        this.imagesCache  = {};
        this.init();
    }

    init() {
        this.modal = document.getElementById('history-modal-overlay');

        if (this.modal && this.modal.parentElement !== document.body) {
            document.body.appendChild(this.modal);
        }

        this.bindEvents();
    }

    bindEvents() {
        document.querySelectorAll('.history-card__read-more').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.openModal(btn.getAttribute('data-history-id'));
            });
        });

        document.querySelectorAll('.history-card').forEach(card => {
            card.addEventListener('click', (e) => {
                if (e.target.closest('.history-card__read-more')) return;
                const historyId = card.getAttribute('data-year');
                if (historyId) this.openModal(historyId);
            });
        });

        if (this.modal) this.bindModalEvents();
    }

    getHistoryData(historyId) {
        const card = document.querySelector(`.history-card[data-year="${historyId}"]`);
        if (!card) return null;

        const year        = card.querySelector('.history-card__year');
        const fullContent = card.querySelector('.history-card__full-content');
        const excerpt     = card.querySelector('.history-card__excerpt');

        let images = [];

        // Feature image
        const primarySrc = card.querySelector('.history-card__image')?.getAttribute('src');
        if (primarySrc) images.push(primarySrc);

        // Gallery images
        const galleryImgs = card.querySelectorAll('.history-card__gallery-item img');
        galleryImgs.forEach(img => {
            if (img.src) images.push(img.src);
        });

        let content = '';
        let hasContent = false;
        
        if (fullContent && fullContent.innerHTML.trim()) {
            content = fullContent.innerHTML.trim();
            hasContent = true;
        } else if (excerpt && excerpt.textContent.trim()) {
            content = `<p>${excerpt.textContent.trim()}</p>`;
            hasContent = true;
        }

        return {
            year: year ? year.textContent.trim() : null,
            images,
            text: content,
            hasYear: !!year,
            hasImages: images.length > 0,
            hasContent: hasContent
        };
    }

    openModal(historyId) {
        if (!this.modal) return;
        this.currentId    = historyId;
        this.currentImage = 0;
        this.renderContent();
        this.modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';

        const modalEl = this.modal.querySelector('.history-modal');
        if (modalEl) modalEl.scrollTop = 0;
    }

    renderContent() {
        const data = this.getHistoryData(this.currentId);
        if (!data) return;

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
        const isFirst     = this.currentImage === 0;
        const isLast      = this.currentImage >= data.images.length - 1;
        const hasMultiple = data.images.length > 1;

        const desktopNav = this.modal.querySelector('.history-modal__nav');
        const mobileNav  = this.modal.querySelector('.history-modal__mobile-nav');
        if (desktopNav) desktopNav.style.display = hasMultiple ? '' : 'none';
        if (mobileNav)  mobileNav.style.display  = hasMultiple ? '' : 'none';

        this.modal.querySelectorAll('.history-modal__nav-btn--prev')
            .forEach(btn => btn.disabled = isFirst);
        this.modal.querySelectorAll('.history-modal__nav-btn--next')
            .forEach(btn => btn.disabled = isLast);
    }

    bindModalEvents() {
        this.modal.addEventListener('click', (e) => {
            if (e.target === this.modal) this.closeModal();
        });

        const closeBtn = this.modal.querySelector('.history-modal__close');
        if (closeBtn) closeBtn.addEventListener('click', () => this.closeModal());

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.modal.style.display === 'flex') this.closeModal();
        });

        this.modal.querySelectorAll('.history-modal__nav-btn--prev')
            .forEach(btn => btn.addEventListener('click', (e) => { e.stopPropagation(); this.navigateImage(-1); }));
        this.modal.querySelectorAll('.history-modal__nav-btn--next')
            .forEach(btn => btn.addEventListener('click', (e) => { e.stopPropagation(); this.navigateImage(1); }));
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
        if (!this.modal) return;
        this.modal.style.display = 'none';
        document.body.style.overflow = '';
        this.currentId    = null;
        this.currentImage = 0;
        
        const modalImage = document.getElementById('history-modal-image');
        if (modalImage) {
            modalImage.style.opacity = '0';
            modalImage.src = '';
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new HistoryModalModule();
});
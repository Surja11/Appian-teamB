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

        if (this.modal) this.bindModalEvents();
    }

    getHistoryData(historyId) {
        const card = document.querySelector(`.history-card[data-year="${historyId}"]`);
        if (!card) return null;

        const year        = card.querySelector('.history-card__year');
        const fullContent = card.querySelector('.history-card__full-content');
        const excerpt     = card.querySelector('.history-card__excerpt');

        let images = [];

        const dataImages = card.getAttribute('data-images');
        if (dataImages) {
            try {
                images = JSON.parse(dataImages).filter(Boolean);
            } catch (e) { }
        }

        if (!images.length) {
            const primarySrc = card.querySelector('.history-card__image')?.getAttribute('src');

            const DUMMY_EXTRA_IMAGES = {
                '1922': [
                    '/wp-content/themes/appian/resources/images/history-1928.png',
                    '/wp-content/themes/appian/resources/images/history-1929.png',
                ],
                '1928': [
                    '/wp-content/themes/appian/resources/images/history-1922.png',
                    '/wp-content/themes/appian/resources/images/history-1929.png',
                ],
                '1929': [
                    '/wp-content/themes/appian/resources/images/history-1922.png',
                    '/wp-content/themes/appian/resources/images/history-1928.png',
                ],
            };

            if (primarySrc) {
                images = [primarySrc, ...(DUMMY_EXTRA_IMAGES[historyId] || [])];
            }
        }

        if (!images.length) {
            images.push(`/wp-content/themes/appian/resources/images/history-${historyId}.png`);
        }

        let content = '';
        if (fullContent && fullContent.innerHTML.trim()) {
            content = fullContent.innerHTML.trim();
        } else if (excerpt) {
            content = `<p>${excerpt.textContent.trim()}</p>`;
        } else {
            content = `<p>No content available.</p>`;
        }

        return {
            year:   year ? year.textContent.trim() : historyId,
            images,
            text:   content,
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

        const modalImage = document.getElementById('history-modal-image');
        const modalYear  = document.getElementById('history-modal-year');
        const modalText  = document.getElementById('history-modal-text');

        if (modalImage) {
            modalImage.src = data.images[this.currentImage] || '';
            modalImage.alt = `Historical image from ${data.year}`;
        }
        if (modalYear) modalYear.textContent = data.year;
        if (modalText) modalText.innerHTML   = data.text;

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
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new HistoryModalModule();
});
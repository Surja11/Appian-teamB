class VideoModalModule {
    constructor() {
        this.modal = null;
        this.modalVideo = null;
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
        this.modal = document.getElementById('video-modal-overlay');
        this.modalVideo = document.getElementById('modalVideoPlayer');

        if (this.modal && this.modal.parentElement !== document.body) {
            document.body.appendChild(this.modal);
        }

        this.bindEvents();
    }

    bindEvents() {
        const videoThumbnails = document.querySelectorAll('.video-thumbnail-wrapper');
        
        videoThumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', () => {
                this.openModal(thumbnail);
            });
            
            thumbnail.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.openModal(thumbnail);
                }
            });
        });

        const playButtons = document.querySelectorAll('.video-control-btn');
        playButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const thumbnail = e.target.closest('.video-thumbnail-wrapper');
                if (thumbnail) {
                    this.openModal(thumbnail);
                }
            });
        });

        if (this.modal) {
            this.bindModalEvents();
        }
    }

    openModal(thumbnailElement) {
        if (!this.modal || !this.modalVideo || !thumbnailElement) {
            return;
        }

        this.lastActiveElement = document.activeElement;

        const videoUrl = thumbnailElement.getAttribute('data-video-url');
        const enableAudio = thumbnailElement.getAttribute('data-enable-audio') === 'true';

        if (!videoUrl) return;

        const videoSource = this.modalVideo.querySelector('source');
        if (videoSource) {
            videoSource.src = videoUrl;
        }
        this.modalVideo.src = videoUrl;
        this.modalVideo.muted = !enableAudio;

        this.adjustModalSize();

        this.modal.classList.remove('d-none');
        this.modal.classList.add('d-flex');
        document.body.style.overflow = 'hidden';

        this.setupFocusTrapping();
        this.focusFirstElement();

        this.modalVideo.play().catch(error => {
            console.log('Auto-play prevented:', error);
        });
    }

    bindModalEvents() {
        if (!this.modal) return;

        this.modal.addEventListener('click', (e) => {
            if (e.target === this.modal) {
                this.closeModal();
            }
        });

        const closeBtn = this.modal.querySelector('.video-modal__close');
        if (closeBtn) {
            closeBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.closeModal();
            });
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !this.modal.classList.contains('d-none')) {
                this.closeModal();
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Tab' && !this.modal.classList.contains('d-none')) {
                this.trapFocus(e);
            }
        });

        window.addEventListener('resize', () => {
            if (!this.modal.classList.contains('d-none')) {
                this.adjustModalSize();
            }
        });

        window.addEventListener('orientationchange', () => {
            if (!this.modal.classList.contains('d-none')) {
                setTimeout(() => {
                    this.adjustModalSize();
                }, 100);
            }
        });
    }

    closeModal() {
        if (!this.modal || !this.modalVideo) return;

        this.modalVideo.pause();
        this.modalVideo.currentTime = 0;
        this.modalVideo.src = '';

        this.modal.classList.remove('d-flex');
        this.modal.classList.add('d-none');
        document.body.style.overflow = '';

        if (this.lastActiveElement) {
            this.lastActiveElement.focus();
            this.lastActiveElement = null;
        }
    }

    setupFocusTrapping() {
        const focusableSelectors = [
            'button:not([disabled])',
            '[href]',
            'input:not([disabled])',
            'select:not([disabled])',
            'textarea:not([disabled])',
            'video[controls]',
            '[tabindex]:not([tabindex="-1"])'
        ];
        
        this.focusableElements = this.modal.querySelectorAll(focusableSelectors.join(', '));
    }

    focusFirstElement() {
        if (this.focusableElements && this.focusableElements.length > 0) {
            const closeBtn = this.modal.querySelector('.video-modal__close');
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
            if (document.activeElement === firstElement) {
                e.preventDefault();
                lastElement.focus();
            }
        } else {
            if (document.activeElement === lastElement) {
                e.preventDefault();
                firstElement.focus();
            }
        }
    }

    adjustModalSize() {
        if (!this.modal || !this.modalVideo) return;

        const modalContainer = this.modal.querySelector('.video-modal');
        if (!modalContainer) return;

        const vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);
        const vh = Math.max(document.documentElement.clientHeight || 0, window.innerHeight || 0);

        const safeWidth = vw - (vw < 768 ? 32 : 64);
        const safeHeight = vh - (vh < 600 ? 64 : 80);

        modalContainer.style.maxWidth = `${safeWidth}px`;
        modalContainer.style.maxHeight = `${safeHeight}px`;

        this.modalVideo.style.maxWidth = '100%';
        this.modalVideo.style.maxHeight = '100%';

        console.log(`Viewport: ${vw}x${vh}, Safe area: ${safeWidth}x${safeHeight}`);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        new VideoModalModule();
    }, 100);
});
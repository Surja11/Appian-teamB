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

        this.modal.classList.remove('d-none');
        this.modal.classList.add('d-flex');
        document.body.style.overflow = 'hidden';

        this.setupFocusTrapping();
        this.focusFirstElement();

        this.modalVideo.addEventListener('loadedmetadata', () => {
            this.forceVideoControlsVisible();
        }, { once: true });

        this.modalVideo.play().catch(error => {
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

        if (this.modalVideo) {
            this.modalVideo.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                if (this.modalVideo.paused) {
                    this.modalVideo.play().catch(error => {
                    });
                } else {
                    this.modalVideo.pause();
                }
            });

            this.modalVideo.addEventListener('dblclick', (e) => {
                e.preventDefault();
                e.stopPropagation();
            });
        }

        document.addEventListener('keydown', (e) => {
            if (!this.modal.classList.contains('d-none')) {
                if (e.key === 'Escape') {
                    this.closeModal();
                } else if (e.key === ' ' || e.key === 'Spacebar') {
                    e.preventDefault();
                    if (this.modalVideo.paused) {
                        this.modalVideo.play().catch(error => {
                        });
                    } else {
                        this.modalVideo.pause();
                    }
                }
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Tab' && !this.modal.classList.contains('d-none')) {
                this.trapFocus(e);
            }
        });

        window.addEventListener('resize', () => {
            if (!this.modal.classList.contains('d-none')) {
                this.forceVideoControlsVisible();
            }
        });

        window.addEventListener('orientationchange', () => {
            if (!this.modal.classList.contains('d-none')) {
                setTimeout(() => {
                    this.forceVideoControlsVisible();
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

    forceVideoControlsVisible() {
        if (!this.modalVideo) return;
        
        this.modalVideo.setAttribute('controls', 'true');
        this.modalVideo.controls = true;
        
        const currentTime = this.modalVideo.currentTime;
        this.modalVideo.currentTime = currentTime + 0.01;
        this.modalVideo.currentTime = currentTime;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        new VideoModalModule();
    }, 100);
});
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
        // Video thumbnail click handlers
        const videoThumbnails = document.querySelectorAll('.video-thumbnail-wrapper');
        
        videoThumbnails.forEach(thumbnail => {
            // Click event
            thumbnail.addEventListener('click', () => {
                this.openModal(thumbnail);
            });
            
            // Keyboard event (Enter or Space)
            thumbnail.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.openModal(thumbnail);
                }
            });
        });

        // Play button click handlers
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

        // Store currently focused element
        this.lastActiveElement = document.activeElement;

        // Get video data from thumbnail
        const videoUrl = thumbnailElement.getAttribute('data-video-url');
        const enableAudio = thumbnailElement.getAttribute('data-enable-audio') === 'true';

        if (!videoUrl) return;

        // Set video source and audio preference
        const videoSource = this.modalVideo.querySelector('source');
        if (videoSource) {
            videoSource.src = videoUrl;
        }
        this.modalVideo.src = videoUrl;
        this.modalVideo.muted = !enableAudio;

        // Show modal
        this.modal.classList.remove('d-none');
        this.modal.classList.add('d-flex');
        document.body.style.overflow = 'hidden';

        // Set focus trapping and move focus to modal
        this.setupFocusTrapping();
        this.focusFirstElement();

        // Auto-play video
        this.modalVideo.play().catch(error => {
            console.log('Auto-play prevented:', error);
        });
    }

    bindModalEvents() {
        if (!this.modal) return;

        // Click outside modal to close
        this.modal.addEventListener('click', (e) => {
            if (e.target === this.modal) {
                this.closeModal();
            }
        });

        // Close button
        const closeBtn = this.modal.querySelector('.video-modal__close');
        if (closeBtn) {
            closeBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.closeModal();
            });
        }

        // Escape key to close
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !this.modal.classList.contains('d-none')) {
                this.closeModal();
            }
        });

        // Tab key focus
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Tab' && !this.modal.classList.contains('d-none')) {
                this.trapFocus(e);
            }
        });
    }

    closeModal() {
        if (!this.modal || !this.modalVideo) return;

        // Pause and reset video
        this.modalVideo.pause();
        this.modalVideo.currentTime = 0;
        this.modalVideo.src = '';

        // Hide modal
        this.modal.classList.remove('d-flex');
        this.modal.classList.add('d-none');
        document.body.style.overflow = '';

        // Return focus to element that opened the modal
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
            // Focus close button first
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

// Initialize video modal
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        new VideoModalModule();
    }, 100);
});
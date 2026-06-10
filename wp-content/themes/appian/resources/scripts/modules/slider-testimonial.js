const initTestimonialSlider = () => {

    // ─── Shared state ────────────────────────────────────────────────────────
    let currentIndex = 0;

    // ─── Grab elements ───────────────────────────────────────────────────────
    // Mobile
    const mobileWrapper   = document.querySelector('.testimonial-swiper-mobile .swiper-wrapper');
    const btnPrev         = document.querySelector('.btn-prev-mobile');
    const btnNext         = document.querySelector('.btn-next-mobile');

    // Desktop
    const desktopWrapper  = document.querySelector('.testimonial-swiper-desktop .swiper-wrapper');
    const progressCurrent = document.querySelector('.progress-current');
    const progressFill    = document.querySelector('.progress-bar-fill');
    const progressWrapper = document.querySelector('.progress-bar-wrapper');

    // ─── Work out total slides (use whichever wrapper exists) ────────────────
    const sourceWrapper = mobileWrapper || desktopWrapper;
    if (!sourceWrapper) return;

    const total = sourceWrapper.querySelectorAll('.swiper-slide').length;
    if (total === 0) return;

    // ─── Core: move to slide N ────────────────────────────────────────────────
    const goTo = (index) => {
        // Clamp — no looping
        currentIndex = Math.max(0, Math.min(index, total - 1));

        // Translate both wrappers
        [mobileWrapper, desktopWrapper].forEach((wrapper) => {
            if (!wrapper) return;
            wrapper.style.transform = `translateX(-${currentIndex * 100}%)`;
        });

        // Update desktop progress UI
        updateProgress();

        // Update mobile button states
        updateButtons();
    };

    // ─── Progress bar & counter ──────────────────────────────────────────────
    const updateProgress = () => {
        if (progressCurrent) {
            progressCurrent.textContent = String(currentIndex + 1).padStart(2, '0');
        }
        if (progressFill) {
            // Width as a percentage of the bar wrapper — no px math
            const minW = 1.5;
            const maxW = 4;
            const w = total > 1 ? minW + ((currentIndex / (total - 1)) * (maxW - minW)) : maxW;
            progressFill.style.width = `${w}rem`;
        }
    };

    // ─── Mobile button disabled states ───────────────────────────────────────
    const updateButtons = () => {
        if (btnPrev) btnPrev.disabled = currentIndex === 0;
        if (btnNext) btnNext.disabled = currentIndex === total - 1;
    };

    // ─── Mobile button events ─────────────────────────────────────────────────
    if (btnPrev) {
        btnPrev.addEventListener('click', () => goTo(currentIndex - 1));
    }
    if (btnNext) {
        btnNext.addEventListener('click', () => goTo(currentIndex + 1));
    }

    // ─── Desktop: progress bar click ─────────────────────────────────────────
    if (progressWrapper) {
        progressWrapper.addEventListener('click', (e) => {
            const rect  = progressWrapper.getBoundingClientRect();
            const ratio = (e.clientX - rect.left) / rect.width;
            const target = Math.round(ratio * (total - 1));
            goTo(target);
        });
    }

    // ─── Desktop: keyboard arrow support ─────────────────────────────────────
    document.addEventListener('keydown', (e) => {
        // Only fire when the desktop slider is visible
        if (!desktopWrapper) return;
        if (e.key === 'ArrowLeft')  goTo(currentIndex - 1);
        if (e.key === 'ArrowRight') goTo(currentIndex + 1);
    });

    // ─── Set initial state ────────────────────────────────────────────────────
    // Make sure wrappers don't animate on first paint
    [mobileWrapper, desktopWrapper].forEach((wrapper) => {
        if (!wrapper) return;
        wrapper.style.display         = 'flex';
        wrapper.style.transition      = 'transform 0.45s cubic-bezier(0.4, 0, 0.2, 1)';
        wrapper.style.willChange      = 'transform';
    });

    goTo(0);
};

export default initTestimonialSlider;

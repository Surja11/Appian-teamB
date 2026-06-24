document.addEventListener('DOMContentLoaded', function () {
    const marquee = document.querySelector('.logo-marquee');
    const track = document.querySelector('.logo-marquee__track');
    const inner = document.querySelector('.logo-marquee__inner');
    const originalContainer = document.querySelector('.logo-marquee__container');

    if (!marquee || !track || !inner || !originalContainer) return;

    function setupClones() {
        // Remove existing clones
        inner.querySelectorAll('.logo-marquee__container[aria-hidden="true"]').forEach(
            el => el.remove()
        );
        inner.style.animation = 'none';
        inner.style.transform = 'translateX(0)';
        void inner.offsetHeight; 

        const trackWidth = track.offsetWidth;
        const originalWidth = originalContainer.offsetWidth;

        // Clone until we have 3x track width worth of content
        const clonesNeeded = Math.ceil((trackWidth * 3) / originalWidth) + 1;
        for (let i = 0; i < clonesNeeded; i++) {
            const clone = originalContainer.cloneNode(true);
            clone.setAttribute('aria-hidden', 'true');
            inner.appendChild(clone);
        }

        inner.style.setProperty('--marquee-scroll-amount', `${originalWidth}px`);

        const speed = 50;
        const duration = originalWidth / speed;
        inner.style.setProperty('--marquee-duration', `${duration}s`);

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                inner.style.animation = '';
            });
        });
    }

    setupClones();

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach(entry => {
                inner.style.animationPlayState = entry.isIntersecting ? 'running' : 'paused';
            });
        },
        { root: null, threshold: 0.1 }
    );
    observer.observe(marquee);

    inner.addEventListener('mouseenter', () => {
        inner.style.animationPlayState = 'paused';
    });
    inner.addEventListener('mouseleave', () => {
        if (marquee.getBoundingClientRect().top < window.innerHeight) {
            inner.style.animationPlayState = 'running';
        }
    });

    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(setupClones, 150);
    });
});
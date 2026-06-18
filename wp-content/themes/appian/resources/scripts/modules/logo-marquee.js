// document.addEventListener('DOMContentLoaded', function () {
//     const marquee = document.getElementsByClassName('logo-marquee')[0];
//     const track = document.getElementsByClassName('logo-marquee__track')[0];
//     const inner = document.getElementsByClassName('logo-marquee__inner')[0];
//     const originalContainer = document.getElementsByClassName('logo-marquee__container')[0];

//     if (!marquee || !track || !inner || !originalContainer) 
//         return;


//     // if the elements are less, cloning them
//     function setupClones() {
//         // removing existing clones
//         inner.querySelectorAll('.logo-marquee__container[aria-hidden="true"]').forEach(
//             container => container.remove()
//         );

//         const trackWidth = track.offsetWidth;
//         let totalWidth = inner.scrollWidth;

//         // repeating entire container until it is 2x track width for smooth scrol
//         while (totalWidth < trackWidth * 2) {
//             const repeatedContainer = originalContainer.cloneNode(true);
//             repeatedContainer.setAttribute('aria-hidden', 'true');

//             inner.appendChild(repeatedContainer);
//             totalWidth = inner.scrollWidth;
//         }

//         // setting exact px scroll amount — original container width only
//         const originalWidth = originalContainer.offsetWidth;
//         inner.style.setProperty('--marquee-scroll-amount', `${originalWidth}px`);

//         const speed = 50;
//         const duration = originalWidth / speed;
//         inner.style.setProperty('--marquee-duration', `${duration}s`);
//     }

//     setupClones();

//     //applying intersection observer
//     const observer = new IntersectionObserver(
//         (entries) => {
//             entries.forEach(entry => {
//                 inner.style.animationPlayState = entry.isIntersecting
//                     ? 'running'
//                     : 'paused';
//             });
//         },
//         { root: null, threshold: 0.1 }
//     );

//     observer.observe(marquee);

//   //stopping on hover
//     inner.addEventListener('mouseenter', () => {
//         inner.style.animationPlayState = 'paused';
//     });

//     inner.addEventListener('mouseleave', () => {
//         if (marquee.getBoundingClientRect().top < window.innerHeight) {
//             inner.style.animationPlayState = 'running';
//         }
//     });

  
//   //resize
//     let resizeTimer;
//     window.addEventListener('resize', () => {
//         clearTimeout(resizeTimer);
//         resizeTimer = setTimeout(() => {
//             inner.style.animation = 'none';
//             setupClones();
//             inner.offsetHeight; 
//             inner.style.animation = '';
//         }, 150);
//     });
// });


document.addEventListener('DOMContentLoaded', function () {
    const marquee = document.getElementsByClassName('logo-marquee')[0];
    const track = document.getElementsByClassName('logo-marquee__track')[0];
    const inner = document.getElementsByClassName('logo-marquee__inner')[0];
    const originalContainer = document.getElementsByClassName('logo-marquee__container')[0];

    if (!marquee || !track || !inner || !originalContainer) 
        return;


    // if the elements are less, cloning them
    function setupClones() {
        // removing existing clones
        inner.querySelectorAll('.logo-marquee__container[aria-hidden="true"]').forEach(
            container => container.remove()
        );

        const trackWidth = track.offsetWidth;
        let totalWidth = inner.scrollWidth;

        // repeating entire container until it is 2x track width for smooth scrol
        while (inner.children.length < 2 || totalWidth < trackWidth * 2) {
            const repeatedContainer = originalContainer.cloneNode(true);
            repeatedContainer.setAttribute('aria-hidden', 'true');

            inner.appendChild(repeatedContainer);
            totalWidth = inner.scrollWidth;
        }

        // setting exact px scroll amount — original container width only
        const originalWidth = originalContainer.offsetWidth;
        inner.style.setProperty('--marquee-scroll-amount', `${originalWidth}px`);

        const speed = 50;
        const duration = originalWidth / speed;
        inner.style.setProperty('--marquee-duration', `${duration}s`);
    }

    // waiting for images to load before measuring widths
    function imagesLoaded(container) {
        const imgs = container.querySelectorAll('img');
        return Promise.all(
            Array.from(imgs).map(img =>
                img.complete ? Promise.resolve() : new Promise(res => {
                    img.addEventListener('load', res, { once: true });
                    img.addEventListener('error', res, { once: true });
                })
            )
        );
    }

    imagesLoaded(originalContainer).then(setupClones);

    //applying intersection observer
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach(entry => {
                inner.style.animationPlayState = entry.isIntersecting
                    ? 'running'
                    : 'paused';
            });
        },
        { root: null, threshold: 0.1 }
    );

    observer.observe(marquee);

  //stopping on hover
    inner.addEventListener('mouseenter', () => {
        inner.style.animationPlayState = 'paused';
    });

    inner.addEventListener('mouseleave', () => {
        if (marquee.getBoundingClientRect().top < window.innerHeight) {
            inner.style.animationPlayState = 'running';
        }
    });

  
  //resize
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            inner.style.animation = 'none';
            setupClones();
            inner.offsetHeight; 
            inner.style.animation = '';
        }, 150);
    });
});
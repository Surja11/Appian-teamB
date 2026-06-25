


const scrollEllipse = document.querySelector('.home-leadspace__scroll-ellipse');
const outerEllipse = document.querySelector('.home-leadspace__outer-ellipse');


const PHASES = [
    {
        scrollStart: 0,
        scrollEnd: 0.08,
        rotStart: 0,
        rotEnd: 0.10
    },

    {
        scrollStart: 0.08,
        scrollEnd: 0.25,
        rotStart: 0.10,
        rotEnd: 0.45
    },

    {
        scrollStart: 0.25,
        scrollEnd: 0.55,
        rotStart: 0.45,
        rotEnd: 0.70
    },

    {
        scrollStart: 0.55,
        scrollEnd: 1.00,
        rotStart: 0.70,
        rotEnd: 1.00
    },
];

const TOTAL_SCROLL = window.innerHeight*2;

if (scrollEllipse) {
    window.addEventListener('scroll', () => {
        const scrolled = window.scrollY;
        const progress = Math.min(scrolled / TOTAL_SCROLL, 1); 

        let rotProgress = 0;

        for (const phase of PHASES) {
            if (progress <= phase.scrollEnd) {

                const phaseProgress = (progress - phase.scrollStart) / (phase.scrollEnd - phase.scrollStart);

                rotProgress = phase.rotStart + phaseProgress * (phase.rotEnd - phase.rotStart);
                break;
            }
            rotProgress = phase.rotEnd;
        }

        const rotation = -rotProgress * 180;
        scrollEllipse.style.transform = `rotate(${rotation}deg)`;
    }, { passive: true });
}
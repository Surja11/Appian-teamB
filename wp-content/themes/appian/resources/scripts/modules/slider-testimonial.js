import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';

const initTestimonialSlider = () => {

    // Mobile swiper
    const mobileSwiper = new Swiper('.testimonial-swiper-mobile', {
        modules: [Navigation],
        loop: false,
        navigation: {
            prevEl: '.btn-prev-mobile',
            nextEl: '.btn-next-mobile',
        },
    });

    // Desktop swiper
    const desktopSwiper = new Swiper('.testimonial-swiper-desktop', {
        loop: false,
        on: {
            slideChange: function() {
                const current = document.querySelector('.progress-current');
                const fill = document.querySelector('.progress-bar-fill');
                const total = this.slides.length;
                const index = this.realIndex + 1;

                if (current) {
                    current.textContent = String(index).padStart(2, '0');
                }
                if (fill) {
                    fill.style.width = `${(index / total) * 24}px`;
                }
            }
        }
    });

    // Make progress bar clickable on desktop
    const progressBarWrapper = document.querySelector('.progress-bar-wrapper');
    if (progressBarWrapper) {
        progressBarWrapper.addEventListener('click', (e) => {
            const rect = progressBarWrapper.getBoundingClientRect();
            const clickX = e.clientX - rect.left;
            const ratio = clickX / rect.width;
            const total = desktopSwiper.slides.length;
            const targetIndex = Math.round(ratio * (total - 1));
            desktopSwiper.slideTo(targetIndex);
        });
    }

};

export default initTestimonialSlider;

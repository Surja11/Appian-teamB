import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';
import 'swiper/css';

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
        modules: [Navigation],
        loop: false,                    
        navigation: {
            prevEl: '.btn-prev-desktop', 
            nextEl: '.btn-next-desktop',
        },
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
};

export default initTestimonialSlider;

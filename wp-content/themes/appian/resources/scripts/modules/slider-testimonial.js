import Swiper from 'swiper';
import { Navigation, Mousewheel } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';

const initTestimonialSlider = () => {
    const testimonialSwiper = new Swiper('.testimonial-swiper', {
        modules: [Navigation, Mousewheel],
        loop: false,
        allowTouchMove: true,
        centeredSlides: false,
        slidesPerView: 1,
        spaceBetween: 0,
        mousewheel: {
            forceToAxis: true,
        },
        navigation: {
            prevEl: '.btn-prev',
            nextEl: '.btn-next',
        },
        a11y: {
            prevSlideMessage: 'Previous testimonial',
            nextSlideMessage: 'Next testimonial',
        },
        on: {
            init: function () {
                updateProgress(this);
            },
            slideChange: function () {
                updateProgress(this);
            }
        }
    });

    function updateProgress(swiperInstance) {
        const current = document.querySelector('.progress-current');
        const fill = document.querySelector('.progress-bar-fill');
        
        const totalSlides = swiperInstance.slides.filter(slide => !slide.classList.contains('swiper-slide-duplicate')).length;
        const activeIndex = swiperInstance.realIndex + 1;

        if (current) {
            current.textContent = String(activeIndex).padStart(2, '0');
        }
        if (fill && totalSlides > 0) {
            const progressPercent = activeIndex / totalSlides;
            fill.style.width = `${progressPercent * 64}px`;
        }
    }

    const progressBarWrapper = document.querySelector('.progress-bar-wrapper');
    if (progressBarWrapper) {
        progressBarWrapper.addEventListener('click', (e) => {
            const rect = progressBarWrapper.getBoundingClientRect();
            const clickX = e.clientX - rect.left;
            const ratio = Math.max(0, Math.min(1, clickX / rect.width));
            
            const totalSlides = testimonialSwiper.slides.filter(slide => !slide.classList.contains('swiper-slide-duplicate')).length;
            const targetIndex = Math.floor(ratio * totalSlides);
            
            testimonialSwiper.slideTo(targetIndex);
        });
    }
};

export default initTestimonialSlider;
import '../styles/app.scss';

import.meta.glob(['../images/**', '../fonts/**'], {
  eager: true,
});

import.meta.glob('./modules/**/*.js', {
  eager: true,
});

import './global/header.js';
import './global/footer.js';
import initTestimonialSlider from './modules/slider-testimonial.js';
import 'bootstrap/js/src/collapse';

initTestimonialSlider();
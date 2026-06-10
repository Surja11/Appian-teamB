import.meta.glob('../images/**','../fonts/**', {
  eager: true,
  import: 'default',
});

import.meta.glob('../fonts/**');

import './global/header.js';
import './global/footer.js';
import './modules/history-modal.js';
import initTestimonialSlider from './modules/slider-testimonial.js';
import 'bootstrap/js/src/collapse';

initTestimonialSlider(); 
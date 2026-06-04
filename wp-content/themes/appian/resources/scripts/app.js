import.meta.glob('../images/**','../fonts/**', {
  eager: true,
  import: 'default',
});

import.meta.glob('../fonts/**');

import './global/header.js';
import './modules/history-modal.js';

import 'bootstrap/js/src/collapse';


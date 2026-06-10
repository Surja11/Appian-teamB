function changeButton() {
  const btn = document.querySelector('.cta-content .btn--cta');
  if (!btn) return;

  if (window.innerWidth < 1025) {  
    btn.classList.add('btn--small');
  } else {
    btn.classList.remove('btn--small');
  }
}

window.addEventListener('resize', changeButton);
document.addEventListener('DOMContentLoaded',changeButton);
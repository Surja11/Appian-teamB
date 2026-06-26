document.addEventListener('DOMContentLoaded', function () {
    const accordion = document.getElementById('accordionFlushExample');
    if (!accordion) return;

    const header = document.querySelector('.header');

    accordion.addEventListener('shown.bs.collapse', function (e) {
        const openItem = e.target.closest('.accordion-item');
        if (!openItem) return;

        const headerHeight = header ? header.offsetHeight : 0;
        const itemTop = openItem.getBoundingClientRect().top + window.scrollY;
        const scrollTarget = itemTop - headerHeight - 16;

        window.scrollTo({
            top: scrollTarget,
            behavior: 'smooth',
        });
    });
});

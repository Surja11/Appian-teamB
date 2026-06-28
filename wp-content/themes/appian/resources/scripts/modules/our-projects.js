document.addEventListener('DOMContentLoaded', function () {

    const section = document.querySelector('.our-projects');
    if (!section) return;

    const cardsContainer = document.querySelector('.our-projects__cards');
    if (!cardsContainer) return;

    const enablePagination = section.getAttribute('data-enable-pagination') === 'true';
    const perPage= parseInt(section.getAttribute('data-projects-per-page')) || 6;
    const selectedIds= section.getAttribute('data-selected-ids') || '';

    let currentFilter = 'all';
    let currentPage   = 1;

    const filterItems= document.querySelectorAll('.our-projects__filter-item');
    const mobileFilterToggle = document.getElementById('mobileFilterToggle');
    const mobileDropdownMenu = document.querySelector('.our-projects__filter-dropdown-menu');
    const mobileFilterOptions = document.querySelectorAll('.our-projects__filter-option');
    const mobileFilterSelected= document.querySelector('.our-projects__filter-selected');
    const mobileFilterArrow   = document.querySelector('.our-projects__filter-arrow');

    function loadProjects(filter, page, scroll) {
        currentFilter = filter || 'all';
        currentPage= page   || 1;

        cardsContainer.style.opacity      = '0.4';
        cardsContainer.style.pointerEvents = 'none';

        const data = new FormData();
        data.append('action','our_projects_filter');
        data.append('nonce',projectsAjax.nonce);
        data.append('filter',currentFilter);
        data.append('page',currentPage);
        data.append('per_page',perPage);
        data.append('selected_ids', selectedIds);

        fetch(projectsAjax.ajaxurl, {
            method: 'POST',
            body:data,
        })
        .then(r => r.text())
        .then(html => {
            cardsContainer.innerHTML = html;
            initPaginationClicks();
            highlightActiveFilter(currentFilter);

            if (scroll) {
                section.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        })
        .catch(err => {
        })
        .finally(() => {
            cardsContainer.style.opacity       = '';
            cardsContainer.style.pointerEvents = '';
        });
    }

    function initPaginationClicks() {
        const pageNumbers = cardsContainer.querySelectorAll('.our-projects__pagination-number');
        pageNumbers.forEach(btn => {
            btn.addEventListener('click', () => {
                const page = parseInt(btn.getAttribute('data-page'));
                if (page) loadProjects(currentFilter, page, true);
            });
        });

        const prevBtn = cardsContainer.querySelector('.our-projects__pagination-arrow--prev');
        const nextBtn = cardsContainer.querySelector('.our-projects__pagination-arrow--next');

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                if (!prevBtn.disabled) loadProjects(currentFilter, currentPage - 1, true);
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                if (!nextBtn.disabled) loadProjects(currentFilter, currentPage + 1, true);
            });
        }
    }

    function highlightActiveFilter(filter) {
        filterItems.forEach(item => {
            const val= item.getAttribute('data-value') || '';
            const isActive = val === filter;
            item.classList.toggle('active',isActive);
            item.classList.toggle('body-small-all', isActive);
            item.classList.toggle('body-small',!isActive);
        });

        mobileFilterOptions.forEach(opt => {
            const val= opt.getAttribute('data-value') || '';
            const isActive = val === filter;
            opt.classList.toggle('active',isActive);
            opt.classList.toggle('body-small-all', isActive);
            opt.classList.toggle('body-small',!isActive);
        });
    }

    filterItems.forEach(item => {
        item.addEventListener('click', function () {
            const val   = this.getAttribute('data-value') || 'all';
            const label = this.textContent.trim();

            if (mobileFilterSelected) mobileFilterSelected.textContent = label;
            loadProjects(val, 1, false);
        });
    });

    mobileFilterOptions.forEach(opt => {
        opt.addEventListener('click', function () {
            const val   = this.getAttribute('data-value') || 'all';
            const label = this.textContent.trim();

            if (mobileFilterSelected) mobileFilterSelected.textContent = label;
            closeMobileDropdown();
            loadProjects(val, 1, false);
        });
    });

    let isToggling = false;

    mobileFilterToggle.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();

        if (isToggling) return;
        isToggling = true;

        if (mobileDropdownMenu.classList.contains('d-none')) {
            openMobileDropdown();
        } else {
            closeMobileDropdown();
        }

        setTimeout(() => { isToggling = false; }, 300);
    });

    function openMobileDropdown() {
        mobileDropdownMenu.classList.remove('d-none');
        if (mobileFilterArrow) mobileFilterArrow.style.transform = 'rotate(180deg)';
    }

    function closeMobileDropdown() {
        mobileDropdownMenu.classList.add('d-none');
        if (mobileFilterArrow) mobileFilterArrow.style.transform = 'rotate(0deg)';
    }

    loadProjects(currentFilter, currentPage, false);

});

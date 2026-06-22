
document.addEventListener('DOMContentLoaded', function() {
    const section = document.querySelector('.our-projects');
    
    if (!section) return;
    
    const enablePagination = section.getAttribute('data-enable-pagination') === 'true';
    const projectsPerPage = parseInt(section.getAttribute('data-projects-per-page')) || 6;
    const totalPages = parseInt(section.getAttribute('data-total-pages')) || 1;
    
    let currentPage = 1;
    let currentFilter = 'all';
    
    const filterItems = document.querySelectorAll('.our-projects__filter-item');
    const paginationNumbers = document.querySelectorAll('.our-projects__pagination-number');
    const paginationArrows = document.querySelectorAll('.our-projects__pagination-arrow');
    const cardsContainer = document.querySelector('.our-projects__cards');
    const allCards = document.querySelectorAll('.our-projects__cards .hero-project-card');
    
    if (allCards.length === 0) {
        return;
    }
    
    let originalCards = Array.from(allCards);
    
    const mobileFilterToggle = document.getElementById('mobileFilterToggle');
    const mobileDropdownMenu = document.querySelector('.our-projects__filter-dropdown-menu');
    const mobileFilterOptions = document.querySelectorAll('.our-projects__filter-option');
    const mobileFilterSelected = document.querySelector('.our-projects__filter-selected');
    const mobileFilterArrow = document.querySelector('.our-projects__filter-arrow');
    
    function filterCards(category) {
        if (category === 'all' || category === 'All Projects') {
            return originalCards;
        }
        
        return originalCards.filter(card => {
            const dataCategory = card.getAttribute('data-category');
            if (dataCategory) {
                return dataCategory.toLowerCase().includes(category.toLowerCase());
            }
            
            const categoryElement = card.querySelector('.hero-project-card__category-text, .category');
            if (categoryElement) {
                const cardCategory = categoryElement.textContent.trim();
                return cardCategory.toLowerCase().includes(category.toLowerCase());
            }
            
            return false;
        });
    }
    
    function paginateCards(cards, page, perPage) {
        const startIndex = (page - 1) * perPage;
        const endIndex = startIndex + perPage;
        return cards.slice(startIndex, endIndex);
    }
    
    function displayCards() {
        if (!cardsContainer || originalCards.length === 0) {
            return;
        }
        
        const filteredCards = filterCards(currentFilter);
        const paginatedCards = enablePagination ? 
            paginateCards(filteredCards, currentPage, projectsPerPage) : 
            filteredCards;
        
        originalCards.forEach(card => {
            card.style.display = 'none';
        });
        
        paginatedCards.forEach(card => {
            card.style.display = 'block';
        });
        
        if (enablePagination) {
            updatePagination(filteredCards.length);
        }
        
        if (filteredCards.length === 0) {
            if (!document.querySelector('.no-results-message')) {
                const noResultsMsg = document.createElement('p');
                noResultsMsg.className = 'text-center no-results-message';
                noResultsMsg.textContent = 'No projects found for this category.';
                cardsContainer.appendChild(noResultsMsg);
            }
        } else {
            const existingMsg = document.querySelector('.no-results-message');
            if (existingMsg) {
                existingMsg.remove();
            }
        }
    }
    
    function updatePagination(totalFilteredCards) {
        const newTotalPages = Math.ceil(totalFilteredCards / projectsPerPage);
        
        const paginationContainer = document.querySelector('.our-projects__pagination-numbers');
        if (paginationContainer && newTotalPages > 1) {
            paginationContainer.innerHTML = '';
            
            const maxVisiblePages = 5;
            let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
            let endPage = Math.min(newTotalPages, startPage + maxVisiblePages - 1);
            
            if (endPage - startPage + 1 < maxVisiblePages) {
                startPage = Math.max(1, endPage - maxVisiblePages + 1);
            }
            
            for (let i = startPage; i <= endPage; i++) {
                const button = document.createElement('button');
                button.className = `our-projects__pagination-number btn-text d-flex align-items-center justify-content-center text-center px-4 py-0 bg-white border border-light rounded-1 ${i === currentPage ? 'active' : ''}`;
                button.setAttribute('data-page', i);
                button.textContent = i;
                button.addEventListener('click', () => goToPage(i));
                paginationContainer.appendChild(button);
            }
            
            if (endPage < newTotalPages) {
                if (endPage < newTotalPages - 1) {
                    const ellipsis = document.createElement('span');
                    ellipsis.className = 'our-projects__pagination-ellipsis';
                    ellipsis.textContent = '...';
                    paginationContainer.appendChild(ellipsis);
                }
                
                const lastButton = document.createElement('button');
                lastButton.className = 'our-projects__pagination-number btn-text d-flex align-items-center justify-content-center text-center px-4 py-0 bg-white border border-light rounded-1';
                lastButton.setAttribute('data-page', newTotalPages);
                lastButton.textContent = newTotalPages;
                lastButton.addEventListener('click', () => goToPage(newTotalPages));
                paginationContainer.appendChild(lastButton);
            }
        }
        
        const prevArrow = document.querySelector('.our-projects__pagination-arrow--prev');
        const nextArrow = document.querySelector('.our-projects__pagination-arrow--next');
        
        if (prevArrow) {
            prevArrow.disabled = currentPage <= 1;
        }
        
        if (nextArrow) {
            nextArrow.disabled = currentPage >= newTotalPages;
        }
        
        const paginationSection = document.querySelector('.our-projects__pagination');
        if (paginationSection) {
            if (newTotalPages <= 1) {
                paginationSection.style.display = 'none';
            } else {
                paginationSection.style.display = 'flex';
            }
        }
    }
    
    function goToPage(page) {
        currentPage = page;
        displayCards();
    }
    
    function applyFilter(category) {
        currentFilter = category;
        currentPage = 1;
        displayCards();
    }
    
    if (mobileFilterToggle && mobileDropdownMenu && mobileFilterArrow) {
        mobileFilterToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            const isOpen = !mobileDropdownMenu.classList.contains('d-none');
            
            if (isOpen) {
                mobileDropdownMenu.classList.add('d-none');
                mobileFilterArrow.style.transform = 'rotate(0deg)';
            } else {
                mobileDropdownMenu.classList.remove('d-none');
                mobileFilterArrow.style.transform = 'rotate(180deg)';
            }
        });
        
        document.addEventListener('click', function(e) {
            if (!mobileFilterToggle.contains(e.target) && !mobileDropdownMenu.contains(e.target)) {
                mobileDropdownMenu.classList.add('d-none');
                mobileFilterArrow.style.transform = 'rotate(0deg)';
            }
        });
    }
    
    if (mobileFilterOptions.length > 0) {
        mobileFilterOptions.forEach(option => {
            option.addEventListener('click', function() {
                const selectedValue = this.getAttribute('data-value') || this.textContent.trim();
                
                if (mobileFilterSelected) {
                    mobileFilterSelected.textContent = this.textContent.trim();
                }
                
                mobileFilterOptions.forEach(opt => {
                    opt.classList.remove('active', 'body-small-all');
                    opt.classList.add('body-small');
                });
                
                this.classList.add('active', 'body-small-all');
                this.classList.remove('body-small');
                
                filterItems.forEach(filterItem => {
                    filterItem.classList.remove('active', 'body-small-all');
                    filterItem.classList.add('body-small');
                    
                    if (filterItem.textContent.trim() === this.textContent.trim()) {
                        filterItem.classList.add('active', 'body-small-all');
                        filterItem.classList.remove('body-small');
                    }
                });
                
                if (mobileDropdownMenu && mobileFilterArrow) {
                    mobileDropdownMenu.classList.add('d-none');
                    mobileFilterArrow.style.transform = 'rotate(0deg)';
                }
                
                applyFilter(selectedValue === 'all' ? 'all' : selectedValue);
            });
        });
    }
    
    if (filterItems.length > 0) {
        filterItems.forEach(item => {
            item.addEventListener('click', function() {
                filterItems.forEach(filterItem => {
                    filterItem.classList.remove('active', 'body-small-all');
                    filterItem.classList.add('body-small');
                });
                
                this.classList.add('active', 'body-small-all');
                this.classList.remove('body-small');
                
                const filterValue = this.textContent.trim();
                
                if (mobileFilterSelected) {
                    mobileFilterSelected.textContent = filterValue;
                }
                
                mobileFilterOptions.forEach(option => {
                    option.classList.remove('active', 'body-small-all');
                    option.classList.add('body-small');
                    
                    if (option.textContent.trim() === filterValue) {
                        option.classList.add('active', 'body-small-all');
                        option.classList.remove('body-small');
                    }
                });
                
                const filterCategory = filterValue === 'All Projects' ? 'all' : filterValue;
                applyFilter(filterCategory);
            });
        });
    }
    
    if (paginationArrows.length > 0) {
        paginationArrows.forEach(arrow => {
            arrow.addEventListener('click', function() {
                if (this.disabled) return;
                
                const isNext = this.classList.contains('our-projects__pagination-arrow--next');
                const isPrev = this.classList.contains('our-projects__pagination-arrow--prev');
                
                const filteredCards = filterCards(currentFilter);
                const maxPages = Math.ceil(filteredCards.length / projectsPerPage);
                
                if (isNext && currentPage < maxPages) {
                    goToPage(currentPage + 1);
                } else if (isPrev && currentPage > 1) {
                    goToPage(currentPage - 1);
                }
            });
        });
    }
    
    if (originalCards.length > 0) {
        displayCards();
    }
});
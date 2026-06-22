
document.addEventListener('DOMContentLoaded', function() {
    const filterItems = document.querySelectorAll('.our-projects__filter-item');
    const paginationNumbers = document.querySelectorAll('.our-projects__pagination-number');
    const paginationArrows = document.querySelectorAll('.our-projects__pagination-arrow');
    
    // Filter
    if (filterItems.length > 0) {
        filterItems.forEach(item => {
            item.addEventListener('click', function() {
                // Remove active class and add body-small for all filter items
                filterItems.forEach(filterItem => {
                    filterItem.classList.remove('active');
                    filterItem.classList.remove('body-small-all');
                    filterItem.classList.add('body-small');
                });
                
                // Add active class and body-small-all to clicked item
                this.classList.add('active');
                this.classList.remove('body-small');
                this.classList.add('body-small-all');
                
                const filterValue = this.textContent.trim();
                console.log('Filter selected:', filterValue);
                
                // TODO: Add project filtering logic
            });
        });
    }
    
    // Pagination
    if (paginationNumbers.length > 0) {
        paginationNumbers.forEach(item => {
            item.addEventListener('click', function() {
                // Remove active class from all pagination numbers
                paginationNumbers.forEach(pageItem => {
                    pageItem.classList.remove('active');
                });
                
                // Add active class to clicked item
                this.classList.add('active');
                
                const pageNumber = this.textContent.trim();
                console.log('Page selected:', pageNumber);
                
                // TODO: Add pagination logic
            });
        });
    }
    
    // Arrow navigation
    if (paginationArrows.length > 0) {
        paginationArrows.forEach(arrow => {
            arrow.addEventListener('click', function() {
                const currentActive = document.querySelector('.our-projects__pagination-number.active');
                if (!currentActive) return;
                
                const isNext = this.classList.contains('our-projects__pagination-arrow--next');
                const isPrev = this.classList.contains('our-projects__pagination-arrow--prev');
                
                let targetPage = null;
                
                if (isNext) {
                    targetPage = currentActive.nextElementSibling;
                } else if (isPrev) {
                    targetPage = currentActive.previousElementSibling;
                }
                
                if (targetPage && targetPage.classList.contains('our-projects__pagination-number')) {
                    // Remove active from current item
                    currentActive.classList.remove('active');
                    // Add active to target item
                    targetPage.classList.add('active');
                    
                    console.log('Navigated to page:', targetPage.textContent.trim());
                }
            });
        });
    }
});
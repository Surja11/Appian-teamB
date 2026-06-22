
document.addEventListener('DOMContentLoaded', function() {
    const filterItems = document.querySelectorAll('.our-projects__filter-item');
    const paginationNumbers = document.querySelectorAll('.our-projects__pagination-number');
    const paginationArrows = document.querySelectorAll('.our-projects__pagination-arrow');
    
    // Mobile dropdown
    const mobileFilterToggle = document.getElementById('mobileFilterToggle');
    const mobileDropdownMenu = document.querySelector('.our-projects__filter-dropdown-menu');
    const mobileFilterOptions = document.querySelectorAll('.our-projects__filter-option');
    const mobileFilterSelected = document.querySelector('.our-projects__filter-selected');
    const mobileFilterArrow = document.querySelector('.our-projects__filter-arrow');
    
    if (mobileFilterOptions.length > 0) {
        mobileFilterOptions.forEach(option => {
            option.style.display = 'block !important';
            option.style.visibility = 'visible !important';
            option.style.opacity = '1 !important';
        });
    }
    
    // Mobile dropdown toggle
    if (mobileFilterToggle && mobileDropdownMenu && mobileFilterArrow) {
        mobileFilterToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            const isOpen = !mobileDropdownMenu.classList.contains('d-none');
            
            if (isOpen) {
                // Close dropdown
                mobileDropdownMenu.classList.add('d-none');
                mobileFilterArrow.style.transform = 'rotate(0deg)';
            } else {
                // Open dropdown
                mobileDropdownMenu.classList.remove('d-none');
                mobileFilterArrow.style.transform = 'rotate(180deg)';
                
                const dropdownRect = mobileFilterToggle.getBoundingClientRect();
                const menuRect = mobileDropdownMenu.getBoundingClientRect();
                const containerRect = mobileFilterToggle.parentElement.getBoundingClientRect();
                
                const rightPosition = containerRect.width - dropdownRect.width;
                mobileDropdownMenu.style.right = '0px';
                mobileDropdownMenu.style.left = 'auto';
                mobileDropdownMenu.style.transform = 'translateX(0)';
                
                mobileFilterOptions.forEach(option => {
                    option.style.display = 'block !important';
                    option.style.visibility = 'visible !important';
                    option.style.opacity = '1 !important';
                });
            }
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!mobileFilterToggle.contains(e.target) && !mobileDropdownMenu.contains(e.target)) {
                mobileDropdownMenu.classList.add('d-none');
                mobileFilterArrow.style.transform = 'rotate(0deg)';
            }
        });
    }
    
    // Mobile dropdown option
    if (mobileFilterOptions.length > 0) {
        mobileFilterOptions.forEach(option => {
            option.addEventListener('click', function() {
                const selectedValue = this.textContent.trim();
                console.log('Mobile option clicked:', selectedValue);
                
                // Update mobile dropdown selected text
                if (mobileFilterSelected) {
                    mobileFilterSelected.textContent = selectedValue;
                }
                
                mobileFilterOptions.forEach((opt, index) => {
                    opt.classList.remove('active');
                    opt.classList.remove('body-small-all');
                    opt.classList.add('body-small');
                    
                    opt.style.display = 'block';
                    opt.style.visibility = 'visible';
                    opt.style.opacity = '1';
                    opt.removeAttribute('hidden');
                    opt.classList.remove('d-none');
                    
                    console.log(`Option ${index}: ${opt.textContent.trim()} - Display: ${opt.style.display}`);
                });
                
                // Add active to selected option
                this.classList.add('active');
                this.classList.remove('body-small');
                this.classList.add('body-small-all');
                
                this.style.display = 'block';
                this.style.visibility = 'visible';
                this.style.opacity = '1';
                
                // Sync with desktop filter items
                filterItems.forEach(filterItem => {
                    filterItem.classList.remove('active');
                    filterItem.classList.remove('body-small-all');
                    filterItem.classList.add('body-small');
                    
                    if (filterItem.textContent.trim() === selectedValue) {
                        filterItem.classList.add('active');
                        filterItem.classList.remove('body-small');
                        filterItem.classList.add('body-small-all');
                    }
                });
                
                // Close dropdown
                if (mobileDropdownMenu && mobileFilterArrow) {
                    mobileDropdownMenu.classList.add('d-none');
                    mobileFilterArrow.style.transform = 'rotate(0deg)';
                }
                
                console.log('Mobile filter selected:', selectedValue);
                
                // TODO: Add project filtering logic
            });
        });
    }
    
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
                
                // Sync with mobile dropdown
                if (mobileFilterSelected) {
                    mobileFilterSelected.textContent = filterValue;
                }
                
                // Update mobile dropdown active state
                mobileFilterOptions.forEach(option => {
                    option.classList.remove('active');
                    option.classList.remove('body-small-all');
                    option.classList.add('body-small');
                    option.style.display = 'block';
                    
                    if (option.textContent.trim() === filterValue) {
                        option.classList.add('active');
                        option.classList.remove('body-small');
                        option.classList.add('body-small-all');
                        option.style.display = 'block';
                    }
                });
                
                console.log('Desktop filter selected:', filterValue);
                
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
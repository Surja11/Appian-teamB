document.addEventListener("DOMContentLoaded", function () {
    console.log("Content loaded");
    
    const ourWorkSection = document.getElementsByClassName("our-work")[0];
    if (!ourWorkSection) {
        console.log("Section not found");
        return;
    }

    // getting all the tabs and tabpanes.
    const tabButtons = Array.from(document.getElementsByClassName("our-work__tab-link"));
    const tabPanes = Array.from(document.querySelectorAll(".our-work__tab-pane"));

    // console.log("buttons found:", tabButtons.length);
    // console.log("panes found:", tabPanes.length);

    function showTab(index) {


        // removing active tab buttons
        tabButtons.forEach((btn, i) => {
            btn.classList.remove("active");
            btn.setAttribute("aria-selected", "false");
            btn.setAttribute("tabindex", "-1");
        });

        // removing all active tab panes
        tabPanes.forEach((pane, i) => {
            pane.classList.remove("active");
        });

        // adding active class to the selected index
        if (tabButtons[index]) {
            tabButtons[index].classList.add("active");
            tabButtons[index].setAttribute("aria-selected", "true");
            tabButtons[index].setAttribute("tabindex", "0"); 
            tabButtons[index].focus(); 
        }

        // adding active to corresponding pane
        if (tabPanes[index]) {
            tabPanes[index].classList.add("active");
            console.log(`Pane ${index} activated`);
        }
    }

    // adding click event listener
    tabButtons.forEach((btn, index) => {
        console.log(`Attaching listener to button ${index}:`, btn.id);
        
        btn.addEventListener("click", function(e) {
            console.log(`Clicked button ${index}`);
            e.preventDefault();
            e.stopPropagation();
            showTab(index);
        });
    });
});
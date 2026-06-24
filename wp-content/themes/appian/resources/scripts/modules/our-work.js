document.addEventListener("DOMContentLoaded", function () {
    const ourWorkSection = document.getElementsByClassName("our-work")[0];
    if (!ourWorkSection) return;

    const tabButtons = Array.from(document.getElementsByClassName("our-work__tab-link"));
    const tabPanes = Array.from(document.querySelectorAll(".our-work__tab-pane"));

    function showTab(index) {

       // removing active tab buttons
        tabButtons.forEach((btn) => {
            btn.classList.remove("active");
            btn.setAttribute("aria-selected", "false");
            btn.setAttribute("tabindex", "-1");
        });

       // removing active tab panes
        tabPanes.forEach((pane) => {
            pane.classList.remove("active");
        });


        // adding active class to the selected index
        if (tabButtons[index]) {
            tabButtons[index].classList.add("active");
            tabButtons[index].setAttribute("aria-selected", "true");
            tabButtons[index].setAttribute("tabindex", "0");
        }

         // adding active to corresponding pane
        if (tabPanes[index]) {
            tabPanes[index].classList.add("active");
        }
    }


    tabButtons.forEach((btn, index) => {
        // adding click event listener
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            showTab(index);
        });
    });

    tabButtons.forEach((btn, index) => {
        btn.addEventListener("keydown", function (e) {
            if (e.key === "Tab" && !e.shiftKey && index < tabButtons.length - 1) {
                e.preventDefault();
                tabButtons[index + 1].setAttribute("tabindex", "0");
                tabButtons[index + 1].focus();
            }


            if (e.key === "Tab" && e.shiftKey && index > 0) {
                e.preventDefault();
                tabButtons[index - 1].setAttribute("tabindex", "0");
                tabButtons[index - 1].focus();
            }

            if (e.key === "Enter") {
                e.preventDefault();
                showTab(index);
            }
        });
    });

    showTab(0);
});
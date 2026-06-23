const header = () => {
  // console.log("Header js loaded");

  const toggleIcon = document.getElementsByClassName("navbar__icon-container")[0];
  const mainNav = document.getElementsByClassName("navbar__main")[0];
  const triggers = Array.from(document.getElementsByClassName("navbar__dropdown-trigger"));
  const extra = document.getElementsByClassName("navbar__extra")[0];
  const overlay = document.getElementById("navbar-overlay");
  ;

  const breakpoint = 1291;


  // Hamburger toggle for small screens
  toggleIcon.addEventListener("click", () => {
    const isOpen = toggleIcon.getAttribute("aria-expanded") === "true";
    toggleIcon.setAttribute("aria-expanded", String(!isOpen));
    mainNav.classList.toggle("navbar__main--open");
    extra.classList.toggle("navbar__extra--open");
    document.body.classList.toggle("menu-open");
  });

  // Dropdown triggers
  triggers.forEach((trigger) => {
    const dropdownId = trigger.getAttribute("aria-controls");
    const dropdown = document.getElementById(dropdownId);
    const parentItem = trigger.closest(".navbar__item--has-dropdown");



    let closeTimer = null;


    // opening target dropdown
    const openDropdown = () => {
      clearTimeout(closeTimer);
      triggers.forEach((other) => {
        if (other !== trigger) {
          other.setAttribute("aria-expanded", "false");
          const otherId = other.getAttribute("aria-controls");
          document.getElementById(otherId).classList.remove("navbar__dropdown--open");
        }
      });
      trigger.setAttribute("aria-expanded", "true");
      dropdown.classList.add("navbar__dropdown--open");

      if (window.innerWidth >= breakpoint) {
        overlay.classList.add("navbar-overlay--visible");
      }
    };

    // closing the dropdown
    const closeDropdown = () => {
      trigger.setAttribute("aria-expanded", "false");
      // console.log(trigger.getAttribute("aria-expanded"));
      dropdown.classList.remove("navbar__dropdown--open");
      if (!document.querySelector(".navbar__dropdown--open")) {
        overlay.classList.remove("navbar-overlay--visible");
      }
    };

    trigger.addEventListener('click', (e)=>{
      // console.log("clicked");
      if (window.innerWidth>breakpoint){
        return
      }
      e.preventDefault();
      const isOpen = trigger.getAttribute('aria-expanded')==="true";
      // console.log(isOpen);
      if (isOpen) {
        closeDropdown();
      } else {
        openDropdown();
      }})

  
 
    // using timeout since we have small gap below the dropdown button and the dropdown box so that it won't close immediately
    parentItem.addEventListener("mouseenter", () => {
      if (window.innerWidth<=breakpoint)
        return
      clearTimeout(closeTimer);
      openDropdown();
    });

    parentItem.addEventListener("mouseleave", () => {
      if (window.innerWidth<=breakpoint)
        return
      closeTimer = setTimeout(closeDropdown, 150);
    });

    parentItem.addEventListener("focusin", (e) => {
      if (window.innerWidth<=breakpoint)
        return
     
      if (e.target === trigger || parentItem.contains(e.target)) {
        openDropdown();
      }
    });

    parentItem.addEventListener("focusout", (e) => {
      if (window.innerWidth<=breakpoint)
        return
      if (parentItem.contains(e.relatedTarget))
        return;
      closeDropdown();
    });


  });

  // closing dropdown when clicking outside
  document.addEventListener("click", (e) => {
    if (!e.target.closest(".navbar__item--has-dropdown")) {
      triggers.forEach((trigger) => {
        trigger.setAttribute("aria-expanded", "false");
        const dropdownId = trigger.getAttribute("aria-controls");
        document.getElementById(dropdownId)?.classList.remove("navbar__dropdown--open");
      });
      overlay.classList.remove("navbar-overlay--visible");
    }
  })

  // Closing dropdown when clicking overlay
  overlay.addEventListener("click", () => {
    triggers.forEach((trigger) => {
      trigger.setAttribute("aria-expanded", "false");
      const dropdownId = trigger.getAttribute("aria-controls");
      document.getElementById(dropdownId).classList.remove("navbar__dropdown--open");
    });
    overlay.classList.remove("navbar-overlay--visible");
  });


  Array.from(document.getElementsByClassName('navbar__link')).forEach(link => {
    if (link.href === window.location.href) {
        link.closest('.navbar__item').classList.add('is-active');
    }
    });


  const header = document.querySelector(".header");

  // Reset mobile state when resizing
  window.addEventListener("resize", () => {

    if (window.innerWidth >= breakpoint) {
      toggleIcon.setAttribute("aria-expanded", "false");
      mainNav.classList.remove("navbar__main--open");
      extra.classList.remove("navbar__extra--open");
      document.body.classList.remove("menu-open");
      triggers.forEach((trigger) => {
        trigger.setAttribute("aria-expanded", "false");
        const dropdownId = trigger.getAttribute("aria-controls");
        document.getElementById(dropdownId)?.classList.remove("navbar__dropdown--open");
      });
      overlay.classList.remove("navbar-overlay--visible");
    }
  });

  let lastScrollY = window.scrollY;
  let scrollStopTimer = null;
  // console.log(lastScrollY);

  window.addEventListener("scroll", () => {
    if (mainNav.classList.contains("navbar__main--open")) return;

    const currentScrollY = window.scrollY;

    // console.log(currentScrollY);
    const scrollingUp = currentScrollY < lastScrollY;
    lastScrollY = currentScrollY;

    clearTimeout(scrollStopTimer);

    if (currentScrollY <= 0) {
      header?.classList.remove("header--hidden");
      // console.log('at top');
      return;
    }


    if (!scrollingUp) {
      header?.classList.add("header--hidden");
      // console.log('it should hide')
      return;
    }


    header.classList.remove("header--hidden");



  });
};

header();

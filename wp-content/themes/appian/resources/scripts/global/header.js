const header = () => {

  const toggleIcon = document.getElementsByClassName("navbar__icon-container")[0];
  const mainNav = document.getElementsByClassName("navbar__main")[0];
  const triggers = Array.from(document.getElementsByClassName("navbar__dropdown-trigger"));
  const extra = document.getElementsByClassName("navbar__extra")[0];
  const overlay = document.getElementById("navbar-overlay");

  const breakpoint = 1200;

  const preventScroll = (e) => e.preventDefault();

  
  function checkNavScrollable() {
    if (mainNav.classList.contains('navbar__main--open')) {
      setTimeout(() => {
        const isScrollable = mainNav.scrollHeight > mainNav.clientHeight;
        mainNav.classList.toggle('navbar__main--scrollable', isScrollable);
      }, 50);
    } else {
      mainNav.classList.remove('navbar__main--scrollable');
    }
  }

  toggleIcon.addEventListener("click", () => {
    const isOpen = toggleIcon.getAttribute("aria-expanded") === "true";
    toggleIcon.setAttribute("aria-expanded", String(!isOpen));
    mainNav.classList.toggle("navbar__main--open");
    extra.classList.toggle("navbar__extra--open");
    document.body.classList.toggle("menu-open");
    requestAnimationFrame(checkNavScrollable);
  });

  triggers.forEach((trigger) => {
    const dropdownId = trigger.getAttribute("aria-controls");
    const dropdown = document.getElementById(dropdownId);
    const parentItem = trigger.closest(".navbar__item--has-dropdown");

    let closeTimer = null;

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
        document.addEventListener("wheel", preventScroll, { passive: false });
        document.addEventListener("touchmove", preventScroll, { passive: false });
      }
      checkNavScrollable();
    };

    const closeDropdown = () => {
      trigger.setAttribute("aria-expanded", "false");
      dropdown.classList.remove("navbar__dropdown--open");
      if (!document.querySelector(".navbar__dropdown--open")) {
        overlay.classList.remove("navbar-overlay--visible");
        document.removeEventListener("wheel", preventScroll);
        document.removeEventListener("touchmove", preventScroll);
      }
      checkNavScrollable();
    };

    trigger.addEventListener('click', (e) => {
      e.preventDefault();
      const isOpen = trigger.getAttribute('aria-expanded') === "true";
      if (isOpen) {
        closeDropdown();
      } else {
        openDropdown();
      }
    });

    parentItem.addEventListener("mouseenter", () => {
      if (window.innerWidth <= breakpoint)
        return;
      clearTimeout(closeTimer);
      openDropdown();
    });

    parentItem.addEventListener("mouseleave", () => {
      if (window.innerWidth <= breakpoint)
        return;
      closeTimer = setTimeout(closeDropdown, 150);
    });

    parentItem.addEventListener("focusin", (e) => {
      if (window.innerWidth <= breakpoint)
        return;
      if (e.target === trigger || parentItem.contains(e.target)) {
        openDropdown();
      }
    });

    parentItem.addEventListener("focusout", (e) => {
      if (window.innerWidth <= breakpoint)
        return;
      if (parentItem.contains(e.relatedTarget))
        return;
      closeDropdown();
    });
  });

  document.addEventListener("click", (e) => {
    const clickedInsideNav = e.target.closest(".navbar__item--has-dropdown");
    const clickedDropdownLink = e.target.closest(".navbar__dropdown");

    if (!clickedInsideNav && !clickedDropdownLink) {
      triggers.forEach((trigger) => {
        trigger.setAttribute("aria-expanded", "false");
        const dropdownId = trigger.getAttribute("aria-controls");
        document.getElementById(dropdownId)?.classList.remove("navbar__dropdown--open");
      });
      overlay.classList.remove("navbar-overlay--visible");
      document.removeEventListener("wheel", preventScroll);
      document.removeEventListener("touchmove", preventScroll);
    }
  });

  overlay.addEventListener("click", () => {
    triggers.forEach((trigger) => {
      trigger.setAttribute("aria-expanded", "false");
      const dropdownId = trigger.getAttribute("aria-controls");
      document.getElementById(dropdownId).classList.remove("navbar__dropdown--open");
    });
    overlay.classList.remove("navbar-overlay--visible");
    document.removeEventListener("wheel", preventScroll);
    document.removeEventListener("touchmove", preventScroll);
  });

  Array.from(document.getElementsByClassName('navbar__link')).forEach(link => {
  const hrefAttr = link.getAttribute('href');
  
  if (!hrefAttr || hrefAttr === '#' || hrefAttr === '') return;

  if (link.href === window.location.href) {
    link.closest('.navbar__item').classList.add('is-active');
  }
});

  const header = document.querySelector(".header");

  window.addEventListener("resize", () => {
    if (window.innerWidth >= breakpoint) {
      toggleIcon.setAttribute("aria-expanded", "false");
      mainNav.classList.remove("navbar__main--open");
      mainNav.classList.remove("navbar__main--scrollable");
      extra.classList.remove("navbar__extra--open");
      document.body.classList.remove("menu-open");
      triggers.forEach((trigger) => {
        trigger.setAttribute("aria-expanded", "false");
        const dropdownId = trigger.getAttribute("aria-controls");
        document.getElementById(dropdownId)?.classList.remove("navbar__dropdown--open");
      });
      overlay.classList.remove("navbar-overlay--visible");
      document.removeEventListener("wheel", preventScroll);
      document.removeEventListener("touchmove", preventScroll);
    } else {
      checkNavScrollable();
    }
  });

  let lastScrollY = window.scrollY;
  let scrollStopTimer = null;

  window.addEventListener("scroll", () => {
    if (mainNav.classList.contains("navbar__main--open")) return;

    const currentScrollY = window.scrollY;

    const scrollingUp = currentScrollY < lastScrollY;
    lastScrollY = currentScrollY;

    clearTimeout(scrollStopTimer);

    if (currentScrollY <= 0) {
      header?.classList.remove("header--hidden");
      return;
    }

    if (!scrollingUp) {
      header?.classList.add("header--hidden");
      return;
    }

    header.classList.remove("header--hidden");
  });
};

header();
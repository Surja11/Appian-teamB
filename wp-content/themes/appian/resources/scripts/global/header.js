const header = () => {
  console.log('Header js loaded');

  const toggleIcon = document.getElementsByClassName('navbar__icon-container')[0];
  const main = document.getElementsByClassName('navbar__main')[0];
  const triggers = Array.from(document.getElementsByClassName('navbar__dropdown-trigger'));
  const extra = document.getElementsByClassName('navbar__extra')[0];
  const overlay = document.getElementById('navbar-overlay');

  const breakpoint = 1291;

  // Hamburger toggle for small sreens
  toggleIcon.addEventListener('click', () => {
    const isOpen = toggleIcon.getAttribute('aria-expanded') === 'true';
    toggleIcon.setAttribute('aria-expanded', String(!isOpen));
    main.classList.toggle('navbar__main--open');
    extra.classList.toggle('navbar__extra--open');
    document.body.classList.toggle('menu-open');
  });

  // Dropdown triggers
  triggers.forEach(trigger => {
    trigger.addEventListener('click', () => {
      const isOpen = trigger.getAttribute('aria-expanded') === 'true';
      const dropdownId = trigger.getAttribute('aria-controls');
      const dropdown = document.getElementById(dropdownId);

      // Close all other dropdowns
      triggers.forEach(other => {
        if (other !== trigger) {
          other.setAttribute('aria-expanded', 'false');
          const otherId = other.getAttribute('aria-controls');
          document.getElementById(otherId).classList.remove('navbar__dropdown--open');
        }
      });


      // Close dropdown when focus leaves the navbar item
      const parentItem = trigger.closest('.navbar__item--has-dropdown');
      parentItem.addEventListener('focusout', (e) => {
        // relatedTarget is the element receiving focus
        // If it's still inside the same parent item, do nothing
        if (parentItem.contains(e.relatedTarget)) return;


        trigger.setAttribute('aria-expanded', 'false');
        const dropdownId = trigger.getAttribute('aria-controls');
        document.getElementById(dropdownId)?.classList.remove('navbar__dropdown--open');


        // if no dropdown opens hides overlay
        if (!document.querySelector('.navbar__dropdown--open')) {
          overlay.classList.remove('navbar-overlay--visible');
        }
      });


      // Toggle clicked dropdown
      trigger.setAttribute('aria-expanded', String(!isOpen));
      dropdown.classList.toggle('navbar__dropdown--open');

      // Showing or hiding the overlay based on expansion of dropdown on wider screens
      if (window.innerWidth >= breakpoint) {
        if (!isOpen) {
          overlay.classList.add('navbar-overlay--visible');
        } else if (!document.querySelector('.navbar__dropdown--open')) {
          overlay.classList.remove('navbar-overlay--visible');
        }
      }
    });
  });

  // Closing dropdown when clicked outside
  document.addEventListener('click', e => {
    if (!e.target.closest('.navbar__item--has-dropdown')) {
      triggers.forEach(trigger => {
        trigger.setAttribute('aria-expanded', 'false');
        const dropdownId = trigger.getAttribute('aria-controls');
        document.getElementById(dropdownId)?.classList.remove('navbar__dropdown--open');
      });
      overlay.classList.remove('navbar-overlay--visible');
    }
  });

  // Closing dropdown when clicking overlay
  overlay.addEventListener('click', () => {
    triggers.forEach(trigger => {
      trigger.setAttribute('aria-expanded', 'false');
      const dropdownId = trigger.getAttribute('aria-controls');
      document.getElementById(dropdownId)?.classList.remove('navbar__dropdown--open');
    });
    overlay.classList.remove('navbar-overlay--visible');
  });

  // Resettiing mobile state when resizing
  window.addEventListener('resize', () => {
    if (window.innerWidth >= breakpoint) {
      toggleIcon.setAttribute('aria-expanded', 'false');
      main.classList.remove('navbar__main--open');
      extra.classList.remove('navbar__extra--open');
      document.body.classList.remove('menu-open');
      triggers.forEach(trigger => {
        trigger.setAttribute('aria-expanded', 'false');
        const dropdownId = trigger.getAttribute('aria-controls');
        document.getElementById(dropdownId)?.classList.remove('navbar__dropdown--open');
      });
      overlay.classList.remove('navbar-overlay--visible');
    }
  });

};

header();
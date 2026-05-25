const header = () => {
console.log('Header js loaded');
  //getting the toggleIcons, 
const toggleIcon = document.getElementsByClassName('navbar__icon-container')[0];
const main = document.getElementsByClassName('navbar__main')[0];
const triggers = Array.from(document.getElementsByClassName('navbar__dropdown-trigger'));

// console.log(toggleIcon);
// console.log(main);
// console.log(triggers);

// when the button is clicked, toggled the aria-expanded attribute and the navbar__main--open class
toggleIcon.addEventListener('click', () => {
  const isOpen = toggleIcon.getAttribute('aria-expanded') === 'true';
  toggleIcon.setAttribute('aria-expanded', String(!isOpen));
  main.classList.toggle('navbar__main--open');
});


// looped through triggers, and added click eventListener. On its click, closed other dropdowns and opened the required dropdown by  toggling the class.
triggers.forEach(trigger => {
  trigger.addEventListener('click', () => {
    const isOpen = trigger.getAttribute('aria-expanded') === 'true';
    const dropdownId = trigger.getAttribute('aria-controls');
    const dropdown = document.getElementById(dropdownId);

    // close all other open dropdowns first
    triggers.forEach(other => {
      if (other !== trigger) {
        other.setAttribute('aria-expanded', 'false');
        const otherId = other.getAttribute('aria-controls');
        document.getElementById(otherId).classList.remove('navbar__dropdown--open');
      }
    });

    // toggle clicked dropdown
    trigger.setAttribute('aria-expanded', String(!isOpen));
    dropdown.classList.toggle('navbar__dropdown--open');
  });
});

// closes dropdown whenwe click outside dropdown item
document.addEventListener('click', e => {
  if (!e.target.closest('.navbar__item--has-dropdown')) {
    triggers.forEach(trigger => {
      trigger.setAttribute('aria-expanded', 'false');
      const dropdownId = trigger.getAttribute('aria-controls');
      document.getElementById(dropdownId)?.classList.remove('navbar__dropdown--open');
    });
  }
});


}

header();

document.addEventListener("DOMContentLoaded", () => {
  const toggle = document.getElementById("sg-nav-toggle");
  const nav = document.getElementById("sg-nav");

  if (toggle && nav) {
    const links = nav.querySelectorAll("a"); // Get all links - only if nav exists

    toggle.addEventListener("click", () => {
      toggle.classList.toggle("is-active");
      nav.classList.toggle("is-open");
    });

    // Close nav when a link is clicked
    links.forEach((link) => {
      link.addEventListener("click", () => {
        toggle.classList.remove("is-active");
        nav.classList.remove("is-open");
      });
    });
  }
});

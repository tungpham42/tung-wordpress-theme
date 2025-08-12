document.addEventListener("DOMContentLoaded", () => {
  const hamburger = document.querySelector(".hamburger");
  const navMenu = document.querySelector(".primary-nav-menu");

  hamburger.addEventListener("click", () => {
    navMenu.classList.toggle("active");
    const isExpanded = navMenu.classList.contains("active");
    hamburger.setAttribute("aria-expanded", isExpanded);
  });
});

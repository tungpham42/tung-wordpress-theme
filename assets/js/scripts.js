document.addEventListener("DOMContentLoaded", function () {
  const backToTopButton = document.getElementById("back-to-top");

  // Show/hide button based on scroll position
  window.addEventListener("scroll", function () {
    if (window.scrollY > 300) {
      backToTopButton.classList.add("visible");
    } else {
      backToTopButton.classList.remove("visible");
    }
  });

  // Smooth scroll to top on click
  backToTopButton.addEventListener("click", function () {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  });
});

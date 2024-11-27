document.addEventListener("DOMContentLoaded", function () {
    const themeToggle = document.getElementById("theme-toggle");
    const themeIcon = document.getElementById("theme-icon");
  
    // Check saved theme from localStorage or default to dark mode
    const savedTheme = localStorage.getItem("theme") || "dark";
    document.body.classList.toggle("light-mode", savedTheme === "light");
    updateIcon(savedTheme);
  
    themeToggle.addEventListener("click", function () {
      const isLightMode = document.body.classList.toggle("light-mode");
      const newTheme = isLightMode ? "light" : "dark";
      localStorage.setItem("theme", newTheme);
      updateIcon(newTheme);
    });
  
    function updateIcon(theme) {
      if (theme === "light") {
        themeIcon.classList.remove("fa-moon");
        themeIcon.classList.add("fa-sun");
      } else {
        themeIcon.classList.remove("fa-sun");
        themeIcon.classList.add("fa-moon");
      }
    }
  });
  
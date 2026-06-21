window.addEventListener("load", () => {
  const logo = document.getElementById("logo");
  const searchIcon = document.getElementById("search-icon");
  const slot = document.getElementById("slot");
  const welcomeText = document.getElementById("welcome-text");
  const splash = document.getElementById("splash");
  const homepage = document.getElementById("homepage");

  // Step 1: Show logo
  logo.style.opacity = "1";

  // Step 2: Show search icon
  setTimeout(() => {
    searchIcon.style.opacity = "1";
    searchIcon.style.transform = "translate(-60px, -20px)";
  }, 1000);

  // Step 3: Move search icon
  setTimeout(() => { searchIcon.style.transform = "translate(0px, -20px)"; }, 1600);
  setTimeout(() => { searchIcon.style.transform = "translate(60px, -20px)"; }, 2200);

  // Step 4: Slot found
  setTimeout(() => {
    slot.style.opacity = "1";
    slot.style.left = "50%";
    slot.style.top = "50%";
    slot.style.transform = "translate(-50%, -50%)";
    slot.classList.add("pulse");
  }, 2800);

  // Step 5: Zoom into slot
  setTimeout(() => {
    slot.style.transform = "scale(30)";
    slot.classList.remove("pulse");
  }, 3200);

  // Step 6: Full blue background + welcome text
  setTimeout(() => {
    splash.style.background = "#2563EB";
    logo.style.opacity = "0";
    searchIcon.style.opacity = "0";
    if (welcomeText) {
      welcomeText.style.opacity = "1";
    }
  }, 3800);

  // Step 7: Fade out splash, open homepage
  setTimeout(() => {
    if (welcomeText) {
      welcomeText.style.opacity = "0";
    }
    slot.style.opacity = "0";
    splash.style.opacity = "0";
    splash.style.transition = "opacity 1s ease";
    window.location.href = "home.php";
  }, 4800);
});

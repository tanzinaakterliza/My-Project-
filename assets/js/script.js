// Simple login redirect (Demo)
function adminLogin() {
    window.location.href = "admin/dashboard.html";
}

function userLogin() {
    window.location.href = "user/dashboard.html";
}
const menuBtn = document.querySelector(".nav-toggle");
const navLinks = document.querySelector(".nav-links");

menuBtn.onclick = () => {
  navLinks.classList.toggle("show");
};

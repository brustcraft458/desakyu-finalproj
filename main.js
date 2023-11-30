// Toggle
const toggle = document.querySelector("#toggle-navbar")
const navbar = document.querySelector("#menu-navbar")
toggle.addEventListener("click", () => {
    navbar.classList.toggle("slide")
    console.log("tess")
})
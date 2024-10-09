const hamburguer = document.querySelector(".hamburguer");
hamburguer.onclick = function() {
    const nav = document.querySelector("nav");
    nav.classList.toggle("active")
}


const currentPage = window.location.pathname;
const navLinks = document.querySelectorAll("nav > ul > li a");

navLinks.forEach(link => {
    if(link.href.includes(`${currentPage}`)) {
        link.classList.add("active");
    }
});

const carousel = document.querySelector('.carousel-wrapper');
const prevButton = document.querySelector('.prev');
const nextButton = document.querySelector('.next');

if (prevButton && nextButton) {
    prevButton.addEventListener('click', () => {
        carousel.scrollLeft -= carousel.offsetWidth;
    });

    nextButton.addEventListener('click', () => {
        carousel.scrollLeft += carousel.offsetWidth;
    });
}

const form = document.querySelector(".project-form");
const showForm = document.querySelector(".create-project-dropdown")

showForm.addEventListener("click", () => {
  form.classList.toggle("hidden-project-form");
  showForm.classList.toggle("hidden-project-form");
});

const projectsCarousel = document.querySelector(".global-carousel-wrapper");
const projectsTable = document.querySelector(".projects-table")
const hideCarouselButton = document.querySelector(".manage-projects");

if (hideCarouselButton) {

    hideCarouselButton.addEventListener("click", () => {
        projectsCarousel.classList.toggle("hide-projects-carousel");
        projectsTable.classList.toggle("hide-projects-table");
    });

}

const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        console.log(entry)
        if (entry.isIntersecting) {
            entry.target.classList.add("show");
        } else {
            entry.target.classList.remove("show");
        }
    });
});

const hiddenElements = document.querySelectorAll(".hidden");
hiddenElements.forEach((el) => observer.observe(el));
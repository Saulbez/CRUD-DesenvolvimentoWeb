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
const slides = document.querySelectorAll('.carousel-item');
const prevButton = document.querySelector('.prev');
const nextButton = document.querySelector('.next');

prevButton.addEventListener('click', () => {
  carousel.scrollLeft -= carousel.offsetWidth;
});

nextButton.addEventListener('click', () => {
  carousel.scrollLeft += carousel.offsetWidth;
});
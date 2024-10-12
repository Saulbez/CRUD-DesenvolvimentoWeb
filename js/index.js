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
        }
    });
});

const hiddenElements = document.querySelectorAll(".hidden");
hiddenElements.forEach((el) => observer.observe(el));

//Mostrar e esconder o formulário para atualizar projeto
// e adicionar o id do projeto a um input escondido para saber que projeto será editado

// Show/hide the form used to update projects
// and add the project id to a hidden input for handling each project update

const editProjectForm = document.querySelector(".edit-project-form");

document.addEventListener("DOMContentLoaded", function() {
    let editButtons = document.querySelectorAll('.edit-project');
    let projectIdUpdate = document.querySelector('input[name="update_id"]');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            editProjectForm.classList.remove("hidden-project-form");
            projectIdUpdate.value = this.getAttribute('data-project-id');
        });
    });

});

const cancelButton = document.querySelector(".cancel");

cancelButton.addEventListener("click", () => {
    editProjectForm.classList.add("hidden-project-form");
});
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
    const items = document.querySelectorAll('.carousel-item');
    const gap = 16; // Gap between items
    const itemWidth = parseFloat(items[0].getBoundingClientRect().width.toFixed(3)); // Get the width of one item rounded to 3 decimals
    console.log("Item Width:", itemWidth);
    
    // Calculate how many items fit in the visible area of the carousel
    const visibleItemsCount = Math.floor(carousel.clientWidth / itemWidth);
    console.log("Visible Items Count:", visibleItemsCount);

    let scrollDistance = (itemWidth + gap).toFixed(3); // Scroll distance for one item
    console.log("Scroll Distance for One Item:", scrollDistance);

    // Adjust for multiple items
    if (visibleItemsCount > 1) {
        scrollDistance = (visibleItemsCount * (itemWidth + gap)).toFixed(3);
    }

    prevButton.addEventListener('click', () => {
        // Move left by the calculated scroll distance
        carousel.scrollLeft -= parseFloat(scrollDistance); // Ensure it's a number
    });

    nextButton.addEventListener('click', () => {
        // Check the current scroll position and the total scrollable width
        const maxScrollLeft = (carousel.scrollWidth - carousel.clientWidth).toFixed(3); // Maximum scrollable width rounded to 3 decimal places
        const nextScrollPosition = (carousel.scrollLeft + parseFloat(scrollDistance)).toFixed(3); // Calculate next position

        // If the next scroll position exceeds the max scroll left, adjust it
        if (parseFloat(nextScrollPosition) > parseFloat(maxScrollLeft)) {
            // Calculate how much to scroll to exactly reach the end
            const remainingScroll = parseFloat(maxScrollLeft) - carousel.scrollLeft;
            carousel.scrollLeft += remainingScroll; // Scroll to the end
        } else {
            carousel.scrollLeft += parseFloat(scrollDistance); // Move right by the calculated scroll distance
        }
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

const collaborators = document.querySelector(".manage-collaborators");

if (collaborators) {
    collaborators.addEventListener("click", () => {
        const collaboratorsForm = document.querySelector("#add-collaborators");
        collaboratorsForm.classList.remove("hidden-project-form")
    });
}
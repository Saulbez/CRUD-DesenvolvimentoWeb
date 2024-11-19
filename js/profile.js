let changeName = document.querySelector("button.edit-username")
let changeNameForm = document.querySelector("div#username-form");
let changePassword = document.querySelector("button.change-password");
let changePasswordForm = document.querySelector("div#password-form");
let cancelButton = document.querySelectorAll("button.cancel");
let message = document.querySelectorAll("p");
let closePasswordFormBtn = document.querySelector("button.close");

changeName.addEventListener ("click", function() {
    changeNameForm.classList.toggle("hidden");
});

changePassword.addEventListener ("click",  function(){
    changePasswordForm.classList.remove("hidden");
});

cancelButton.forEach(button => {
    button.addEventListener("click", function() {
        changePasswordForm.classList.add("hidden");
    });
});

if (closePasswordFormBtn) {
    closePasswordFormBtn.addEventListener("click", function () {
        changePasswordForm.classList.add("hidden");
    });
}

message.forEach(message => {
    if (message.textContent === "Senha incorreta" || message.textContent === "A senha deve ser no mínimo 6 caracteres"){
        message.classList.add('error');
    }
});

const currentPage = window.location.pathname;
const navLinks = document.querySelectorAll("nav > ul > li a");

navLinks.forEach(link => {
    if(link.href.includes(`${currentPage}`)) {
        link.classList.add("active");
    }
});

const hamburguer = document.querySelector(".hamburguer");
hamburguer.onclick = function() {
    const nav = document.querySelector("nav");
    nav.classList.toggle("active")
}

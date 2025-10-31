//Ejecutando funciones
document.getElementById("btn__iniciar-sesion").addEventListener("click", iniciarSesion);
document.getElementById("btn__registrarse").addEventListener("click", register);
window.addEventListener("resize", anchoPage);

//Declarando variables
var formulario_login = document.querySelector(".formulario__login");
var formulario_register = document.querySelector(".formulario__register");
var contenedor_login_register = document.querySelector(".contenedor__login-register");
var caja_trasera_login = document.querySelector(".caja__trasera-login");
var caja_trasera_register = document.querySelector(".caja__trasera-register");


const passwordField = document.getElementById('password');
const confirmPasswordField = document.getElementById('confirm-password');
const passwordHint = document.getElementById('password-hint');
const confirmPasswordHint = document.getElementById('confirm-password-hint');

// Validar contraseña
passwordField.addEventListener('input', () => {
    const password = passwordField.value;
    const regex = /^(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

    if (regex.test(password)) {
        passwordHint.textContent = 'Contraseña válida';
        passwordHint.classList.add('valid');
        passwordHint.classList.remove('invalid');
    } else {
        passwordHint.textContent = 'La contraseña debe tener al menos 8 caracteres, incluir una letra minúscula, un número y un carácter especial.';
        passwordHint.classList.add('invalid');
        passwordHint.classList.remove('valid');
    }
});

// Confirmar contraseña
confirmPasswordField.addEventListener('input', () => {
    const password = passwordField.value;
    const confirmPassword = confirmPasswordField.value;

    if (password === confirmPassword) {
        confirmPasswordHint.textContent = 'Las contraseñas coinciden.';
        confirmPasswordHint.classList.add('valid');
        confirmPasswordHint.classList.remove('invalid');
    } else {
        confirmPasswordHint.textContent = 'Las contraseñas no coinciden.';
        confirmPasswordHint.classList.add('invalid');
        confirmPasswordHint.classList.remove('valid');
    }
});

    //FUNCIONES

function anchoPage(){

    if (window.innerWidth > 850){
        caja_trasera_register.style.display = "block";
        caja_trasera_login.style.display = "block";
    }else{
        caja_trasera_register.style.display = "block";
        caja_trasera_register.style.opacity = "1";
        caja_trasera_login.style.display = "none";
        formulario_login.style.display = "block";
        contenedor_login_register.style.left = "0px";
        formulario_register.style.display = "none";   
    }
}

anchoPage();


    function iniciarSesion(){
        if (window.innerWidth > 850){
            formulario_login.style.display = "block";
            contenedor_login_register.style.left = "10px";
            formulario_register.style.display = "none";
            caja_trasera_register.style.opacity = "1";
            caja_trasera_login.style.opacity = "0";
        }else{
            formulario_login.style.display = "block";
            contenedor_login_register.style.left = "0px";
            formulario_register.style.display = "none";
            caja_trasera_register.style.display = "block";
            caja_trasera_login.style.display = "none";
        }
    }

    function register(){
        if (window.innerWidth > 850){
            formulario_register.style.display = "block";
            contenedor_login_register.style.left = "410px";
            formulario_login.style.display = "none";
            caja_trasera_register.style.opacity = "0";
            caja_trasera_login.style.opacity = "1";
        }else{
            formulario_register.style.display = "block";
            contenedor_login_register.style.left = "0px";
            formulario_login.style.display = "none";
            caja_trasera_register.style.display = "none";
            caja_trasera_login.style.display = "block";
            caja_trasera_login.style.opacity = "1";
        }
}
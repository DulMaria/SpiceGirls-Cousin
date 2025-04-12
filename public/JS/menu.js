// menu.js

console.log("El script del menú se ha cargado"); // Agrega esta línea

function toggleMenu() {
    const menu = document.getElementById('menu');
    const body = document.body;

    if (menu.classList.contains('open')) {
        menu.classList.remove('open');
        body.classList.remove('menu-open');
    } else {
        menu.classList.add('open');
        body.classList.add('menu-open');
    }
}

// Asegúrate de agregar el evento al botón
document.querySelector('.menu-btn').addEventListener('click', toggleMenu);
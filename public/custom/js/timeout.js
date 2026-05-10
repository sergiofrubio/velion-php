const sessionTimeout = 600;
let timer;

// Función para redirigir a la página de cierre de sesión después del tiempo de inactividad
function checkInactivity() {
    window.addEventListener('mousemove', resetTimer);
    window.addEventListener('keydown', resetTimer);

    function resetTimer() {
        clearTimeout(timer);
        timer = setTimeout(function () {
            // Redirigir a la página de cierre de sesión
            window.location.href = '/logout';
        }, sessionTimeout * 1000);
    }

    // Iniciar el temporizador al cargar la página
    resetTimer();
}

// Llamar a la función al cargar la página
document.addEventListener('DOMContentLoaded', checkInactivity);

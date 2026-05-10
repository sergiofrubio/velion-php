function validatePassword() {
    var password = document.getElementById("pass").value;
    var confirmPassword = document.getElementById("confirmPass").value;
    if (password != confirmPassword) {
        document.getElementById("passwordError").innerHTML = "Las contraseñas no coinciden. Por favor, inténtalo de nuevo.";
        return false;
    }
    return true;
}

// Función para validar el DNI
function validarDNI(dni) {
    var dniRegex = /^[0-9]{8}[a-zA-Z]$/;
    if (!dniRegex.test(dni)) {
        return false;
    }
    var letrasDNI = 'TRWAGMYFPDXBNJZSQVHLCKE';
    var numeroDNI = dni.substring(0, 8);
    var letraDNI = dni.substring(8).toUpperCase();
    var resto = numeroDNI % 23;
    var letraCalculada = letrasDNI.charAt(resto);
    return letraDNI === letraCalculada;
}

// Función para manejar el evento de entrada
function validarInput() {
    var dniInput = document.getElementById('usuario_id');
    var dni = dniInput.value;
    var idError = document.getElementById('idError');

    if (!validarDNI(dni)) {
        idError.textContent = 'El DNI no es válido.';
        idError.style.color = 'red';
    } else {
        idError.textContent = '';

    }
}
<?php
    // Inicia la sesión si no está iniciada
    session_start();

    // Verifica si hay un nombre de usuario en la sesión
    if (isset($_SESSION['email'])) {
        $nombre = $_SESSION['nombre'];
        $apellidos = $_SESSION['apellidos'];
        $DNI = $_SESSION['usuario_id'];
        $correo= $_SESSION['email'];
        $fecha_nacimiento =  $_SESSION['fecha_nacimiento'];
        $direccion = $_SESSION['direccion'];
        $provincia = $_SESSION['provincia'];
        $rol = $_SESSION['rol'];
        $municipio = $_SESSION['municipio'];
        $cp = $_SESSION['cp'];
        $direccionCompleta = $_SESSION['direccion'] . " " . $_SESSION['provincia'] . " " . $_SESSION['municipio'] . " " . $_SESSION['cp'];
        $telefono = $_SESSION['telefono'];
        $sesiones = isset($_SESSION['sesiones_disponibles']) ? $_SESSION['sesiones_disponibles'] : "";

    } else {
        // Si no hay un nombre de usuario en la sesión, redirige a la página de inicio de sesión
        header('Location: ./404.php');
        exit();
    }
?>

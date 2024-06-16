<?php
include '../controllers/LoginController.php';

// Crea una instancia del controlador de inicio de sesión
$loginController = new LoginController();

// Intenta registrar un usuario con los datos proporcionados
$loginController->finishSesion();

?>

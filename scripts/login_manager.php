<?php
include '../controllers/LoginController.php';

$loginController = new LoginController();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
    $action = $_POST["action"];
    switch ($action) {
        case 'iniciar_sesion':
            // Lógica para iniciar sesión
            handleLogin($loginController);
            break;
        case 'solicitar_nueva_contraseña':
            // Lógica para solicitar nueva contraseña
            handlePasswordResetRequest($loginController);
            break;
        case 'resetear_contraseña':
            // Logica para resetear la contraseña:
            handlePasswordReset($loginController);
            break;
        case 'registrar_usuario':
            $datos = array(
                'usuario_id' => $_POST["usuario_id"],
                'nombre' => $_POST["nombre"],
                'apellidos' => $_POST["apellidos"],
                'genero' => $_POST["genero"],
                'telefono' => $_POST["telefono"],
                'fecha_nacimiento' => $_POST["fecha_nacimiento"],
                'direccion' => $_POST["direccion"],
                'provincia' => $_POST["provincia"],
                'municipio' => $_POST["municipio"],
                'cp' => $_POST["cp"],
                'email' => $_POST["email"],
                'pass' => password_hash($_POST["pass"], PASSWORD_DEFAULT),
                'rol' => 'Paciente'
            );

            $loginController->registrarNuevoUsuario($datos);
            break;
    
    }
}

function handleLogin($loginController) {
    if (isset($_POST["email"]) && isset($_POST["pass"])) {
        $email = $_POST["email"];
        $pass = $_POST["pass"];
        $loginController->iniciarSesion($email, $pass);
    } else {
        echo "Por favor, introduzca nombre de usuario y contraseña.";
    }
}

function handlePasswordResetRequest($loginController) {
    if (isset($_POST["resetEmail"])) {
        $email = $_POST["resetEmail"];
        $loginController->generatePasswordResetToken($email);
    }
}

function handlePasswordReset($loginController) {
    if (isset($_POST["token"]) && isset($_POST["pass"]) && isset($_POST["confirmPassword"])) {
        $token = $_POST["token"];
        $password = $_POST["pass"];
        $confirmPassword = $_POST["confirmPassword"];
        if ($password === $confirmPassword) {
            $loginController->resetPassword($token, $password);
        } else {
            echo "Las contraseñas no coinciden.";
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
}
?>
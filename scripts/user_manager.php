<?php
include '../controllers/UserController.php';
include 'session_manager.php';

$userController = new UserController();

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["action"]) {

    switch ($_POST['action']) {
        case 'añadir_usuario':
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
                'rol' => $_POST["rol"]
            );

            $userController->añadirNuevoUsuario($datos);
            break;

        case 'editar_usuario':
            $datos = array(
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
                'rol' => $_POST["rol"]
            );

            $condicion = "usuario_id = '" . $_POST["usuario_id"] . "'";
            $userController->editarUsuario($datos, $condicion);
            break;

        case 'eliminar_usuario':
            $userController->eliminarUsuario($_POST["usuario_id"]);
            break;

        case 'actualizar_datos':
            $datos = array(
                'email' => $_POST["email"],
                'pass' => password_hash($_POST["pass"], PASSWORD_DEFAULT)
            );
            $condicion = "usuario_id = '" . $_POST["usuario_id"] . "'";
            $userController->actualizarDatos($datos, $condicion);
            break;

        case 'pdf':
            $userController->exportarDatosAPdf();
            break;
    }

}

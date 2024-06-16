<?php
include '../controllers/SpecialityController.php';
include 'session_manager.php';

$specialityController = new SpecialityController();

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["action"]) {

    switch ($_POST['action']) {
        case 'añadir':
            $datos = array(
                'descripcion' => $_POST["descripcion"],
            );

            $specialityController->añadirEspecialidad($datos);
            break;

        case 'editar':
            $datos = array(
                'descripcion' => $_POST["descripcion"],
            );

            $condicion = "especialidad_id = '" . $_POST["especialidad_id"] . "'";
            $specialityController->editarEspecialidad($datos, $condicion);
            break;

        case 'eliminar':
            $datos = "especialidad_id = '" . $_POST["especialidad_id"] . "'";
            $specialityController->eliminarEspecialidad($datos);
            break;

        case 'exportar':
            $specialityController->exportarDatos();
            break;
    }
}

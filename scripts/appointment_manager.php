<?php
include '../controllers/AppointmentController.php';

// Crea una instancia del controlador de inicio de sesión
$appointmentController = new AppointmentController();

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["action"]) {

    switch ($_POST['action']) {
        case 'asignar':
            $datos = array(
                'paciente_id' => $_POST["paciente_id"],
                'especialidad_id' => $_POST["especialidad_id"],
                'fisioterapeuta_id' => $_POST["fisioterapeuta_id"],
                'fecha_hora' => $_POST["fecha_hora"],
                'estado' => $_POST["estado"]
            );
            $appointmentController->asignarCita('citas', $datos);

            break;

        case 'confirmar':
            $datos = array(
                'estado' => 'Realizada',
                'diagnostico' => $_POST['diagnostico'],
                'tratamiento' => $_POST['tratamiento'],
                'notas' => $_POST['notas']

            );
            $condicion = "cita_id = '" . $_POST["cita_id"] . "'";
            $appointmentController->confirmarCita('citas', $datos, $condicion);
            break;

        case 'editar':
            $datos = array(
                'paciente_id' => $_POST["paciente_id"],
                'especialidad_id' => $_POST["especialidad_id"],
                'fisioterapeuta_id' => $_POST["fisioterapeuta_id"],
                'fecha_hora' => $_POST["fecha_hora"],
                'estado' => $_POST["estado"]
            );
            $condicion = "cita_id = '" . $_POST["cita_id"] . "'";
            $appointmentController->editarCita('citas', $datos, $condicion);

            break;

        case 'eliminar':
            $condicion = "cita_id = '" . $_POST["cita_id"] . "'";
            $appointmentController->eliminarCita('citas', $condicion);

            break;
        case 'eliminar-patient':
            $condicion = "cita_id = '" . $_POST["cita_id"] . "'";
            $appointmentController->eliminarCitaPatient('citas', $condicion);

            break;
        case 'agregarPendiente':
            $datos = array(
                'paciente_id' => $_POST["paciente_id"],
                'especialidad_id' => $_POST["especialidad_id"],
                'fisioterapeuta_id' => $_POST['fisioterapeuta_id'],
                'estado' => $_POST["estado"]
            );
            $appointmentController->asignarCitaPatients('citas', $datos);

            break;
    }
}
?>
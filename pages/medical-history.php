<?php
require_once '../scripts/session_manager.php';
require_once '../controllers/MedicalHistoryController.php';

if ($rol == "Paciente") {
    header("Location: 404.php");
    exit();
}

$medicalhistory = new MedicalHistoryController();

// Manejar la búsqueda de las citas del paciente
if (isset($_GET['usuario_id'])) {
    $usuario_id = $_GET['usuario_id'];
    $citas = $medicalhistory->obtenerInforme($usuario_id);
}


$pacientes = $medicalhistory->obtenerListaPacientes();

include_once './includes/dashboard.php';
?>

<div class="container mt-5">

    <?php
    if (isset($_SESSION['alert'])) {
        $alert_type = $_SESSION['alert']['type'];
        $alert_message = $_SESSION['alert']['message'];
        echo '<div class="alert alert-' . $alert_type . ' alert-dismissible fade show" role="alert">' . $alert_message . '
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        unset($_SESSION['alert']);
    }
    ?>

    <div class="d-flex align-items-start justify-content-between">
        <h1 class="mb-4">Historial Médico</h1>
    </div>

    <form class="form input mb-3" action="" method="get">
        <input class="form-control" list="datalistOptions" id="usuario_id" name="usuario_id" placeholder="Escribe aquí para buscar...">
        <datalist id="datalistOptions">
            <?php foreach ($pacientes as $paciente) : ?>
                <option value="<?php echo $paciente['usuario_id']; ?>"><?php echo $paciente['nombre'] . ' ' . $paciente['apellidos']; ?></option>
            <?php endforeach; ?>
        </datalist>
    </form>

    <?php if (isset($citas)) : ?>
        <div class="accordion" id="accordionCitas">
            <?php foreach ($citas as $cita) : ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading<?php echo $cita['cita_id']; ?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $cita['cita_id']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $cita['cita_id']; ?>">
                            Cita del <?php echo $cita['fecha_hora'] . ' en ' . $cita['especialidad']; ?>
                        </button>
                    </h2>
                    <div id="collapse<?php echo $cita['cita_id']; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $cita['cita_id']; ?>" data-bs-parent="#accordionCitas">
                        <div class="accordion-body">
                            <div class="card mb-4">
                                <div class="card-header">
                                    Información del Paciente
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Nombre del paciente: <?php echo $cita['paciente_nombre'] . ' ' . $cita['paciente_apellidos']; ?></h5>
                                    <p class="card-text">Fecha de nacimiento: <?php echo $cita['paciente_fecha_nacimiento']; ?></p>
                                    <p class="card-text">Género: <?php echo $cita['paciente_genero']; ?></p>
                                    <p class="card-text">Dirección: <?php echo $cita['paciente_direccion'] . ' ' . $cita['paciente_provincia'] . ' ' . $cita['paciente_cp']; ?></p>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header">
                                    Historial Médico
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Fecha del informe: <?php echo $cita['fecha_hora']; ?></h5>
                                    <p class="card-text">Diagnóstico: <?php echo $cita['diagnostico']; ?></p>
                                    <p class="card-text">Tratamiento: <?php echo $cita['tratamiento']; ?></p>
                                    <p class="card-text">Notas Adicionales: <?php echo $cita['notas']; ?></p>
                                </div>
                            </div>
                            <form action="../scripts/medicalhistory_manager.php" method="GET">
                                <input type="hidden" name="id" value="<?php echo $cita['cita_id']; ?>">
                                <button type="submit" class="btn btn-success"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-arrow-down" viewBox="0 0 16 16">
                                        <path d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293z" />
                                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
                                    </svg>
                                    Generar Reporte</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

</main>

</body>

</html>
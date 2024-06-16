<?php
require_once '../scripts/session_manager.php';
require_once '../controllers/AppointmentController.php';
$appointmentController = new AppointmentController();

if ($rol == "Administrador" || $rol == "Fisioterapeuta") {
    header("Location: 404.php");
    exit();
}

if (!$_GET) {
    header('location:appointments-patients.php?pagina=1');
}

$articulos_x_pagina = 10;

$citas = $appointmentController->obtenerCitas();

$iniciar = ($_GET['pagina'] - 1) * $articulos_x_pagina;

$filtro_usuario_id = isset($_POST['usuario_id']) ? $_POST['usuario_id'] : '';
$filtro_fecha_hora = isset($_POST['fecha_hora']) ? $_POST['fecha_hora'] : '';
$filtro_estado = isset($_POST['estado']) ? $_POST['estado'] : '';
$filtro_especialidad = isset($_POST['especialidad_id']) ? $_POST['especialidad_id'] : '';

// Obtener citas aplicando los filtros si es necesario
if (!empty($filtro_usuario_id) || !empty($filtro_estado) || !empty($filtro_fecha_hora) || !empty($filtro_especialidad)) {
    // Si se aplica al menos un filtro
    $citasPaginadas = $appointmentController->buscarCitasPatients($filtro_usuario_id, $filtro_fecha_hora, $filtro_estado, $filtro_especialidad);
} else {
    // Si no se aplican filtros, obtener citas paginados
    $citasPaginadas = $appointmentController->obtenerCitasUsuarioPaginadas($DNI, $iniciar, $articulos_x_pagina);
}

$n_botones_paginacion = ceil(count($citas) / ($articulos_x_pagina));

if ($_GET['pagina'] > $n_botones_paginacion) {
    header('location:appointments-patients.php?pagina=1');
}

$fisioterapeutas = $appointmentController->obtenerListaFisioterapeutas();
$especialidades = $appointmentController->obtenerEspecialidades();

include_once './includes/dashboard-patients.php';
include_once './modals/appointments-patients/add_modal.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 mt-5">
    <form class="row g-3" method="post" action="">
        <input type="text" id="usuario_id" name="usuario_id" hidden value="<?php echo $DNI ?>">
        <div class="col-auto">
            <input type="date" class="form-control custom-bg-color" id="fecha_hora" name="fecha_hora">
        </div>
        <div class="col-auto">
            <select class="form-select custom-bg-color" id="estado" name="estado">
                <option selected value="" hidden>Selecciona un estado</option>
                <option value="Programada">Programada</option>
                <option value="Pendiente">Pendiente</option>
            </select>
        </div>
        <div class="col-auto">
            <select class="form-select custom-bg-color" id="especialidad" name="especialidad">
                <option selected value="" hidden>Selecciona una especialidad</option>
                <?php foreach ($especialidades as $especialidad): ?>
                    <option value="<?php echo $especialidad['especialidad_id']; ?>">
                        <?php echo $especialidad['especialidad_id'] . ' - ' . $especialidad['descripcion']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-dark mb-3">Filtrar</button>
        </div>
    </form>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-dark mb-3" data-bs-toggle="modal" data-bs-target="#AsignarCita">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
            class="bi bi-plus-circle-dotted" viewBox="0 0 16 16">
            <path
                d="M8 0q-.264 0-.523.017l.064.998a7 7 0 0 1 .918 0l.064-.998A8 8 0 0 0 8 0M6.44.152q-.52.104-1.012.27l.321.948q.43-.147.884-.237L6.44.153zm4.132.271a8 8 0 0 0-1.011-.27l-.194.98q.453.09.884.237zm1.873.925a8 8 0 0 0-.906-.524l-.443.896q.413.205.793.459zM4.46.824q-.471.233-.905.524l.556.83a7 7 0 0 1 .793-.458zM2.725 1.985q-.394.346-.74.74l.752.66q.303-.345.648-.648zm11.29.74a8 8 0 0 0-.74-.74l-.66.752q.346.303.648.648zm1.161 1.735a8 8 0 0 0-.524-.905l-.83.556q.254.38.458.793l.896-.443zM1.348 3.555q-.292.433-.524.906l.896.443q.205-.413.459-.793zM.423 5.428a8 8 0 0 0-.27 1.011l.98.194q.09-.453.237-.884zM15.848 6.44a8 8 0 0 0-.27-1.012l-.948.321q.147.43.237.884zM.017 7.477a8 8 0 0 0 0 1.046l.998-.064a7 7 0 0 1 0-.918zM16 8a8 8 0 0 0-.017-.523l-.998.064a7 7 0 0 1 0 .918l.998.064A8 8 0 0 0 16 8M.152 9.56q.104.52.27 1.012l.948-.321a7 7 0 0 1-.237-.884l-.98.194zm15.425 1.012q.168-.493.27-1.011l-.98-.194q-.09.453-.237.884zM.824 11.54a8 8 0 0 0 .524.905l.83-.556a7 7 0 0 1-.458-.793zm13.828.905q.292-.434.524-.906l-.896-.443q-.205.413-.459.793zm-12.667.83q.346.394.74.74l.66-.752a7 7 0 0 1-.648-.648zm11.29.74q.394-.346.74-.74l-.752-.66q-.302.346-.648.648zm-1.735 1.161q.471-.233.905-.524l-.556-.83a7 7 0 0 1-.793.458zm-7.985-.524q.434.292.906.524l.443-.896a7 7 0 0 1-.793-.459zm1.873.925q.493.168 1.011.27l.194-.98a7 7 0 0 1-.884-.237zm4.132.271a8 8 0 0 0 1.012-.27l-.321-.948a7 7 0 0 1-.884.237l.194.98zm-2.083.135a8 8 0 0 0 1.046 0l-.064-.998a7 7 0 0 1-.918 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
        </svg>
        Pedir Cita
    </button>
</div>

<?php
// Verificar si hay una alerta de usuario
if (isset($_SESSION['alert'])) {
    $alert_type = $_SESSION['alert']['type'];
    $alert_message = $_SESSION['alert']['message'];
    // Mostrar la alerta
    echo '<div class="alert alert-' . $alert_type . ' alert-dismissible fade show" role="alert">' . $alert_message . '
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    // Eliminar la variable de sesión después de mostrar la alerta
    unset($_SESSION['alert']);
}
?>

<div class="table-responsive small">
    <div class="row">
        <!-- Aquí se mostrarán las citas en forma de listas -->
        <div class="col">
            <ul class="list-group">
                <li class="list-group-item custom-blur">
                    <h3 class="mb-0 d-flex justify-content-center align-items-center" style="color: #FFFFFF">Mis citas</h3>
                </li>
                <?php foreach ($citasPaginadas as $cita): ?>
                    <?php if ($cita['estado'] == 'Programada' || $cita['estado'] == 'Pendiente') { ?>
                        <li class="list-group-item custom-blur">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Cita <?php echo $cita['cita_id'] ?></h5>
                                <small>Fecha y Hora: <?php echo $cita['fecha_hora'] ?></small>
                            </div>
                            <p class="mb-1">Especialidad: <?php echo $cita['especialidad_id'] . ' - ' . $cita['descripcion'] ?>
                            </p>
                            <small>Nombre del paciente:
                                <?php echo $cita['paciente_nombre'] . " " . $cita['paciente_apellidos']; ?></small>
                            <br>
                            <small>Nombre del fisioterapeuta:
                                <?php echo $cita['fisioterapeuta_nombre'] . " " . $cita['fisioterapeuta_apellidos']; ?></small>
                            <br>
                            <small>Estado:
                                <?php
                                $estado = $cita['estado'];

                                switch ($estado) {
                                    case 'Programada':
                                        $text_gb_class = 'text-bg-warning';
                                        break;
                                    case 'Pendiente':
                                        $text_gb_class = 'text-bg-info';
                                        break;
                                    default:
                                        $text_gb_class = 'text-bg-info';
                                }
                                ?><span class="badge <?php echo $text_gb_class; ?>">
                                    <?php echo $estado; ?>
                                </span></small>
                            <div class="text-end mt-2">
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#delete_<?php echo $cita['cita_id']; ?>">Cancelar cita</button>
                                <?php include 'modals/appointments-patients/edit_delete_modal.php'; ?>
                            </div>
                        </li>
                    <?php }endforeach; ?>
                <!-- Repite estas listas para cada cita -->
            </ul>
        </div>
    </div>
</div>
<br>
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-start">
        <li class="page-item <? echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>">
            <a class="page-link" style="background-color: #222; color: #FFFFFF; border-color:#222"
                href="appointments-patients.php?pagina=<?php echo $_GET['pagina'] - 1 ?>">Anterior</a>
        </li>
        <?php for ($i = 0; $i < $n_botones_paginacion; $i++): ?>
            <li class="page-item <? echo $_GET['pagina'] == $i + 1 ? 'active' : '' ?>"><a class="page-link"
                    href="appointments-patients.php?pagina=<?php echo $i + 1 ?>"><?php echo $i + 1 ?></a></li>
        <?php endfor ?>
        <li class="page-item <? echo $_GET['pagina'] >= $n_botones_paginacion ? 'disabled' : '' ?>">
            <a class="page-link" style="background-color: #222; color: #FFFFFF; border-color:#222"
                href="appointments-patients.php?pagina=<?php echo $_GET['pagina'] + 1 ?>">Siguiente</a>
        </li>
    </ul>
</nav>

</body>

</html>
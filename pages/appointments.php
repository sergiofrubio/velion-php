<?php
require_once '../scripts/session_manager.php';
require_once '../controllers/AppointmentController.php';
$appointmentController = new AppointmentController();


if ($rol == "Paciente") {
    header("Location: 404.php");
    exit();
}

if (!$_GET) {
    header('Location: appointments.php?pagina=1');
    exit();
}

$articulos_x_pagina = 5;

$citas = $appointmentController->obtenerCitas();

$iniciar = ($_GET['pagina']  - 1) * $articulos_x_pagina;

// Obtener el valor de los filtros, si están presentes en el formulario
$filtro_usuario_id = isset($_POST['usuario_id']) ? $_POST['usuario_id'] : '';
$filtro_fecha_hora = isset($_POST['fecha_hora']) ? $_POST['fecha_hora'] : '';
$filtro_estado = isset($_POST['estado']) ? $_POST['estado'] : '';
$filtro_especialidad = isset($_POST['especialidad']) ? $_POST['especialidad'] : '';

// Obtener usuarios aplicando los filtros si es necesario
if (!empty($filtro_usuario_id) || !empty($filtro_estado) || !empty($filtro_fecha_hora) || !empty($filtro_especialidad)) {
    // Si se aplica al menos un filtro
    $citasPaginadas = $appointmentController->buscarCitas($filtro_usuario_id, $filtro_fecha_hora, $filtro_estado, $filtro_especialidad);
} else {
    // Si no se aplican filtros, obtener usuarios paginados
    $citasPaginadas = $appointmentController->obtenerCitasPaginadas($iniciar, $articulos_x_pagina);
}

$n_botones_paginacion = ceil(count($citas) / $articulos_x_pagina);

if ($_GET['pagina'] > $n_botones_paginacion) {
    header('Location: appointments.php?pagina=1');
    exit();
}

$pacientes = $appointmentController->obtenerListaPacientes();
$fisioterapeutas = $appointmentController->obtenerListaFisioterapeutas();
//echo(json_encode($fisioterapeutas));
$especialidades = $appointmentController->obtenerEspecialidades();

include_once './includes/dashboard.php';
include 'modals/appointments/add_modal.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Citas</h1>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AsignarCita"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-dotted" viewBox="0 0 16 16">
            <path d="M8 0q-.264 0-.523.017l.064.998a7 7 0 0 1 .918 0l.064-.998A8 8 0 0 0 8 0M6.44.152q-.52.104-1.012.27l.321.948q.43-.147.884-.237L6.44.153zm4.132.271a8 8 0 0 0-1.011-.27l-.194.98q.453.09.884.237zm1.873.925a8 8 0 0 0-.906-.524l-.443.896q.413.205.793.459zM4.46.824q-.471.233-.905.524l.556.83a7 7 0 0 1 .793-.458zM2.725 1.985q-.394.346-.74.74l.752.66q.303-.345.648-.648zm11.29.74a8 8 0 0 0-.74-.74l-.66.752q.346.303.648.648zm1.161 1.735a8 8 0 0 0-.524-.905l-.83.556q.254.38.458.793l.896-.443zM1.348 3.555q-.292.433-.524.906l.896.443q.205-.413.459-.793zM.423 5.428a8 8 0 0 0-.27 1.011l.98.194q.09-.453.237-.884zM15.848 6.44a8 8 0 0 0-.27-1.012l-.948.321q.147.43.237.884zM.017 7.477a8 8 0 0 0 0 1.046l.998-.064a7 7 0 0 1 0-.918zM16 8a8 8 0 0 0-.017-.523l-.998.064a7 7 0 0 1 0 .918l.998.064A8 8 0 0 0 16 8M.152 9.56q.104.52.27 1.012l.948-.321a7 7 0 0 1-.237-.884l-.98.194zm15.425 1.012q.168-.493.27-1.011l-.98-.194q-.09.453-.237.884zM.824 11.54a8 8 0 0 0 .524.905l.83-.556a7 7 0 0 1-.458-.793zm13.828.905q.292-.434.524-.906l-.896-.443q-.205.413-.459.793zm-12.667.83q.346.394.74.74l.66-.752a7 7 0 0 1-.648-.648zm11.29.74q.394-.346.74-.74l-.752-.66q-.302.346-.648.648zm-1.735 1.161q.471-.233.905-.524l-.556-.83a7 7 0 0 1-.793.458zm-7.985-.524q.434.292.906.524l.443-.896a7 7 0 0 1-.793-.459zm1.873.925q.493.168 1.011.27l.194-.98a7 7 0 0 1-.884-.237zm4.132.271a8 8 0 0 0 1.012-.27l-.321-.948a7 7 0 0 1-.884.237l.194.98zm-2.083.135a8 8 0 0 0 1.046 0l-.064-.998a7 7 0 0 1-.918 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
        </svg>
        Asignar Cita
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
    <form class="row g-3" method="post" action="">
        <div class="col-auto">
            <input type="text" class="form-control" id="usuario_id" name="usuario_id" placeholder="Filtrar por ID de paciente...">
        </div>
        <div class="col-auto">
            <input type="date" class="form-control" id="fecha_hora" name="fecha_hora">
        </div>
        <div class="col-auto">
            <select class="form-select" id="estado" name="estado">
                <option selected value="" hidden>Selecciona un estado</option>
                <option value="Programada">Programada</option>
                <option value="Realizada">Realizada</option>
                <option value="Cancelada">Cancelada</option>
                <option value="Pendiente">Pendiente</option>
            </select>
        </div>
        <div class="col-auto">
            <select class="form-select" id="especialidad" name="especialidad">
                <option selected value="" hidden>Selecciona una especialidad</option>
                <?php foreach ($especialidades as $especialidad) : ?>
                    <option value="<?php echo $especialidad['especialidad_id']; ?>"><?php echo $especialidad['especialidad_id'] . ' - ' . $especialidad['descripcion']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3">Filtrar</button>
        </div>
    </form>

    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 5%;">ID Pac.</th>
                            <th scope="col" style="width: 10%;">Fecha</th>
                            <th scope="col" style="width: 7%;">Paciente</th>
                            <th scope="col" style="width: 7%;">Contacto Pac.</th>
                            <th scope="col" style="width: 10%;">Especialidad</th>
                            <th scope="col" style="width: 7%;">Fis. Asoc.</th>
                            <!-- <th scope="col" style="width: 10%;">Consulta</th> -->
                            <th scope="col" style="width: 6%;">Estado</th>
                            <th scope="col" style="width: 7%;">Acciones</th>
                        </tr>
                    </thead>
                    <?php if (!empty($citasPaginadas)) : ?>
                        <?php foreach ($citasPaginadas as $cita) : ?>
                            <tr>
                                <td><?php echo $cita['paciente_id']; ?></td>
                                <td><?php echo $cita['fecha_hora']; ?></td>
                                <td><?php echo $cita['paciente_nombre'] . " " . $cita['paciente_apellidos']; ?></td>
                                <td><?php echo $cita['paciente_telefono'] ?></td>
                                <td><?php echo $cita['especialidad_id'] . ' - ' . $cita['descripcion'] ?></td>
                                <td><?php echo $cita['fisioterapeuta_nombre'] . " " . $cita['fisioterapeuta_apellidos'];  ?></td>
                                <td>
                                    <?php
                                    $estado = $cita['estado'];

                                    switch ($estado) {
                                        case 'Realizada':
                                            $text_gb_class = 'text-bg-success';
                                            break;
                                        case 'Cancelada':
                                            $text_gb_class = 'text-bg-danger';
                                            break;
                                        case 'Programada':
                                            $text_gb_class = 'text-bg-warning';
                                            break;
                                        case 'Pendiente':
                                            $text_gb_class = 'text-bg-info';
                                            break;
                                        default:
                                            $text_gb_class = 'text-bg-info';
                                    }
                                    ?>
                                    <span class="badge <?php echo $text_gb_class; ?>">
                                        <?php echo $estado; ?>
                                    </span>
                                </td>
                                <td>
                                    <button onclick="window.location='medical-history.php?usuario_id=<?php echo $cita['paciente_id']; ?>'" class="btn btn-primary btn-sm" <?php if ($cita['estado'] == 'Programada' || $cita['estado'] == 'Pendiente' || $cita['estado'] == 'Cancelada') {
                                                                                echo 'hidden';
                                                                            } ?>>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox=" 0 0 16 16">
                                            <path d="M9.5 0a.5.5 0 0 1 .5.5.5.5 0 0 0 .5.5.5.5 0 0 1 .5.5V2a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 2v-.5a.5.5 0 0 1 .5-.5.5.5 0 0 0 .5-.5.5.5 0 0 1 .5-.5z" />
                                            <path d="M3 2.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 0 0-1h-.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1H12a.5.5 0 0 0 0 1h.5a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5z" />
                                            <path d="M9.979 5.356a.5.5 0 0 0-.968.04L7.92 10.49l-.94-3.135a.5.5 0 0 0-.926-.08L4.69 10H4.5a.5.5 0 0 0 0 1H5a.5.5 0 0 0 .447-.276l.936-1.873 1.138 3.793a.5.5 0 0 0 .968-.04L9.58 7.51l.94 3.135A.5.5 0 0 0 11 11h.5a.5.5 0 0 0 0-1h-.128z" />
                                        </svg>
                                    </button>
                                    <button class="btn btn-sm btn-success" <?php if ($cita['estado'] == 'Realizada' || $cita['estado'] == 'Cancelada' || $cita['estado'] == 'Pendiente') {
                                                                                echo 'hidden';
                                                                            } ?> data-bs-toggle="modal" data-bs-target="#confirm_<?php echo $cita['cita_id']; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                            <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z" />
                                        </svg></button>
                                    <button class="btn btn-warning btn-sm" <?php if ($cita['estado'] == 'Realizada' || $cita['estado'] == 'Cancelada') {
                                                                                echo 'style="display: none"';
                                                                            } ?>data-bs-toggle="modal" data-bs-target="#edit_<?php echo $cita['cita_id']; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                            <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
                                                                          </svg></button>
                                    <button class="btn btn-sm btn-danger" <?php if ($cita['estado'] == 'Realizada' || $cita['estado'] == 'Cancelada') {
                                                                                echo 'hidden';
                                                                            } ?> data-bs-toggle="modal" data-bs-target="#delete_<?php echo $cita['cita_id']; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                        </svg></button>
                                    <?php include 'modals/appointments/edit_delete_modal.php'; ?>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6">No se encontraron citas.</td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
</div>

<nav aria-label="Page navigation example">
    <ul class="pagination">
        <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : ''; ?>">
            <a class="page-link" href="appointments.php?pagina=<?php echo $_GET['pagina'] - 1; ?>">Anterior</a>
        </li>
        <?php for ($i = 0; $i < $n_botones_paginacion; $i++) : ?>
            <li class="page-item <?php echo $_GET['pagina'] == $i + 1 ? 'active' : ''; ?>">
                <a class="page-link" href="appointments.php?pagina=<?php echo $i + 1; ?>"><?php echo $i + 1; ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?php echo $_GET['pagina'] >= $n_botones_paginacion ? 'disabled' : ''; ?>">
            <a class="page-link" href="appointments.php?pagina=<?php echo $_GET['pagina'] + 1; ?>">Siguiente</a>
        </li>
    </ul>
</nav>

</main>

</body>

</html>
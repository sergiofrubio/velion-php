<?php
require_once '../scripts/session_manager.php';
require_once '../controllers/MedicalHistoryController.php';

$medHist = new MedicalHistoryController();

if ($rol == "Administrador" || $rol == "Fisioterapeuta") {
    header("Location: 404.php");
    exit();
}

if (!$_GET) {
    header('location:start-patients.php?pagina=1');
}

$articulos_x_pagina = 4;

$iniciar = ($_GET['pagina'] - 1) * $articulos_x_pagina;

$informes = $medHist->obtenerInforme($DNI);

$n_botones_paginacion = ceil(count($informes) / ($articulos_x_pagina));

if ($_GET['pagina'] > $n_botones_paginacion) {
    header('location:appointments-patients.php?pagina=1');
}

include_once 'includes/dashboard-patients.php';
?>




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

<div class="table-responsive">
    <div class="row">
        <!-- Aquí se mostrará cada informe en forma de listas -->
        <div class="col">
            <ul class="list-group mt-5 custom-bg" style="background-color: transparent">
                <li class="list-group-item custom-blur">
                    <h3 class="mb-0 d-flex justify-content-center align-items-center" style="color: #FFFFFF">Mis informes</h3>
                </li>
                <?php foreach ($informes as $informe) { ?>
                    <li class="list-group-item custom-blur">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-2">Informe <?php echo $informe['cita_id']; ?></h5>
                            <small>Fecha: <?php echo $informe['fecha_hora']; ?></small>
                        </div>
                        <p class="mb-2"><b>Información sobre el informe:</b></p>
                        <small>Nombre del paciente:
                            <?php echo $informe['paciente_nombre'] . " " . $informe['paciente_apellidos']; ?></small>
                        <br>
                        <small>Nombre del fisioterapeuta:
                            <?php echo $informe['fisioterapeuta_nombre'] . " " . $informe['fisioterapeuta_apellidos']; ?></small>
                        <br>
                        <small>Especialidad:
                            <?php echo $informe['especialidad']; ?></small>
                        <div class="text-end mt-2">
                            <form action="../scripts/medicalhistory_manager.php" method="GET">
                                <input type="hidden" id="id" name="id"
                                    value="<?php echo $informe['cita_id']; ?>">
                                <button type="submit" class="btn btn-success btn-success">Descargar</button>
                            </form>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>

<br>
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-start">
        <li class="page-item <? echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>">
            <a class="page-link" style="background-color: #222; color: #FFFFFF; border-color:#222" href="start-patients.php?pagina=<?php echo $_GET['pagina'] - 1 ?>">Anterior</a>
        </li>
        <?php for ($i = 0; $i < $n_botones_paginacion; $i++): ?>
            <li class="page-item <? echo $_GET['pagina'] == $i + 1 ? 'active' : '' ?>"><a class="page-link"
                    href="start-patients.php?pagina=<?php echo $i + 1 ?>"><?php echo $i + 1 ?></a></li>
        <?php endfor ?>
        <li class="page-item <? echo $_GET['pagina'] >= $n_botones_paginacion ? 'disabled' : '' ?>">
            <a class="page-link custom-page-link" style="background-color: #222; color: #FFFFFF; border-color:#222" href="start-patients.php?pagina=<?php echo $_GET['pagina'] + 1 ?>">Siguiente</a>
        </li>
    </ul>
</nav>

</div>

</body>

</html>
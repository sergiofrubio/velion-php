<?php
require_once '../scripts/session_manager.php';
require_once '../controllers/UserController.php';
require_once '../controllers/AppointmentController.php';
require_once '../controllers/MedicalHistoryController.php';
$appointmentController = new AppointmentController();
$userController = new UserController();
$medicalhistory = new MedicalHistoryController();


if ($rol == "Paciente") {
    include_once './includes/dashboard-patients.php';
} else {
    include_once './includes/dashboard.php';
}

if (isset($_GET['usuario_id'])) {
    $usuario = $userController->buscarUsuarios($_GET['usuario_id'], '');
    $citas = $appointmentController->obtenerCitasUsuario($_GET['usuario_id']);
    $informes = $medicalhistory->obtenerInforme($_GET['usuario_id']);
}


?>

<div class="container">
    <div class="profile-header">
        <img src="../assets/custom/img/foto_perfil.jpg" alt="Foto de Perfil" class="profile-picture">
    </div>
    <div class="row" style="margin-right: 5.7%; margin-left: 0.02%; height: 50vh;">
        <div class="col-md-3">
            <div class="profile-info text-center">
                <h1 class="custom-color"><? echo ($usuario[0]['nombre'] . ' ' .  $usuario[0]['apellidos']); ?></h1>
                <b class="custom-color"><? echo ($usuario[0]['rol']); ?></b>
            </div>
        </div>
        <div class="col-md-9">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-about-tab" data-bs-toggle="pill" data-bs-target="#pills-about" type="button" role="tab" aria-controls="pills-about" aria-selected="true" style="color: #000000">Acerca de</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-appointments-tab" data-bs-toggle="pill" data-bs-target="#pills-appointments" type="button" role="tab" aria-controls="pills-appointments" aria-selected="false" style="color: #000000">Citas</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-history-tab" data-bs-toggle="pill" data-bs-target="#pills-history" type="button" role="tab" aria-controls="pills-history" aria-selected="false" style="color: #000000">Historial Médico</button>
                </li>
                <?
                if ($rol == "Paciente") {
                    echo ('
                    <button class="nav-link" id="pills-data-tab" data-bs-toggle="pill" data-bs-target="#pills-data" type="button" role="tab" aria-controls="pills-data" aria-selected="false" style="color: #000000">Modificar datos</button>
                    ');
                }
                ?>
                <?
                if ($rol != "Paciente") {
                    echo ('
                        <li class="nav-item" role="presentation">
                        <a class="nav-link" href="users.php" style="color: #000000">Volver atrás</a>
                        </li>');
                }
                ?>
            </ul>
            <div class="tab-content custom-color" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-about" role="tabpanel" aria-labelledby="pills-about-tab" >
                    <div class="content-section" style="margin-right: 10%">
                        <h3>Acerca de</h3>
                        <p><? echo ($usuario[0]['acerca_de']); ?></p>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-appointments" role="tabpanel" aria-labelledby="pills-appointments-tab">
                    <div class="content-section">
                        <h3>Histórico de Citas</h3>
                        <ul class="list-group" style="margin-right: 10%">
                            <?php foreach ($citas as $cita) : ?>
                                <li class="list-group-item"><? echo $cita['fecha_hora'] . ' ' .  $cita['descripcion']; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-history" role="tabpanel" aria-labelledby="pills-history-tab">
                    <div class="content-section">
                        <h3>Historial Médico</h3>
                        <ul class="list-group" style="margin-right: 10%">
                            <?php foreach ($informes as $informe) : ?>
                                <li class="list-group-item"><? echo $informe['fecha_hora'] . ' ' .  $informe['especialidad']; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-data" role="tabpanel" aria-labelledby="pills-data-tab">
                    <div class="content-section">
                        <h3>Cambiar datos</h3>
                        <div class="card" style="margin-right: 10%">
                            <div class="card-body">
                                <form action="../scripts/user_manager.php" method="POST">
                                    <input type="hidden" id="action" name="action" value="actualizar_datos">
                                    <input type="hidden" id="usuario_id" name="usuario_id" value="<?php echo $DNI ?>">

                                    <div class="mb-2">
                                        <label for="email" class="form-label" style="margin-left: 5px;">Correo Electrónico:</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Correo electrónico" value="<?php echo $correo ?>">
                                    </div>
                                    <div class="mb-2">
                                        <label for="pass" class="form-label" style="margin-left: 5px;">Nueva contraseña:</label>
                                        <input type="password" class="form-control" id="pass" name="pass" placeholder="Contraseña" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="confirmPassword" class="form-label" style="margin-left: 5px;">Confirmar nueva contraseña:</label>
                                        <input type="password" class="form-control" id="confirmPass" name="confirmPass" placeholder="Confirmar Contraseña" required>
                                        <div id="passwordError" class="text-danger"></div>
                                    </div>
                                    <button type="submit" class="btn btn-light" onclick="return validatePassword()">Guardar Cambios</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>

    </html>
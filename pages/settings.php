<?php
require_once '../scripts/session_manager.php';

if ($rol == "Paciente") {
    header('Location: 404.php');
    exit();
}

include_once './includes/dashboard.php';

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

<div class="container mt-5">
<div class="col-md-9">
      <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="pills-about-tab" data-bs-toggle="pill" data-bs-target="#pills-about" type="button" role="tab" aria-controls="pills-about" aria-selected="true">Acerca de</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="pills-appointments-tab" data-bs-toggle="pill" data-bs-target="#pills-appointments" type="button" role="tab" aria-controls="pills-appointments" aria-selected="false">Citas</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="pills-history-tab" data-bs-toggle="pill" data-bs-target="#pills-history" type="button" role="tab" aria-controls="pills-history" aria-selected="false">Historial Médico</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="pills-data-tab" data-bs-toggle="pill" data-bs-target="#pills-data" type="button" role="tab" aria-controls="pills-data" aria-selected="false">Modificar datos</button>
        </li>
      </ul>
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-about" role="tabpanel" aria-labelledby="pills-about-tab">
          <div class="content-section">
            <h3>Acerca de</h3>
            <p>Juan Pérez es un paciente de 45 años que ha estado bajo nuestro cuidado desde 2015. Vive en Ciudad de México y trabaja como ingeniero. En su tiempo libre, disfruta de la lectura y el senderismo.</p>
          </div>
        </div>
        <div class="tab-pane fade" id="pills-appointments" role="tabpanel" aria-labelledby="pills-appointments-tab">
          <div class="content-section">
            <h3>Próximas Citas</h3>
            <ul class="list-group">
              <li class="list-group-item">20/05/2024 - Consulta de seguimiento</li>
              <li class="list-group-item">25/05/2024 - Examen de sangre</li>
              <li class="list-group-item">30/05/2024 - Evaluación de ECG</li>
            </ul>
          </div>
        </div>
        <div class="tab-pane fade" id="pills-history" role="tabpanel" aria-labelledby="pills-history-tab">
          <div class="content-section">
            <h3>Historial Médico</h3>
            <ul class="list-group">
              <li class="list-group-item">15/04/2024 - Tratamiento para hipertensión</li>
              <li class="list-group-item">12/03/2024 - Consulta general</li>
              <li class="list-group-item">20/01/2024 - Evaluación de colesterol</li>
            </ul>
          </div>
        </div>
        <div class="tab-pane fade" id="pills-data" role="tabpanel" aria-labelledby="pills-data-tab">
          <div class="content-section">
            <h3>Cambiar datos</h3>
            <div class="card">
              <div class="card-body">
                <form action="../scripts/user_manager.php" method="POST">
                  <input type="hidden" id="action" name="action" value="actualizar_datos">
                  <input type="hidden" id="usuario_id" name="usuario_id" value="<?php echo $DNI ?>">

                  <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Correo electrónico" value="<?php echo $correo ?>">
                  </div>
                  <div class="mb-3">
                    <label for="pass" class="form-label">Nueva contraseña</label>
                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Contraseña" required>
                  </div>
                  <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirmar nueva contraseña</label>
                    <input type="password" class="form-control" id="confirmPass" name="confirmPass" placeholder="Confirmar Contraseña" required>
                    <div id="passwordError" class="text-danger"></div>
                  </div>
                  <button type="submit" class="btn btn-primary" onclick="return validatePassword()">Guardar Cambios</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    </body>

    </html>
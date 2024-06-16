<?php
require_once '../scripts/session_manager.php';
require_once '../controllers/UserController.php';

if ($rol == "Paciente") {
    header("Location: 404.php");
    exit();
}

$userController = new UserController();
$usuarios = $userController->obtenerUltimosUsuarios();

include_once './includes/dashboard.php';
?>

<div class="container">
    <div class="container mt-5">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <!-- Tarjeta de usuarios registrados -->
            <div class="col">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Usuarios Registrados</h5>
                        <p class="card-text fs-1">500</p>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de fisioterapeutas -->
            <div class="col">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Fisioterapeutas</h5>
                        <p class="card-text fs-1">50</p>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de facturas -->
            <div class="col">
                <div class="card text-white bg-danger">
                    <div class="card-body">
                        <h5 class="card-title">Facturas</h5>
                        <p class="card-text fs-1">200</p>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de citas -->
            <div class="col">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <h5 class="card-title">Citas</h5>
                        <p class="card-text fs-1">1000</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 mt-5 border-bottom">
        <h3>Últimos usuarios registrados</h3>
    </div>

    <div class="table-responsive small">
        <div class="row">
            <!-- Aquí se mostrarán los usuarios en forma de tabla -->
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 5%;">ID</th>
                                <th scope="col" style="width: 10%;">Nombre</th>
                                <th scope="col" style="width: 15%;">Apellidos</th>
                                <th scope="col" style="width: 15%;">Email</th>
                                <th scope="col" style="width: 29%;">Direccion</th>
                                <th scope="col" style="width: 5%;">Teléfono</th>
                                <th scope="col" style="width: 5%;">Ses.Dis.</th>
                                <th scope="col" style="width: 5%;">Rol</th>
                                <th scope="col" style="width: 8%;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $usuario) : ?>
                                <tr>
                                    <td><?php echo $usuario['usuario_id']; ?></td>
                                    <td><?php echo $usuario['nombre']; ?></td>
                                    <td><?php echo $usuario['apellidos']; ?></td>
                                    <td><?php echo $usuario['email']; ?></td>
                                    <td><?php echo $usuario['direccion'] . ' ' . $usuario['provincia'] . ' ' . $usuario['municipio'] . ' ' . $usuario['cp'] ?></td>
                                    <td><?php echo $usuario['telefono']; ?></td>
                                    <td><?php echo $usuario['sesiones_disponibles']; ?></td>
                                    <td>
                                        <?php
                                        $rol = $usuario['rol'];

                                        switch ($rol) {
                                            case 'Paciente':
                                                $text_gb_class = 'text-bg-secondary';
                                                break;
                                            case 'Fisioterapeuta':
                                                $text_gb_class = 'text-bg-info';
                                                break;
                                            case 'Administrador':
                                                $text_gb_class = 'text-bg-danger';
                                                break;
                                            default:
                                                $text_gb_class = 'text-bg-secondary';
                                        }
                                        ?>
                                        <span class="badge <?php echo $text_gb_class; ?>">
                                            <?php echo $rol; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#edit_<?php echo $usuario['usuario_id']; ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                            </svg>
                                        </button>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_<?php echo $usuario['usuario_id']; ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                            </svg></button>
                                        <?php include './modals/users/edit_delete_modal.php'; ?>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<!-- 
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-start">
                <li class="page-item <? echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="users.php?pagina=<?php echo $_GET['pagina'] - 1 ?>">Anterior</a>
                </li>
                <?php for ($i = 0; $i < $n_botones_paginacion; $i++) : ?>
                    <li class="page-item <? echo $_GET['pagina'] == $i + 1 ? 'active' : '' ?>"><a class="page-link" href="users.php?pagina=<?php echo $i + 1 ?>"><?php echo $i + 1 ?></a></li>
                <?php endfor ?>
                <li class="page-item <? echo $_GET['pagina'] >= $n_botones_paginacion ? 'disabled' : '' ?>">
                    <a class="page-link" href="users.php?pagina=<?php echo $_GET['pagina'] + 1 ?>">Siguiente</a>
                </li>
            </ul>
        </nav>
    </div> -->

</main>

</body>

</html>
<?php
include '../scripts/session_manager.php';
include '../controllers/InvoiceController.php';
$invoiceController = new InvoiceController();

if ($rol == "Administrador" || $rol == "Fisioterapeuta") {
    header("Location: 404.php");
    exit();
}

if (!$_GET) {
    header('location:invoices-patients.php?pagina=1');
}

$articulos_x_pagina = 10;

$facturas = $invoiceController->obtenerFacturas();

$iniciar = ($_GET['pagina'] - 1) * $articulos_x_pagina;

// Obtener el valor de los filtros, si están presentes en el formulario
$filtro_usuario_id = isset($_POST['usuario_id']) ? $_POST['usuario_id'] : '';
$filtro_estado = isset($_POST['estado']) ? $_POST['estado'] : '';

// Obtener usuarios aplicando los filtros si es necesario
if (!empty($filtro_usuario_id) || !empty($filtro_estado)) {
    // Si se aplica al menos un filtro
    $facturasPaginadas = $invoiceController->buscarFacturasPatients($filtro_usuario_id, $filtro_estado);
} else {
    // Si no se aplican filtros, obtener usuarios paginados
    $facturasPaginadas = $invoiceController->obtenerFacturasUsuarioPaginadas($DNI, $iniciar, $articulos_x_pagina);
}

$n_botones_paginacion = ceil(count($facturas) / ($articulos_x_pagina));

if ($_GET['pagina'] > $n_botones_paginacion) {
    header('location:invoices-patients.php?pagina=1');
}

include_once './includes/dashboard-patients.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 mt-5">
    <form class="row g-3" method="post" action="">
        <input type="text" id="usuario_id" name="usuario_id" hidden value="<?php echo $DNI ?>">
        <div class="col-auto">
            <select class="form-select custom-bg-color" id="estado" name="estado" aria-label="Selecciona un estado">
                <option selected value="" hidden>Selecciona un estado</option>
                <option value="Pagada">Pagada</option>
                <option value="Pendiente">Pendiente</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-dark mb-3">Filtrar</button>
        </div>
    </form>
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
        <div class="col">
            <div class="table-responsive">
                <table class="table rounded-table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" style="width: 5%;">ID</th>
                            <th scope="col" style="width: 15%;">Cliente</th>
                            <th scope="col" style="width: 15%;">Fecha de Emisión</th>
                            <th scope="col" style="width: 15%;">Estado</th>
                            <th scope="col" style="width: 15%;">Monto</th>
                            <th scope="col" style="width: 15%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider table-active table-dark">
                        <?php foreach ($facturasPaginadas as $factura): ?>
                            <tr>
                                <td><?php echo $factura['factura_id']; ?></td>
                                <td><?php echo $factura['paciente_id']; ?></td>
                                <td><?php echo $factura['fecha_emision']; ?></td>
                                <td>
                                    <?php
                                    $estado = $factura['estado'];

                                    switch ($estado) {
                                        case 'Pendiente':
                                            $text_gb_class = 'text-bg-warning';
                                            break;
                                        case 'Pagada':
                                            $text_gb_class = 'text-bg-success';
                                            break;
                                        default:
                                            $text_gb_class = 'text-bg-warning';
                                    }
                                    ?>
                                    <span class="badge <?php echo $text_gb_class; ?>">
                                        <?php echo $estado; ?>
                                    </span>
                                </td>
                                <td><?php echo $factura['monto']; ?>€</td>
                                <td>
                                    <form action="../scripts/invoice_manager.php" method="GET">
                                        <input type="hidden" name="id" value="<?php echo $factura['factura_id']; ?>">
                                        <button type="submit" class="btn btn-primary btn-sm" style="padding: 6px 12px;"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-file-earmark-arrow-down"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293z" />
                                                <path
                                                    d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
                                            </svg> Descargar</button>
                                    </form>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-start">
            <li class="page-item <? echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" style="background-color: #222; color: #FFFFFF; border-color:#222" href="invoices-patients.php?pagina=<?php echo $_GET['pagina'] - 1 ?>">Anterior</a>
            </li>
            <?php for ($i = 0; $i < $n_botones_paginacion; $i++): ?>
                <li class="page-item <? echo $_GET['pagina'] == $i + 1 ? 'active' : '' ?>"><a class="page-link"
                        href="invoices-patients.php?pagina=<?php echo $i + 1 ?>"><?php echo $i + 1 ?></a></li>
            <?php endfor ?>
            <li class="page-item <? echo $_GET['pagina'] >= $n_botones_paginacion ? 'disabled' : '' ?>">
                <a class="page-link" style="background-color: #222; color: #FFFFFF; border-color:#222" href="invoices-patients.php?pagina=<?php echo $_GET['pagina'] + 1 ?>">Siguiente</a>
            </li>
        </ul>
    </nav>

</div>

</div>

</body>

</html>
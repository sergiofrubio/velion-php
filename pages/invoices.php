<?php
require_once '../scripts/session_manager.php';
require_once '../controllers/InvoiceController.php';
require_once '../controllers/ProductController.php';

$productController = new ProductController();
$invoiceController = new InvoiceController();

$productos = $productController->obtenerProductos();

if ($rol == "Paciente") {
    header("Location: 404.php");
    exit();
}

if (!$_GET) {
    header('location:invoices.php?pagina=1');
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
    $facturasPaginadas = $invoiceController->buscarFacturas($filtro_usuario_id, $filtro_estado);
} else {
    // Si no se aplican filtros, obtener usuarios paginados
    $facturasPaginadas = $invoiceController->obtenerFacturasPaginadas($iniciar, $articulos_x_pagina);
}

$n_botones_paginacion = ceil(count($facturas) / ($articulos_x_pagina));

if ($_GET['pagina'] > $n_botones_paginacion) {
    header('location:invoices.php?pagina=1');
}



include_once './includes/dashboard.php';
include './modals/invoices/add_modal.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Facturas</h1>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarModal">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-dotted" viewBox="0 0 16 16">
            <path d="M8 0q-.264 0-.523.017l.064.998a7 7 0 0 1 .918 0l.064-.998A8 8 0 0 0 8 0M6.44.152q-.52.104-1.012.27l.321.948q.43-.147.884-.237L6.44.153zm4.132.271a8 8 0 0 0-1.011-.27l-.194.98q.453.09.884.237zm1.873.925a8 8 0 0 0-.906-.524l-.443.896q.413.205.793.459zM4.46.824q-.471.233-.905.524l.556.83a7 7 0 0 1 .793-.458zM2.725 1.985q-.394.346-.74.74l.752.66q.303-.345.648-.648zm11.29.74a8 8 0 0 0-.74-.74l-.66.752q.346.303.648.648zm1.161 1.735a8 8 0 0 0-.524-.905l-.83.556q.254.38.458.793l.896-.443zM1.348 3.555q-.292.433-.524.906l.896.443q.205-.413.459-.793zM.423 5.428a8 8 0 0 0-.27 1.011l.98.194q.09-.453.237-.884zM15.848 6.44a8 8 0 0 0-.27-1.012l-.948.321q.147.43.237.884zM.017 7.477a8 8 0 0 0 0 1.046l.998-.064a7 7 0 0 1 0-.918zM16 8a8 8 0 0 0-.017-.523l-.998.064a7 7 0 0 1 0 .918l.998.064A8 8 0 0 0 16 8M.152 9.56q.104.52.27 1.012l.948-.321a7 7 0 0 1-.237-.884l-.98.194zm15.425 1.012q.168-.493.27-1.011l-.98-.194q-.09.453-.237.884zM.824 11.54a8 8 0 0 0 .524.905l.83-.556a7 7 0 0 1-.458-.793zm13.828.905q.292-.434.524-.906l-.896-.443q-.205.413-.459.793zm-12.667.83q.346.394.74.74l.66-.752a7 7 0 0 1-.648-.648zm11.29.74q.394-.346.74-.74l-.752-.66q-.302.346-.648.648zm-1.735 1.161q.471-.233.905-.524l-.556-.83a7 7 0 0 1-.793.458zm-7.985-.524q.434.292.906.524l.443-.896a7 7 0 0 1-.793-.459zm1.873.925q.493.168 1.011.27l.194-.98a7 7 0 0 1-.884-.237zm4.132.271a8 8 0 0 0 1.012-.27l-.321-.948a7 7 0 0 1-.884.237l.194.98zm-2.083.135a8 8 0 0 0 1.046 0l-.064-.998a7 7 0 0 1-.918 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
        </svg>
        Agregar Factura
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
            <input type="text" class="form-control" id="usuario_id" name="usuario_id" placeholder="Filtrar por ID del cliente...">
        </div>
        <div class="col-auto">
            <select class="form-select" id="estado" name="estado" aria-label="Selecciona un estado">
                <option selected value="" hidden>Selecciona un estado</option>
                <option value="Pagada">Pagada</option>
                <option value="Pendiente">Pendiente</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3">Filtrar</button>
        </div>
    </form>
    <div class="row">
        <!-- Aquí se mostrarán las facturas en forma de tabla -->
        <div class="col">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 5%;">ID</th>
                            <th scope="col" style="width: 10%;">Cliente</th>
                            <th scope="col" style="width: 10%;">Fecha de Emisión</th>
                            <th scope="col" style="width: 10%;">Estado</th>
                            <th scope="col" style="width: 10%;">Monto</th>
                            <th scope="col" style="width: 5%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($facturasPaginadas as $factura) : ?>
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
                                        <input type="hidden" name="id" value="<?php echo $factura['factura_id']; ?>">
                                        <button class="btn btn-sm btn-success" <?php if ($factura['estado'] == 'Pagada') {
                                                                                echo 'disabled';
                                                                            } ?> data-bs-toggle="modal" data-bs-target="#confirm_<?php echo $factura['factura_id']; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                            <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z" />
                                        </svg></button>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#generate_<?php echo $factura['factura_id'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-arrow-down" viewBox="0 0 16 16">
                                                <path d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293z" />
                                                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
                                            </svg></button>

                                        <button type="button" class="btn btn-danger btn-sm d-inline" data-bs-toggle="modal" data-bs-target="#delete_<?php echo $factura['factura_id'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                            </svg></button>

                                        <?php include 'modals/invoices/edit_delete_modal.php'; ?>
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
            <a class="page-link" href="invoices.php?pagina=<?php echo $_GET['pagina'] - 1 ?>">Anterior</a>
        </li>
        <?php for ($i = 0; $i < $n_botones_paginacion; $i++) : ?>
            <li class="page-item <? echo $_GET['pagina'] == $i + 1 ? 'active' : '' ?>"><a class="page-link" href="invoices.php?pagina=<?php echo $i + 1 ?>"><?php echo $i + 1 ?></a></li>
        <?php endfor ?>
        <li class="page-item <? echo $_GET['pagina'] >= $n_botones_paginacion ? 'disabled' : '' ?>">
            <a class="page-link" href="invoices.php?pagina=<?php echo $_GET['pagina'] + 1 ?>">Siguiente</a>
        </li>
    </ul>
</nav>

</div>

</main>

</body>

</html>
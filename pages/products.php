<?php
require_once '../scripts/session_manager.php';
require_once '../controllers/ProductController.php';

$productController = new ProductController();

if ($rol == "Paciente") {
    header("Location: 404.php");
    exit();
}

if (!$_GET) {
    header('location:products.php?pagina=1');
}

$articulos_x_pagina = 10;

$productos = $productController->obtenerProductos();
$categorias = $productController->obtenerCategorias();

$iniciar = ($_GET['pagina'] - 1) * $articulos_x_pagina;

// Obtener el valor de los filtros, si están presentes en el formulario
$filtro_producto_id = isset($_POST['producto_id']) ? $_POST['producto_id'] : '';
$filtro_categoria = isset($_POST['categoria_id']) ? $_POST['categoria_id'] : '';

// Obtener productos aplicando los filtros si es necesario
if (!empty($filtro_producto_id) || !empty($filtro_categoria)) {
    // Si se aplica al menos un filtro
    $productosPaginados = $productController->buscarProductos($filtro_producto_id, $filtro_categoria);
} else {
    // Si no se aplican filtros, obtener productos paginados
    $productosPaginados = $productController->obtenerProductosPaginados($iniciar, $articulos_x_pagina);
}

$n_botones_paginacion = ceil(count($productos) / ($articulos_x_pagina));

if ($_GET['pagina'] > $n_botones_paginacion) {
    header('location:products.php?pagina=1');
}

include_once './includes/dashboard.php';
include_once './modals/products/add_modal.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Productos</h1>

    <div class="d-flex justify-content-end align-items-center">
        <form action="../scripts/product_manager.php" method="POST">
            <div class="col-auto">
                <input type="hidden" value="exportar" id="action" name="action">
                <button class="btn btn-primary me-2" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf" viewBox="0 0 16 16">
                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
                        <path d="M4.603 14.087a.8.8 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.7 7.7 0 0 1 1.482-.645 20 20 0 0 0 1.062-2.227 7.3 7.3 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a11 11 0 0 0 .98 1.686 5.8 5.8 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.86.86 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.7 5.7 0 0 1-.911-.95 11.7 11.7 0 0 0-1.997.406 11.3 11.3 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.8.8 0 0 1-.58.029m1.379-1.901q-.25.115-.459.238c-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361q.016.032.026.044l.035-.012c.137-.056.355-.235.635-.572a8 8 0 0 0 .45-.606m1.64-1.33a13 13 0 0 1 1.01-.193 12 12 0 0 1-.51-.858 21 21 0 0 1-.5 1.05zm2.446.45q.226.245.435.41c.24.19.407.253.498.256a.1.1 0 0 0 .07-.015.3.3 0 0 0 .094-.125.44.44 0 0 0 .059-.2.1.1 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a4 4 0 0 0-.612-.053zM8.078 7.8a7 7 0 0 0 .2-.828q.046-.282.038-.465a.6.6 0 0 0-.032-.198.5.5 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822q.036.167.09.346z" />
                    </svg>
                    Exportar a PDF
                </button>
            </div>
        </form>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarModal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-dotted" viewBox="0 0 16 16">
                <path d="M8 0q-.264 0-.523.017l.064.998a7 7 0 0 1 .918 0l.064-.998A8 8 0 0 0 8 0M6.44.152q-.52.104-1.012.27l.321.948q.43-.147.884-.237L6.44.153zm4.132.271a8 8 0 0 0-1.011-.27l-.194.98q.453.09.884.237zm1.873.925a8 8 0 0 0-.906-.524l-.443.896q.413.205.793.459zM4.46.824q-.471.233-.905.524l.556.83a7 7 0 0 1 .793-.458zM2.725 1.985q-.394.346-.74.74l.752.66q.303-.345.648-.648zm11.29.74a8 8 0 0 0-.74-.74l-.66.752q.346.303.648.648zm1.161 1.735a8 8 0 0 0-.524-.905l-.83.556q.254.38.458.793l.896-.443zM1.348 3.555q-.292.433-.524.906l.896.443q.205-.413.459-.793zM.423 5.428a8 8 0 0 0-.27 1.011l.98.194q.09-.453.237-.884zM15.848 6.44a8 8 0 0 0-.27-1.012l-.948.321q.147.43.237.884zM.017 7.477a8 8 0 0 0 0 1.046l.998-.064a7 7 0 0 1 0-.918zM16 8a8 8 0 0 0-.017-.523l-.998.064a7 7 0 0 1 0 .918zm-.152 1.56q-.104.52-.27 1.012l-.948-.321q.147-.43.237-.884zm-15.425.271a8 8 0 0 0 .27 1.012l.98-.194q-.09-.453-.237-.884zm14.478 2.597q.233-.471.524-.905l-.83-.556q-.205.413-.459.793zm-13.843-.905a8 8 0 0 0 .524.905l.83-.556q-.254-.38-.458-.793zm-.925 1.873q.346.394.74.74l.66-.752q-.345-.303-.648-.648zm14.742.74a8 8 0 0 0 .74-.74l-.752-.66q-.303.345-.648.648zm-1.735 1.161q.433-.292.905-.524l-.556-.83q-.38.254-.793.458zm-10.51-.524a8 8 0 0 0 .906.524l.443-.896q-.413-.205-.793-.459zm9.176.646q.52-.104 1.012-.27l-.321-.948q-.43.147-.884.237zM3.516 15.577q.471.233.905.524l.556-.83q-.38-.254-.793-.458zm8.84.524a8 8 0 0 0 1.012-.27l-.194-.98q-.453.09-.884.237zm-4.469.271c.175.011.351.017.523.017s.348-.006.523-.017l-.064-.998a7 7 0 0 1-.918 0z" />
                <path d="M8 4a.5.5 0 0 1 .5.5V7h2.5a.5.5 0 0 1 0 1H8.5v2.5a.5.5 0 0 1-1 0V8H5a.5.5 0 0 1 0-1h2.5V4.5A.5.5 0 0 1 8 4z" />
            </svg>
            Agregar Producto
        </button>
    </div>
</div>

<?php
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

<!-- Filtrado -->
<div class="table-responsive small">
    <form class="row g-3 mb-3" method="POST" action="">
        <div class="col-auto">
            <input type="text" class="form-control" id="producto_id" name="producto_id" value="<?php echo $filtro_producto_id; ?>" placeholder="Filtrar por ID...">
        </div>
        <div class="col-auto">
            <select class="form-select" id="categoria_id" name="categoria_id">
                <option selected value="" hidden>Seleccione una categoría</option>
                <?php foreach ($categorias as $categoria) : ?>
                    <option value="<?php echo $categoria['categoria_id']; ?>" <?php echo ($filtro_categoria == $categoria['categoria_id']) ? 'selected' : ''; ?>><?php echo $categoria['nombre']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
    </form>

    <!-- Tabla de Productos -->
    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Categoría</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($productosPaginados)) : ?>
                            <?php foreach ($productosPaginados as $producto) : ?>
                                <tr>
                                    <td><?php echo $producto['producto_id']; ?></td>
                                    <td><?php echo $producto['nombre']; ?></td>
                                    <td><?php echo $producto['monto']; ?></td>
                                    <td><?php echo $producto['categoria']; ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#edit_<?php echo $producto['producto_id']; ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                            </svg>
                                        </button>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_<?php echo $producto['producto_id']; ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                            </svg></button>
                                        <?php include './modals/products/edit_delete_modal.php'; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6">No se encontraron productos.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="products.php?pagina=<?php echo $_GET['pagina'] - 1; ?>">Anterior</a>
                    </li>
                    <?php for ($i = 0; $i < $n_botones_paginacion; $i++) : ?>
                        <li class="page-item <?php echo $_GET['pagina'] == $i + 1 ? 'active' : ''; ?>">
                            <a class="page-link" href="products.php?pagina=<?php echo $i + 1; ?>"><?php echo $i + 1; ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo $_GET['pagina'] >= $n_botones_paginacion ? 'disabled' : ''; ?>">
                        <a class="page-link" href="products.php?pagina=<?php echo $_GET['pagina'] + 1; ?>">Siguiente</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
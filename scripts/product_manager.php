<?php
include '../controllers/ProductController.php';
include 'session_manager.php';

$productController = new ProductController();

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["action"]) {

    switch ($_POST['action']) {
        case 'añadir':
            $datos = array(
                'nombre' => $_POST["nombre"],
                'categoria_id' => $_POST["categoria_id"],
                'descripcion' => $_POST["descripcion"],
                'monto' => $_POST["monto"]
            );

            $productController->agregarProducto('productos', $datos);
            break;

        case 'editar':
            $datos = array(
                'nombre' => $_POST["nombre"],
                'categoria_id' => $_POST["categoria_id"],
                'descripcion' => $_POST["descripcion"],
                'monto' => $_POST["monto"]
            );

            $condicion = "producto_id = '" . $_POST["producto_id"] . "'";
            $productController->editarProducto('productos', $datos, $condicion);
            break;

        case 'eliminar':
            $datos = "producto_id = '" . $_POST["producto_id"] . "'";
            $productController->eliminarProducto('productos', $datos);
            break;

        case 'exportar':
            $productController->exportarDatos();
            break;
    }
}

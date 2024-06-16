<?php
require_once '../models/ProductModel.php';
require_once '../assets/fpdf186/fpdf.php';

class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new ProductModel();
    }

    public function obtenerProductos() {
        return $this->productModel->read('productos');
    }

    public function obtenerFacturasUsuario($DNI){
        return $this->productModel->obtenerFacturasPorID($DNI);
    }


    public function obtenerProductosPaginados($inicio, $articulosPorPagina) {
        return $this->productModel->getProductsPaginated($inicio, $articulosPorPagina);
    }

    public function buscarProductos($productoId, $categoria) {
        $productosFiltrados = $this->productModel->searchProducts($productoId, $categoria);
        if (!empty($productosFiltrados)) {
            return $productosFiltrados;
        } else {
            $_SESSION['alert'] = array('type' => 'warning', 'message' => 'No se ha encontrado ningún usuario con los criterios seleccionados.');
            header('Location: ../pages/products.php');
            exit();
        }
    }

    public function obtenerCategorias() {
        return $this->productModel->read('categorias');
    }
    
    public function agregarProducto($tabla, $datos) {
        if ($this->productModel->insert($tabla, $datos)) {
            $_SESSION['alert'] = array('type' => 'success', 'message' => 'Producto añadido correctamente.');
            header('Location: ../pages/products.php');
            exit();
        } else {
            $_SESSION['alert'] = array('type' => 'warning', 'message' => 'No se ha podido añadir el producto correctamente.');
            header('Location: ../pages/products.php');
            exit();
        }
    }

    public function editarProducto($tabla, $datos, $condicion) {
        if ($this->productModel->update($tabla, $datos, $condicion)) {
            $_SESSION['alert'] = array('type' => 'success', 'message' => 'Datos del producto actualizados correctamente.');
            header('Location: ../pages/products.php');
            exit();
        } else {
            $_SESSION['alert'] = array('type' => 'warning', 'message' => 'No se ha podido actualizar los datos del producto.');
            header('Location: ../pages/products.php');
            exit();
        }
    }

    public function eliminarProducto($tabla, $condicion) {
        if ($this->productModel->delete($tabla, $condicion)) {
            $_SESSION['alert'] = array('type' => 'success', 'message' => 'Producto eliminado correctamente.');
            header('Location: ../pages/products.php');
            exit();
        } else {
            $_SESSION['alert'] = array('type' => 'warning', 'message' => 'No se ha podido eliminar el producto correctamente.');
            header('Location: ../pages/products.php');
            exit();
        }
    }

    public function exportarDatos()
    {
        $productos = $this->productModel->obtenerProductos();

    
        // Instanciar un nuevo objeto FPDF
        $pdf = new FPDF(); // Orientación horizontal, unidad de medida en mm, tamaño de página A4
    
        // Agregar una nueva página al PDF
        $pdf->AddPage();

        // Definir el alias para el total de páginas
        // $pdf->AliasNbPages();
    
        // Definir el título del reporte
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252', 'Reporte de Productos'), 1, 1, 'C');
    
        // Definir los encabezados de la tabla
        $pdf->SetFont('Arial', 'B', 8); // Cambiar el tamaño de la letra
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(27, 10, 'ID', 1, 0, 'C'); // Reducir la anchura de la celda
        $pdf->Cell(59, 10, iconv('UTF-8', 'windows-1252', 'Nombre'), 1, 0, 'C'); // Ajustar la anchura de la celda
        $pdf->Cell(59, 10, iconv('UTF-8', 'windows-1252', 'Categoria'), 1, 0, 'C'); // Ajustar la anchura de la celda
        $pdf->Cell(45, 10, iconv('UTF-8', 'windows-1252', 'Monto'), 1, 0, 'C'); // Ajustar la anchura de la celda

        $pdf->Ln(); // Salto de línea para la siguiente fila
    
        // Recorrer los usuarios y mostrarlos en la tabla
        $pdf->SetFont('Arial', '', 8);
        foreach ($productos as $producto) {
            $pdf->Cell(27, 10, $producto['producto_id'], 1, 0, 'C');
            $pdf->Cell(59, 10, iconv('UTF-8', 'windows-1252', $producto['nombre']), 1, 0, 'L');
            $pdf->Cell(59, 10, iconv('UTF-8', 'windows-1252', $producto['categoria']), 1, 0, 'L');
            $pdf->Cell(45, 10, iconv('UTF-8', 'windows-1252', $producto['monto']. '€'), 1, 0, 'C');
            $pdf->Ln(); // Salto de línea para la siguiente fila
        }

        // Crear el footer en cada página
        // $pdf->SetFont('Arial', '', 8);
        // $pdf->SetY(-15); // Posicionamiento vertical del footer (1.5 cm desde el final)
        // $pdf->Cell(0, 10, 'Pagina ' . $pdf->PageNo() . 'de {nb}', 0, 0, 'C'); // Page No. and Total Pages
            
        // Generar el archivo PDF y descargarlo
        $pdf->Output('ReporteEspecialidades.pdf', 'D', true); // 'D' para descargar, 'F' para guardar en el servidor
    }
}
?>

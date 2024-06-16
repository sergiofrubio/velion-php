<?php
require_once 'BaseModel.php';

class ProductModel extends BaseModel{

    public function __construct() {
        parent::__construct();
    }

    public function getProductsPaginated($inicio, $articulosPorPagina) {
        $query = "SELECT p.producto_id, p.nombre, p.descripcion, p.monto, c.nombre AS categoria 
        FROM productos p 
        JOIN categorias c ON p.categoria_id = c.categoria_id 
        LIMIT ?, ?
        ";
        $stmt = self::$conexion->prepare($query);
        $stmt->bind_param('ii', $inicio, $articulosPorPagina);
        $stmt->execute();
        $result = $stmt->get_result();
        $productos = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $productos;
    }


    public function obtenerFacturasPorID($usuario_id)
    {
        $sql = "SELECT f.factura_id, f.paciente_id, f.fecha_emision, f.estado, 
                   p.nombre AS producto_nombre, p.descripcion AS producto_descripcion, p.monto 
            FROM `facturas` f
            JOIN `productos` p ON f.producto_id = p.producto_id
            WHERE f.paciente_id = ?";
        $stmt = self::$conexion->prepare($sql);
        $stmt->bind_param("s", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $facturas = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $facturas;
    }

    public function searchProducts($productoId, $categoria) {
        $sql = "SELECT p.producto_id, p.categoria_id, p.nombre, p.monto, c.nombre AS categoria FROM productos p JOIN categorias c ON p.categoria_id = c.categoria_id WHERE 1=1";
        $params = [];
        $types = "";
        
    
        if (!empty($productoId)) {
            $sql .= " AND p.producto_id = ?";
            $params[] = $productoId;
            $types .= "i";
        }
    
        if (!empty($categoria)) {
            $sql .= " AND p.categoria_id = ?";
            $params[] = $categoria;
            $types .= "i";
        }

        $stmt = self::$conexion->prepare($sql);
        if ($types) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $productos = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $productos;
    }

    public function obtenerProductos(){
        $sql = "SELECT p.producto_id, p.categoria_id, p.nombre, p.monto, c.nombre AS categoria FROM productos p JOIN categorias c ON p.categoria_id = c.categoria_id";
        $stmt = self::$conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $productos = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $productos;
    }

}
?>

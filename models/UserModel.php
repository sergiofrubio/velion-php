<?php

require_once 'BaseModel.php';

class UserModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct(); // Llama al constructor de la clase padre (BaseModel)
    }

    public function obtenerUltimosUsuarios($limite = 5)
    {
        // Prepara la consulta para obtener los últimos 5 usuarios ordenados por fecha de creación
        $sql = "SELECT * FROM usuarios ORDER BY usuario_id DESC LIMIT ?";
        
        // Prepara y ejecuta la consulta
        $stmt = self::$conexion->prepare($sql);
        $stmt->bind_param("i", $limite);
        $stmt->execute();
        $resultado = $stmt->get_result();

        // Obtiene los resultados
        $usuarios = [];
        while ($fila = $resultado->fetch_assoc()) {
            $usuarios[] = $fila;
        }

        // Libera el statement y cierra la conexión
        $stmt->close();
        
        return $usuarios;
    }

    public function obtenerUsuariosPaginados($iniciar, $articulos_x_pagina)
    {
        // Buscar el usuario en la base de datos
        $sql = "SELECT * FROM usuarios LIMIT $iniciar, $articulos_x_pagina";

        $resultado = self::$conexion->query($sql);

        // Ejecutar la consulta
        $resultado =  self::$conexion->query($sql);

        // Manejo de errores
        if (!$resultado) {
            die("Error al ejecutar la consulta: " . self::$conexion->error);
        }

        // Procesa el resultado
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        return $datos;
    }

    public function buscarUsuarios($usuario_id, $rol)
    {
        $sql = "SELECT * FROM `usuarios` WHERE 1=1";
        $params = [];
        $types = "";
    
        if (!empty($usuario_id)) {
            $sql .= " AND usuario_id = ?";
            $params[] = $usuario_id;
            $types .= "s";
        }
    
        if (!empty($rol)) {
            $sql .= " AND rol = ?";
            $params[] = $rol;
            $types .= "s";
        }
    
        $stmt = self::$conexion->prepare($sql);
        if ($types) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $usuarios = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    
        return $usuarios;
    }
    

    public function actualizarUsuario($usuario_id, $datos)
    {
        $sql = "UPDATE `usuarios` SET nombre = ?, apellidos = ?, telefono = ?, fecha_nacimiento = ?, direccion = ?, provincia = ?, municipio = ?, cp = ?, email = ?, pass = ?, rol = ?, genero = ? WHERE usuario_id = ?";
        $stmt = self::$conexion->prepare($sql);
        $stmt->bind_param("ssissssisssss", $datos['nombre'], $datos['apellidos'], $datos['telefono'], $datos['fecha_nacimiento'], $datos['direccion'], $datos['provincia'], $datos['municipio'], $datos['cp'], $datos['email'], $datos['pass'], $datos['rol'], $datos['genero'], $usuario_id);
        $result = $stmt->execute(); // Ejecutar la consulta UPDATE
        $stmt->close();
        return $result;
    }

    public function eliminarUsuario($usuario_id)
    {
        $conexion = self::$conexion;
        $usuario_id_escapado = $conexion->real_escape_string($usuario_id);

        // Iniciar una transacción
        $conexion->begin_transaction();

        try {
            // Eliminar las citas asociadas
            $sql = "DELETE FROM `citas` WHERE `paciente_id` = '$usuario_id_escapado' OR `fisioterapeuta_id` = '$usuario_id_escapado'";
            $conexion->query($sql);

            // Eliminar las facturas asociadas
            $sql = "DELETE FROM `facturas` WHERE `paciente_id` = '$usuario_id_escapado'";
            $conexion->query($sql);

            // Eliminar los registros de historial médico asociados
            $sql = "DELETE FROM `historial_medico` WHERE `paciente_id` = '$usuario_id_escapado' OR `fisioterapeuta_id` = '$usuario_id_escapado'";
            $conexion->query($sql);

            // Finalmente, eliminar el usuario
            $sql = "DELETE FROM `usuarios` WHERE `usuario_id` = '$usuario_id_escapado'";
            $conexion->query($sql);

            // Si todo ha ido bien, confirmar la transacción
            $conexion->commit();

            // Establecer la alerta de éxito
            $_SESSION['alert'] = array('type' => 'success', 'message' => 'Usuario eliminado correctamente.');
        } catch (Exception $e) {
            // Si ha habido algún problema, revertir la transacción
            $conexion->rollback();

            // Establecer la alerta de error
            $_SESSION['alert'] = array('type' => 'error', 'message' => 'No se ha podido eliminar el usuario correctamente. Error: ' . $e->getMessage());
        }

        // Redirigir a la página de usuarios
        header('Location: ../pages/users.php');
        exit();
    }
}

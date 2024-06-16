<?php

require_once 'BaseModel.php';

class SpecialityModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct(); // Llama al constructor de la clase padre (BaseModel)
    }

    public function obtenerEspecialidadesPaginadas($iniciar, $articulos_x_pagina)
    {
        // Buscar el usuario en la base de datos
        $sql = "SELECT * FROM especialidades LIMIT $iniciar, $articulos_x_pagina";

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

    public function obtenerEspecialidadesPorDescripcion($filtro_especialidad)
    {
        $sql = "SELECT * FROM especialidades WHERE descripcion LIKE '%$filtro_especialidad%'";
        $stmt = self::$conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $horarios = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $horarios;
    }

}

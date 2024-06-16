<?php

require_once 'BaseModel.php';

class MedicalHistoryModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct(); // Llama al constructor de la clase padre (BaseModel)
    }

    public function obtenerInforme($DNI)
    {
        $DNI = self::$conexion->real_escape_string($DNI);

        $sql = "SELECT 
        c.cita_id,
        c.fecha_hora,
        c.estado AS estado_cita,
        c.diagnostico,
        c.notas,
        c.tratamiento,
        e.descripcion AS especialidad,
        p.usuario_id AS paciente_id,
        p.nombre AS paciente_nombre,
        p.apellidos AS paciente_apellidos,
        p.telefono AS paciente_telefono,
        p.fecha_nacimiento AS paciente_fecha_nacimiento,
        p.direccion AS paciente_direccion,
        p.provincia AS paciente_provincia,
        p.municipio AS paciente_municipio,
        p.cp AS paciente_cp,
        p.email AS paciente_email,
        p.genero AS paciente_genero,
        f.nombre AS fisioterapeuta_nombre,
        f.apellidos AS fisioterapeuta_apellidos
        FROM 
            citas c
        JOIN 
            usuarios p ON c.paciente_id = p.usuario_id
        JOIN
            usuarios f ON c.fisioterapeuta_id = f.usuario_id
        LEFT JOIN 
            especialidades e ON c.especialidad_id = e.especialidad_id
        WHERE 
            p.usuario_id = '$DNI'
        AND
            c.estado = 'Realizada'
        ORDER BY 
        c.fecha_hora DESC";

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

    public function imprimirInforme($historial_id)
    {
        $historial_id = self::$conexion->real_escape_string($historial_id);

        $sql = "SELECT 
        c.cita_id,
        c.fecha_hora,
        c.estado AS estado_cita,
        c.diagnostico,
        c.notas,
        c.tratamiento,
        e.descripcion AS especialidad,
        p.usuario_id AS paciente_id,
        p.nombre AS paciente_nombre,
        p.apellidos AS paciente_apellidos,
        p.telefono AS paciente_telefono,
        p.fecha_nacimiento AS paciente_fecha_nacimiento,
        p.direccion AS paciente_direccion,
        p.provincia AS paciente_provincia,
        p.municipio AS paciente_municipio,
        p.cp AS paciente_cp,
        p.email AS paciente_email,
        p.genero AS paciente_genero,
        f.nombre AS fisioterapeuta_nombre,
        f.apellidos AS fisioterapeuta_apellidos
        FROM 
            citas c
        JOIN 
            usuarios p ON c.paciente_id = p.usuario_id
        JOIN
            usuarios f ON c.fisioterapeuta_id = f.usuario_id
        LEFT JOIN 
            especialidades e ON c.especialidad_id = e.especialidad_id
        WHERE 
            c.cita_id = '$historial_id'
        AND
            c.estado = 'Realizada'
        ORDER BY 
        c.fecha_hora DESC";

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
    
}

<?php
namespace App\Core;
use PDO;
use PDOException;


class DataBase
{
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __construct()
    {
        $this->host = getenv('DB_HOST') ?: 'db';
        $this->db_name = getenv('DB_NAME') ?: 'velion';
        $this->username = getenv('DB_USER') ?: 'root';
        $this->password = getenv('DB_PASS') ?: 'root';
    }

    public function connect()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new \Exception('Connection error: ' . $e->getMessage());
        }
        return $this->conn;
    }

    // public function insert($tabla, $datos)
    // {
    //     // Prepara la consulta
    //     $campos = implode(', ', array_map(function ($campo) {
    //         return "`$campo`";
    //     }, array_keys($datos)));
    //     $valores = implode(', ', array_map(function ($valor) {
    //         return "'" . self::$conexion->real_escape_string($valor) . "'";
    //     }, array_values($datos)));
    //     $sql = "INSERT INTO `$tabla` ($campos) VALUES ($valores)";
    //     // Ejecuta la consulta
    //     return $this->executeQuery($sql);
    // }

    // public function update($tabla, $datos, $condicion)
    // {
    //     // Prepara la consulta
    //     $actualizaciones = implode(', ', array_map(function ($campo, $valor) {
    //         return "`$campo` = '" . self::$conexion->real_escape_string($valor) . "'";
    //     }, array_keys($datos), array_values($datos)));
    //     $sql = "UPDATE `$tabla` SET $actualizaciones WHERE $condicion";

    //     // Ejecuta la consulta
    //     return $this->executeQuery($sql);
    // }

    // public function delete($tabla, $condicion)
    // {
    //     // Prepara la consulta
    //     $sql = "DELETE FROM `$tabla` WHERE $condicion";

    //     // Ejecuta la consulta
    //     return $this->executeQuery($sql);
    // }

    // public function read($tabla, $condicion = '')
    // {
    //     // Prepara la consulta
    //     $sql = "SELECT * FROM `$tabla`";
    //     if ($condicion !== '') {
    //         $sql .= " WHERE $condicion";
    //     }

    //     // Ejecuta la consulta
    //     $resultado = self::$conexion->query($sql);

    //     // Manejo de errores
    //     if (!$resultado) {
    //         die("Error al ejecutar la consulta: " . self::$conexion->error);
    //     }

    //     // Procesa el resultado
    //     $datos = array();
    //     while ($fila = $resultado->fetch_assoc()) {
    //         $datos[] = $fila;
    //     }
    //     return $datos;
    // }

    // protected function executeQuery($sql)
    // {
    //     // Ejecuta la consulta
    //     if (self::$conexion->query($sql) === TRUE) {
    //         return true;
    //     } else {
    //         die("Error al ejecutar la consulta: " . self::$conexion->error);
    //     }
    // }
}

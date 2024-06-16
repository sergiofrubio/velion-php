<?php
require_once '../models/UserModel.php';
require_once '../assets/fpdf186/fpdf.php';

class UserController
{
    private $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UserModel();
    }
    
    public function obtenerUltimosUsuarios() {
        return  $this->usuarioModel->obtenerUltimosUsuarios();

    }

    public function obtenerUsuariosPaginados($iniciar, $articulos_x_pagina)
    {
        return $this->usuarioModel->obtenerUsuariosPaginados($iniciar, $articulos_x_pagina);
    }

    public function obtenerUsuarios()
    {
        return $this->usuarioModel->read('usuarios');
    }

    public function buscarUsuarios($usuario_id, $rol, $isApiRequest = false)
    {
        $usuariosFiltrados = $this->usuarioModel->buscarUsuarios($usuario_id, $rol);

        if($isApiRequest){
            return $usuariosFiltrados;
        }
    
        if (!empty($usuariosFiltrados)) {
            return $usuariosFiltrados;
        } else {
            $_SESSION['alert'] = array('type' => 'warning', 'message' => 'No se ha encontrado ningún usuario con los criterios seleccionados.');
            header('Location: ../pages/users.php');
            exit();
        }
    }
    

    public function añadirNuevoUsuario($datos)
    {
        if ($this->usuarioModel->insert('usuarios', $datos)) {
            // Dentro de la función añadirNuevoUsuario en UserController.php
            $_SESSION['alert'] = array('type' => 'success', 'message' => 'Usuario añadido correctamente.');
            header('Location: ../pages/users.php');
            exit();
        } else {
            // Dentro de la función añadirNuevoUsuario en UserController.php
            $_SESSION['alert'] = array('type' => 'warning', 'message' => 'No se ha podido añadir el usuario correctamente.');
            header('Location: ../pages/users.php');
            exit();
        }
    }


    public function editarUsuario($datos, $condicion)
    {
        if ($this->usuarioModel->update('usuarios', $datos, $condicion)) {
            $_SESSION['alert'] = array('type' => 'success', 'message' => 'Datos de usuario actualizados correctamente.');
            header('Location: ../pages/users.php');
            exit();
        } else {
            $_SESSION['alert'] = array('type' => 'warning', 'message' => 'No se ha podido actualizar los datos del usuario.');
            header('Location: ../pages/users.php');
            exit();
        }
    }


    public function eliminarUsuario($datos)
    {
        if ($this->usuarioModel->eliminarUsuario($datos)) {
            $_SESSION['alert'] = array('type' => 'success', 'message' => 'Usuario eliminado correctamente.');
            header('Location: ../pages/users.php');
            exit();
        } else {
            $_SESSION['alert'] = array('type' => 'warning', 'message' => 'No se ha podido eliminar el usuario correctamente.');
            header('Location: ../pages/users.php');
            exit();
        }
    }

    public function actualizarDatos($datos, $condicion, $isApiRequest = false)
    {
        if($isApiRequest){
            if ($this->usuarioModel->update('usuarios', $datos, $condicion) == true) {
               return ["message" => "Datos actualizados correctamente."];
            } else {
                return ["message" => "No se han podido actualizar tus datos."];
            }

        } else {
            if ($this->usuarioModel->update('usuarios', $datos, $condicion) == true) {
                $_SESSION['alert'] = array('type' => 'success', 'message' => 'Datos actualizados correctamente.');
                header('Location: ../pages/settings.php');
                exit();
            } else {
                echo "No se ha podido completar el registro";
            }
        }
    }

    public function exportarDatosAPdf()
    {
        // Instanciar un nuevo objeto FPDF
        $pdf = new FPDF('L', 'mm', 'A4'); // Orientación horizontal, unidad de medida en mm, tamaño de página A4

        // Agregar una nueva página al PDF
        $pdf->AddPage();

        // Definir el alias para el total de páginas
        // $pdf->AliasNbPages();

        // Definir el título del reporte
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(0, 10, 'Reporte de Usuarios', 1, 1, 'C');

        // Definir los encabezados de la tabla
        $pdf->SetFont('Arial', 'B', 8); // Cambiar el tamaño de la letra
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(17, 10, 'ID', 1, 0, 'C'); // Reducir la anchura de la celda
        $pdf->Cell(25, 10, 'Nombre', 1, 0, 'C'); // Ajustar la anchura de la celda
        $pdf->Cell(25, 10, 'Apellidos', 1, 0, 'C'); // Ajustar la anchura de la celda
        $pdf->Cell(20, 10, 'Telefono', 1, 0, 'C'); // Ajustar la anchura de la celda
        $pdf->Cell(25, 10, 'F. Nac.', 1, 0, 'C'); // Ajustar la anchura de la celda
        $pdf->Cell(40, 10, 'Direccion', 1, 0, 'C'); // Ajustar la anchura de la celda
        $pdf->Cell(20, 10, 'Provincia', 1, 0, 'C'); // Ajustar la anchura de la celda
        $pdf->Cell(20, 10, 'Municipio', 1, 0, 'C'); // Ajustar la anchura de la celda
        $pdf->Cell(15, 10, 'CP', 1, 0, 'C'); // Reducir la anchura de la celda
        $pdf->Cell(35, 10, 'Email', 1, 0, 'C'); // Ajustar la anchura de la celda
        $pdf->Cell(20, 10, 'Rol', 1, 0, 'C'); // Reducir la anchura de la celda
        $pdf->Cell(15, 10, 'Genero', 1, 0, 'C'); // Reducir la anchura de la celda
        $pdf->Ln(); // Salto de línea para la siguiente fila

        // Obtener los datos de los usuarios (ejemplo usando una consulta a BD)
        $usuarios = $this->obtenerUsuarios(); // Suponiendo que 'obtenerUsuarios' devuelve un array de usuarios

        // Recorrer los usuarios y mostrarlos en la tabla
        $pdf->SetFont('Arial', '', 8);
        foreach ($usuarios as $usuario) {
            $pdf->Cell(17, 10, $usuario['usuario_id'], 1, 0, 'C');
            $pdf->Cell(25, 10, $usuario['nombre'], 1, 0, 'L');
            $pdf->Cell(25, 10, $usuario['apellidos'], 1, 0, 'L');
            $pdf->Cell(20, 10, $usuario['telefono'], 1, 0, 'C');
            $pdf->Cell(25, 10, $usuario['fecha_nacimiento'], 1, 0, 'C');
            $pdf->Cell(40, 10, $usuario['direccion'], 1, 0, 'L');
            $pdf->Cell(20, 10, $usuario['provincia'], 1, 0, 'L');
            $pdf->Cell(20, 10, $usuario['municipio'], 1, 0, 'L');
            $pdf->Cell(15, 10, $usuario['cp'], 1, 0, 'C');
            $pdf->Cell(35, 10, $usuario['email'], 1, 0, 'L');
            $pdf->Cell(20, 10, $usuario['rol'], 1, 0, 'C');
            $pdf->Cell(15, 10, $usuario['genero'], 1, 0, 'C');
            $pdf->Ln(); // Salto de línea para la siguiente fila
        }

        // Crear el footer en cada página
        // $pdf->SetFont('Arial', '', 8);
        // $pdf->SetY(-15); // Posicionamiento vertical del footer (1.5 cm desde el final)
        // $pdf->Cell(0, 10, 'Pagina ' . $pdf->PageNo() . 'de {nb}', 0, 0, 'C'); // Page No. and Total Pages

        // Generar el archivo PDF y descargarlo
        $pdf->Output('ReporteUsuarios.pdf', 'D', true); // 'D' para descargar, 'F' para guardar en el servidor
    }

    public function obtenerEspecialidades(){
        return $this->usuarioModel->read('especialidades');
    }
}

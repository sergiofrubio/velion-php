<?php
require_once '../models/SpecialityModel.php';
require '../assets/fpdf186/fpdf.php';

class SpecialityController
{
    private $specialityModel;

    public function __construct()
    {
        $this->specialityModel = new SpecialityModel();
    }

    public function obtenerEspecialidadesPaginadas($iniciar, $articulos_x_pagina)
    {
        return $this->specialityModel->obtenerEspecialidadesPaginadas($iniciar, $articulos_x_pagina);
    }

    public function obtenerEspecialiades()
    {
        return $this->specialityModel->read('especialidades');
    }

    public function obtenerEspecialidadesPorDescripcion($filtro_especialidad)
    {
        $especialidadBuscada = $this->specialityModel->obtenerEspecialidadesPorDescripcion($filtro_especialidad);

        if ($especialidadBuscada) {
            return $especialidadBuscada;
        } else {
            $_SESSION['alert'] = array('type' => 'warning', 'message' => 'No se ha encontrado ninguna especialidad con los criterios seleccionados.');
            header('Location: ../pages/speciality.php');
            exit();
        }
    }

    public function añadirEspecialidad($datos)
    {
        if ($this->specialityModel->insert('especialidades', $datos)) {
            // Dentro de la función añadirNuevoUsuario en UserController.php
            $_SESSION['alert'] = array('type' => 'success', 'message' => 'Especialidad añadida correctamente.');
            header('Location: ../pages/speciality.php');
            exit();
        } else {
            // Dentro de la función añadirNuevoUsuario en UserController.php
            $_SESSION['alert'] = array('type' => 'warning', 'message' => 'No se ha podido añadir la especialidad.');
            header('Location: ../pages/speciality.php');
            exit();
        }
    }


    public function editarEspecialidad($datos, $condicion)
    {
        if ($this->specialityModel->update('especialidades', $datos, $condicion)) {
            $_SESSION['alert'] = array('type' => 'success', 'message' => 'Datos de la especialidad actualizados correctamente.');
            header('Location: ../pages/speciality.php');
            exit();
        } else {
            $_SESSION['alert'] = array('type' => 'warning', 'message' => 'No se ha podido actualizar los datos de la especialidad.');
            header('Location: ../pages/speciality.php');
            exit();
        }
    }


    public function eliminarEspecialidad($datos)
    {
        if ($this->specialityModel->delete('especialidades', $datos)) {
            $_SESSION['alert'] = array('type' => 'success', 'message' => 'Especialidad eliminada correctamente.');
            header('Location: ../pages/speciality.php');
            exit();
        } else {
            $_SESSION['alert'] = array('type' => 'success', 'message' => 'No se ha podido eliminar la especialidad correctamente.');
            header('Location: ../pages/speciality.php');
            exit();
        }
    }

    public function actualizarDatos($datos, $condicion)
    {
        if ($this->specialityModel->update('especialidades', $datos, $condicion) == true) {
            $_SESSION['alert'] = array('type' => 'success', 'message' => 'Datos actualizados correctamente.');
            header('Location: ../pages/settings.php');
            exit();
        } else {
            echo "No se ha podido completar el registro";
        }
    }

    public function exportarDatos()
    {
        $especialidades = $this->specialityModel->read('especialidades');
    
        // Instanciar un nuevo objeto FPDF
        $pdf = new FPDF(); // Orientación horizontal, unidad de medida en mm, tamaño de página A4
    
        // Agregar una nueva página al PDF
        $pdf->AddPage();

        // Definir el alias para el total de páginas
        // $pdf->AliasNbPages();
    
        // Definir el título del reporte
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252', 'Reporte de Especialidades médicas'), 1, 1, 'C');
    
        // Definir los encabezados de la tabla
        $pdf->SetFont('Arial', 'B', 8); // Cambiar el tamaño de la letra
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(27, 10, 'ID', 1, 0, 'C'); // Reducir la anchura de la celda
        $pdf->Cell(118, 10, iconv('UTF-8', 'windows-1252', 'Descripción'), 1, 0, 'C'); // Ajustar la anchura de la celda
        $pdf->Cell(45, 10, iconv('UTF-8', 'windows-1252', 'Última modificación'), 1, 0, 'C'); // Ajustar la anchura de la celda
        $pdf->Ln(); // Salto de línea para la siguiente fila
    
        // Recorrer los usuarios y mostrarlos en la tabla
        $pdf->SetFont('Arial', '', 8);
        foreach ($especialidades as $especialidad) {
            $pdf->Cell(27, 10, $especialidad['especialidad_id'], 1, 0, 'C');
            $pdf->Cell(118, 10, iconv('UTF-8', 'windows-1252', $especialidad['descripcion']), 1, 0, 'L');
            $pdf->Cell(45, 10, $especialidad['fecha'], 1, 0, 'C');
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

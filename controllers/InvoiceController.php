<?php

require_once '../models/InvoiceModel.php';
require_once '../assets/fpdf186/invoice.php';

class InvoiceController extends PDF_Invoice
{
    private $invoiceModel;

    public function __construct()
    {
        $this->invoiceModel = new InvoiceModel();
    }

    public function obtenerFacturas()
    {
        return $this->invoiceModel->read('facturas');
    }

    public function obtenerFacturasUsuario($DNI){
        return $this->invoiceModel->obtenerFacturasPorID($DNI);
    }

    public function buscarFacturas($usuario_id, $estado)
    {
        // Verificar si se está aplicando algún filtro
        if (!empty($usuario_id) && !empty($estado)) {
            // Si se están aplicando ambos filtros
            $facturasFiltradas = $this->invoiceModel->buscarFacturasPorIDyEstado($usuario_id, $estado);
        } elseif (!empty($usuario_id)) {
            // Si solo se está aplicando el filtro por ID
            $facturasFiltradas = $this->invoiceModel->obtenerFacturasPorID($usuario_id);
        } elseif (!empty($estado)) {
            // Si solo se está aplicando el filtro por estado
            $facturasFiltradas = $this->invoiceModel->obtenerFacturasPorEstado($estado);
        } else {
            // Si no se aplica ningún filtro, redirigir con un mensaje de alerta
            $_SESSION['alert'] = array('type' => 'warning', 'message' => 'No se ha aplicado ningún filtro.');
            header('Location: ../pages/invoices.php');
            exit();
        }

        // Verificar si se encontraron usuarios
        if (!empty($facturasFiltradas)) {
            return $facturasFiltradas;
        } else {
            // Si no se encontraron usuarios, mostrar mensaje de alerta
            $_SESSION['alert'] = array('type' => 'warning', 'message' => 'No se ha encontrado ningún Factura con los criterios seleccionados.');
            header('Location: ../pages/invoices.php');
            exit();
        }
    }

    public function buscarFacturasPatients($usuario_id, $estado)
    {
        // Verificar si se está aplicando algún filtro
        if (!empty($usuario_id) && !empty($estado)) {
            // Si se están aplicando ambos filtros
            $facturasFiltradas = $this->invoiceModel->buscarFacturasPorIDyEstado($usuario_id, $estado);
        } elseif (!empty($usuario_id)) {
            // Si solo se está aplicando el filtro por ID
            $facturasFiltradas = $this->invoiceModel->obtenerFacturasPorID($usuario_id);
        } elseif (!empty($estado)) {
            // Si solo se está aplicando el filtro por estado
            $facturasFiltradas = $this->invoiceModel->obtenerFacturasPorEstado($estado);
        } else {
            // Si no se aplica ningún filtro, redirigir con un mensaje de alerta
            $_SESSION['alert'] = array('type' => 'warning', 'message' => 'No se ha aplicado ningún filtro.');
            header('Location: ../pages/invoices-patients.php');
            exit();
        }

        // Verificar si se encontraron usuarios
        if (!empty($facturasFiltradas)) {
            return $facturasFiltradas;
        } else {
            // Si no se encontraron usuarios, mostrar mensaje de alerta
            $_SESSION['alert'] = array('type' => 'warning', 'message' => 'No se ha encontrado ningún Factura con los criterios seleccionados.');
            header('Location: ../pages/invoices-patients.php');
            exit();
        }
    }

    public function obtenerFacturasPaginadas($iniciar, $articulos_x_pagina)
    {
        return $this->invoiceModel->obtenerDatosFacturasPaginadas($iniciar, $articulos_x_pagina);
    }

    public function obtenerFacturasUsuarioPaginadas($DNI, $iniciar, $articulos_x_pagina)
    {
        return $this->invoiceModel->obtenerFacturasUsuarioPaginadas($DNI, $iniciar, $articulos_x_pagina);
    }

    // Función para generar la factura PDF
    function generarFacturaPDF($factura_id)
    {
        $factura = $this->invoiceModel->obtenerDatosFactura($factura_id);
        //echo(json_encode($factura));

        // Verificar si se encontró la factura
        if ($factura) {
            $pdf = new PDF_Invoice('P', 'mm', 'A4');
            $pdf->AddPage();
            $pdf->addSociete(
                iconv('UTF-8', 'windows-1252', 'Clínica Fisioterapia'),
                "CIF: X-12345678\n" .
                    "Av. Prueba, 17\n" .
                    iconv('UTF-8', 'windows-1252', "Córdoba, Córdoba, 14001\n") .
                    iconv('UTF-8', 'windows-1252', "Tel.: 957 000 000 • 600 000 000")
            );
            $pdf->fact_dev("Factura:", $factura_id);
            // $pdf->temporaire("Devis temporaire");
            $pdf->addDate($factura[0]['fecha_emision']);
            $pdf->addClient($factura[0]['paciente_id']);
            $pdf->addPageNumber("1");
            $pdf->addClientAdresse($factura);
            $pdf->addReglement("Tarjeta");
            $pdf->addEstado("Pagada");
            $pdf->addNumTVA("FR888777666");
            // $pdf->addReference("Devis ... du ....");
            $cols = array(
                "REF"    => 23,
                iconv('UTF-8', 'windows-1252', "DESCRIPCIÓN")  => 78,
                "CANTIDAD"     => 22,
                "PRECIO UNITARIO" => 37,
                "PRECIO TOTAL" => 30,
            );
            $pdf->addCols($cols);
            $cols = array(
                "REF"    => "L",
                iconv('UTF-8', 'windows-1252', "DESCRIPCIÓN")  => "L",
                "CANTIDAD"     => "C",
                "PRECIO UNITARIO" => "R",
                "PRECIO TOTAL" => "R",
            );
            $pdf->addLineFormat($cols);
            $pdf->addLineFormat($cols);

            $y    = 109;
            $line = array(
                "REF"    => "REF1",
                iconv('UTF-8', 'windows-1252', "DESCRIPCIÓN")  => iconv('UTF-8', 'windows-1252', $factura[0]['producto_nombre']),
                "CANTIDAD"     => "1",
                "PRECIO UNITARIO"      => $factura[0]['monto'] . EURO,
                "PRECIO TOTAL" => $factura[0]['monto'] . EURO,
            );
            $size = $pdf->addLine($y, $line);
            $pdf->Output("", "", true);
        }
    }


    public function guardarFactura($datos)
    {
        if ($this->invoiceModel->insert("facturas", $datos)) {
            $_SESSION['alert'] = array('type' => 'success', 'message' => 'Factura añadida correctamente.');
            header('Location: ../pages/invoices.php');
            exit();
        } else {
            $_SESSION['alert'] = array('type' => 'warning', 'message' => 'No se ha podido añadir la factura correctamente.');
            header('Location: ../pages/invoices.php');
            exit();
        }

    }

    public function confirmarFactura($datos, $condicion)
    {
        if ($this->invoiceModel->update("facturas", $datos, $condicion)) {
            $_SESSION['alert'] = array('type' => 'success', 'message' => 'Pago de la factura confirmado correctamente.');
            header('Location: ../pages/invoices.php');
            exit();
        } else {
            $_SESSION['alert'] = array('type' => 'warning', 'message' => 'No se ha podido conmfirma el pago de la factura correctamente.');
            header('Location: ../pages/invoices.php');
            exit();
        }

    }

    public function eliminarFactura($condicion)
    {
        if ($this->invoiceModel->delete("facturas", $condicion)) {
            $_SESSION['alert'] = array('type' => 'success', 'message' => 'Factura eliminada correctamente.');
            header('Location: ../pages/invoices.php');
            exit();
        } else {
            $_SESSION['alert'] = array('type' => 'warning', 'message' => 'No se ha podido la factura correctamente.');
            header('Location: ../pages/invoices.php');
            exit();
        }

    }

}

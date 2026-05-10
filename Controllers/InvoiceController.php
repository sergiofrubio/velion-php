<?php
namespace App\Controllers;
use App\Core\Controller;

class InvoiceController extends Controller
{

    // // Función para generar la factura PDF
    // function generarFacturaPDF($factura_id)
    // {
    //     $factura = $this->invoiceModel->obtenerDatosFactura($factura_id);
    //     //echo(json_encode($factura));

    //     // Verificar si se encontró la factura
    //     if ($factura) {
    //         $pdf = new PDF_Invoice('P', 'mm', 'A4');
    //         $pdf->AddPage();
    //         $pdf->addSociete(
    //             iconv('UTF-8', 'windows-1252', 'Clínica Fisioterapia'),
    //             "CIF: X-12345678\n" .
    //                 "Av. Prueba, 17\n" .
    //                 iconv('UTF-8', 'windows-1252', "Córdoba, Córdoba, 14001\n") .
    //                 iconv('UTF-8', 'windows-1252', "Tel.: 957 000 000 • 600 000 000")
    //         );
    //         $pdf->fact_dev("Factura:", $factura_id);
    //         // $pdf->temporaire("Devis temporaire");
    //         $pdf->addDate($factura[0]['fecha_emision']);
    //         $pdf->addClient($factura[0]['paciente_id']);
    //         $pdf->addPageNumber("1");
    //         $pdf->addClientAdresse($factura);
    //         $pdf->addReglement("Tarjeta");
    //         $pdf->addEstado("Pagada");
    //         $pdf->addNumTVA("FR888777666");
    //         // $pdf->addReference("Devis ... du ....");
    //         $cols = array(
    //             "REF"    => 23,
    //             iconv('UTF-8', 'windows-1252', "DESCRIPCIÓN")  => 78,
    //             "CANTIDAD"     => 22,
    //             "PRECIO UNITARIO" => 37,
    //             "PRECIO TOTAL" => 30,
    //         );
    //         $pdf->addCols($cols);
    //         $cols = array(
    //             "REF"    => "L",
    //             iconv('UTF-8', 'windows-1252', "DESCRIPCIÓN")  => "L",
    //             "CANTIDAD"     => "C",
    //             "PRECIO UNITARIO" => "R",
    //             "PRECIO TOTAL" => "R",
    //         );
    //         $pdf->addLineFormat($cols);
    //         $pdf->addLineFormat($cols);

    //         $y    = 109;
    //         $line = array(
    //             "REF"    => "REF1",
    //             iconv('UTF-8', 'windows-1252', "DESCRIPCIÓN")  => iconv('UTF-8', 'windows-1252', $factura[0]['producto_nombre']),
    //             "CANTIDAD"     => "1",
    //             "PRECIO UNITARIO"      => $factura[0]['monto'] . EURO,
    //             "PRECIO TOTAL" => $factura[0]['monto'] . EURO,
    //         );
    //         $size = $pdf->addLine($y, $line);
    //         $pdf->Output("", "", true);
    //     }
    // }

}

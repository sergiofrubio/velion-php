<?php
require_once '../models/MedicalHistoryModel.php';
require_once '../assets/fpdf186/fpdf.php';

class MedicalHistoryController extends FPDF
{
    private $medicalhistoryModel;

    public function __construct()
    {
        $this->medicalhistoryModel = new MedicalHistoryModel();
    }

    public function generarInformeMedico($cita_id)
    {
        $informe = $this->medicalhistoryModel->imprimirInforme($cita_id);
        // Crear una instancia de FPDF
        $pdf = new FPDF();
        $pdf->AddPage();

        // Configurar fuente y tamaño
        $pdf->SetFont('Arial', 'B', 16);

        // Título del informe
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252', 'Informe Médico'), 0, 1, 'C');

        // Datos del paciente, facultativo, diagnóstico, tratamiento y observaciones
        $paciente_nombre = $informe[0]['paciente_nombre'] . ' ' . $informe[0]['paciente_apellidos'];
        $paciente_fecha_nacimiento = $informe[0]['paciente_fecha_nacimiento'];
        $paciente_genero = $informe[0]['paciente_genero'];
        $fisioterapeuta_nombre = $informe[0]['fisioterapeuta_nombre'] . ' ' . $informe[0]['fisioterapeuta_apellidos'];
        $especialidad = $informe[0]['especialidad'];
        $diagnostico = $informe[0]['diagnostico'];
        $tratamiento = $informe[0]['tratamiento'];
        $notas = $informe[0]['notas'];

        // Generar los recuadros con la información
        $pdf->SetFillColor(230, 230, 230);

        // Recuadro para los datos del paciente
        $pdf->Rect(10, 25, 90, 30, 'DF');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 18, iconv('UTF-8', 'windows-1252', 'Datos del Paciente'), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(10, 25);
        $pdf->Cell(0, 18, iconv('UTF-8', 'windows-1252', 'Nombre: ') . iconv('UTF-8', 'windows-1252', $paciente_nombre), 0, 1, 'L');
        $pdf->SetXY(10, 30);
        $pdf->Cell(0, 18, iconv('UTF-8', 'windows-1252', 'Fecha de Nacimiento: ') . iconv('UTF-8', 'windows-1252', $paciente_fecha_nacimiento), 0, 1, 'L');
        $pdf->SetXY(10, 35);
        $pdf->Cell(0, 18, iconv('UTF-8', 'windows-1252', 'Género: ') . iconv('UTF-8', 'windows-1252', $paciente_genero), 0, 1, 'L');

        // Recuadro para los datos del facultativo
        $pdf->Rect(110, 25, 90, 30, 'DF');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(110, 20);
        $pdf->Cell(0, 18, iconv('UTF-8', 'windows-1252', 'Datos del Facultativo'), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(110, 25);
        $pdf->Cell(0, 18, iconv('UTF-8', 'windows-1252', 'Nombre: ') . iconv('UTF-8', 'windows-1252', $fisioterapeuta_nombre), 0, 1, 'L');
        $pdf->SetXY(110, 30);
        $pdf->Cell(0, 18, iconv('UTF-8', 'windows-1252', 'Especialidad: ') . iconv('UTF-8', 'windows-1252', $especialidad), 0, 1, 'L');

        // Recuadro para el diagnóstico
        $pdf->Rect(10, 70, 190, 30, 'DF');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(9, 60);
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252', 'Diagnóstico Médico'), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(15, 75);
        $pdf->MultiCell(0, 10, iconv('UTF-8', 'windows-1252', $diagnostico));

        // Recuadro para el tratamiento
        $pdf->Rect(10, 120, 190, 30, 'DF');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(9, 110);
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252', 'Tratamiento'), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(15, 125);
        $pdf->MultiCell(0, 10, iconv('UTF-8', 'windows-1252', $tratamiento));

        // Recuadro para las observaciones
        $pdf->Rect(10, 170, 190, 30, 'DF');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(9, 160);
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252', 'Observaciones'), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(15, 175);
        $pdf->MultiCell(0, 10, iconv('UTF-8', 'windows-1252', $notas));

        // Salida del PDF
        $pdf->Output('', '', true);
    }

    public function actualizarInformeMedico($datos, $condicion)
    {
        if ($this->medicalhistoryModel->update('medico', $datos, $condicion)) {
            $_SESSION['alert'] = array('type' => 'success', 'message' => 'Informe médico actualizado correctamente.');
            header("Location: ../pages/medical-history.php");
            exit();
        } else {
            $_SESSION['alert'] = array('type' => 'warning', 'message' => 'No se ha podido actualizar el informe médico.');
            header("Location: ../pages/medical-history.php");
            exit();
        }
    }

    public function obtenerInformeUsuario($DNI, $isApiRequest = false)
    {
        $informe = $this->medicalhistoryModel->obtenerInforme($DNI);
        
        if ($isApiRequest) {
            return $informe;
        }
    
        if (!$informe) {
            $_SESSION['alert'] = array('type' => 'warning', 'message' => 'No se ha encontrado ningún informe médico para el usuario seleccionado.');
            header("Location: ../pages/medical-history.php");
            exit();
        }
        return $informe;
    }

    public function obtenerCitasUsuario($usuario_id)
    {
        $condicion = "paciente_id = '$usuario_id' OR fisioterapeuta_id = '$usuario_id'";
        $tabla = "citas";

        // Realiza la consulta utilizando la función read() del BaseModel
        $citas = $this->medicalhistoryModel->read($tabla, $condicion);

        return $citas;
    }

    public function obtenerInforme($DNI)
    {
        return $this->medicalhistoryModel->obtenerInforme($DNI);
    }

    public function obtenerListaPacientes()
    {
        return $this->medicalhistoryModel->read('usuarios', 'rol = \'paciente\'');
    }

}

<?php
include '../controllers/MedicalHistoryController.php';

$medicalController = new MedicalHistoryController();

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $medicalController->generarInformeMedico($_GET['id']);
    exit();
}
?>
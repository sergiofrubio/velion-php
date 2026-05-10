<?php
namespace App\Controllers;

use App\Core\Controller;

class ConfiguracionController extends Controller
{
    public function index()
    {
        $configuracionModel = $this->model('Configuracion');
        
        $data = [
            'horarios' => $configuracionModel->getHorariosFisios(),
            'ausencias' => $configuracionModel->getAusenciasFisios(),
            'especialidades' => $configuracionModel->getEspecialidades(),
            'bonos' => $configuracionModel->getBonos(),
            'clinica' => $configuracionModel->getClinica()
        ];
        
        $this->view('configuracion/index', $data);
    }

    public function createHorario()
    {
        $configuracionModel = $this->model('Configuracion');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'fisioterapeuta_id' => $_POST['fisioterapeuta_id'],
                'dia_semana' => $_POST['dia_semana'],
                'hora_inicio' => $_POST['hora_inicio'],
                'hora_fin' => $_POST['hora_fin']
            ];
            if ($configuracionModel->saveHorario($data)) {
                header('Location: ' . PROJECT_ROOT . '/configuracion');
                exit();
            }
        } else {
            $data = ['fisios' => $configuracionModel->getFisios()];
            $this->view('configuracion/horarios_form', $data);
        }
    }

    public function createAusencia()
    {
        $configuracionModel = $this->model('Configuracion');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'fisioterapeuta_id' => $_POST['fisioterapeuta_id'],
                'fecha_inicio' => $_POST['fecha_inicio'],
                'fecha_fin' => $_POST['fecha_fin'],
                'motivo' => htmlspecialchars($_POST['motivo'] ?? '', ENT_QUOTES, 'UTF-8')
            ];
            if ($configuracionModel->saveAusencia($data)) {
                header('Location: ' . PROJECT_ROOT . '/configuracion');
                exit();
            }
        } else {
            $data = ['fisios' => $configuracionModel->getFisios()];
            $this->view('configuracion/ausencias_form', $data);
        }
    }

    public function createEspecialidad()
    {
        $configuracionModel = $this->model('Configuracion');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $descripcion = htmlspecialchars($_POST['descripcion'] ?? '', ENT_QUOTES, 'UTF-8');
            if ($configuracionModel->saveEspecialidad($descripcion)) {
                header('Location: ' . PROJECT_ROOT . '/configuracion');
                exit();
            }
        } else {
            $this->view('configuracion/especialidades_form');
        }
    }

    public function createBono()
    {
        $configuracionModel = $this->model('Configuracion');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre' => htmlspecialchars($_POST['nombre'] ?? '', ENT_QUOTES, 'UTF-8'),
                'numero_sesiones' => (int)$_POST['numero_sesiones'],
                'precio' => (float)$_POST['precio'],
                'estado' => $_POST['estado'] ?? 'Activo'
            ];
            if ($configuracionModel->saveBono($data)) {
                header('Location: ' . PROJECT_ROOT . '/configuracion');
                exit();
            }
        } else {
            $this->view('configuracion/bonos_form');
        }
    }

    public function updateClinica()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $configuracionModel = $this->model('Configuracion');
            $data = [
                'id_clinica' => $_POST['id_clinica'] ?? null,
                'nombre_comercial' => htmlspecialchars($_POST['nombre_comercial'] ?? '', ENT_QUOTES, 'UTF-8'),
                'razon_social' => htmlspecialchars($_POST['razon_social'] ?? '', ENT_QUOTES, 'UTF-8'),
                'direccion_calle' => htmlspecialchars($_POST['direccion_calle'] ?? '', ENT_QUOTES, 'UTF-8'),
                'ciudad' => htmlspecialchars($_POST['ciudad'] ?? '', ENT_QUOTES, 'UTF-8'),
                'provincia_estado' => htmlspecialchars($_POST['provincia_estado'] ?? '', ENT_QUOTES, 'UTF-8'),
                'codigo_postal' => htmlspecialchars($_POST['codigo_postal'] ?? '', ENT_QUOTES, 'UTF-8'),
                'pais' => htmlspecialchars($_POST['pais'] ?? 'España', ENT_QUOTES, 'UTF-8'),
                'telefono_contacto' => htmlspecialchars($_POST['telefono_contacto'] ?? '', ENT_QUOTES, 'UTF-8'),
                'email_contacto' => htmlspecialchars($_POST['email_contacto'] ?? '', ENT_QUOTES, 'UTF-8'),
                'sitio_web' => htmlspecialchars($_POST['sitio_web'] ?? '', ENT_QUOTES, 'UTF-8')
            ];
            
            if ($configuracionModel->saveClinica($data)) {
                $_SESSION['success_message'] = "Datos de la clínica guardados correctamente.";
            } else {
                $_SESSION['error_message'] = "Error al guardar los datos de la clínica.";
            }
            header('Location: ' . PROJECT_ROOT . '/configuracion');
            exit();
        }
    }

    public function editHorario()
    {
        $configuracionModel = $this->model('Configuracion');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['horario_id'];
            $data = [
                'fisioterapeuta_id' => $_POST['fisioterapeuta_id'],
                'dia_semana' => $_POST['dia_semana'],
                'hora_inicio' => $_POST['hora_inicio'],
                'hora_fin' => $_POST['hora_fin']
            ];
            if ($configuracionModel->updateHorario($id, $data)) {
                header('Location: ' . PROJECT_ROOT . '/configuracion');
                exit();
            }
        } else {
            $id = $_GET['id'];
            $data = [
                'horario' => $configuracionModel->getHorarioById($id),
                'fisios' => $configuracionModel->getFisios()
            ];
            $this->view('configuracion/horarios_form', $data);
        }
    }

    public function editAusencia()
    {
        $configuracionModel = $this->model('Configuracion');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['ausencia_id'];
            $data = [
                'fisioterapeuta_id' => $_POST['fisioterapeuta_id'],
                'fecha_inicio' => $_POST['fecha_inicio'],
                'fecha_fin' => $_POST['fecha_fin'],
                'motivo' => htmlspecialchars($_POST['motivo'] ?? '', ENT_QUOTES, 'UTF-8')
            ];
            if ($configuracionModel->updateAusencia($id, $data)) {
                header('Location: ' . PROJECT_ROOT . '/configuracion');
                exit();
            }
        } else {
            $id = $_GET['id'];
            $data = [
                'ausencia' => $configuracionModel->getAusenciaById($id),
                'fisios' => $configuracionModel->getFisios()
            ];
            $this->view('configuracion/ausencias_form', $data);
        }
    }

    public function editEspecialidad()
    {
        $configuracionModel = $this->model('Configuracion');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['especialidad_id'];
            $descripcion = htmlspecialchars($_POST['descripcion'] ?? '', ENT_QUOTES, 'UTF-8');
            if ($configuracionModel->updateEspecialidad($id, $descripcion)) {
                header('Location: ' . PROJECT_ROOT . '/configuracion');
                exit();
            }
        } else {
            $id = $_GET['id'];
            $data = ['especialidad' => $configuracionModel->getEspecialidadById($id)];
            $this->view('configuracion/especialidades_form', $data);
        }
    }

    public function editBono()
    {
        $configuracionModel = $this->model('Configuracion');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['bono_id'];
            $data = [
                'nombre' => htmlspecialchars($_POST['nombre'] ?? '', ENT_QUOTES, 'UTF-8'),
                'numero_sesiones' => (int)$_POST['numero_sesiones'],
                'precio' => (float)$_POST['precio'],
                'estado' => $_POST['estado'] ?? 'Activo'
            ];
            if ($configuracionModel->updateBono($id, $data)) {
                header('Location: ' . PROJECT_ROOT . '/configuracion');
                exit();
            }
        } else {
            $id = $_GET['id'];
            $data = ['bono' => $configuracionModel->getBonoById($id)];
            $this->view('configuracion/bonos_form', $data);
        }
    }
}

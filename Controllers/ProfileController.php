<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\MetodoPago;

class ProfileController extends Controller
{
    public function index()
    {
        $this->checkAuth();
        
        $userModel = $this->model('User');
        $metodoPagoModel = new MetodoPago();
        
        $usuario = $userModel->getByusuario_id($_SESSION['usuario_id']);
        
        if (!$usuario) {
            header('Location: ' . PROJECT_ROOT . '/logout');
            exit();
        }

        $metodosPago = $metodoPagoModel->getByUsuario($_SESSION['usuario_id']);

        $data = [
            'usuario' => $usuario,
            'metodosPago' => $metodosPago,
            'pageTitle' => 'Mi Perfil - Velion'
        ];

        $this->view('vista-pacientes/perfil/index', $data);
    }

    public function edit()
    {
        $this->checkAuth();
        
        $userModel = $this->model('User');
        $usuario_id = $_SESSION['usuario_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre' => htmlspecialchars($_POST['nombre'] ?? '', ENT_QUOTES, 'UTF-8'),
                'apellidos' => htmlspecialchars($_POST['apellidos'] ?? '', ENT_QUOTES, 'UTF-8'),
                'telefono' => htmlspecialchars($_POST['telefono'] ?? '', ENT_QUOTES, 'UTF-8'),
                'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? '',
                'direccion' => htmlspecialchars($_POST['direccion'] ?? '', ENT_QUOTES, 'UTF-8'),
                'provincia' => htmlspecialchars($_POST['provincia'] ?? '', ENT_QUOTES, 'UTF-8'),
                'municipio' => htmlspecialchars($_POST['municipio'] ?? '', ENT_QUOTES, 'UTF-8'),
                'cp' => htmlspecialchars($_POST['cp'] ?? '', ENT_QUOTES, 'UTF-8'),
                'email' => htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'),
                'rol' => 'Paciente', // Keep the same role
                'genero' => $_POST['genero'] ?? 'Otro'
            ];

            if (!empty($_POST['pass'])) {
                $data['pass'] = password_hash($_POST['pass'], PASSWORD_DEFAULT);
            }

            if ($userModel->update($usuario_id, $data)) {
                // Update session info if needed
                $_SESSION['nombre'] = $data['nombre'];
                header('Location: ' . PROJECT_ROOT . '/vista-pacientes/perfil?success=1');
                exit();
            } else {
                $data['error'] = "Error al actualizar el perfil.";
                $data['usuario'] = $userModel->getByusuario_id($usuario_id);
                $metodoPagoModel = new MetodoPago();
                $data['metodosPago'] = $metodoPagoModel->getByUsuario($usuario_id);
                $this->view('vista-pacientes/perfil/index', $data);
            }
        } else {
            header('Location: ' . PROJECT_ROOT . '/vista-pacientes/perfil');
        }
    }

    public function addPaymentMethod()
    {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $metodoPagoModel = new MetodoPago();
            
            $numeroTarjeta = $_POST['card_number'] ?? '';
            $last4 = substr($numeroTarjeta, -4);
            $tipo = $_POST['tipo'] ?? 'Tarjeta';
            $proveedor = $_POST['proveedor'] ?? 'Visa';
            $fechaExp = $_POST['expiry'] ?? '';
            
            $data = [
                'usuario_id' => $_SESSION['usuario_id'],
                'tipo' => $tipo,
                'proveedor' => $proveedor,
                'last4' => $last4,
                'fecha_expiracion' => $fechaExp,
                'token_externo' => bin2hex(random_bytes(16)), // Simulating a token
                'es_predeterminado' => isset($_POST['es_predeterminado']) ? 1 : 0
            ];

            if ($metodoPagoModel->save($data)) {
                header('Location: ' . PROJECT_ROOT . '/vista-pacientes/perfil?success=pm_added');
            } else {
                header('Location: ' . PROJECT_ROOT . '/vista-pacientes/perfil?error=pm_failed');
            }
            exit();
        }
    }

    public function deletePaymentMethod()
    {
        $this->checkAuth();
        $metodo_id = $_GET['id'] ?? 0;
        
        $metodoPagoModel = new MetodoPago();
        if ($metodoPagoModel->delete($metodo_id, $_SESSION['usuario_id'])) {
            header('Location: ' . PROJECT_ROOT . '/vista-pacientes/perfil?success=pm_deleted');
        } else {
            header('Location: ' . PROJECT_ROOT . '/vista-pacientes/perfil?error=pm_delete_failed');
        }
        exit();
    }

    public function setPrimaryPaymentMethod()
    {
        $this->checkAuth();
        $metodo_id = $_GET['id'] ?? 0;
        
        $metodoPagoModel = new MetodoPago();
        if ($metodoPagoModel->setPredeterminado($metodo_id, $_SESSION['usuario_id'])) {
            header('Location: ' . PROJECT_ROOT . '/vista-pacientes/perfil?success=pm_primary');
        } else {
            header('Location: ' . PROJECT_ROOT . '/vista-pacientes/perfil?error=pm_primary_failed');
        }
        exit();
    }
}

<?php
require '../controllers/ProductController.php';
require '../controllers/MedicalHistoryController.php';
require '../controllers/AppointmentController.php';
require '../controllers/UserController.php';
require '../controllers/LoginController.php';

header("Content-Type: application/json");

$requestMethod = $_SERVER["REQUEST_METHOD"];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

// Asegúrate de que la URL contenga al menos /api/productos
if ($uri[1] !== 'api' || ! isset($uri[2])) {
    header("HTTP/1.1 404 Not Found");
    echo json_encode([
        "message" => "Recurso no encontrado"
    ]);
    exit();
}

$productController = new ProductController();
$appointmentController = new AppointmentController();
$medicalhistoryController = new MedicalHistoryController();
$userController = new UserController();
$loginController = new LoginController();

switch ($uri[2]) {
    case 'productos':
        if ($requestMethod == 'GET') {
            echo (json_encode($productController->obtenerProductos()));
        }
        break;
    case 'informes':
        if ($requestMethod == 'GET') {
            if (isset($uri[3])) {
                $DNI = $uri[3];
                echo (json_encode($medicalhistoryController->obtenerInformeUsuario($DNI, true)));
            }
        }
        break;
    case 'generar-informe':
        if ($requestMethod == 'GET') {
            if (isset($uri[3])) {
                $DNI = $uri[3];
                echo (json_encode($medicalhistoryController->generarInformeMedico(1)));
            }
        }
        break;
    case 'citas':
        if ($requestMethod == 'GET') {
            if (isset($uri[3])) {
                $DNI = $uri[3];
                echo (json_encode($appointmentController->obtenerCitasUsuario($DNI)));
            }
        }
        break;
    case 'facturas':
        if ($requestMethod == 'GET') {
            if (isset($uri[3])) {
                $DNI = $uri[3];
                echo (json_encode($productController->obtenerFacturasUsuario($DNI)));
            }
        }
        break;
    case 'registro':
        if ($requestMethod == 'POST') {
            // Obtener el contenido del cuerpo de la solicitud POST
            $json = file_get_contents('php://input');

            // Decodificar el JSON
            $data = json_decode($json, true);
            $datos = array(
                'usuario_id' => $_POST["usuario_id"],
                'nombre' => $_POST["nombre"],
                'apellidos' => $_POST["apellidos"],
                //'genero' => $_POST["genero"],
                'telefono' => $_POST["telefono"],
                'fecha_nacimiento' => $_POST["fecha_nacimiento"],
                'direccion' => $_POST["direccion"],
                'provincia' => $_POST["provincia"],
                'municipio' => $_POST["municipio"],
                'cp' => $_POST["cp"],
                'email' => $_POST["email"],
                'pass' => password_hash($_POST["pass"], PASSWORD_DEFAULT),
                'rol' => 'Paciente'
            );
            if ($datos) {
                echo (json_encode($loginController->registrarNuevoUsuario($datos, true)));
            } else {
                echo json_encode([
                    "message" => "Datos incompletos"
                ]);
            }
        }
        break;
    case 'recoverpass':
        if ($requestMethod == 'GET') {
            if (isset($uri[3])) {
                $email = $uri[3];
                echo (json_encode($loginController->generatePasswordResetToken($email, true)));
            }
        }
        break;
    case 'actualizar-datos':
        if ($requestMethod == 'POST') {
            // Obtener el contenido del cuerpo de la solicitud POST
            $json = file_get_contents('php://input');

            // Decodificar el JSON
            $data = json_decode($json, true);
            $datos = array(
                'email' => $_POST["email"],
                'pass' => password_hash($_POST["pass"], PASSWORD_DEFAULT),
            );
            $condicion = "usuario_id = '" . $_POST["usuario_id"] . "'";
            if ($datos) {
                echo (json_encode($userController->actualizarDatos($datos, $condicion, true)));
            } else {
                echo json_encode([
                    "message" => "Datos incompletos"
                ]);
            }
        }
        break;
    case 'usuarios':
        if ($requestMethod == 'GET') {
            if (isset($uri[3])) {
                $DNI = $uri[3];
                echo (json_encode($userController->buscarUsuarios($DNI, "", true)));
            }
        } else if ($requestMethod == 'POST') {
            // Obtener el contenido del cuerpo de la solicitud POST
            $json = file_get_contents('php://input');

            // Decodificar el JSON
            $data = json_decode($json, true);
            $email = isset($_POST['email']) ? urldecode($_POST['email']) : '';
            $pass = isset($_POST['pass']) ? urldecode($_POST['pass']) : '';
            if ($email && $pass) {
                echo (json_encode($loginController->iniciarSesion($email, $pass, true)));
            } else {
                echo json_encode([
                    "message" => "Datos incompletos"
                ]);
            }
        }
        break;
    // Añadir más rutas según sea necesario
    default:
        header("HTTP/1.1 404 Not Found");
        echo json_encode([
            "message" => "Recurso no encontrado"
        ]);
        break;
}

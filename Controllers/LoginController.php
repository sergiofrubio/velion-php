<?php
namespace App\Controllers;
use App\Core\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class LoginController extends Controller {

    private $loginModel;

    public function __construct() {
        $this->loginModel = $this->model('Login');
    }

    public function cargarVista(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['email'])) {
            header('Location: ' . PROJECT_ROOT . '/inicio');
            exit();
        }
        $this->view('login/login');
    }

    public function iniciarSesion() {
        $email = $_POST['email'] ?? null;
        $pass = $_POST['pass'] ?? null;

        if ($email && $pass) {
            $usuario = $this->loginModel->getByEmail($email);

            if ($usuario) {
                if (password_verify($pass, $usuario['pass'])) {
                    $this->startSession($usuario);
                } else {
                    $this->redirectWithMessage("Contraseña incorrecta.", 'warning');
                }
            } else {
                $this->redirectWithMessage("Usuario no encontrado.", 'warning');
            }
        } else {
            $this->redirectWithMessage("Faltan credenciales.", 'warning');
        }
    }

    public function registrarNuevoUsuario($datos, $isApiResquest = false)
    {
        if ($isApiResquest){
            if ($this->loginModel->insert('usuarios', $datos)){
                return ["message" => "Usuario registrado"];
            }else{
                return ["message" => "Error al completar el registro"];
            }
        } else {
            if ($this->loginModel->insert('usuarios', $datos)) {
                // Dentro de la función añadirNuevoUsuario en UserController.php
                $this->redirectWithMessage("Registrado correctamente.", 'success');
            } else {
                // Dentro de la función añadirNuevoUsuario en UserController.php
                $this->redirectWithMessage("Ha ocurrido un error al registrarse.", 'warning');
            }
        }

    }

    private function startSession($usuario) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = array_merge($_SESSION, $usuario);
        
        header('Location: ' . PROJECT_ROOT . '/inicio');
        exit();
    }

    public function finishSesion()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
        header("Location: " . PROJECT_ROOT . "/login?alert=success&message=Sesion finalizada");
        exit();
    }

    private function redirectWithMessage($message, $alertType) {
        header("Location: " . PROJECT_ROOT . "/login?alert=$alertType&message=$message");
        exit();
    }

    public function generatePasswordResetToken() {
        $email = $_POST['resetEmail'] ?? null;
        if (!$email) {
            $this->redirectWithMessage('Correo no proporcionado', 'warning');
        }

        $token = bin2hex(random_bytes(32));
        
        $db = (new \App\Core\DataBase())->connect();
        $stmt = $db->prepare("DELETE FROM password_resets WHERE email = ?");
        $stmt->execute([$email]);

        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO password_resets (email, token) VALUES (?, ?)");
        $stmt->execute([$email, $hashedToken]);

        $resetLink = 'localhost' . PROJECT_ROOT . '/login/reset?token=' . $token;
        if($this->sendPasswordResetEmail($email, $resetLink)){
            $this->redirectWithMessage('Se ha enviado un correo con un enlace para restablecer la contraseña', 'success');
        } else {
            $this->redirectWithMessage('Error al enviar el correo.', 'warning');
        }
    }

    public function resetPassword() {
        $token = $_POST['token'] ?? null;
        $password = $_POST['password'] ?? null;
        
        if (!$token || !$password) {
            $this->redirectWithMessage('Faltan datos.', 'warning');
        }

        $db = (new \App\Core\DataBase())->connect();
        $stmt = $db->query("SELECT email, token FROM password_resets WHERE created_at >= (NOW() - INTERVAL 1 HOUR)");
        
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            foreach ($result as $row) {
                if (password_verify($token, $row['token'])) {
                    $email = $row['email'];
                    $newPasswordHash = password_hash($password, PASSWORD_DEFAULT);
                    $updateStmt = $db->prepare("UPDATE usuarios SET pass = ? WHERE email = ?");
                    if ($updateStmt->execute([$newPasswordHash, $email])) {
                        $deleteStmt = $db->prepare("DELETE FROM password_resets WHERE email = ?");
                        $deleteStmt->execute([$email]);
                        $this->redirectWithMessage('Contraseña actualizada correctamente.', 'success');
                    } else {
                        $this->redirectWithMessage('Error al actualizar la contraseña.', 'warning');
                    }
                    return;
                }
            }
        }
        
        $this->redirectWithMessage('Token inválido o expirado.', 'warning');
    }



    private function sendPasswordResetEmail($email, $resetLink) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'sergiofrubio@gmail.com';
            $mail->Password = 'wcgs pxws wttd aeco';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->setFrom('sergiofrubio@gmail.com', 'SIGEFI');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = iconv('UTF-8', 'windows-1252', "Recuperación de contraseña");
            $mail->Body = 'Haz clic en el siguiente enlace para recuperar tu contraseña: <a href="' . $resetLink . '">Recuperar Contraseña</a>';
            $mail->send();
        } catch (Exception $e) {
            echo "No se pudo enviar el mensaje. Error de Mailer: {$mail->ErrorInfo}";
        }
    }
}

?>

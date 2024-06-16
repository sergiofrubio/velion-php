<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once '../models/LoginModel.php';
require '../vendor/autoload.php';

class LoginController {
    private $loginModel;

    public function __construct() {
        $this->loginModel = new LoginModel();
    }

    public function iniciarSesion($email, $pass, $isApiResquest = false) {
        $usuarios = $this->loginModel->read('usuarios', "email = '$email'");

        if ($isApiResquest){
            if (!empty($usuarios)) {
                $usuario = $usuarios[0];
                if (password_verify($pass, $usuario['pass']) && $usuario['rol'] == 'Paciente') {
                   return $usuario;
                } else{
                    return ["message" => "No tienes permiso para acceder."];

                }
            }
            return ["message" => "Credenciales incorrectas."];
        }

        if (!empty($usuarios)) {
            $usuario = $usuarios[0];
            if (password_verify($pass, $usuario['pass'])) {
                $this->startSession($usuario);
            } else {
                $this->redirectWithMessage("Contraseña incorrecta.", 'warning');
            }
        } else {
            $this->redirectWithMessage("Usuario no encontrado.", 'warning');
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
        session_start();
        $_SESSION = array_merge($_SESSION, $usuario);
        $redirectUrl = ($usuario['rol'] == 'Administrador' || $usuario['rol'] == 'Fisioterapeuta') ? '../pages/start.php' : '../pages/start-patients.php';
        header('Location: ' . $redirectUrl);
        exit();
    }

    public function finishSesion()
    {
        // Cerrar sesión
        session_start();

        // Destruir todas las variables de sesión
        // $_SESSION = array();

        // Borrar la cookie de sesión
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

        // Destruir la sesión
        session_destroy();

        // Redirigir a la página de inicio
        header("Location: ../index.php?alert=success&message=Sesion finalizada");
        exit();
    }

    private function redirectWithMessage($message, $alertType) {
        header("Location: ../index.php?alert=$alertType&message=$message");
        exit();
    }

    public function generatePasswordResetToken($email, $isApiResquest = false) {
        $token = bin2hex(random_bytes(32));
        $conn = $this->loginModel->getConnection();
        $this->deleteExistingTokens($conn, $email);
        $this->insertNewToken($conn, $email, $token);
        $resetLink = 'localhost/pages/resetPassword.php?token=' . $token;
        if($this->sendPasswordResetEmail($email, $resetLink)){
            $this->redirectWithMessage('Se ha enviado un correo con un enlace para restablecer la contraseña', 'success');
        }
        $conn->close();

        if ($isApiResquest){
            return ["message" => "Solicitud enviada correctamente"];

        }
    }

    public function resetPassword($token, $password) {
        $conn = $this->loginModel->getConnection();
        $sql = "SELECT email, token FROM password_resets WHERE created_at >= (NOW() - INTERVAL 1 HOUR)";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if (password_verify($token, $row['token'])) {
                    $email = $row['email'];
                    $newPasswordHash = password_hash($password, PASSWORD_DEFAULT);
                    $updateSql = "UPDATE usuarios SET pass = ? WHERE email = ?";
                    $stmt = $conn->prepare($updateSql);
                    $stmt->bind_param("ss", $newPasswordHash, $email);
                    if ($stmt->execute()) {
                        $this->deleteExistingTokens($conn, $email);
                        $this->redirectWithMessage('Contraseña actualizada correctamente.', 'success');
                    } else {
                        $this->redirectWithMessage('Error al actualizar la contraseña.', 'warning');
                    }
                    $stmt->close();
                    break;
                }
            }
        } else {
            $this->redirectWithMessage('Token inválido o expirado.', 'warning');
        }
        
        $conn->close();
    }

    private function deleteExistingTokens($conn, $email) {
        $sql = "DELETE FROM password_resets WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->close();
    }

    private function insertNewToken($conn, $email, $token) {
        $sql = "INSERT INTO password_resets (email, token) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        $stmt->bind_param("ss", $email, $hashedToken);
        $stmt->execute();
        $stmt->close();
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

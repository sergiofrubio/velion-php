<?php
namespace App\Core;

class Controller
{
    public function view($view, $data = [])
    {
        extract($data);
        require_once "../Views/$view.php";
    }

    public function model($model)
    {
        $modelClass = "App\\Models\\$model";
        return new $modelClass();
    }

    public function checkAuth()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . PROJECT_ROOT . '/login');
            exit();
        }
    }

    public function checkAuthApi()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['usuario_id'])) {
            header('Content-Type: application/json');
            http_response_code(401);
            echo json_encode(['error' => 'No autorizado']);
            exit();
        }
    }

}
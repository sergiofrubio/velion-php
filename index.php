<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicio de sesión</title>
    <link rel="icon" href="./assets/custom/img/VELION Logo Rounded.png" type="image/png">
    <link href="./assets/bootstrap-5.3/css/bootstrap.min.css" rel="stylesheet">
    <script src="./assets/bootstrap-5.3/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-image: url('assets/custom/img/fondo.jpg');
            /* Reemplaza con la ruta de tu imagen */
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .login-container h2 {
            margin-bottom: 20px;
            font-weight: bold;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #495057;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-link {
            color: #007bff;
            text-decoration: none;
            /* Quitar subrayado de los enlaces */
        }
    </style>
</head>

<body>

    <div class="login-container">
        <?php
        // Verificar si hay una alerta de usuario
        if (isset($_GET['alert']) && isset($_GET['message'])) {
            // Mostrar la alerta
            echo '<div class="alert alert-' . $_GET['alert'] . ' alert-dismissible fade show" role="alert">' . $_GET['message'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        ?>
        <h2 class="text-center">Inicia sesión</h2>
        <form action="./scripts/login_manager.php" method="post">
            <input type="hidden" id="actionType" name="action" value="iniciar_sesion">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="pass" id="pass" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
            <div class="mt-3 d-flex justify-content-between">
                <a href="./pages/signup.php" class="btn btn-link">Regístrate</a>
                <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-link">Recuperar contraseña</a>
            </div>
        </form>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Recuperar Contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="./scripts/login_manager.php" method="post">
                    <div class="modal-body">
                        <label for="resetEmail" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="resetEmail" name="resetEmail" required>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="action" value="solicitar_nueva_contraseña">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</body>

</html>
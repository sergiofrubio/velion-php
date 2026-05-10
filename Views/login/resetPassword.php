<!DOCTYPE html>
<html lang="es" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reinicio de Contraseña</title>
    <link href="../assets/bootstrap-5.3/css/bootstrap.min.css" rel="stylesheet">
    <script src="../assets/bootstrap-5.3/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-image: url("../assets/custom/img/fondo.jpg"); /* Replace with your background image URL */
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .reset-container {
            background: rgba(255, 255, 255, 0.8); /* White background with transparency */
            padding: 30px;
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Box shadow */
            max-width: 400px; /* Limit form width */
            width: 100%; /* Ensure responsiveness */
        }

        .reset-container h2 {
            margin-bottom: 20px;
            font-weight: bold;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #495057; /* Adjust focus border color */
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-link {
            color: #007bff;
            text-decoration: none; /* Remove link underline */
        }
    </style>
</head>

<body>

    <div class="reset-container">
        <h2 class="text-center">Reinicio de Contraseña</h2>

        <form action="../scripts/login_manager.php" method="post">
            <input type="hidden" name="action" value="resetear_contraseña">
            <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">

            <div class="mb-3">
                <label for="password" class="form-label">Nueva Contraseña</label>
                <input type="password" class="form-control" id="pass" name="pass" minlength="8" required>
            </div>

            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirmar Contraseña</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" minlength="8" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Reiniciar Contraseña</button>
        </form>
    </div>

</body>

</html>

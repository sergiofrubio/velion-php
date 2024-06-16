<!DOCTYPE html>
<html lang="es" data-bs-theme="auto">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Error 404 - Página no encontrada</title>
  <link href="../assets/bootstrap-5.3/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-image: url('../assets/custom/img/fondo.jpg');
      /* Reemplaza con la ruta de tu imagen */
      background-size: cover;
      background-position: center;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .container {
      background: rgba(255, 255, 255, 0.8);
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      max-width: 400px;
      width: 100%;
    }

    .error-container {
      text-align: center;
    }
  </style>
</head>

<body>

  <div class="container">
    <div class="row">
      <div class="col-md-12 error-container">
        <h1 class="display-4">¡Oops!</h1>
        <p class="lead">Lo sentimos, la página que estás buscando no se pudo encontrar.</p>
        <a href="#" onclick="history.back();" class="btn btn-secondary">Volver atrás</a>
      </div>
    </div>
  </div>

</body>

</html>
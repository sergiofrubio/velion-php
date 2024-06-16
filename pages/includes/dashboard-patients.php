<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Pacientes</title>
  <link rel="icon" href="../assets/custom/img/VELION Logo Rounded.png" type="image/png">
  <link href="../assets/bootstrap-5.3/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/custom/css/userdetail.css">
  <script src="../assets/bootstrap-5.3/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/custom/js/timeout.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="../assets/bootstrap-5.3/js/color-modes.js"></script>
  <script src="../assets/custom/js/logout.js"></script>
  <style>
    body {
      background-image: url('../assets/custom/img/fondo-patients.png');
    }

    .navbar-dark .navbar-nav .nav-link {
      color: #000 !important;
    }

    .navbar-dark .navbar-brand {
      color: #000 !important;
    }


    .navbar-dark .navbar-toggler-icon {
      filter: invert(1);
    }

    .custom-bg {
      background-image: url('../assets/custom/img/fondo-patients.png');
    }

    .custom-blur {
      border: 2px solid black;
      color: #FFFFFF !important;
      background: #222;
    }

    .custom-bg-color {
      background-color: #222;
      border: none;
      color: #FFFFFF;
    }

    .rounded-table {
      border-radius: 6px;
      overflow: hidden;
      /* Esto asegura que el contenido dentro de la tabla no se desborde */
    }

    .custom-btn {
      background-color: #222;
      /* Fondo oscuro */
      color: white;
      /* Texto blanco */
      border-color: #222;
      /* Borde del mismo color que el fondo */
    }

    .custom-color {
      color: #000000;
    }

    .profile-header {
      width: 1200px;
      /* Ajusta el ancho según tus necesidades */
      height: 300px;
      /* Ajusta la altura según tus necesidades */
      background-image: url('../assets/custom/img/foto_fondo_perfil.jpg');
      background-size: cover;
      /* Ajusta la imagen para que cubra todo el div */
      background-position: center;
      /* Centra la imagen en el div */
      position: relative;
      /* Para posicionar el contenido dentro del div */
      border-radius: 10px;
    }

    .profile-picture {
      border: none;
    }

    .nav-link {
      color: #343a40;
      /* Color oscuro para los botones no seleccionados */
    }

    .nav-link.active {
      background-color: #343a40 !important;
      /* Color oscuro */
      color: white !important;
      /* Texto blanco para contraste */
    }

    .link-wrapper {
      display: flex;
      align-items: center;
      text-decoration: none;
      color: inherit;
      /* Mantiene el color del texto según el contexto */
    }

    .link-wrapper img {
      margin-right: 10px;
      /* Espaciado entre la imagen y el texto */
    }

    .link-wrapper span {
      font-size: 1.2em;
      /* Ajusta el tamaño del texto */
      color: black;
      /* Cambia el color del texto a negro */
      text-decoration: none;
      /* Elimina el subrayado */
      font-size: 1.3rem;
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }

    .link-wrapper:hover span {
      text-decoration: none;
      /* Asegura que el texto no se subraye al pasar el mouse */
    }
  </style>
</head>

<body>

  <nav class="navbar sticky-top navbar-expand-lg navbar-dark shadow">
    <div class="container">
      <a href="userdetail.php?usuario_id=<?php echo $DNI ?>" class="link-wrapper">
        <img src="../assets/custom/img/foto_perfil.jpg" alt="Foto de Perfil" class="rounded-circle"
          style="width: 30px; height: 30px;">
        <span><?php echo $nombre . ' ' . $apellidos; ?></span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="start-patients.php">
              <i class="bi bi-house-door"></i> Inicio
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="appointments-patients.php">
              <i class="bi bi-calendar"></i> Citas
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="invoices-patients.php">
              <i class="bi bi-receipt"></i> Facturas
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="shop.php">
              <i class="bi bi-shop"></i> Tienda
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="cerrarSesion()">
              <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-4" id="contenido">
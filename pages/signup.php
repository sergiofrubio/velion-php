<!DOCTYPE html>
<html lang="es" data-bs-theme="auto">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario de Registro</title>
  <link href="../assets/bootstrap-5.3/css/bootstrap.min.css" rel="stylesheet">
  <script src="../assets/bootstrap-5.3/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/custom/js/validaciones.js"></script>
  <style>
    body {
      background-image: url('../assets/custom/img/fondo.jpg'); /* Ruta a la imagen de fondo */
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      height: 100vh;
    }
    .form-container {
      background-color: rgba(255, 255, 255, 0.8); /* Fondo blanco semitransparente */
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
  </style>
  
</head>

<body>
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="form-container">
          <!-- Formulario de Registro -->
          <form action="../scripts/login_manager.php" method="post" onsubmit="return validatePassword()">
            <h2 class="mb-3">Registro</h2>
            <input type="hidden" id="actionType" name="action" value="registrar_usuario">
            <!-- Nombre y Apellidos -->
            <div class="row mb-3">
              <div class="col">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
              </div>
              <div class="col">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
              </div>
            </div>

            <!-- DNI y Género -->
            <div class="row mb-3">
              <div class="col">
                <label for="usuario_id" class="form-label">DNI</label>
                <input type="text" class="form-control" id="usuario_id" name="usuario_id" pattern="\d{8}[A-Za-z]" title="Introduce un DNI válido (8 dígitos seguidos de una letra)" oninput="return validarInput()" required>
                <div id="idError" class="text-danger"></div>
              </div>
              <div class="col">
                <label for="genero" class="form-label">Género</label>
                <select class="form-select" id="genero" name="genero" aria-label="Selecciona tu género">
                  <option selected>Selecciona tu género</option>
                  <option value="Hombre">Hombre</option>
                  <option value="Mujer">Mujer</option>
                  <option value="Otro">Otro</option>
                </select>
              </div>
            </div>

            <!-- Fecha de nacimiento -->
            <div class="mb-3">
              <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
              <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
            </div>

            <!-- Teléfono y Dirección -->
            <div class="row mb-3">
              <div class="col">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" pattern="\d{8}[0-9]" title="Introduce un telefono válido, sin espacios (9 dígitos)" required>
              </div>
              <div class="col">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" required>
              </div>
            </div>

            <!-- Provincia, Municipio y CP -->
            <div class="row mb-3">
              <div class="col">
                <label for="provincia" class="form-label">Provincia</label>
                <input type="text" class="form-control" id="provincia" name="provincia" required>
              </div>

              <div class="col">
                <label for="municipio" class="form-label">Municipio</label>
                <input type="text" class="form-control" id="municipio" name="municipio" required>
              </div>

              <div class="col">
                <label for="cp" class="form-label">Código Postal</label>
                <input type="text" class="form-control" id="cp" name="cp" pattern="[0-9]{5}" title="Introduce un código postal válido (5 dígitos)" required>
              </div>
            </div>

            <!-- Correo electrónico -->
            <div class="mb-3">
              <label for="email" class="form-label">Correo electrónico</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <!-- Contraseña y Confirmar contraseña -->
            <div class="row mb-3">
              <div class="col">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="pass" minlength="8" name="pass" required>
              </div>
              <div class="col">
                <label for="confirmPassword" class="form-label">Confirmar contraseña</label>
                <input type="password" class="form-control" id="confirmPass" name="confirmPass" required>
                <div id="passwordError" class="text-danger"></div>
              </div>
            </div>

            <!-- CheckBox para aceptar términos y condiciones -->
            <div class="mb-3">
              <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" requiredChecked>
              <label class="form-check-label" for="flexCheckDefault">
                Acepto los <a href="terms.php">términos y condiciones del servicio</a>
              </label>
            </div>

            <!-- Botón de Registro -->
            <button type="submit" class="btn btn-primary">Registrarse</button>
            <a href="#" onclick="history.back();" class="btn btn-secondary">Volver atrás</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
